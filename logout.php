<?php
require_once 'config.php';
$_SESSION=[];session_destroy();
jsonResponse(['success'=>true]);
