
<?php

session_start();
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
if(!isset($_POST['username'])){
    echo 'Invalid request.';
    exit;
}
    require_once 'connection.php';
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if(!$user){
        echo 'User with that username does not exist.';
        exit;
    }
    $query = "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id'], $user['id'], $user['id'], $_SESSION['id']]);
    if($stmt->rowCount() == 1){
        if($stmt->fetch()['accepted'] == 1){
            echo 'You are already friends with this user.';
            exit;
        } 
        echo 'You have already sent a friend request to this user.';
        exit;
    }
    $query = "INSERT INTO friends (user_id, friend_id, accepted) VALUES (?, ?, 0)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id'], $user['id']]);
    echo "Friend request sent.";
    exit;
?>
