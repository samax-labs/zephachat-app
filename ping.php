<?php
require_once 'config.php';
header('Content-Type: application/json');
requireAuth();
pingLastSeen();
jsonResponse(['success'=>true]);
