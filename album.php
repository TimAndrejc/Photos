<?php
include_once 'header.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}
if(!isset($_GET['album'])){
    header("Location: index.php");
    exit();
}
require_once 'connection.php';
$query = "SELECT* FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$album = $stmt->fetch();
if(!$album){
    header("Location: index.php");
    exit();
}

$query = "SELECT u.username FROM users u JOIN album_user a ON u.id = a.user_id WHERE a.album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);

$query = "SELECT username FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$album['creator_id']]);
$creator = $stmt->fetch(PDO::FETCH_COLUMN);

?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<div class="modal fade" id="friendsModal" tabindex="-1" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="friendsModalLabel">Options</h5>
                <a type="button" class="btn-close pointer" data-bs-dismiss="modal" aria-label="Close"><h1></h1></a>
            </div>
            <div class="modal-body" style="text-align:center;">
            <a href="upload_to_album.php?album=<?php echo $album['id']?>" class ="btn btn-outline-success">Upload Pictures</a><br><br>
            <a href="add_to_album.php?album=<?php echo $album['id']?>" class ="btn btn-outline-primary">Add Friends to album</a><br><br>
            <a href="download_album.php?album=<?php echo $album['id']?>" class ="btn btn-outline-warning">Download Album</a><br><br>
            <?php
            if($album['creator_id'] == $_SESSION['id']){
                ?>
                <a href="delete_album.php?album=<?php echo $album['id']?>" class ="btn btn-outline-danger">Delete Album</a>
                <?php
            }
            ?>
            </div>
            
        </div>
    </div>
</div>







<div class="info"><div style="text-align:right; padding-top:5px;"><button type="button" class="btn btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#friendsModal">
                        Options
                    </button></div> 
<h1> <?php echo $album['name']?></h1>

<p> <?php echo date("d.m.Y", strtotime($album['date_of_hangout']))?></p>
<p> Created by <?php echo $creator ?></p>
<p> Shared with <?php echo implode(", ", $users) ?></p>
</div>



<link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <div class="container" style ="margin-top:10px; text-align: -webkit-center;">
    <div class="masonry-container">
    <?php
        $query ="SELECT * FROM pictures WHERE album_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_GET['album']]);
        $pictures = $stmt->fetchAll();
        foreach($pictures as $picture){
            ?>
            <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="uploads/<?php echo $picture['location']?>" alt="error" class="image">
                </div>
            </div>
        </div>
        <?php
        }
    ?>  
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>




