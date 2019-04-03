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
    $currentYear 		    = trim($_POST['currentYear']);
    $currentSemester 		= trim($_POST['currentSemester']);
    $fees 		            = trim($_POST['fees']);

    if($currentYear != "" && $currentSemester != ""  && $fees != "")
    {
        $editcatsql = mysqli_query($connect,"select * from fees_structure where year='".$currentYear."' and semester='".$currentSemester."' ");
        if(mysqli_num_rows($editcatsql) == 0)
        {
            $userinsertqry = "insert into fees_structure(year,semester,fees_amount) VALUE ('".$currentYear."','".$currentSemester."','".$fees."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-fees-structure.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-fees-structure.php?m=wrong");
                exit;
            }
        }
        else
        {
            header("Location: manage-fees-structure.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-fees-structure.php?m=wrong");
        exit;
    }
}
else if($_POST['btnsubmit'] == 'Update')
{
    $currentYear 		    = trim($_POST['currentYear']);
    $currentSemester 		= trim($_POST['currentSemester']);
    $fees 		            = trim($_POST['fees']);
    $uid =                  $_POST['f_id'];

    if($currentYear != "" && $currentSemester != ""  && $fees != "")
    {
        $editcatsql = mysqli_query($connect,"select * from fees_structure where id ='".$uid."'");
        if(mysqli_num_rows($editcatsql) > 0)
        {
            $updqry			=	"update fees_structure set year='".$currentYear."',semester='".$currentSemester."',fees_amount='".$fees."' where id='".$uid."'";
            mysqli_query($connect,$updqry);

            header("Location: manage-fees-structure.php?m=updt");
            exit;
        }
        else
        {
            header("Location: manage-fees-structure.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-fees-structure.php?m=wrong");
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
    $stids 		= $_REQUEST['id'];
    $editcatsql = mysqli_query($connect,"select * from fees_structure where id='".$stids."'");
    if($row = mysqli_fetch_assoc($editcatsql))
    {
        $currentYear		= $row['year'];
        $currentSemester	= $row['semester'];
        $fees_amount		= $row['fees_amount'];
    }
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
                    <h3 class="box-title">Add Fees Structure</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-fees-structure.php">
                            <button type="button" class="btn btn-block btn-info">Fees Structure</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-fees-structure.php" >
                    <input type="hidden" name="f_id" value="<?php echo $stids;?>">


                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="studname" class="col-sm-4 control-label">Select Year</label>
                                        <div class="col-sm-8">

                                            <select name="currentYear" class="form-control input-sm" tabindex="20" id="currentYear">
                                                <option value="FIRST">First (FY) </option>
                                                <option value="SECOND">Second (SY) </option>
                                                <option value="THIRD">Third (TY) </option>
                                            </select>


                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Select Semester</label>
                                        <div class="col-sm-8">
                                            <select name="currentSemester" class="form-control input-sm" tabindex="21" id="currentSemester">
                                                <option value="FIRST">First</option>
                                                <option value="SECOND">Second</option>
                                                <option value="THIRD">Third</option>
                                                <option value="FOURTH">Fourth</option>
                                                <option value="FIFTH">Fifth</option>
                                                <option value="SIX">Six</option>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-4 control-label">Fees Amount</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="fees" name="fees" placeholder="Fees Amount" value="<?php echo $fees_amount; ?>">
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
    $(function () {
        $("#currentYear").val("<?php echo $currentYear;?>");
        $("#currentSemester").val("<?php echo $currentSemester;?>");
    });
</script>
</body>
</html>
