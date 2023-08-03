<?php
require_once 'header.php';
if(isset($_GET['error'])){
  echo"<script> Swal.fire({
    title: 'Error!',
    text: 'An account already exists with that email.',
    icon: 'error',
    timer: 2000,
    })</script>";
}
?>
<form action="push_registration.php" method="post"style="margin-top: 10px;">
  <section class="intro">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 2rem">
          <div class="card gradient-custom" style="border-radius: 1rem;">
            <div class="card-body p-5" style="padding: 0;">
              <div class="my-md-5">
                <div class="text-center">
                  <h1 class="fw-bold my-5 text-uppercase">REGISTRATION</h1>
                </div>
                <div class="form-outline form-white mb-4">
                    <input type="text" name="username" id="typeEmail" placeholder="Enter a username" class="form-control form-control-lg active text-gray" />
                    <label class="form-label text-gray" for="typeEmail">Username</label>
                  </div>
                <div class="form-outline form-white mb-4">
                    <input type="email" name="email" id="typeEmail" autocomplete="email" placeholder="Enter your email" class="form-control form-control-lg active text-gray" />
                    <label class="form-label text-gray" for="typeEmail">Email</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" id="typePassword" placeholder="Enter your password" name="password" class="form-control form-control-lg active text-gray" />
                    <label class="form-label text-gray" for="typePassword">Password</label>
                  </div>
                  <div class="text-center py-5"  style="padding:5px !important">
                    <button class="btn btn-light btn-lg btn-rounded px-5" type="submit">Register</button>
                  </div>
              </div>
              <div class="text-center">
                <p class="mb-0"><a href="login.php" class="fw-bold linker">Already have an account?</a></p>
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