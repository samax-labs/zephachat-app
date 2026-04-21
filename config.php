<?php
define('DB_HOST',    'localhost');
define('DB_NAME',    'zephachat');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', 'uploads/');
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB

define('ALLOWED_IMAGE',    ['image/jpeg','image/png','image/gif','image/webp']);
define('ALLOWED_AUDIO',    ['audio/mpeg','audio/ogg','audio/wav','audio/webm','audio/mp4']);
define('ALLOWED_VIDEO',    ['video/mp4','video/webm','video/ogg','video/quicktime']);
define('ALLOWED_DOCUMENT', ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/plain','application/zip']);

foreach (['images','audio','video','documents','avatars'] as $d) {
    $p = UPLOAD_DIR . $d;
    if (!is_dir($p)) mkdir($p, 0755, true);
}

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            jsonResponse(['success'=>false,'message'=>'Database connection failed.'], 500);
        }
    }
    return $pdo;
}

session_start();

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function requireAuth(): void {
    if (empty($_SESSION['user_id'])) jsonResponse(['success'=>false,'message'=>'Not authenticated.'], 401);
}

function sanitize(string $str): string {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

function pingLastSeen(): void {
    if (!empty($_SESSION['user_id'])) {
        try {
            $db = getDB();
            $db->prepare('UPDATE users SET last_seen=NOW() WHERE id=?')->execute([$_SESSION['user_id']]);
        } catch (Exception $e) {}
    }
}
