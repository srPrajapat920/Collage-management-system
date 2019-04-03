<?php
session_start();
include('connect.php');
include('common.php');

if($_SERVER['HTTP_REFERER'] == "")
{
    header("location:index.php");
    exit();
}
$blg = "active";
if($_POST['btnsubmit'] == 'Add')
{
    $teachername 		= trim($_POST['teachername']);
    $teacheraddress 		= trim($_POST['teacheraddress']);
    $teacherclass 		= trim($_POST['teacherclass']);
    $contactno 		= trim($_POST['contactno']);
    $username 		= trim($_POST['username']);
    $password 		= trim($_POST['password']);
    $subjects 		= trim($_POST['subjects']);
    $qualification 		= trim($_POST['qualification']);
    $email 		= trim($_POST['email']);
    $joindate 		= trim($_POST['joindate']);

    $cfileimg 		= $_FILES['cfileimg']['name'];
    $filename 		= explode(".",$cfileimg);

    if($teachername != "" && $teacherclass != "" )
    {
        $editcatsql = mysqli_query($connect,"select * from users where username='".$username."'");
        if(mysqli_num_rows($editcatsql) == 0)
        {

            if(strtolower($filename[1]) == 'jpg' || strtolower($filename[1]) == 'jpeg')
            {
                $path			=	'';
                $date_latest	= 	date("Y-m-d_H-i-s");
                $path 			= 	$date_latest.".jpg";
                copy($_FILES['cfileimg']['tmp_name'],'teacher-img/'.$path);

                if(file_exists('teacher-img/'.$path))
                {

                    $userinsertqry = "insert into users(username,password,user_type) VALUE ('".$username."','".$password."','teacher')";
                    $bgresultuser	=  mysqli_query($connect,$userinsertqry);
                    if($bgresultuser)
                    {
                        $progIdnewinsert 	= mysqli_insert_id($connect);
                    }else{
                        echo("Error description users: " . mysqli_error($connect));
                    }
                    $insertqry 		= "insert into teacher (userid,teachername,address,contactno,classteacher,subjects,qualification,email,joindate) value ('".$progIdnewinsert."','".$teachername."','".$teacheraddress."','".$contactno."','".$teacherclass."','".$subjects."','".$qualification."','".$email."','".$joindate."')";
                    $bgresult	=  mysqli_query($connect,$insertqry);

                    if($bgresult)
                    {
                        echo "student insert";
                        $progId 	= mysqli_insert_id($connect);
                        $npath	  	= $progId."_".$path;
                        rename('teacher-img/'.$path,'teacher-img/'.$npath);

                        mysqli_query($connect,"update teacher set teacherprofileurl='".$npath."' where teacherid='".$progId."'");
                        header("Location: manage-teacher.php?m=s");
                        exit;
                    }
                    else
                    {
                        //echo("Error description: " . mysqli_error($connect));
                        header("Location: manage-teacher.php?m=wrong");
                        exit;
                    }

                }
                else
                {
                    header("Location: manage-teacher.php?m=invld");
                    exit;
                }
            }
            else
            {
                header("Location: manage-teacher.php?m=wrngimg");
                exit;
            }
        }
        else
        {
            header("Location: manage-teacher.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-teacher.php?m=wrong");
        exit;
    }
}
else if($_POST['btnsubmit'] == 'Update')
{
    $teachername 		= trim($_POST['teachername']);
    $teacheraddress 		= trim($_POST['teacheraddress']);
    $teacherclass 		= trim($_POST['teacherclass']);
    $contactno 		= trim($_POST['contactno']);
    $username 		= trim($_POST['username']);
    $password 		= trim($_POST['password']);
    $subjects 		= trim($_POST['subjects']);
    $qualification 		= trim($_POST['qualification']);
    $email 		= trim($_POST['email']);
    $joindate 		= trim($_POST['joindate']);

    $cfileimg 		= $_FILES['cfileimg']['name'];
    $filename 		= explode(".",$cfileimg);
    $id				= $_POST['updateteacherid'];
    $uid = $_POST['updateuserid'];

    if($teachername != "" )
    {
        $editcatsql = mysqli_query($connect,"select * from teacher where teacherid ='".$id."'");
        if(mysqli_num_rows($editcatsql) > 0)
        {
            if($cfileimg != "")
            {
                if(strtolower($filename[1]) == 'jpg' || strtolower($filename[1]) == 'jpeg')
                {
                    $path			=	'';
                    $date_latest	= 	date("Y-m-d_H-i-s");
                    $path 			= 	$id."_".$date_latest.".jpg";
                    copy($_FILES['cfileimg']['tmp_name'],'teacher-img/'.$path);

                    if(file_exists('teacher-img/'.$path))
                    {

                        mysqli_query($connect,"update users set username='".$username."',password='".$password."' where userid='".$uid."'");

                        $updqry			=	"update teacher set teachername='".$teachername."',address='".$teacheraddress."',contactno='".$contactno."',classteacher='".$teacherclass."',subjects='".$subjects."',qualification='".$qualification."',email='".$email."',joindate='".$joindate."' where teacherid='".$id."'";
                        $blogresult		=	mysqli_query($connect,$updqry);

                        if($blogresult)
                        {
                            if(file_exists('teacher-img/'.$oldimhpt))
                            {
                                unlink('teacher-img/'.$oldimhpt);
                            }
                            mysqli_query($connect,"update teacher set teacherprofileurl='".$path."' where teacherid='".$id."'");
                            header("Location: manage-teacher.php?m=updt");
                            exit;
                        }
                        else
                        {
                            header("Location: manage-teacher.php?m=wrong");
                            exit;
                        }
                    }
                    else
                    {
                        header("Location: manage-teacher.php?m=invld");
                        exit;
                    }
                }
                else
                {
                    header("Location: manage-teacher.php?m=wrngimg");
                    exit;
                }
            }
            else
            {
                $userupdatequery = "update users set username='".$username."', password='".$password."' where userid='".$uid."'";
                mysqli_query($connect,$userupdatequery);

                $updqry			=	"update teacher set teachername='".$teachername."',address='".$teacheraddress."',contactno='".$contactno."',classteacher='".$teacherclass."',subjects='".$subjects."',qualification='".$qualification."',email='".$email."',joindate='".$joindate."' where teacherid='".$id."'";
                mysqli_query($connect,$updqry);

                header("Location: manage-teacher.php?m=updt");
                exit;
            }
        }
        else
        {
            header("Location: manage-teacher.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-teacher.php?m=wrong");
        exit;
    }
}

if($_REQUEST['act'] == 'add')
{
    $btn = 'Add';
}
else
{
    $btn 		= 'Update';
    $stids 		= $_REQUEST['teacher_id'];
    $editcatsql = mysqli_query($connect,"select * from teacher where teacherid='".$stids."'");
    if($row = mysqli_fetch_assoc($editcatsql))
    {
        $teacherid		= $row['teacherid'];
        $userid		= $row['userid'];
        $teachername		= $row['teachername'];
        $address		= $row['address'];
        $contactno		= $row['contactno'];
        $classteacher		= $row['classteacher'];
        $subjects		= $row['subjects'];
        $qualification		= $row['qualification'];
        $teacherprofileurl		= $row['teacherprofileurl'];
        $email		= $row['email'];
        $joindate		= $row['joindate'];

        $nextToupdateUserid= $userid;

        $edituser = mysqli_query($connect,"select * from users where userid='".$userid."'");
        if($rowuser = mysqli_fetch_assoc($edituser))
        {
            $username		= $rowuser['username'];
            $password		= $rowuser['password'];
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PEMS | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <?php include("top-link.php"); ?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Class</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-class.php">
                            <button type="button" class="btn btn-block btn-info">Class List</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-class.php" >
                    <input type="hidden" name="updateteacherid" value="<?php echo $stids;?>">
                    <input type="hidden" name="updateuserid" value="<?php echo $nextToupdateUserid;?>">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="studname" class="col-sm-3 control-label">Class</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="teachername" name="teachername" placeholder="Class Name" value="<?php echo $teachername; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-3 control-label">Division</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="teacheraddress"  name="teacheraddress" placeholder="Division" value="<?php echo $address; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-3 control-label">Section</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="teacherclass" name="teacherclass" placeholder="Section" value="<?php echo $classteacher; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="contactno" class="col-sm-3 control-label">Room No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="contactno" id="contactno" placeholder="Room No" value="<?php echo $contactno; ?>">
                                        </div>
                                    </div>


                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-success col-md-3" name="btnsubmit" id="btnsubmit" value="<?php echo $btn;?>">
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>
                </form>
            </div>

    </div>
    </section>
    <!-- /.content -->


    <!-- /.content-wrapper -->

    <?php include("footer.php"); ?>

</div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<?php include("bottom-link.php"); ?>
</body>
</html>
