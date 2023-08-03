<?php
if(isset($_GET['prijava'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Login successful!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
  }
if(isset($_GET['odjava'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Logout successful!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
}
if(isset($_GET['passwordReset'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Password changed successfully!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
  }
