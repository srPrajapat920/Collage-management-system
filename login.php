<?php
session_start();
include("connect.php");

//sql injection redirect code
require_once ('common.php');
if(isset($_SESSION["sql"]))
{
    header("Location:bad.php");
    exit();
}

if($_REQUEST['msg'] == 'err')
    $msg = "Username or Password is wrong.";
else if($_REQUEST['msg'] == 'fpwd')
    $msg = "Forgot Password Link Send To Your Account";
else if($_REQUEST['msg'] == 's')
    $msg = "Your Password Has Been Reset Successfully";
else
    $msg = "";

if($_POST['btnsubmit'] == "Login")
{
    $username    	= 	$_POST['username'];
    $password 	= 	$_POST['password'];
    $result 	= 	mysqli_query($connect,"SELECT * from users where username='".$username."'");

    if($row = mysqli_fetch_assoc($result))
    {
        $pwd  =	$row['password'];

        if($password == $pwd)
        {
            $_SESSION['ttb_userid']     = $row['userid'];
            $_SESSION['ttb_useremail']  = $row['username'];
            header("Location: index.php");
            exit;
        }
        else
        {
            header("Location: login.php?msg=err");
            exit;
        }
    }
    else
    {
        header("Location: login.php?msg=err");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PEMS | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <!--<a href="../../index2.html"><b>Admin</b>LTE</a>-->
        <img src="img/logo.png">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session <br> <span style="color:red"><?php echo $msg;?></span></p>

        <form action="login.php" method="post" name="loginform">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-offset-3">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnsubmit" value="Login">Login</button>
                </div>

            </div>
        </form>
    </div>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
