<?php
session_start();
include 'functions.php';


if (isset($_POST['add'])) {

    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    if (empty($user_id) || empty($amount) || empty($month) || empty($year)){
        $_SESSION['msg_salary'] = '<div class="alert alert-danger">Please enter all fields</div>';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isSalaryExists($user_id, $month, $year)) {
        $_SESSION['msg_salary'] = '<div class="alert alert-danger">This salary already exists</div>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $sql = mysqli_query($conn, "INSERT INTO salaries (`user_id`, `amount`, `month`, `year`) VALUES ('$user_id', '$amount', '$month', '$year')") or die(mysqli_error($conn));

    if ($sql) {
        $_SESSION['msg_salary'] = '<div class="alert alert-success">The salary has been added</div>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}


?>