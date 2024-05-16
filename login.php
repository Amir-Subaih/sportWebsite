<?php

session_start();
include_once "config.php";
if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"]){
    header("Location:sport.php");
    return;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $errors = [];

    if(!isset($_POST["username"])){
        array_push($errors,"Username is required .");
    }else if (strlen($_POST["username"]) < 6){
        array_push($errors,"Username should be more than or equal 6 characters.");
    }else if (strlen($_POST["username"]) > 100){
        array_push($errors,"Username should be less than or equal 100 characters.");
    }

    if(!isset($_POST["password"])){
        array_push($errors,"Password is required");
    }else if (strlen($_POST["password"]) < 6){
        array_push($errors,"Password should be more than or equal 6 characters.");
    }else if (strlen($_POST["password"]) > 100){
        array_push($errors,"Password should be less than or equal 100 characters.");
    }
    if(count($errors)<=0){

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = mysqli_query($conn, "SELECT * FROM user WHERE username = '{$username}';");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if ($user_pass === $enc_pass) {
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if ($sql2) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    //DATABASE PROCESSING STEP
                    session_start();
                    $_SESSION["username"]=$username;
                    $_SESSION["isLogged"]=true;
                    header("Location:sport.php");
                    return;
                    echo "success";
                } else {
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "<script>alert('Email or Password is Incorrect!');</script>";
            }
        }

    }else{
        session_start();
        $_SESSION["errors"]=$errors;

        header("Location:login.php");
        return;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width,inital-scale-1,shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            background-image: url("images/sports_club.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        /*.bg-p1{
            background-image: url("images/waves.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            backdrop-filter: opacity(0.5);
        }*/
        .c1{
            color: #52340e;
            font-size: 20px;
        }
        .c1:hover{
            color: #652131;
            font-size: 24px;
        }
        .c2:hover{
            color: #652131;
            font-size: 24px;
        }
    </style>
    <title>Login</title>

</head>
<body>

<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-6 offset-0 offset-md-3">
            <div class="card shadow border shadow-lg bg-p1 bg-success">
                <div class="card-body">
                    <h2 class="text-center">
                        Login
                    </h2>
                    <hr>
                    <?php if (isset($_SESSION["errors"]) && count($_SESSION["errors"])>0) { ?>
                        <div class="alert-danger alert">
                            <ul class="my-0 list-unstyled">
                                <?php foreach ($_SESSION["errors"] as $errors) { ?>
                                    <li>
                                        <?php echo $errors; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION["errors"]); ?>
                    <?php } ?>
                    <form action="" method="POST">
                        <div class="form-group row">
                            <label for="username" class="col-form-label col-12">
                                Username
                            </label>
                            <div class="col-12">
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-form-label col-12">
                                Password
                            </label>
                            <div class="col-12">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary c2" type="submit">
                                Login
                            </button>

                        </div>
                    </form>
                    <div class="link text-center mt-3">Not yet signed up? <a href="index.php" class="c1">Signup now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-6 offset-0 offset-md-3">
            <div class="card shadow border shadow-lg bg-secondary">
                <div class="card-body">
                    <h2 class="text-center">
                        Comment
                    </h2>
                    <hr>
                    <marquee direction="bottom">
                        <?php
                        $Q1=mysqli_query($conn,"select * from comment;");
                        while($R1=mysqli_fetch_array($Q1)) {
                            echo "<div class='card shadow border shadow-lg bg-p1 bg-danger mt-2'>";
                            echo "<div class='card-body'>";
                            echo "<h1 class='text-center'>$R1[1]</h1>";
                            echo "<p class='mt-2 bg-success'>$R1[2]</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
