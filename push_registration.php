<?php
require_once 'connection.php';
if (!empty($_POST['email'])
        && !empty($_POST['password']) && !empty($_POST['username'])){

    $email = $_POST['email'];
    $email = htmlspecialchars($email);
    $email = trim($email);
    $email = strip_tags($email);
    $email = stripslashes($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       header("location:index.php");
       die();
    }
    if (strpos($email, '@') == false) {
        header("location:index.php");
        die();
    }

    $password = $_POST['password'];

    $username = $_POST['username'];
    $username = trim($username);
    $username = strip_tags($username);
    $username = stripslashes($username);
    $username = htmlspecialchars($username);
    $username = str_replace(' ', '', $username);

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
            
    if ($stmt->rowCount() == 0) {
        try{
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (id, username, email, password) VALUES (NULL, ?,?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email, $pass]);
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = $user['id'];
        $mailHead = implode("\r\n", [
        "MIME-Version: 1.0",
        "Content-type: text/html; charset=utf-8"
         ]);
        $token = md5(uniqid(rand(), true));
        $token = substr($token, 0, 10);
        $token = $token . time();
        $token = md5($token);
        $query ="INSERT INTO `confirmation` (`id`, `user_id`, `token`) VALUES (NULL, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user, $token]);
        mail($email, "Email confirmation", "Hello! <br>
        Please confirm your email  <a href = 'https://timandrejc.eu/Photos/confirm.php?token=$token' target=”_blank”> HERE! </a><br>", $mailHead);
        header("Location: login.php?success=success");
        }
        catch(Exception $e){
            echo $e;
        }
    }
    else{
        header("Location: register.php?error=AlreadyExists");
    }
    
}
else {
    header("Location: register.php");
}

?>