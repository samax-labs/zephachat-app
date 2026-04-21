<?php
require_once 'config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['success'=>false,'message'=>'Method not allowed.'],405);
$body=$json=json_decode(file_get_contents('php://input'),true);
$username=trim($body['username']??'');$password=$body['password']??'';
if(!$username||!$password) jsonResponse(['success'=>false,'message'=>'All fields required.']);
$db=getDB();$s=$db->prepare('SELECT id,username,password FROM users WHERE username=?');$s->execute([$username]);$user=$s->fetch();
if(!$user||!password_verify($password,$user['password'])) jsonResponse(['success'=>false,'message'=>'Invalid username or password.']);
$_SESSION['user_id']=$user['id'];$_SESSION['username']=$user['username'];
$db->prepare('UPDATE users SET last_seen=NOW() WHERE id=?')->execute([$user['id']]);
jsonResponse(['success'=>true,'username'=>$user['username']]);
