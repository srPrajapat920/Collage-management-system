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
    $curr_date = date("d/m/Y");
    $curr_year = date("Y");
    if($student_id != "" )
    {
        $editcatsql = mysqli_query($connect,"select * from transfer_certi where student_id='".$student_id."' ");
        if(mysqli_num_rows($editcatsql) == 0)
        {
            $userinsertqry = "insert into transfer_certi(student_id,current_year,created_date) VALUE ('".$student_id."','".$curr_year."','".$curr_date."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-transfer-certi.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-transfer-certi.php?m=wrong");
                exit;
            }
        }
        else
        {
            header("Location: manage-transfer-certi.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-transfer-certi.php?m=wrong");
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
                    <h3 class="box-title">Add Transfer Certificate</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-transfer-certi.php">
                            <button type="button" class="btn btn-block btn-info">Transfer Certificate List</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-transfer-certi.php" >

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
