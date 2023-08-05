<?php
include_once("header.php");
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
require_once 'connection.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<form action="push_album.php" method="post" style="margin-top: 10px;">
<div class="modal fade" id="friendsModal" tabindex="-1" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="friendsModalLabel">Add Friends</h5>
                <a type="button" class="btn-close pointer" data-bs-dismiss="modal" aria-label="Close"><h1><i class="bi bi-x"></i></h1></a>
            </div>
            <?php 
            $query = "SELECT * FROM friends WHERE (user_id = ? OR friend_id = ?) AND accepted = 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['id'],$_SESSION['id']]);
            $friends = $stmt->fetchAll();
            ?>
            
            <div class="modal-body">
                
                <?php
                foreach($friends as $friend)
                {
                    if ($friend['user_id'] == $_SESSION['id'])
                    {
                        $query ="SELECT u.username, c.token FROM users u INNER JOIN confirmation c ON u.id = c.user_id WHERE u.id = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$friend['friend_id']]);
                        $friend = $stmt->fetch();
                        ?>
                        <div class="friend-checkbox">
                        <label for="<?php echo $friend['token']; ?>"><?php echo $friend['username']; ?></label>
                        <input type="checkbox" name="friends[]" value="<?php echo $friend['token']; ?>" id="<?php echo $friend['token']; ?>">
                        </div>
                        <br>
                        <?php
                    }
                    else
                    {
                        $query ="SELECT u.username, c.token FROM users u INNER JOIN confirmation c ON u.id = c.user_id WHERE u.id = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$friend['user_id']]);
                        $friend = $stmt->fetch();
                        ?>
                        <div class="friend-checkbox">
                        <label for="<?php echo $friend['token']; ?>"><?php echo $friend['username']; ?></label>
                        <input type="checkbox" name="friends[]" value="<?php echo $friend['token']; ?>" id="<?php echo $friend['token']; ?>">
                        </div>
                        <br>
                        <?php
                    }
                }
                ?>
            </div>
            
        </div>
    </div>
</div>

  <section class="intro">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 2rem">
          <div class="card gradient-custom" style="border-radius: 1rem;">
            <div class="card-body p-5" style="padding: 0;">
              <div class="my-md-5">
                <div class="text-center">
                  <h1 class="fw-bold my-5 text-uppercase">Create Album</h1>
                </div>
                <div class="form-outline form-white mb-4">
                  <input type="text" name="albumName" id="albumName" placeholder="Enter album name" class="form-control form-control-lg active text-gray" required/>
                  <label class="form-label text-gray" for="albumName">Album Name</label>
                </div>
                <div class="form-outline form-white mb-4">
                  <input type="date" name="hangoutDate" id="hangoutDate" class="form-control form-control-lg active text-gray" required />
                  <label class="form-label text-gray" for="hangoutDate">Date of Hangout</label>
                </div>
                <div class="form-outline form-white mb-4">
                <input type="file" name="albumCover" id="albumCover" class="form-control form-control-lg active text-gray" />
                <label class="form-label text-gray" for="albumCover">Album Cover <span style="font-size:12px">(can add later)</span></label>
                <div class="progress" hidden=true>
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>
                </div>
                <input type="hidden" name="filename" id="picname"/>
                </div>
                <div class="form-outline form-white mb-4">
                    <button type="button" class="btn btn-outline-secondary" style="width:100%" data-bs-toggle="modal" data-bs-target="#friendsModal">
                        Add Friends
                    </button>
                  <label class="form-label text-gray" for="accessibleFriends">Invite Friends <span style="font-size:12px" id ="nofriends">(can change later)</span></label>
                </div>
                <div class="text-center py-5" style="padding: 5px !important">
                  <button class="btn btn-light btn-lg btn-rounded px-5" type="submit">Create Album</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</form>

<?php
include_once("footer.php");
?>
<script>
        const fileInput = document.getElementById('albumCover');
        const progressBar = document.querySelector('.progress-bar');
        const prgoresdiv = document.querySelector('.progress');
        fileInput.addEventListener('change', (event) => {
            prgoresdiv.hidden = false;
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('file', file);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:3000/upload', true);

            xhr.upload.addEventListener('progress', (event) => {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                console.log('Progress:', percentComplete); // Add this line
                progressBar.style.width = percentComplete + '%';
            }
            });
            xhr.onload = () => {
                if (xhr.status === 200) {
                    console.log('File uploaded successfully.');
                    var picname = xhr.responseText;
                    document.getElementById("picname").value = picname;
                    console.log(picname);
                
                } else {
                    console.log('File upload failed.');
                }
            };

            xhr.send(formData);
            prgoresdiv.hidden = true;
        });
    </script>
    </script>
    <script>
        var friends = document.getElementsByName("friends[]");
        var nofriends = document.getElementById("nofriends");
        var count = 0;
        for (var i = 0; i < friends.length; i++)
        {
            friends[i].addEventListener("click", function(){
                if (this.checked)
                {
                    count++;
                }
                else
                {
                    count--;
                }
                if (count == 0)
                {
                    nofriends.innerHTML = "(can change later)";
                }
                else if (count == 1)
                {
                    nofriends.innerHTML = "(1 friend selected)";
                }
                else
                {
                    nofriends.innerHTML = "(" + count + " friends selected)";
                }
            });
        }
    </script>