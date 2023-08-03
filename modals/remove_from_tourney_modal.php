<?php
if(isset($_GET['remove_from_tourney'])){
    $query = "SELECT * FROM teams WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $team = $stmt->fetch();
    if($_SESSION['id'] != $team['creator_id']){
        header("Location: index.php");
        die();
    }


  echo"<script> Swal.fire({
    title: 'Odjava ekipe',
    text: 'Če želite sodelovati v turnirju, morate ekipo ponovno prijaviti!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Odjava!',
    cancelButtonText: 'Prekliči'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Odjavljeno!',
        text: 'Ekipa je bila odjavljena. Zdaj lahko spremenite soigralce.',
        icon: 'success',
        showConfirmButton: false,
        allowOutsideClick: false,
      })
      $.ajax({
        url: 'add_to_tourney.php',
        type: 'POST',
        data: {
          team: ".$_GET['id']."
        }
      });
      setTimeout(function(){
        window.location.href = 'team.php?id=".$_GET['id']."';
      }, 2000);
     
    }else{
        window.location.href = 'team.php?id=".$_GET['id']."';
    }
  })</script>";
}