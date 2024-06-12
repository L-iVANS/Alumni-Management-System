<?php require 'function.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table boarder="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $users = mysqli_query($conn, "SELECT * FROM users");
                $i = 1;
                foreach($users as $row) :
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><img src="uploads/<?php echo $row["image"]; ?> " width="200" alt="Image"></td>
                <td>
                    <a href="edituser.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <form class="" action="" method="POST">
                        <button class="" type="submit" name="submit" value="<?php echo $row['id']; ?>">Archive</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="adduser.php">ADD NEW USER</a>

</body>
</html>