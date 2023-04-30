<?php
    ob_start();
    session_start();
?>
<header>
<nav class="navbar navbar-expand-sm">
    <div class="container d-flex">
        <a class="navbar-brand" href="#">
            <h1 class="text-light">
                LSI勤怠管理
            </h1>
        </a>
        <div class="collapse navbar-collapse justify-content-end" id="navBarHeader">
            <ul class="navbar-nav ">
                <?php
                    if (isset($_SESSION["username"])){
                        echo "<li class='nav-item'><p class='text-info mt-2 ml-1'>Hello there, ".$_SESSION["name"]."</p></li>";
                        echo "<li class='nav-item'><a href='../include/logout.inc.php' class='nav-link text-light'>ログアウト</a></li>";
                    } else  {
                        echo "<li class='nav-item'><a href='../login.php' class='nav-link text-light'>ログイン</a></li>";
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>
</header>
<?php ob_end_flush(); ?>
