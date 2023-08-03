<?php
session_start();
if(isset($_SESSION['id'])){
    header("Location: index.php");
    die();
}
require_once 'connection.php';
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = htmlspecialchars($email);
    $email = trim($email);
    $email = strip_tags($email);
    $email = stripslashes($email);

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];        
            $_SESSION['username'] = $user['username'];     
            if($user['admin'] == 1) {
                $_SESSION['admin'] = 1;
            }
            header("Location: index.php?prijava=success");
            die();
        }
    }
}
header("Location: login.php?error=error");
?>