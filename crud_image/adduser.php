<?php require 'function.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD USER</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        NAME
        <input type="text" name="name" required> <br>
        IMAGE
        <input type="file" name="file" id="upload_file" onchange="getImagePreview(event)" required> <br>
         <!-- preview image -->
         <div id="preview"></div>
        <button type="submit" name="submit" value="add">ADD</button>
    </form>
    <br>
    <a href="index.php">Index Page</a>

    <script type="text/javascript">
         function getImagePreview(event)
            {
                var image=URL.createObjectURL(event.target.files[0]);
                var imagediv= document.getElementById('preview');
                var newimg=document.createElement('img');
                imagediv.innerHTML='';
                newimg.src=image;
                newimg.width="300";
                imagediv.appendChild(newimg);
            }
    </script>
</body>
</html>