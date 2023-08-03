<?php
if(isset($_GET['forgotPassword'])){
?>
    <script src="https://unpkg.com/sweetalert2"></script> 
<script>Swal.fire({
  title: 'Enter your email',
  input: 'email',
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Send',
  cancelButtonText: 'Cancel',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
    $.ajax({
        url: 'forgot_password.php',
        type: 'POST',
        data: {
            email: login
        },
        success: function (data) {
            if (data == 'true') {
                Swal.fire({
                    title: 'Email sent!',
                    text: 'Check your email.',
                    icon: 'success'
                })
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'User with that email does not exist.',
                    icon: 'error'
                })
            }
        }
    })  
    },
    allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Email sent!',
                text: 'Check your email.',
                icon: 'success'
            })
        }
    })
</script>
<?php
}
?>