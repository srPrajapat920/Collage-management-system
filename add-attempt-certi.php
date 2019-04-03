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
    $student_id 		    = trim($_POST['student_id']);
    $exdetails 		    = trim($_POST['exdetails']);
    $attempt 		    = trim($_POST['attempt']);
    $curr_date = date("d/m/Y");

    if($student_id != "" && $exdetails != "" && $attempt != "")
    {
        $editcatsql = mysqli_query($connect,"select * from attampt_certi where student_id='".$student_id."' ");
        if(mysqli_num_rows($editcatsql) == 0)
        {
            $userinsertqry = "insert into attampt_certi(student_id,exam_year,attampt,created_date) VALUE ('".$student_id."','".$exdetails."','".$attempt."','".$curr_date."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-attempt-certi.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-attempt-certi.php?m=wrong");
                exit;
            }
        }
        else
        {
            header("Location: manage-attempt-certi.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-attempt-certi.php?m=wrong");
        exit;
    }
}


if($_REQUEST['act'] == 'add')
{
    $btn = 'Add';
}
else
{

}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>M.L Parmar | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
                    <h3 class="box-title">Add Attempt Certificate</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-attempt-certi.php">
                            <button type="button" class="btn btn-block btn-info">Attempt Certificate List</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-attempt-certi.php">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="studname" class="col-sm-4 control-label">Select Student</label>
                                        <div class="col-sm-8">

                                            <select name="student_id" id="student_id" class="form-control">
                                                <?php
                                                $clgYear = mysqli_query($connect,"select *from student");
                                                while($myrow = mysqli_fetch_assoc($clgYear))
                                                {
                                                    $st_id   = $myrow['id'];
                                                    $f_name   = $myrow['first_name'];
                                                    $m_name   = $myrow['middle_name'];
                                                    $l_name   = $myrow['last_name'];
                                                    $enrollment_no = $myrow['enrollment_no'];

                                                    ?>
                                                    <option value="<?php echo $st_id;?>"><?php echo $enrollment_no . '-'. $f_name . '-'. $m_name . '-'. $l_name ;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Examination Details</label>
                                        <div class="col-sm-8">
                                            <input name="exdetails" class="form-control"  type="text" aria-describedby="nameHelp" placeholder="e.g April/May 2018">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Attempt</label>
                                        <div class="col-sm-8">
                                            <select name="attempt"class="form-control" id="attempt">
                                                <option value="FIRST">First </option>
                                                <option value="SECOND">Second </option>
                                                <option value="THIRD">Third </option>
                                                <option value="FOURTH">Fourth </option>
                                                <option value="FIFTH">Fifth </option>
                                                <option value="SIXTH">Sixth </option>
                                                <option value="SEVENTH">Seventh </option>
                                            </select>
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <input type="submit" class="btn btn-success col-md-3" name="btnsubmit" id="btnsubmit" value="<?php echo $btn;?>">
                                        </div>
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


<?php include("bottom-link.php"); ?>

<script>
    $(document).ready(function() { $("#student_id").select2(); });
</script>


</body>
</html>
