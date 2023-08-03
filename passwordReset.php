<?php
if(!isset($_GET['token'])){
    header('Location: index.php');
    exit;
}
require_once 'connection.php';
$query = "SELECT * FROM password_reset WHERE token = ? AND used = 0";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['token']]);
if($stmt->rowCount() == 0){
    header('Location: index.php');
    exit;
}
if(isset($_POST['password'])){
    $query = "SELECT * FROM password_reset WHERE token = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['token']]);
    $user = $stmt->fetch()['user_id'];
    $query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([password_hash($_POST['password'], PASSWORD_DEFAULT), $user]);
    $query = "UPDATE password_reset SET used = 1 WHERE token = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['token']]);
    header('Location: index.php?passwordReset=success');
    exit;
}
include_once 'header.php';
?>
<form action="#" method="post"> 
<section class="intro">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom:2rem">
            <div class="card gradient-custom" style="border-radius: 1rem;">
              <div class="card-body p-5 text-white" style="padding:0">
                <div class="my-md-5">
                  <div class="text-center pt-1">
                 <i class="fa-solid fa-gamepad fa-3x"></i>
                    <h1 class="fw-bold my-5 text-uppercase">Change your password</h1>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" id="typePassword" placeholder="Vnesi geslo" name="password" class="form-control form-control-lg active" />
                    <label class="form-label" for="typePassword">New password</label>
                  </div>
                  <div class="text-center py-5"  style="padding:5px !important">
                    <button class="btn btn-light btn-lg btn-rounded px-5" type="submit">Change</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </section>
</form>
<?php
include_once 'footer.php';
?>