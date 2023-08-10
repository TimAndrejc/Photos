<?php
require_once 'connection.php';

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:login.php');
    exit;
}
if (!isset($_POST['album_id'])) {
    header('Location:index.php');
    exit;
}
if(!isset($_POST['friends'])){
    $friends = [];
}else{
    $friends = $_POST['friends'];
}

$query = "SELECT * FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['album_id']]);
$album = $stmt->fetch();
if (!$album) {
    header('Location:index.php');
    exit;
}
$query = "SELECT user_id FROM album_user WHERE album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['album_id']]);
$album_users = $stmt->fetchAll();
$album_users = array_column($album_users, 'user_id');

$people = [];

foreach($friends as $friendss){
    $query ="SELECT u.id FROM users u INNER JOIN confirmation c ON c.user_id = u.id WHERE token = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$friendss]);
    $friend = $stmt->fetch();
    if(!$friend){
        continue;
    }
    $people[] = $friend;

}
$people = array_column($people, 'id');

if (!in_array($_SESSION['id'], $album_users)) {
    header('Location:index.php');
    exit;
}

if($album['creator_id'] == $_SESSION['id']){
    foreach($album_users as $album_user){
        if(in_array($album_user, $people) || $album_user == $_SESSION['id']){
            continue;
        }else{
            $query = "DELETE FROM album_user WHERE album_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['album_id'], $album_user]);
        }
    }
    foreach($people as $person){
        if(in_array($person, $album_users) || $person == $_SESSION['id']){
            continue;
        }
        $query = "INSERT INTO album_user (album_id, user_id) VALUES (?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_POST['album_id'], $person]);
    }
}else{
    foreach($people as $person){
        if(in_array($person, $album_users)){
            continue;
        }
        $query = "INSERT INTO album_user (album_id, user_id) VALUES (?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_POST['album_id'], $person]);
    }
}
header('Location:album.php?album='.$_POST['album_id']);
exit;