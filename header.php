<?php
session_start();
include("connect.php");
$userid = $_SESSION['ttb_userid'];
$result 	= 	mysqli_query($connect,"SELECT * from teacher where userid='".$userid."'");
if($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
}


?>
<header class="main-header">
    <a href="index.php" class="logo">
        <h5>M.L Parmar Science College</h5>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>


    </nav>
</header>