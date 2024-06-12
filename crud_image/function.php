<?php
     $serername="localhost";
     $db_username="root";
     $db_password="";
     $db_name="crud";
     $conn=mysqli_connect($serername, $db_username, $db_password, $db_name);

    if(isset($_POST['submit'])){
        if($_POST['submit'] == "add"){
            add();
        }else if($_POST['submit'] == "update"){
            update();
        }else{
            delete();
        }
    }

    function add(){
        global $conn;

        $name = $_POST["name"];
        $filename = $_FILES["file"]["name"];
        $tmpName = $_FILES["file"]["tmp_name"];
        
        $newfilename = uniqid() . "" . $filename;

        move_uploaded_file($tmpName, 'uploads/' . $newfilename);
        $query = "INSERT INTO users SET name='$name', image='$newfilename'";
        mysqli_query($conn, $query);

        echo
        "
            <Script>
                alert('User Added Successfully'); document.location.href ='index.php';
            </Script>
        ";
    }

    function update(){
        global $conn;

        $id = $_GET["id"];
        $name = $_POST["name"];

        if($_FILES["file"]["error"] !=4){
            $filename = $_FILES["file"]["name"];
            $tmpName = $_FILES["file"]["tmp_name"];

            $newfilename = uniqid() . "-" . $filename;
            
            move_uploaded_file($tmpName, 'uploads/' . $newfilename);
            $query = "UPDATE users SET image = '$newfilename' WHERE id=$id";
            mysqli_query($conn, $query);
        }

        $query = "UPDATE users SET name = '$name' WHERE id=$id";
        mysqli_query($conn, $query);

        echo
        "
            <Script>
                alert('User Edited Successfully'); document.location.href ='index.php'; 
            </Script>
        ";
    }

    function delete(){
        global $conn;

        $id = $_POST["submit"];
        $query = "DELETE FROM users WHERE id=$id";
        mysqli_query($conn, $query);

        echo
        "
            <Script> 
                alert('User Edited Successfully');
            </Script>
        ";
    }

?>