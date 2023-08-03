<?php
include_once("header.php");
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}

?>

<?php
include_once("footer.php");
?>
