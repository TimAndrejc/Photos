
<style>
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}</style>
<?php
include_once 'header.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}
if(!isset($_GET['album'])){
    header("Location: index.php");
    exit;
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
                <a type="button" class="btn-close pointer" data-bs-dismiss="modal" aria-label="Close"><h3><i class="bi bi-x"></i></h3></a>
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




 <div class="container" style ="margin-top:10px; text-align: -webkit-center;">
    <div class="masonry-container">
    <?php
        $query ="SELECT * FROM pictures p INNER JOIN users u ON u.id=p.user_id WHERE album_id = ? ";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_GET['album']]);
        $pictures = $stmt->fetchAll();
        foreach($pictures as $picture){
            ?>
            <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                  <img src="uploads/<?php echo $picture['location'] ?>" alt="<?php echo $picture['username'] ?>" class="image" id="myImg">
                </div>
            </div>
        </div>
        <?php
        }
    ?>  
    </div>
</div>

<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
  // JavaScript for modal functionality
  var modal = document.getElementById("myModal");
  var img = document.getElementsByClassName("image");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");

  for (var i = 0; i < img.length; i++) {
    img[i].onclick = function() {
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }
  }

  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() {
    modal.style.display = "none";
  };
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>




