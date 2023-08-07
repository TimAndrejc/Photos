<?php

if(isset($_POST['album'])){
    $_GET['album'] = $_POST['album'];
}

if(!isset($_GET['album'])){
    header('Location:index.php');
    exit;
}
include_once 'header.php';
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
require_once 'connection.php';
$query = "SELECT * FROM albums WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$album = $stmt->fetch();
if(!$album){
    header('Location:index.php');
    exit;
}
$query = "SELECT * FROM album_user WHERE album_id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album'], $_SESSION['id']]);
if($stmt->rowCount() == 0){
    header('Location:index.php');
    exit;
}
$query = "SELECT * FROM pictures WHERE album_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['album']]);
$pictures = $stmt->fetchAll();


?>
<div style="text-align:center;">
<br><br>
        <h1>Download Album - <?php echo $album['name'] ?></h1>
        <?php 
        $number = count($pictures);
        if($number == 1){
            echo "1 picture in album";
        }
        else {
            echo $number." pictures in album";
        }
        ?>
        
        <br><br>
        <form action="download_album.php" method="POST">
            <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>">
            <input type="submit" name="download" class ="btn btn-success"value="Download album">
        </form>
        <?php
        if(isset($_POST['download'])){
            $zip = new ZipArchive();
            $filename = "album_".$album['name']."_".$album['date_of_hangout'].".zip";
            if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
                exit("cannot open <$filename>\n");
            }
            foreach($pictures as $picture){
                $zip->addFile("uploads/".$picture['location'], $picture['name']);
            }
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename='.$filename);
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            unlink($filename);
        }
        ?>
        <br>
    <a href="album.php?album=<?php echo $_GET['album']; ?>" class="linker">Back to Album</a>
</div>

<?php
include_once 'footer.php';
?>