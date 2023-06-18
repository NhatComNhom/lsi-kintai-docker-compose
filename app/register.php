<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <title>LSI勤怠管理</title>
</head>
<body>
    <?php 
        include_once('./view/header.php'); 
    ?>
    <section class="register-form">
        <div class="container d-flex justify-content-center">
            <form action="include/register.inc.php" class="col-md-6 p-3 my-3" id="form-login" method="post">
                <h1 class="text-center text-uppercase mb-4 text-light">サインアップ</h1>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "<p class='text-warning'>全部埋めてください。</p>";
                        } else if ($_GET["error"] == "invaliduid") {
                            echo "<p class='text-warning'>ほかのユーザーネームを入れてください。</p>";
                        } else if ($_GET["error"] == "invalidemail") {
                            echo "<p class='text-warning'>ほかのEメールを入れてください。</p>";
                        } else if ($_GET["error"] == "pwddontmatch") {
                            echo "<p class='text-warning'>パスワード同一しない！</p>";
                        } else if ($_GET["error"] == "usernametaken") {
                            echo "<p class='text-warning'>ほかのユーザーネームを入れてください。</p>";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "<p class='text-warning'>エラーが発生しました。もう一度お試しください。</p>";
                        } else if ($_GET["error"] == "createuserfailed") {
                            echo "<p class='text-warning'>エラーが発生しました。もう一度お試しください。</p>";
                        }  else if ($_GET["error"] == "none") {
                            echo "<script>alert('サインアップ完了でした！');window.location.href='login.php';</script>";
                        }
                    }
                ?>
                <div class="form-group mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Eメール" name="email">
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="fullname" placeholder="フルネーム" name="name">
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="username" placeholder="ユーザーネーム" name="username">
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" id="password" placeholder="パスワード" name="pwd">
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control" id="cpassword" placeholder="パスワード確認" name="cpwd">
                </div>
                <div class="form-group mb-3">        
                    <button type="input" name="submit" class="btn btn-primary text-uppercase" id="form-submit">サインアップ</button>
                </div>
            </div>  
        </form>
    </section>
    <?php 
        include_once('./view/footer.php'); 
    ?>
</body>
</html>