<?php

// $t = "admin()@admin//.com";
//echo filter_var($t,FILTER_SANITIZE_EMAIL);
session_start();
include_once "config.php";
if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"]){
    header("Location:sport.php");
    return;
}
if(isset($_POST["email"]) && isset($_POST["username"])){
    $email=$_POST["email"];
    $username=$_POST["username"];
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $errors = [];


    if (strlen($_POST["firstname"]) > 60){
        array_push($errors,"First name should be less than or equal 60 characters.");
    }

    if (strlen($_POST["lastname"]) > 60){
        array_push($errors,"Last name should be less than or equal 60 characters.");
    }

    if(!isset($_POST["username"])||strlen($_POST["username"]) <=0){
        array_push($errors,"Username is required .");
    }else if (strlen($_POST["username"]) < 6){
        array_push($errors,"Username should be more than or equal 6 characters.");
    }else if (strlen($_POST["username"]) > 100){
        array_push($errors,"Username should be less than or equal 100 characters.");
    }else {
        $sql1 = mysqli_query($conn, "SELECT * FROM user WHERE username = '{$username}'");
        if (mysqli_num_rows($sql1) > 0) {
            array_push($errors, "$username - This username already exist!");
        }
    }

    if(!isset($_POST["email"])||strlen($_POST["email"]) <=0){
        array_push($errors,"Email is required .");
    }else if (strlen($_POST["email"]) > 125){
        array_push($errors,"Email should be less than or equal 125 characters.");
    }else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        array_push($errors,"Email ($email) is not valid.");
    }else {
        $sql2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}';");
        if (mysqli_num_rows($sql2) > 0) {
            array_push($errors, "$email - This email already exist!");
        }
    }

    if(!isset($_POST["password"])||strlen($_POST["password"]) <=0){
        array_push($errors,"Password is required");
    }else if (strlen($_POST["password"]) < 6){
        array_push($errors,"Password should be more than or equal 6 characters.");
    }else if (strlen($_POST["password"]) > 100){
        array_push($errors,"Password should be less than or equal 100 characters.");
    }

    if(!isset($_POST["repassword"])||strlen($_POST["repassword"]) <=0){
        array_push($errors,"Retype Password is required");
    }else if (strlen($_POST["repassword"]) < 6){
        array_push($errors,"Retype Password should be more than or equal 6 characters.");
    }else if (strlen($_POST["repassword"]) > 100){
        array_push($errors,"Retype Password should be less than or equal 100 characters.");
    }

    if (strlen($_POST["bio"]) > 1000){
        array_push($errors,"Bio should be less than or equal 1000 characters.");
    }

    if(count($errors)<=0){
        if(strcmp($_POST["password"],$_POST["repassword"]) != 0){
            array_push($errors,"Passwor and Retype Password do not match.");
        }else{
            $f_name=$_POST["firstname"];
            $l_name=$_POST["lastname"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $birthdate=$_POST["birthDate"];
            $gender=$_POST["gender"];
            $bio=$_POST["bio"];
                $encrypt_pass = md5($password);
            $ran_id = rand(time(), 100000000);
            $status = "Active now";
                $q1="INSERT INTO user values ('{$f_name}','{$l_name}','{$username}','{$email}','{$encrypt_pass}','{$birthdate}','{$gender}','{$bio}','{$ran_id}','{$status}');";
                $q2=mysqli_query($conn,$q1) or die("the problem in query 1.");
            if($q2) {
                $select_sql2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}';");
                if (mysqli_num_rows($select_sql2) > 0) {
                    $result = mysqli_fetch_assoc($select_sql2);
                    $_SESSION['unique_id'] = $result['unique_id'];
                    session_start();
                    $_SESSION["username"]=$username;
                    $_SESSION["isLogged"]=true;
                    header("Location:sport.php");
                } else {
                    echo "This email address not Exist!";
                }
            }
            }
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
            background-image: url("images/design.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
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
    <title>Register</title>

</head>
<body>

<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-6 offset-0 offset-md-3">
            <div class="card shadow border shadow-lg">
                <div class="card-body">
                    <h2 class="text-center">
                        Register
                    </h2>
                    <hr>
                    <?php if (isset($errors) && count($errors)>0) { ?>
                        <div class="alert-danger alert">
                            <ul class="my-0 list-unstyled">
                                <?php foreach ($errors as $errors) { ?>
                                    <li>
                                        <?php echo $errors; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <form action="" method="POST" novalidate>
                        <div class="form-group row">
                            <label for="firstname" class="col-form-label col-12">
                                First Name
                            </label>
                            <div class="col-12">
                                <input type="text" name="firstname" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname" class="col-form-label col-12">
                                Last Name
                            </label>
                            <div class="col-12">
                                <input type="text" name="lastname" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-form-label col-12">
                                Username
                            </label>
                            <div class="col-12">
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-form-label col-12">
                                Email
                            </label>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control">
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
                        <div class="form-group row">
                            <label for="repassword" class="col-form-label col-12">
                                Retype Password
                            </label>
                            <div class="col-12">
                                <input type="password" name="repassword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthDate" class="col-form-label col-12">
                                BirthDate
                            </label>
                            <div class="col-12">
                                <input type="date" name="birthDate" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-form-label col-12">
                                Gender
                            </label>
                            <div class="col-12">
                                <select name="gender" class="form-control" id="gender">
                                    <option value="" selected disabled></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bio" class="col-form-label -12col">
                                Bio.
                            </label>
                            <div class="col-12">
                                <textarea name="bio" id="bio" class="form-control"
                                          cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary c2" type="submit">
                                Register
                            </button>
                        </div>
                    </form>
                    <div class="link text-center mt-2">Already signed up? <a href="login.php" class="c1">Login now</a></div>
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
