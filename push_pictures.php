<?php
session_start();
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
if(!isset($_POST['album'])){
    header('Location:index.php');
    exit;
}
if(!isset($_POST['picnames'])){
    header('Location:index.php');
    exit;
}
$picnames = $_POST['picnames'];
$album_id = $_POST['album'];
require_once 'connection.php';
$query = "SELECT * FROM albums WHERE id = ? ";
$stmt = $pdo->prepare($query);
$stmt->execute([$album_id]);
$album = $stmt->fetch();
if(!$album){
    header('Location:index.php');
    exit;
}
$query = "SELECT * FROM album_user WHERE album_id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$album_id, $_SESSION['id']]);
$album_user = $stmt->fetch();
if(!$album_user){
    header('Location:index.php');
    exit;
}
$picnames = explode(',', $picnames);
foreach($picnames as $picname){
    $query = "INSERT INTO pictures (album_id, location, user_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$album_id, $picname, $_SESSION['id']]);
}
header('Location:album.php?album='.$album_id);
?>
