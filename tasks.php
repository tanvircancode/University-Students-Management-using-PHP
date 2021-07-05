<?php

include_once 'config.php';
include_once 'functions.php';

session_start();
$_SESSION['loggedin'] = $_SESSION['loggedin'] ?? '';

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    throw new Exception("Not Connected<br>");

}

$_POST['action'] = $_POST['action'] ?? '';
if ($_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email != '' && $password != '') {
        $q = "SELECT id,name,password FROM myclass WHERE email='$email' ";
        $info = mysqli_query($connection, $q);
        $res = mysqli_num_rows($info);
        $data = mysqli_fetch_assoc($info);
        $pass = $data['password'];
        if ($res > 0) {
            if (password_verify($password, $pass)) {
                $_SESSION['id'] = $data['id'];
                header('location:home.php');
                return;
            } else {
                $status = "email and password didn't match";
                // echo "email and password didn't match";

            }

        } else {
            $status = "user doesn't exists";
            //
        }
    } else {
        $status = "email or password is empty";
        //
    }
    header("location:index.php?status={$status}");

} else if ($_POST['action'] == 'register') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $roll = $_POST['roll'] ?? '';
    $cgpa = $_POST['cgpa'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if ($email && $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT into myclass(name,email,password,roll,cgpa,gender) VALUES ('$name','$email','$password','$roll','$cgpa','$gender')";
        $res = mysqli_query($connection, $query);
        if (mysqli_error($connection)) {
            $status = "Duplicate Email or Roll Number entered";
        } else {
            $status = "Information saved successfully";
        }
    } else {
        $status = "email or password is empty";
    }
    // var_dump($password);exit;
    header("location:index.php?status={$status}");
} else if ($_POST['action'] == 'editByAdmin') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $roll = $_POST['roll'] ?? '';
    $cgpa = $_POST['cgpa'] ?? '';
    $id = $_POST['user-id'] ?? '';
    $query = "UPDATE myclass SET name='$name', email='$email', roll='$roll', cgpa='$cgpa' WHERE id = '$id' ";
    $res = mysqli_query($connection, $query);
    if (mysqli_error($connection)) {
        $status = "Duplicate Email or Roll entered";
        header("location:edit.php?status={$status}&editId={$id}");
    } else {
        // $status = "Information Updated Successfully";
        header("location:home.php");
    }
} else if ($_POST['action'] == 'memberRequest') {
    $id = $_POST['taskid'];
    $query = "UPDATE myclass SET status=3 where id='$id' ";
    $res = mysqli_query($connection, $query);
    header('location:home.php');
} else if ($_POST['action'] == 'adminRequest') {
    $id = $_POST['taskid'];
    $query = "UPDATE myclass SET status=2 where id='$id' ";
    $res = mysqli_query($connection, $query);
    header('location:home.php');
} else if ($_POST['action'] == 'adminRequest') {
    $id = $_POST['taskid'];
    $query = "UPDATE myclass SET status=2 where id='$id' ";
    $res = mysqli_query($connection, $query);
    header('location:home.php');
} else if ($_POST['action'] == 'deleteRequest') {
    $id = $_POST['taskid'];
    $query = "DELETE FROM myclass WHERE id='$id' ";
    $res = mysqli_query($connection, $query);
    header('location:home.php');
}
