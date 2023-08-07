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
?>
<style>
    * {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}


.wrapper {
  margin: auto;
  max-width: 900px;
  padding-top: 20px;
  text-align: center;
}

.container {
  padding: 20px;
  border-radius: 10px;
}

h1 {
  color: #130f40;
  letter-spacing: -.5px;
  font-weight: 700;
  padding-bottom: 10px;
}

.upload-container {
  background-color: rgb(239, 239, 239);
  border-radius: 6px;
  padding: 10px;
}

.border-container {
  border: 5px dashed rgba(198, 198, 198, 0.65);
/*   border-radius: 4px; */
  padding: 20px;
}

.border-container p {
  color: #130f40;
  font-weight: 600;
  font-size: 1.1em;
  letter-spacing: -1px;
  margin-top: 30px;
  margin-bottom: 0;
  opacity: 0.65;
}

#file-browser {
  text-decoration: none;
  color: rgb(22,42,255);
  border-bottom: 3px dotted rgba(22, 22, 255, 0.85);
}

#file-browser:hover {
  color: rgb(0, 0, 255);
  border-bottom: 3px dotted rgba(0, 0, 255, 0.85);
}

.icons {
  color: #95afc0;
  opacity: 0.55;
}
</style>

<div class="wrapper">
  <div class="container">
    <h1>Upload Images</h1>
    <div class="upload-container">
      <div class="border-container">
        <div class="icons fa-4x">
          <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
          <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
          <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
        </div>
        <input type="file" id="file-upload" class="pointer" style="width:100%; height:20vh;" multiple>
        <p> Click or drag images here.</p>
    </div>
  </div>

</div>
<div style ="text-align:center;"> <a href="album.php?album=<?php echo $_GET['album'] ?>" class="linker">Back to Album</a></div>


<script>
    $("#file-upload").css("opacity", "0");

$("#file-browser").click(function(e) {
  e.preventDefault();
  $("#file-upload").trigger("click");
});
</script>

<?php
include_once("footer.php");
?>