<?php
    if (isset($_SESSION['username'])) {
        if(isset($_SESSION['role']))
        {
            header("Location: ./admin/admin.php");
            exit();
        } else {
            header("Location: ./index.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>    <title>LSI勤怠管理</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php 
        include_once('./view/header.php'); 
    ?>
    <div class="container d-flex justify-content-center">
        <form action="include/login.inc.php" class="col-md-6 p-3 my-3" id="form-login" method="post">
            <h2 class="text-center text-uppercase mb-4 text-light">
                ログイン
            </h2>
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p class='text-warning'>Fill in all fields!</p>";
                    } else if ($_GET["error"] == "wronglogin") {
                        echo "<p class='text-warning'>Incorrect id or password</p>";
                    }
                }
            ?>
            <div class="form-group mb-3">        
                <input type="text" class="form-control" placeholder="IDまたメール" name="uid">
            </div>
            <div class="form-group mb-3">      
                <input type="password" class="form-control" placeholder="パスワード" name="pwd">
            </div>
            <div class="form-group mb-3">        
                <button type="input" name="submit" class="btn btn-primary" id="form-submit">ログイン</button>
            </div>
            <div class="form-group mb-3">        
                <a href="register.php" class="text-primary">Don't Have an Account?</a>
            </div>
        </form>
    </div>  
    <?php 
        include_once('./view/footer.php'); 
    ?>
</body>
</html>