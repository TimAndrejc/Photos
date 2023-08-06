<?php
include_once("header.php");
require_once 'modals/loginLogout_modal.php';
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
?>
<h2>Hello <?php echo $_SESSION['username'] ?>!</h2>
<div class="row" style ="width:100%; text-align:center; text-align: -webkit-center;">

<?php
    require_once 'connection.php';
    $query = "SELECT * FROM album_user WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id']]);
    $albums = $stmt->fetchAll();
    foreach($albums as $album){
        $query = "SELECT * FROM albums WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$album['album_id']]);
        $album = $stmt->fetch();
        ?>
        <a href="album.php?album=<?php echo $album['id'] ?>" style ="text-decoration:none; color:black"><div class="col-sm-6 col-lg-4" style="padding: 15px;">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="uploads/<?php echo $album['main_pic']?>" alt="error">
            <div class="card-body">
                <h5 class="card-title"><?php echo $album['name']?></h5>
                <p class="card-text"><?php echo date("d.m.Y", strtotime($album['date_of_hangout'])) ?></p>
            </div>
        </div>
    </div>
    </a>
        <?php
    }
    
    
?>
</div>
<?php
include_once("footer.php");
?>