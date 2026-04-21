<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
pingLastSeen();

$db  = getDB();
// Online = last seen < 2 minutes, recent = last seen < 1 hour, exclude self
$s   = $db->prepare(
    'SELECT id, username, display_name, avatar_type, avatar_photo, last_seen,
            CASE
              WHEN TIMESTAMPDIFF(SECOND, last_seen, NOW()) < 120   THEN "online"
              WHEN TIMESTAMPDIFF(SECOND, last_seen, NOW()) < 3600  THEN "recent"
              ELSE "offline"
            END AS online_status
     FROM users
     WHERE id != ?
       AND TIMESTAMPDIFF(SECOND, last_seen, NOW()) < 3600
     ORDER BY last_seen DESC'
);
$s->execute([$_SESSION['user_id']]);
jsonResponse(['success'=>true,'users'=>$s->fetchAll()]);
