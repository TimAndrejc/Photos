<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: login.php");
}
require_once 'connection.php';
if(!isset($_POST['albumName']) || empty($_POST['albumName'])){
    header("Location: create_album.php");
}
$albumName = $_POST['albumName'];
$albumName = trim($albumName);
$albumName = filter_var($albumName, FILTER_SANITIZE_STRING);
$albumName = htmlspecialchars($albumName);
$albumName = stripslashes($albumName);
$albumName = strip_tags($albumName);
$albumName = htmlentities($albumName);
$albumName = str_replace(array("\r\n", "\r", "\n"), "", $albumName);
$albumName = addslashes($albumName);

$date = $_POST['hangoutDate'];
if(isset($_POST['filename'])){
    $albumCover = $_POST['filename'];
    $query ="INSERT INTO albums (creator_id, name, main_pic, date_of_hangout) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id'], $albumName, $albumCover, $date]);
    $album_id = $pdo->lastInsertId();
}else{
    $query ="INSERT INTO albums (user_id, name, date_of_hangout) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id'], $albumName, $date]);
    $album_id = $pdo->lastInsertId();
}
$query = "INSERT INTO album_user (album_id, user_id) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$album_id, $_SESSION['id']]);
if(isset($_POST['friends'])){
    $friends = $_POST['friends'];
    foreach($friends as $friend){
        $query = "SELECT u.id FROM confirmation c INNER JOIN users u ON u.id = c.user_id WHERE c.token = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$friend]);
        $friend = $stmt->fetch();
        $friend_id = $friend['id'];
        $query = "INSERT INTO album_user (album_id, user_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$album_id, $friend_id]);
    }
}
header("Location: index.php");
?>
