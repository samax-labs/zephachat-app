<?php
require_once 'config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
$body     = json_decode(file_get_contents('php://input'), true);
$username = trim($body['username'] ?? '');
$password = $body['password'] ?? '';
if (!$username || !$password)                   jsonResponse(['success'=>false,'message'=>'All fields required.']);
if (strlen($username)<3||strlen($username)>30)  jsonResponse(['success'=>false,'message'=>'Username must be 3-30 chars.']);
if (!preg_match('/^[a-zA-Z0-9_]+$/',$username)) jsonResponse(['success'=>false,'message'=>'Letters, numbers and underscores only.']);
if (strlen($password)<6)                        jsonResponse(['success'=>false,'message'=>'Password must be at least 6 characters.']);
$db=$getDB=getDB();
$s=$db->prepare('SELECT id FROM users WHERE username=?');$s->execute([$username]);
if($s->fetch()) jsonResponse(['success'=>false,'message'=>'Username already taken.']);
$db->prepare('INSERT INTO users (username,password,display_name) VALUES (?,?,?)')->execute([$username,password_hash($password,PASSWORD_BCRYPT),$username]);
jsonResponse(['success'=>true,'message'=>'Account created!']);
