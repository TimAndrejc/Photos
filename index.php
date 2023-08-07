<?php
include_once("header.php");
require_once 'modals/loginLogout_modal.php';
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
?>
<h2>Hello <?php echo $_SESSION['username'] ?>!</h2>

 <div class="container" style ="margin-top:10px; text-align: -webkit-center;">
    <div class="masonry-container">
<?php
    require_once 'connection.php';
    $query = "SELECT * FROM album_user a INNER JOIN albums u ON u.id = a.album_id WHERE user_id = ? ORDER BY date_of_hangout DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id']]);
    $albums = $stmt->fetchAll();
    foreach($albums as $album){
        $query = "SELECT * FROM albums WHERE id = ? ";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$album['album_id']]);
        $album = $stmt->fetch();
        ?>
        <a href="album.php?album=<?php echo $album['id'] ?>" style="text-decoration:none; color:black">
        <div class="masonry-item container album-<?php echo $album['id']; ?>">
            <div class="row">
                <div class="col-md-12">
                    <img class="card-img-top" src="uploads/<?php echo $album['main_pic'] ?>" alt="error">
                        <div class="overlay">
                            <div class="text"><?php echo $album['name']. '<br>'. date("d.m.Y", strtotime($album['date_of_hangout'])) ?></div>
                        </div>
                </div>
             </div>
        </div>
        </a>

        <?php
    }
    
    
?>
</div>
</div>
<?php
include_once("footer.php");
?>
<script>
    console.log(window.innerWidth);
    if(window.innerWidth > 768){
        var albumContainers = document.querySelectorAll('.masonry-item.container');

    // Set initial opacity to 0 for all overlays
    albumContainers.forEach(function(container) {
        var overlay = container.querySelector('.overlay');
        overlay.style.opacity = '0';
    });

    // Add event listeners to each album container
    albumContainers.forEach(function(container) {
        container.addEventListener('mouseenter', function() {
            var overlay = this.querySelector('.overlay');
            overlay.style.opacity = '1';
        });

        container.addEventListener('mouseleave', function() {
            var overlay = this.querySelector('.overlay');
            overlay.style.opacity = '0';
        });
    });

    }else{
           var textElements = document.querySelectorAll('.masonry-item .text');

    textElements.forEach(function(text) {
        text.style.fontSize = '12px'; // Set a smaller font size
        text.style.position = 'relative'; // Reset position
        text.style.color = 'black'; // Set text color to black
        text.style.textAlign = 'center'; // Center text
        text.style.padding = '5px'; // Add padding
        text.style.backgroundColor = 'white'; // Add background color for better contrast
    });

    // Set initial opacity to 1 for all overlays on mobile
    albumContainers.forEach(function(container) {
        var overlay = container.querySelector('.overlay');
        overlay.style.opacity = '0';
    });
    }
    
</script>



