<?php
require_once 'config.php';
header('Content-Type: application/json');
if (!empty($_SESSION['user_id'])) {
    pingLastSeen();
    $db=$s=getDB();$s=$db->prepare('SELECT id,username,display_name,avatar_type,avatar_photo FROM users WHERE id=?');
    $s->execute([$_SESSION['user_id']]);$user=$s->fetch();
    jsonResponse(['loggedIn'=>true,'user'=>$user]);
} else {
    jsonResponse(['loggedIn'=>false]);
}
