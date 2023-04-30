<?php

function emptyInputSignup($email, $name, $username, $password, $cpassword) {
    if (empty($email) || empty($name) || empty($username) || empty($password) || empty($cpassword)) {
        return true;
    } else {
        return false;
    }
}

function invalidUid($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail($email) {
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function pwdMatch($password, $cpassword) {
    if($password != $cpassword) {
        return true;
    } else {
        return false;
    }
}

function uidExists($conn, $username, $email) {
    $sql = " SELECT * FROM tbl_employees WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location:../register.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $name, $username, $password) {
    $role = 0;
    $insert = "INSERT INTO `tbl_employees` (`name`, `username`, `email`, `password`, `role`) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $insert)) {
        header('location:../register.php?error=createuserfailed');
        exit();
    }

    $hashPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssd", $name, $username, $email, $hashPwd, $role);
    mysqli_stmt_execute($stmt);
    header('location:../register.php?error=none');
    exit();
}

function emptyInputLogin($username, $password) {
    if (empty($username) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

function loginUser($conn, $username, $password) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header('location:../login.php?error=wronglogin');
        exit();
    }

    $pwdHashed = $uidExists["password"];
    $checkPwd = password_verify($password,$pwdHashed);

    if ($checkPwd === false) {
        header('location:../login.php?error=wronglogin');
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["username"] = $uidExists["username"];
        $_SESSION["name"] = $uidExists["name"];
        $_SESSION['success'] = 'Login Successfully!';
        $_SESSION['role'] = $uidExists["role"];
        if($_SESSION['role']) {
            echo "<script>alert('Hi Admin');window.location.href='../admin/admin.php';</script>";
        } else {
            echo "<script>alert('Login Successfully!');window.location.href='../attendance.php';</script>";
        }
        exit();
    }
}

?>