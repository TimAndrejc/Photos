<?php
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
include_once("header.php");
?>

<?php
include_once("footer.php");
?>
