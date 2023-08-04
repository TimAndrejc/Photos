<?php

include_once 'header.php';
if(!isset($_SESSION['id'])){
    if(isset($_GET['friend'])){
        header('location:login.php?friend='.$_GET['friend']);
    }else{
        header('location:login.php');
    }
}
require_once 'modals/loginLogout_modal.php';

require_once 'connection.php';

$query = "SELECT s.* FROM users s INNER JOIN confirmation c ON s.id = c.user_id WHERE c.token = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['friend']]);
$friend = $stmt->fetch();
if(!$friend || $friend['id'] == $_SESSION['id']){
    header('location:index.php');
    exit();
}
if(isset($_GET['add']) && isset($_GET['friend'])){
    $query = "SELECT s.id FROM users s INNER JOIN confirmation c ON s.id = c.user_id WHERE c.token = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['friend']]);
    $friend = $stmt->fetch();
    $query = "INSERT INTO friends (user_id, friend_id, accepted) VALUES (?, ?, 1)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id'], $friend['id']]);
    header('location:friends.php');
    exit();
}

$query = "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['id'], $friend['id'], $friend['id'], $_SESSION['id']]);
if($stmt->rowCount() == 1){
    header('location:index.php');
    exit();
}
?>
<section class="intro text-gray" style="margin-top:10px;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom:2rem">
      <div class="card gradient-custom" style="border-radius: 1rem;">
        <div class="card-body p-5" style="padding:0">
            <div class="text-center pt-1">
            Friend link
              <h1 class="fw-bold  text-uppercase"><?php echo $friend['username']?></h1>
            </div>
            <div class="form-outline form-white mb-4"> 
            </div>
              <div class="text-center pt-1">
              <a href="add_friend.php?add=true&friend=<?php echo $_GET['friend'] ?>" class="btn btn-outline-secondary btn-lg" style="border-radius: 2rem;"> <i class="bi bi-person-fill-add"></i>  </i>Add to friends list</a>
              </div>
    </div>
  </div>
  <span class="pointer">
  </span>
</div>
</div>
</section>