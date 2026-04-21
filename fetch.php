<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
pingLastSeen();
$lastId=(int)($_GET['last_id']??0);
$db=getDB();
$s=$db->prepare('SELECT m.id,m.msg_type,m.message,m.media_path,m.file_name,m.sent_at,u.id AS user_id,u.username,u.display_name,u.avatar_type,u.avatar_photo FROM messages m JOIN users u ON m.user_id=u.id WHERE m.id>? ORDER BY m.sent_at ASC LIMIT 60');
$s->execute([$lastId]);
echo json_encode($s->fetchAll());
