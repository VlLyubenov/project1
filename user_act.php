<?php
session_start();
include 'functions.php';


if (isset($_POST['add'])){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $age = $_POST['age'];

    if (empty($name) || empty($age) || empty($email) || empty($password)){
        $_SESSION['msg'] = '<div class="alert alert-danger">Please enter the requierd fields</div>'; 
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isUserExists($email)){
        $_SESSION['msg'] = '<div class="alert alert-danger">This user already exists</div>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


    $sql = mysqli_query($conn, "INSERT INTO users (`name`, `email`, `password`, `age`) VALUES ('$name', '$email', '$password', '$age')") or die(mysqli_error($conn));

    if ($sql) {
        $_SESSION['msg'] = '<div class="alert alert-success">The user has been added</div>';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
}


if (isset($_POST['edit'])) {

    $id = $_GET['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $age = $_POST['age'];

    if (empty($name) || empty($age) || empty($email)) {
        $_SESSION['msg'] = '<div class="alert alert-danger">Please enter the requierd fields</div>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (trim($_POST['password']) != "") {
        mysqli_query($conn, "UPDATE users SET `password` = '$password' WHERE `id` = '$id' ") or die(mysqli_error($conn));
    }

    $sql = mysqli_query($conn, "UPDATE users SET 
                                            `name` = '$name',
                                            `email` = '$email',
                                            `age` = '$age'
                                WHERE `id` = '$id'
                                ") or die(mysqli_error($conn));
    
    if ($sql){
        $_SESSION['msg'] = '<div class="alert alert-success">The user info has been edited</div>';
        header('Location: ' .$_SERVER['HTTP_REFERER']);
        exit;
    }

}


if ($_GET['action'] == 'delete'){
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM `users` WHERE `id` = '$id'") or die(mysqli_error($conn));
    if ($sql){
        $_SESSION['msg_delete'] = '<div class="alert alert-danger">The user has been deleted</div>';
        header('Location: ' .$_SERVER['HTTP_REFERER']);
        exit;
    }
}

?>