<?php 
    require 'function.php'; 
    $id = $_GET["id"];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT USER</title>
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
        NAME
        <input type="text" name="name" value="<?php echo $row['name'];?>" required> <br>
        IMAGE
        <input type="file" name="file" id="upload_file" onchange="getImagePreview(event)" required> <br>
        <img id="preview" src="uploads/<?php echo $row["image"]; ?> " width="200" alt="Image"> <br>
        <button type="submit" name="submit" value="update">Update</button>
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