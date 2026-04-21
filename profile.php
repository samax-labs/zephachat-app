<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uid = isset($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['user_id'];
    $s   = $db->prepare('SELECT id,username,display_name,bio,avatar_type,avatar_photo,contact_info,last_seen,created_at FROM users WHERE id=?');
    $s->execute([$uid]);
    $user = $s->fetch();
    if (!$user) jsonResponse(['success'=>false,'message'=>'User not found.'],404);
    // compute online status
    $diff = time() - strtotime($user['last_seen']);
    $user['online_status'] = $diff < 120 ? 'online' : ($diff < 3600 ? 'recent' : 'offline');
    jsonResponse(['success'=>true,'user'=>$user]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_name = sanitize($_POST['display_name'] ?? '');
    $bio          = sanitize($_POST['bio'] ?? '');
    $contact_info = sanitize($_POST['contact_info'] ?? '');
    $avatar_type  = $_POST['avatar_type'] ?? 'initials';
    $avatar_photo = null;

    if ($avatar_type === 'photo' && isset($_FILES['avatar_photo']) && $_FILES['avatar_photo']['error'] === UPLOAD_ERR_OK) {
        $file     = $_FILES['avatar_photo'];
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mimeType, ALLOWED_IMAGE)) jsonResponse(['success'=>false,'message'=>'Invalid image type.']);
        if ($file['size'] > 5*1024*1024) jsonResponse(['success'=>false,'message'=>'Image must be under 5MB.']);
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_'.$_SESSION['user_id'].'_'.time().'.'.$ext;
        $dest     = UPLOAD_DIR.'avatars/'.$filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) jsonResponse(['success'=>false,'message'=>'Upload failed.']);
        $avatar_photo = UPLOAD_URL.'avatars/'.$filename;
    } elseif ($avatar_type === 'photo') {
        $s=$db->prepare('SELECT avatar_photo FROM users WHERE id=?');$s->execute([$_SESSION['user_id']]);
        $row=$s->fetch();$avatar_photo=$row['avatar_photo'];
    }

    $db->prepare('UPDATE users SET display_name=?,bio=?,contact_info=?,avatar_type=?,avatar_photo=? WHERE id=?')
       ->execute([$display_name?:null,$bio?:null,$contact_info?:null,$avatar_type,$avatar_photo,$_SESSION['user_id']]);
    jsonResponse(['success'=>true,'message'=>'Profile updated!']);
}
