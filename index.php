<?php
include_once("header.php");
require_once 'modals/loginLogout_modal.php';
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
?>
Hello <?php echo $_SESSION['username'] ?>!

<?php
include_once("footer.php");
?>