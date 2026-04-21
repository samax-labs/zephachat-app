<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
pingLastSeen();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);

$db       = getDB();
$msg_type = $_POST['msg_type'] ?? '';

// text comes as JSON body
if (!$msg_type) {
    $body     = json_decode(file_get_contents('php://input'), true);
    $msg_type = $body['msg_type'] ?? 'text';
    $message  = sanitize($body['message'] ?? '');
    if (!$message) jsonResponse(['success'=>false,'message'=>'Empty message.']);
    $db->prepare('INSERT INTO messages (user_id,msg_type,message) VALUES (?,?,?)')->execute([$_SESSION['user_id'],$msg_type,$message]);
    jsonResponse(['success'=>true]);
}

// media upload
if (in_array($msg_type,['image','audio','video','document'])) {
    if (!isset($_FILES['media'])||$_FILES['media']['error']!==UPLOAD_ERR_OK) jsonResponse(['success'=>false,'message'=>'Upload failed.']);
    $file=$_FILES['media'];
    $finfo=finfo_open(FILEINFO_MIME_TYPE);$mime=finfo_file($finfo,$file['tmp_name']);finfo_close($finfo);
    if ($file['size']>MAX_FILE_SIZE) jsonResponse(['success'=>false,'message'=>'File too large (max 50MB).']);
    $allowed=match($msg_type){
        'image'=>ALLOWED_IMAGE,'audio'=>ALLOWED_AUDIO,'video'=>ALLOWED_VIDEO,'document'=>ALLOWED_DOCUMENT,default=>[]
    };
    if (!in_array($mime,$allowed)) jsonResponse(['success'=>false,'message'=>'File type not allowed.']);
    $ext=pathinfo($file['name'],PATHINFO_EXTENSION);
    $fname=$msg_type.'_'.$_SESSION['user_id'].'_'.time().'.'.$ext;
    $subdir=$msg_type==='document'?'documents':$msg_type.'s';
    if(!move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$subdir.'/'.$fname)) jsonResponse(['success'=>false,'message'=>'Save failed.']);
    $path=UPLOAD_URL.$subdir.'/'.$fname;
    $caption=sanitize($_POST['caption']??'');
    $origname=sanitize($file['name']);
    $db->prepare('INSERT INTO messages (user_id,msg_type,message,media_path,file_name) VALUES (?,?,?,?,?)')->execute([$_SESSION['user_id'],$msg_type,$caption,$path,$origname]);
    jsonResponse(['success'=>true]);
}
jsonResponse(['success'=>false,'message'=>'Unknown type.']);
