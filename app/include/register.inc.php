<?php
include "dbh.inc.php";

if((isset($_POST['submit']))){
   $email = $_POST["email"];
   $name = $_POST["name"];
   $username = $_POST["username"];
   
   $password = $_POST["pwd"];
   $cpassword = $_POST["cpwd"];
   //$user_type = $_POST['user_type'];  //todo

   require_once 'dbh.inc.php';
   require_once 'functions.inc.php';
   
   if (emptyInputSignup($email, $name, $username, $password, $cpassword) !== false) {
      header('location:../register.php?error=emptyinput');
      exit();
   }

   if (invalidUid($username) !== false) {
      header('location:../register.php?error=invaliduid');
      exit();
   }

   if (invalidEmail($email) !== false) {
      header('location:../register.php?error=invalidemail');
      exit();
   }

   if (pwdMatch($password, $cpassword) !== false) {
      header('location:../register.php?error=pwddontmatch');
      exit();
   }

   if (uidExists($conn, $username,  $email) !== false) {
      header('location:../register.php?error=usernametaken');
      exit();
   }

   createUser($conn, $email, $name, $username, $password);
} else {
   header('location:../register.php');
   exit();
}

?>