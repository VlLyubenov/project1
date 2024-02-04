<?php   
include 'database.php';

function getUsers($filter = array()){
    global $conn;
    
    if ($filter['keyword'] != ""){
        $sqlKeyword = "AND (users.name LIKE '%". $filter['keyword']."%' OR users.email LIKE '".$filter['keyword']."')";
    }

    if ($filter['age_from'] != "" && $filter['age_to'] != ""){
        $sqlAge = "AND `users`.`age` BETWEEN '".$filter['age_from']."' AND '".$filter['age_to']."'";
    }

    $sql = mysqli_query($conn, "SELECT
                                    users.id,
                                    users.email,
                                    users.password,
                                    users.name,
                                    users.age,
                                    users.created_at,
                                    (
                                        SELECT COUNT(`id`) FROM `salaries` WHERE `salaries`.`user_id` = `users`.`id`
                                    ) AS salaryCount,
                                    (
                                        SELECT COUNT(`id`) FROM `address` WHERE `address`.`user_id` = `users`.`id`
                                    ) AS addressCount,
                                    (
                                        SELECT SUM(`amount`) FROM `salaries` WHERE `salaries`.`user_id` = `users`.`id`
                                    ) AS salarySum
                                FROM users 
                                WHERE 1 $sqlKeyword $sqlAge
                                -- HAVING (salarySum) > 2000
                                ORDER BY `name` ASC") or die(mysqli_error($conn));

    return $sql;
}

function getMonths(){
    $monthsArr = array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );
    return $monthsArr;
}

function isUserExists($email){
    global $conn;
    $sql = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `email` LIKE '$email'") or die(mysqli_error($conn));
    $num = mysqli_num_rows($sql);
    if ($num > 0){
        return true;
    }else{
        return false;
    }
    
}

function isSalaryExists($user_id, $month, $year){
    global $conn;
    $sql = mysqli_query($conn, "SELECT `id` FROM `salaries` WHERE `user_id` = '$user_id' AND `month` = '$month' AND `year` = '$year'" );
    $num = mysqli_num_rows($sql);
    if ($num > 0){
        return true;
    }else{
        return false;
    }
}

function userInfo($id){
    global $conn;
    $sql = mysqli_query($conn , "SELECT * FROM `users` WHERE `id` = '$id'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    return $row;
}

function getUserSalary($user_id){
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM `salaries` WHERE  `user_id` = '$user_id' ORDER BY `year` ASC, `month` ASC") or die(mysqli_error($conn));
    return $sql;
}

function getUserAddresses($user_id){
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM `address` WHERE `user_id` = '$user_id'") or die(mysqli_error($conn));
    return $sql;
}



?>