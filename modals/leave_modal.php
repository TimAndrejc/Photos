<?php
if(isset($_GET['leave'])){
    $query = "SELECT * FROM teams WHERE  id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $team = $stmt->fetch();
    if($stmt->rowCount() == 0){
        header("Location: index.php");
        die();
    }
    if($_SESSION['id'] == $team['creator_id']){
        header("Location: index.php");
        die();
    }
  echo"<script> Swal.fire({
    title: 'Zapusti ekipo?',
    text: 'Si prepričan/a da želiš zapustiti ekipo?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ja!',
    cancelButtonText: 'Prekliči'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Zapuščena ekipa!',
        text: 'Zapistil/a si skupino.',
        icon: 'success',
        showConfirmButton: false,
        allowOutsideClick: false,
      })
      $.ajax({
        url: 'leave_team.php',
        type: 'POST',
        data: {
          team: ".$_GET['id']."
        }
      });
      setTimeout(function(){
        window.location.href = 'index.php';
      }, 2000);
     
    }else{
        window.location.href = 'team.php?id=".$_GET['id']."';
    }
  })</script>";
}