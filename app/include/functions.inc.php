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
    $sql = "SELECT * FROM tbl_employees WHERE username = $1 OR email = $2;";
    $stmt = pg_prepare($conn, "uid_exists", $sql);
    if (!$stmt) {
        header('location:../register.php?error=stmtfailed');
        exit();
    }

    $resultData = pg_execute($conn, "uid_exists", array($username, $email));

    if ($row = pg_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    pg_free_result($resultData);
}

function createUser($conn, $email, $name, $username, $password) {
    $role = 0;
    $insert = "INSERT INTO tbl_employees (name, username, email, password, role) VALUES ($1, $2, $3, $4, $5)";
    $stmt = pg_prepare($conn, "create_user_query", $insert);
    if (!$stmt) {
        header('location:../register.php?error=createuserfailed');
        exit();
    }

    $hashPwd = password_hash($password, PASSWORD_DEFAULT);

    $result = pg_execute($conn, "create_user_query", array($name, $username, $email, $hashPwd, $role));
    if (!$result) {
        header('location:../register.php?error=createuserfailed');
        exit();
    }
    
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
            echo "<script>alert('Adminページへようこそ');window.location.href='../admin/admin.php';</script>";
        } else {
            echo "<script>alert('ログインしました！');window.location.href='../attendance.php';</script>";
        }
        exit();
    }
}

?>