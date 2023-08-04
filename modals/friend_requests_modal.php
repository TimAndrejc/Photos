<?php
if(isset($_GET['requests'])){
    $query = "SELECT * FROM friends WHERE friend_id = ? AND accepted = 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id']]);
    $requests = $stmt->fetchAll();

    ?>
    <style>
    .friend-card {
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .friend-username {
        font-size: 18px;
        margin-right: 10px;
    }

    .friend-buttons {
        display: flex;
        gap: 10px;
    }

    .friend-button {
        padding: 5px 10px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s, color 0.3s;
    }

    .accept-button {
        background-color: #28a745;
        color: #fff;

    }
    .accept-button:hover {
        text-decoration: none;
        color : #fff;
    }

    .remove-button {
        background-color: #dc3545;
        color: #fff;
    }
    .remove-button:hover {
        text-decoration: none;
        color : #fff;
    }
</style>

  <script src="https://unpkg.com/sweetalert2"></script>
    <script>
        Swal.fire({
        title: 'Friend requests',
        html: `<?php
        if(!$requests){
            echo 'You have no friend requests.';
        }
        foreach($requests as $request){
            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$request['user_id']]);
            $user = $stmt->fetch();
            echo '
            <div class="friend-card">
                <div class="friend-username">' . $user['username'] . '</div>
                <div class="friend-buttons">
                    <a href="" class="friend-button accept-button" onClick="Confirm('.$user['id'].')">Accept</a>
                    <a href="" class="friend-button remove-button" onClick="Remove('.$user['id'].')">Remove</a>
                </div>
            </div>
            ';
            
        }
        ?>`,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        })
        function Confirm(id){
            window.location.href = "friends.php?add=requests&confirm="+id;
        }
        function Remove(id){
         window.location.href = "friends.php?add=requests&removereq="+id;
        }
    </script>

<?php
}
