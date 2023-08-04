
<?php 
include 'header.php';

if(!isset($_SESSION['id'])){
    header('location:login.php');
}
require_once 'connection.php';
if(isset($_GET['remove'])){
    $query ="DELETE FROM friends WHERE (user_id = ? OR friend_id = ?) AND accepted = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['remove'],$_GET['remove']]);
    header('location:friends.php');
}

require_once 'modals/add_friend_modal.php';
require_once 'modals/friend_requests_modal.php';
$query = "SELECT token FROM confirmation WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['id']]);
$addCode = $stmt->fetch();

if(isset($_GET['confirm'])){
    $query = "UPDATE friends SET accepted = 1 WHERE user_id = ? AND friend_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['confirm'], $_SESSION['id']]);
    header('location:friends.php?requests=true');
}
if(isset($_GET['removereq'])){
    $query = "DELETE FROM friends WHERE user_id = ? AND friend_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['removereq'], $_SESSION['id']]);
    header('location:friends.php?requests=true');
}
?>
<section class="intro text-gray" style="margin-top:10px;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom:2rem">
    
      <div class="card gradient-custom" style="border-radius: 1rem;">
   
        <div class="card-body p-5" style="padding:0">
        <div style="text-align: right;">
        <a href = "friends.php?requests=true" class="btn btn-outline-secondary btn-sm" style="border-radius: 2rem;">Requests</a>
        </div>
            <div class="text-center pt-1">
            <i class="bi bi-people-fill fa-3x"></i>
              <h1 class="fw-bold  text-uppercase">Friends list</h1>
            </div>
            <?php
            $query ="SELECT* FROM friends WHERE (user_id = ? OR friend_id = ?) AND accepted = 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['id'],$_SESSION['id']]);
            $friends = $stmt->fetchAll();
            foreach($friends as $friend)
            {
                if ($friend['user_id'] == $_SESSION['id'])
                {
                    $query ="SELECT* FROM users WHERE id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$friend['friend_id']]);
                    $friend = $stmt->fetch();
                }else{
                $query ="SELECT* FROM users WHERE id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$friend['user_id']]);
                $friend = $stmt->fetch();
                }

            echo '
            <div class="form-outline form-white mb-4"> '.$friend['username'].'
            ';
              echo'<a href ="friends.php?remove='.$friend['id'].'" class="linker"/><div style = "float:right; "><i class="bi bi-x"></i></div></a>';
              echo'
            </div><hr>';
            };

              echo'
              <div class="text-center pt-1">
              <a href="friends.php?add=true" class="btn btn-outline-secondary btn-lg" style="border-radius: 2rem;"> <i class="bi bi-person-fill-add"></i>  </i>Add friend</a>
              </div>
              ';
            ?>
    </div>
  
  </div>
  <span class="pointer">
  <a class="linker" onClick="copyFriendLink()" style="text-align:center">Copy friend link</a>
  </span>
</div>
</div>
</section>
<script>
function copyFriendLink() {
  var copyText = "http://localhost/Photos/add_friend.php?friend=<?php echo $addCode['token']; ?>";
  navigator.clipboard.writeText(copyText);
  Swal.fire({
  title: 'Copied!',
  text: 'Your friend link has been copied to your clipboard.',
  icon: 'success',
  timer: 2000,
  })
}
</script>
<?php
include_once("footer.php");
?>
