<?php
if(isset($_GET['prijava'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Prijava uspešna!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
  }
if(isset($_GET['odjava'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Odjava uspešna!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
}
if(isset($_GET['passwordReset'])){
    echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Geslo uspešno spremenjeno!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
  }
