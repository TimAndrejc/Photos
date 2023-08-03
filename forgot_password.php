<?php
require_once 'connection.php';
if(!isset($_POST['email'])) {
    echo "No email address provided.";
    exit();
}
try{
$email = $_POST['email'];
$sender= "From: your@mail.com";
$token = md5(uniqid(rand(), true));
$token = substr($token, 0, 10);
$token = $token . time();
$token = md5($token);
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email]);
$user = $stmt->fetch()['id'];
if ($stmt->rowCount() == 0) {
    echo "No user with that email address exists.";
    exit();
}
$query = "INSERT INTO password_reset (user_id, token) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$user, $token]);

mail($email, "Password recovery", "Please visit this website to change your password: localhost/LanParty/passwordReset.php?token=$token", $sender);
}
catch(PDOException $e){
    echo $e->getMessage();
}

?>
