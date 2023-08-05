<?php
if(!isset($_GET['token'])){
    header('Location:login.php');
    exit;
}
require 'connection.php';
$token = $_GET['token'];
$query = "SELECT user_id FROM confirmation WHERE token = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$token]);
if($stmt->rowCount() == 0){
    header('Location:login.php');
    exit;
}
$user_id = $stmt->fetch()['user_id'];
$query = "UPDATE users SET confirmed = 1 WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
header('Location:login.php');
exit;