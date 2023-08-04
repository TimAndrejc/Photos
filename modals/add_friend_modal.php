<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
if(isset($_GET['add'])){
    ?>
  <script src="https://unpkg.com/sweetalert2"></script> 
<script>Swal.fire({
      title: 'Find friend',
      html:
      '<input id="swal-input1" autocomplete="off" placeholder="Username" class="swal2-input">',
      focusConfirm: false,
      required: true,
      showCancelButton: true,
      confirmButtonText: 'ADD',
      cancelButtonText: 'Cancel',
      showLoaderOnConfirm: true,
      preConfirm: function () {
                return new Promise(function (resolve) {
                    if ($('#swal-input1').val() == '') {
                        swal.showValidationMessage("Username is required!")
                        swal.enableButtons()
                        swal.hideLoading();
                        
                    } else {
                        swal.resetValidationMessage(); 
                        resolve([
                            $('#swal-input1').val()
                        ]);
                    }
                })
            },
            onOpen: function () {
                $('#swal-input1').focus()
            }
        }).then(function (result) {
            if (typeof(result.value) == 'undefined') {
                return false;
            }
            var username = result.value[0];
            $.ajax({
                url: 'add_friend_request.php',
                type: 'POST',
                data: {
                    username: username
                },
                success: function (data) {    
                if(data == "fuck me"){
                    Swal.fire({
                        title: 'Success!',
                        text: 'Friend request sent!',
                        icon: 'success',
                        timer: 2000,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    
                }else{
                    Swal.fire({
                        text: data,
                        icon: 'info',
                        timer: 2000
                        })
                }
            }});
        }).catch(swal.noop);
        </script>
    <?php
}
