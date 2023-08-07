<?php 

if(!isset($_GET['album'])){
    header('Location:index.php');
    exit;
}
include_once 'header.php';
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
require_once 'connection.php';
$query = "SELECT * FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$album = $stmt->fetch();
if(!$album){
    header('Location:index.php');
    exit;
}
$query = "DELETE FROM album_user WHERE album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$query = "DELETE FROM pictures WHERE album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$query = "DELETE FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
header('Location:index.php');
exit;

