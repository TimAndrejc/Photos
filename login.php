<?php
require_once 'header.php';
if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
}
if(isset($_GET['error'])){
    echo"<script> Swal.fire({
      title: 'Error!',
      text: 'Incorrect email or password.',
      icon: 'error',
      })</script>";
}
if(isset($_GET['success'])){
    echo"<script> Swal.fire({
      title: 'Registration successful!',
      text: 'Confirm your email and login to continue.',
      icon: 'success',
      })</script>";
}
if(isset($_GET['forgotPassword'])){
  include 'modals/forgot_password_modal.php';
}
if(isset($_GET['notConfirmed'])){
    include 'modals/not_confirmed_modal.php';
}
?>
<form action="check_login.php" method="post" style="margin-top: 10px;">
  <section class="intro">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 2rem">
          <div class="card gradient-custom" style="border-radius: 1rem;">
            <div class="card-body p-5" style="padding: 0;">
              <div class="my-md-5">
                <div class="text-center">
                  <h1 class="fw-bold my-5 text-uppercase">LOGIN</h1>
                </div>
                <div class="form-outline form-white mb-4">
                    <input type="email" name="email" id="typeEmail" autocomplete="email" placeholder="Enter your email" class="form-control form-control-lg active text-gray" />
                    <label class="form-label text-gray" for="typeEmail">Email</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" id="typePassword" placeholder="Enter your password" name="password" class="form-control form-control-lg active text-gray" />
                    <label class="form-label text-gray" for="typePassword">Password</label>
                  </div>
                  <?php
                  if(isset($_GET['friend'])){
                    echo '<input type="hidden" name="friend" value="'.$_GET['friend'].'">';
                  }
                  ?>
                  <div class="text-center py-5"  style="padding:5px !important">
                    <button class="btn btn-light btn-lg btn-rounded px-5" type="submit">Login</button>
                  </div>
              </div>
              <div class="text-center">
                <p class="mb-0"><a href="register.php" class="fw-bold linker">Don't have an account?</a></p>
                <p class="mb-0"><a href="login.php?forgotPassword=true" class="fw-bold linker">Forgot your password?</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</form>



<?php
require_once 'footer.php';
?>