<?php 
if(isset($_GET['TeamCreated'])){
    if($_GET['TeamCreated'] == 'success'){
      echo "<script>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Skupina je bila ustvarjena!',
        background: '#fff',
        showConfirmButton: false,
        timer: 1000
      });</script>";
    }
    else if($_GET['TeamCreated'] == "taken"){
        echo "<script>Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Skupina ni bila ustvarjena!',
            text: 'Ime skupine je že zasedeno!',
            showConfirmButton: false,
            timer: 4000
          });</script>";
    }
    else if($_GET['TeamCreated'] == "failed"){
        echo "<script>Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Skupina ni bila ustvarjena!',
            text: 'Skupine ni bilo možno narediti!',
            showConfirmButton: false,
            timer: 4000
          });</script>";
    }
    else{
      echo "<script>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Skupina ni bila ustvarjena!',
        showConfirmButton: false,
        timer: 1000
      });</script>";
    }
}
