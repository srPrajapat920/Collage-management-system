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
    $desc 		= trim($_POST['desc']);


    if($currentYear != "" && $desc != "" )
    {
        $editcatsql = mysqli_query($connect,"select * from admission_year where admission_year='".$currentYear."' and ad_desc='".$desc."' ");
        if(mysqli_num_rows($editcatsql) == 0)
        {
            $userinsertqry = "insert into admission_year(admission_year,ad_desc) VALUE ('".$currentYear."','".$desc."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-admission-year.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-admission-year.php?m=wrong");
                exit;
            }
        }
        else
        {
            header("Location: manage-admission-year.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-admission-year.php?m=wrong");
        exit;
    }
}
else if($_POST['btnsubmit'] == 'Update')
{
    $currentYear 		    = trim($_POST['currentYear']);
    $desc 		= trim($_POST['desc']);
    $uid =                  $_POST['f_id'];

    if($currentYear != "" && $desc != ""  )
    {
        $editcatsql = mysqli_query($connect,"select * from admission_year where id ='".$uid."'");
        if(mysqli_num_rows($editcatsql) > 0)
        {
            $updqry			=	"update admission_year set admission_year='".$currentYear."',ad_desc='".$desc."' where id='".$uid."'";
            mysqli_query($connect,$updqry);

            header("Location: manage-admission-year.php?m=updt");
            exit;
        }
        else
        {
            header("Location: manage-admission-year.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-admission-year.php?m=wrong");
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
    $editcatsql = mysqli_query($connect,"select * from admission_year where id='".$stids."'");
    if($row = mysqli_fetch_assoc($editcatsql))
    {
        $currentYear		= $row['admission_year'];
        $desc		= $row['ad_desc'];
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
                    <h3 class="box-title">Add Admission Year</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-fees-structure.php">
                            <button type="button" class="btn btn-block btn-info">List Admission Year</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-admission-year.php" >
                    <input type="hidden" name="f_id" value="<?php echo $stids;?>">


                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Admission Year</label>
                                        <div class="col-sm-8">

                                            <input type="text" class="form-control" id="currentYear" name="currentYear" placeholder="e.g 2018" value="<?php echo currentYear; ?>">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-4 control-label">Description</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="desc" name="desc" placeholder="e.g 2018-2019" value="<?php echo $desc; ?>">
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
