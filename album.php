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
<h1> <?php echo $album['name']?></h1>
<p> <?php echo date("d.m.Y", strtotime($album['date_of_hangout']))?></p>
<p> Created by <?php echo $creator ?></p>


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
                     <img src="uploads/<?php echo $picture['located']?>" alt="error" class="image">
                </div>
            </div>
        </div>
        <?php
        }
    ?>  
    <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div><div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://www.adorama.com/alc/wp-content/uploads/2018/11/landscape-photography-tips-yosemite-valley-feature.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
        <div class="masonry-item">
            <div class="row">
                <div class="col-md-12">
                     <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/ECurtis.jpg" alt="error" class="image">
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>




