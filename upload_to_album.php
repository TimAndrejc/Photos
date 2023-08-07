<?php

include_once("header.php");

if(!isset($_SESSION['id'])){
    header('Location:login.php');
    exit;
}
if(!isset($_GET['album'])){
    header('Location:index.php');
    exit;
}
?>
<style>
    * {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}


.wrapper {
  margin: auto;
  max-width: 900px;
  padding-top: 20px;
  text-align: center;
}

.container {
  padding: 20px;
  border-radius: 10px;
}

h1 {
  color: #130f40;
  letter-spacing: -.5px;
  font-weight: 700;
  padding-bottom: 10px;
}

.upload-container {
  background-color: rgb(239, 239, 239);
  border-radius: 6px;
  padding: 10px;
}

.border-container {
  border: 5px dashed rgba(198, 198, 198, 0.65);
/*   border-radius: 4px; */
  padding: 20px;
}

.border-container p {
  color: #130f40;
  font-weight: 600;
  font-size: 1.1em;
  letter-spacing: -1px;
  margin-top: 30px;
  margin-bottom: 0;
  opacity: 0.65;
}

#file-browser {
  text-decoration: none;
  color: rgb(22,42,255);
  border-bottom: 3px dotted rgba(22, 22, 255, 0.85);
}

#file-browser:hover {
  color: rgb(0, 0, 255);
  border-bottom: 3px dotted rgba(0, 0, 255, 0.85);
}

.icons {
  color: #95afc0;
  opacity: 0.55;
}
</style>
<form action="push_pictures.php" method="POST">
<div class="wrapper">
  <div class="container">
    <h1>Upload Images</h1>
    <div class="upload-container">
      <div class="border-container">
        <div class="icons fa-4x">
          <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
          <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
          <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
        </div>
        <input type="file" id="Pictures" class="pointer" style="width:100%; height:20vh; opacity:0;" multiple>
        <input type="hidden" id="album" name="album" value="<?php echo $_GET['album'] ?>">
        <input type="hidden" name="picnames" id="picnames" value="">
        <p> Click or drag images here.</p>
        <div class="progress" style="display:none;">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
  </div>
  <div class="uploaded-images">
</div>
<br>
<input type="submit" id="submitButton"  class ="btn btn-success" value="Upload" hidden>
</form>
</div>
<br>
<div style ="text-align:center;"> <a href="album.php?album=<?php echo $_GET['album'] ?>" class="linker">Back to Album</a></div>


<script>
    $("#file-upload").css("opacity", "0");

$("#file-browser").click(function(e) {
  e.preventDefault();
  $("#file-upload").trigger("click");
});
</script>

<script>
const fileInput = document.getElementById('Pictures');
const progressBar = document.querySelector('.progress-bar');
const prgoresdiv = document.querySelector('.progress');
const uploadedImagesContainer = document.querySelector('.uploaded-images');
const picNamesInput = document.getElementById('picnames');
const submitButton = document.getElementById('submitButton');


fileInput.addEventListener('change', (event) => {
    submitButton.hidden = false;
    prgoresdiv.hidden = false;
    const files = event.target.files; // Get all selected files
    // Loop through each file and upload
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const formData = new FormData();
        formData.append('file', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://slikice.timandrejc.eu/upload', true);

        xhr.upload.addEventListener('progress', (event) => {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                console.log('Progress:', percentComplete);
                progressBar.style.width = percentComplete + '%';
            }
        });

        xhr.onload = () => {
            if (xhr.status === 200) {
                console.log('File uploaded successfully.');
                var picname = xhr.responseText;
                    var picnames = document.getElementById('picnames').value;
                    if(picnames == ""){
                        picnames = picname;
                    }else{
                        picnames = picnames + "," + picname;
                    }
                    document.getElementById('picnames').value = picnames;
                     const fileContainer = document.createElement('div');
                fileContainer.classList.add('uploaded-file');
                fileContainer.innerHTML = `
                    <span class="filename">${file.name}</span>
                    <span class="remove-icon">x</span>
                `;

                // Add click event to remove icon
                const removeIcon = fileContainer.querySelector('.remove-icon');
                removeIcon.addEventListener('click', () => {
                    uploadedImagesContainer.removeChild(fileContainer);
                    const updatedPicNames = picNamesInput.value.split(',').filter(name => name !== picname).join(',');
                    picNamesInput.value = updatedPicNames;
                });

                uploadedImagesContainer.appendChild(fileContainer);
            } else {
                console.log('File upload failed.');
            }
        };

        xhr.send(formData);
    }

    prgoresdiv.hidden = true;
});

    </script>



<?php
include_once("footer.php");
?>