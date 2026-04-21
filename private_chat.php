<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
pingLastSeen();

$db     = getDB();
$action = $_GET['action'] ?? '';
$me     = $_SESSION['user_id'];

// ── start / get conversation ──────────────────────────────────────────────────
if ($action === 'start') {
    $other = (int)($_GET['user_id'] ?? 0);
    if (!$other || $other === $me) jsonResponse(['success'=>false,'message'=>'Invalid user.']);
    $s=$db->prepare('SELECT id,username,display_name,avatar_type,avatar_photo FROM users WHERE id=?');
    $s->execute([$other]);$ou=$s->fetch();
    if (!$ou) jsonResponse(['success'=>false,'message'=>'User not found.']);
    $u1=min($me,$other);$u2=max($me,$other);
    $s=$db->prepare('SELECT id FROM conversations WHERE user1_id=? AND user2_id=?');$s->execute([$u1,$u2]);$c=$s->fetch();
    if (!$c){$db->prepare('INSERT INTO conversations (user1_id,user2_id) VALUES (?,?)')->execute([$u1,$u2]);$cid=$db->lastInsertId();}
    else $cid=$c['id'];
    jsonResponse(['success'=>true,'conversation_id'=>$cid,'other_user'=>$ou]);
}

// ── list my conversations ─────────────────────────────────────────────────────
if ($action === 'list') {
    $s=$db->prepare(
        'SELECT c.id AS conversation_id,
                u.id AS other_id, u.username, u.display_name, u.avatar_type, u.avatar_photo,
                (SELECT COUNT(*) FROM private_messages pm WHERE pm.conversation_id=c.id AND pm.is_read=0 AND pm.sender_id!=?) AS unread,
                (SELECT pm2.message FROM private_messages pm2 WHERE pm2.conversation_id=c.id ORDER BY pm2.sent_at DESC LIMIT 1) AS last_message,
                (SELECT pm2.msg_type FROM private_messages pm2 WHERE pm2.conversation_id=c.id ORDER BY pm2.sent_at DESC LIMIT 1) AS last_type,
                (SELECT pm3.sent_at FROM private_messages pm3 WHERE pm3.conversation_id=c.id ORDER BY pm3.sent_at DESC LIMIT 1) AS last_time
         FROM conversations c
         JOIN users u ON u.id=IF(c.user1_id=?,c.user2_id,c.user1_id)
         WHERE c.user1_id=? OR c.user2_id=?
         ORDER BY last_time DESC'
    );
    $s->execute([$me,$me,$me,$me]);
    jsonResponse(['success'=>true,'conversations'=>$s->fetchAll()]);
}

// ── fetch messages in a conversation ─────────────────────────────────────────
if ($action === 'fetch') {
    $cid    = (int)($_GET['conversation_id'] ?? 0);
    $lastId = (int)($_GET['last_id'] ?? 0);
    // verify membership
    $s=$db->prepare('SELECT id FROM conversations WHERE id=? AND (user1_id=? OR user2_id=?)');
    $s->execute([$cid,$me,$me]);
    if (!$s->fetch()) jsonResponse(['success'=>false,'message'=>'Access denied.'],403);
    // mark read
    $db->prepare('UPDATE private_messages SET is_read=1 WHERE conversation_id=? AND sender_id!=? AND is_read=0')->execute([$cid,$me]);
    // fetch
    $s=$db->prepare(
        'SELECT pm.id,pm.sender_id,pm.msg_type,pm.message,pm.media_path,pm.file_name,pm.sent_at,pm.is_read,
                u.username,u.display_name,u.avatar_type,u.avatar_photo
         FROM private_messages pm
         JOIN users u ON pm.sender_id=u.id
         WHERE pm.conversation_id=? AND pm.id>?
         ORDER BY pm.sent_at ASC LIMIT 60'
    );
    $s->execute([$cid,$lastId]);
    jsonResponse(['success'=>true,'messages'=>$s->fetchAll()]);
}

// ── send private message ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'send') {
    $msg_type = $_POST['msg_type'] ?? '';

    // JSON text message
    if (!$msg_type) {
        $body     = json_decode(file_get_contents('php://input'), true);
        $msg_type = $body['msg_type'] ?? 'text';
        $cid      = (int)($body['conversation_id'] ?? 0);
        $message  = sanitize($body['message'] ?? '');
        if (!$message) jsonResponse(['success'=>false,'message'=>'Empty message.']);
        // verify
        $s=$db->prepare('SELECT id FROM conversations WHERE id=? AND (user1_id=? OR user2_id=?)');
        $s->execute([$cid,$me,$me]);
        if(!$s->fetch()) jsonResponse(['success'=>false,'message'=>'Access denied.'],403);
        $db->prepare('INSERT INTO private_messages (conversation_id,sender_id,msg_type,message) VALUES (?,?,?,?)')->execute([$cid,$me,$msg_type,$message]);
        jsonResponse(['success'=>true]);
    }

    // media upload
    if (in_array($msg_type,['image','audio','video','document'])) {
        $cid=(int)($_POST['conversation_id']??0);
        $s=$db->prepare('SELECT id FROM conversations WHERE id=? AND (user1_id=? OR user2_id=?)');
        $s->execute([$cid,$me,$me]);
        if(!$s->fetch()) jsonResponse(['success'=>false,'message'=>'Access denied.'],403);
        if(!isset($_FILES['media'])||$_FILES['media']['error']!==UPLOAD_ERR_OK) jsonResponse(['success'=>false,'message'=>'Upload failed.']);
        $file=$_FILES['media'];
        $finfo=finfo_open(FILEINFO_MIME_TYPE);$mime=finfo_file($finfo,$file['tmp_name']);finfo_close($finfo);
        if($file['size']>MAX_FILE_SIZE) jsonResponse(['success'=>false,'message'=>'File too large.']);
        $allowed=match($msg_type){'image'=>ALLOWED_IMAGE,'audio'=>ALLOWED_AUDIO,'video'=>ALLOWED_VIDEO,'document'=>ALLOWED_DOCUMENT,default=>[]};
        if(!in_array($mime,$allowed)) jsonResponse(['success'=>false,'message'=>'File type not allowed.']);
        $ext=pathinfo($file['name'],PATHINFO_EXTENSION);
        $fname=$msg_type.'_'.$me.'_'.time().'.'.$ext;
        $subdir=$msg_type==='document'?'documents':$msg_type.'s';
        if(!move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$subdir.'/'.$fname)) jsonResponse(['success'=>false,'message'=>'Save failed.']);
        $path=UPLOAD_URL.$subdir.'/'.$fname;
        $caption=sanitize($_POST['caption']??'');
        $origname=sanitize($file['name']);
        $db->prepare('INSERT INTO private_messages (conversation_id,sender_id,msg_type,message,media_path,file_name) VALUES (?,?,?,?,?,?)')->execute([$cid,$me,$msg_type,$caption,$path,$origname]);
        jsonResponse(['success'=>true]);
    }
}

// ── search users ──────────────────────────────────────────────────────────────
if ($action === 'search') {
    $q=sanitize($_GET['q']??'');
    if(strlen($q)<1) jsonResponse(['success'=>true,'users'=>[]]);
    $s=$db->prepare('SELECT id,username,display_name,avatar_type,avatar_photo FROM users WHERE username LIKE ? AND id!=? LIMIT 10');
    $s->execute(['%'.$q.'%',$me]);
    jsonResponse(['success'=>true,'users'=>$s->fetchAll()]);
}

jsonResponse(['success'=>false,'message'=>'Unknown action.'],400);
