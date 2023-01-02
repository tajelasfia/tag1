loc)  4.63 KB

<?php

require "conn.php";

if(!empty($_GET['user_id']))
{
    $user_id = $_GET['user_id'];

    $sql = "select * from users where user_id = ?";
    $result = $conn->prepare($sql);
    $result->bind_param("i",$user_id);
    $result->execute();

    $GetResult = $result->get_result();

    $UserRow = $GetResult->fetch_assoc();

}

if (isset($_POST['Add'])){

    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $q = "insert into users(user_name,password,phone,address) values (?, ?, ?, ?)";
    $r = $conn->prepare($q);
    $r->bind_param("ssis", $user_name, $password, $phone, $address);
    $e = $r->execute();

    if($e){
        $msg = "<font color='green'>Has been saved</font>";
    }else {
        $msg = "<font color='red'>Has not been saved</font>";
    }
}

if (isset($_POST['Edit'])){

    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "update users set user_name= ?, password=?, phone=?, address=? where user_id=?";
    $result = $conn->prepare($sql);
    $result->bind_param("ssisi", $user_name, $password, $phone, $address, $user_id);
    $e = $result->execute();
    
    if($e){
        $msg = "<font color='green'>Has been updated</font>";
    }else {
        $msg = "<font color='red'>Has not been updated</font>";
    }

}

if(!empty($_GET['duser_id'])){

    $user_id = $_GET['duser_id'];

    $sql = "delete from users where user_id=?";
    $result = $conn->prepare($sql);
    $result->bind_param("i", $user_id);
    $e = $result->execute();

    if($e){
        $msg = "<font color='green'>Has been deleted</font>";
    }else {
        $msg = "<font color='red'>Has not been deleted</font>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Home Page</title>
<meta charset="UTF-8">
<meta name="descrption" contant="My First Page">
<meta name="kewords" contant="My, First, Page">

<link href="./css/style.css" rel="stylesheet">
</head>

<body>
<div class="header">
    Hame Page
</div>

<div class="page">
<a href="home.php">Home</a>
<a href="users.php">Users</a>
</div>

<div class="page">
    <div class="left">
        <form method="post" action="home.php">
            <?php echo $msg; ?>
        <table>
            <input type="hidden" name="user_id" value="<?php echo $UserRow['user_id']; ?>">
        <tr>
            <td>UserName:</td>
            <td><input type="text" name="user_name" value="<?php echo $UserRow['user_name']; ?>" ></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="text" name="password" value="<?php echo $UserRow['password']; ?>"></td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td><input type="number" name="phone" value="<?php echo $UserRow['phone']; ?>"></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><textarea cols="20" rows="7" name="address"><?php echo $UserRow['address']; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2">
            <?php  
            if(!empty($_GET['user_id'])){
            ?>
                <input type="submit" class="btn btn2" name="Edit" value="Edit" >
            <?php
            } else {
            ?>
                <input type="submit" class="btn btn1" name="Add" value="Add" >
            <?php
            }
            ?>
            </td>
        </tr>

        </table>

        </form>

        </div>
        <div class="right">
          <table class="table">
            <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Password</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>
            <?php
            $sql = "select * from users order by user_id";
            $result = $conn->prepare($sql);
            $result->execute();
            $GetResult = $result->get_result();
            $i = 0;
            while ($row = $GetResult->fetch_assoc()) {
            ?>
            <tr>
            <td><?php echo ++$i; ?></td>
            <td><?php echo $row['user_name']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><a class="btn btn2" href="home.php?user_id=<?php echo $row['user_id']; ?>">Edit</a></td>
            <td><a class="btn btn3" href="home.php?duser_id=<?php echo $row['user_id']; ?>">Delete</a></td>
            </tr>
            <?php
            }
            ?>
          </table>
        </div>
</div>

</body>



</html>