<?php
$connect= mysqli_connect('localhost', 'root', '', 'php');
if($connect){
    //echo "Database Connected";
}
else{
    echo "Database NOT Connected";
}

ob_start();

$pass_error_msg= '';

?>
<br>

<?php
    if(isset($_POST['button'])){
        $name= $_POST["name"];
        $email= $_POST["email"];
        $pass= $_POST["pass"];
        

        $pass_lenth= strlen($pass);
        if($pass_lenth >= 8 && $name!=null && $email!=null){

            $pass = sha1($pass);

            $sql_pass= "INSERT INTO user(username, email, passward) VALUES('$name', '$email', '$pass')";

            $data_pass= mysqli_query($connect, $sql_pass);

            if($data_pass){
                header('location: index.php');
            // echo "Value Insert Successfully"; 
            }
            else{
            echo "DATA Insert ERROR";
            }
        }

        else{
            $pass_error_msg= "Password Must be 8 Character Long <br> Or Username, Email, Password can't be empty";
            }
        
    
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>

<body style="display: flex;">

<div>
    <h3>User Info</h3>
    <table>
        <thead>
        <tr>
            <td> # </td>
            <td> Username </td>
            <td> Email </td>
            <td> Password </td>
            <td> Action</td>
        </tr>
        </thead>

        <tbody>
            <?php
                $read= "SELECT * FROM user";
                $read_pass= mysqli_query($connect, $read);

                $serial=0;

                while($read_feedback= mysqli_fetch_assoc($read_pass)){
                    $u_id     = $read_feedback['u_id'];
                    $username = $read_feedback['username'];
                    $email    = $read_feedback['email'];
                    $passward = $read_feedback['passward'];

                    $serial++;

                    ?>
                    <div>
                    <div>
                    <tr>
                    <td><?php echo $serial; ?>  </td>
                    <td><?php echo $username; ?></td>
                    <td><?php echo $email; ?>   </td>
                    <td><?php echo $passward; ?></td>
                    <td>
                        <a href="index.php?editid=<?php echo $u_id;?>"><button>Edit</button></a>
                        <a href="index.php?delid=<?php echo $u_id;?>"><button>Delete</button></a>
                    </td>
                    </tr>
                    </div>
            <?php
                }
                ?>
    </tbody>
    </table>
</div>

<?php
if(isset($_GET['editid'])){
    $edit_id= $_GET['editid'];

    $edit_info= "SELECT * FROM user WHERE u_id='$edit_id'";
    $edit_info_db= mysqli_query($connect, $edit_info);

    $edit_db_feedback= mysqli_fetch_assoc($edit_info_db);

        $username = $edit_db_feedback['username'];
        $email    = $edit_db_feedback['email'];
        $passward = $edit_db_feedback['passward'];

    ?>

    <div style="position: absolute; bottom: 300px; left: 60px;">
    <h3>Edit User Info</h3>
    <div style="text-align: center;">
    <form action="" method="post">
        <label for="">Edit Your Name</label>
        <input type="text" name="name" placeholder="Name" value="<?php echo $username; ?>"><br>
        <label for="">Edit Your Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>"><br>
        <label for="">Enter New Password</label>
        <input type="password" name="pass" placeholder="Password" style="margin-right: 23px;"><br>
        <input type="submit" name="button_edit" value="Edit">
    </form>
    </div>
    </div>


    <?php
    if(isset($_POST['button_edit'])){
        $name= $_POST['name'];
        $email= $_POST['email'];
        $pass= $_POST['pass'];

        $pass_lenth= strlen($pass);
        if($pass_lenth>=8){

            $pass= sha1($pass);

            $update= "UPDATE user SET username='$name', email='$email', passward='$pass' WHERE u_id='$edit_id'";
            $update_query= mysqli_query($connect, $update);

            if($update_query){
                header('location: index.php');
            }
            else{
                echo "Update Error!";
            }
        }
        if(empty($pass)){
            $pass= $passward;
            $update= "UPDATE user SET username='$name', email='$email', passward='$pass' WHERE u_id='$edit_id'";
            $update_query= mysqli_query($connect, $update);

            if($update_query){
                header('location: index.php');
            }
            else{
                echo "Update Error!";
            }
        }
        else{
            echo "<p style='position: relative; top: 385px; right: 506px; color: red;'>Password Must be 8 Digit Long!</p>";
        }
    }
    ?>

<?php
}
?>

<div style="text-align: center; padding-top: 100px; margin-left: 165px;">
<form action="" method="post">
    <label for="">Enter Your Name</label>
    <input type="text" name="name" placeholder="Name"><br>
    <label for="">Enter Your Email</label>
    <input type="email" name="email" placeholder="Email"><br>
    <label for="">Enter Your Password</label>
    <input type="password" name="pass" placeholder="Password" style="margin-right: 23px;"><br>
    <small style="color: red;"><?php echo $pass_error_msg; ?></small><br>
    <input type="submit" name="button" value="ENTER">
</form>
</div>
</div>


<?php 
    if(isset($_GET['delid'])){

        $delete_id = $_GET['delid'];
        
        $del= "DELETE FROM user WHERE u_id= '$delete_id'";

        $delete= mysqli_query($connect,$del);

        if($delete){
            header('location: index.php');
        }
        else{
        echo "Delete Error!!";
        }
    }
    
?>

<?php 
    ob_end_flush();
?>

</body>
</html>