<?php

include_once("header.php");

if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
if(!isset($_GET['album'])){
    header('Location:index.php');
    exit;
}
require_once("connection.php");
$query ="SELECT * FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$album = $stmt->fetch();
$query ="SELECT*  FROM album_user WHERE album_id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album'],$_SESSION['id']]);
$album_user = $stmt->fetch();
if(!$album || !$album_user){
    header('Location:index.php');
    exit;
}

$query ="SELECT * FROM album_user WHERE album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$album_users = $stmt->fetchAll();

$album_users = array_column($album_users, 'user_id');

$query = "SELECT u.id, f.friend_id, token FROM friends f INNER JOIN users u ON u.id = f.user_id INNER JOIN confirmation c ON u.id = c.user_id WHERE (f.user_id = ? OR f.friend_id = ?) AND accepted = 1";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['id'],$_SESSION['id']]);
$mfriends = $stmt->fetchAll();

foreach($mfriends as $friend){
   if($friend['id'] == $_SESSION['id']){
        $query = "SELECT u.id, c.token, u.username FROM users u INNER JOIN confirmation c ON c.user_id=u.id WHERE u.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$friend['friend_id']]);
        $friend = $stmt->fetch();
        $friends[] = $friend;
    }
    else{
        $query = "SELECT u.id, c.token, u.username FROM users u INNER JOIN confirmation c ON c.user_id=u.id WHERE u.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$friend['id']]);
        $friend = $stmt->fetch();
        $friends[] = $friend;
    }
}


if(!$friends){
    echo '<div class="container mt-5" style="text-align:center;">';
    echo '<h2>You have no friends to add to this album</h2>';
    echo '</div>';
    include_once("footer.php");
    exit;
}

?>
<div class="container mt-5" style="text-align:center;">
    <h2>Select Friends to Add to the Album</h2>
    <br>
    <form method="post" action="push_friends_to_album.php">
        <?php
        foreach($friends as $friend){
            if(in_array($friend['id'], $album_users)){
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" name="friends[]" value="'.$friend['token'].'" id="'.$friend['token'].'" checked';
                if($album['creator_id'] != $_SESSION['id']){
                    echo ' disabled';
                }
                echo '>';
                echo '<label class="form-check-label" for="'.$friend['token'].'">'.$friend['username'].'</label>';
                echo '</div>';
            }else{
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" name="friends[]" value="'.$friend['token'].'" id="'.$friend['token'].'" >';
                echo '<label class="form-check-label" for="'.$friend['token'].'">'.$friend['username'].'</label>';
                echo '</div>';
            }
        }
        $freindsid=array_column($friends, 'id');
        foreach($album_users as $album_user){
            if($album_user == $_SESSION['id']){
                continue;
            }
            $query = "SELECT u.id, c.token, u.username FROM users u INNER JOIN confirmation c ON c.user_id=u.id WHERE u.id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$album_user]);
            $user = $stmt->fetch();
            if(!$user){
                continue;
            }
            
            if(in_array($user['id'], $freindsid)){
                continue;
            }
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="friends[]" value="'.$user['token'].'" id="'.$user['token'].'" checked ';
            if($album['creator_id'] == $user['id']){
                echo 'disabled';
            }
            echo '">';
            echo '<label class="form-check-label" for="'.$user['token'].'">'.$user['username'].'</label>';
            echo '</div>';

        }
        ?>
        <input type="hidden" name="album_id" value="<?php echo $_GET['album']; ?>">
        <br>
        <input type="submit" value="Add Friends" class="btn btn-primary">
    </form>
</div>
<?php
include_once("footer.php");
?>
