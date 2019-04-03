<?php
session_start();
include("connect.php");

$info = $_REQUEST['m'];
if($info == "s")
    $msg = '<span style="color:green; font-weight:600; font-size:20px"> Added Successfully</span>';
else if($info == "d")
{
    $msg = '<span style="color:green; font-weight:600; font-size:20px"> Deleted Successfully</span>';
}
else if($info == "updt")
    $msg = '<span style="color:green; font-weight:600; font-size:20px"> Updated Successfully</span>';
else if($info == "bg")
    $msg = '<span style="color:green; font-weight:600; font-size:20px"> Status Updated Successfully</span>';
else if($info == "exist")
    $msg = '<span style="color:red; font-weight:600; font-size:20px"> Already Exists.</span>';
else if($info == "wrong")
    $msg = '<span style="color:red; font-weight:600; font-size:20px">Something went wrong.Please try again later.</span>';
else if($info == "invld")
    $msg = '<span style="color:red; font-weight:600; font-size:20px">There is a problem with Image.Image should be in jpg/jpeg format.</span>';
else if($info == "wrngimg")
    $msg = '<span style="color:red; font-weight:600; font-size:20px">Only jpg and jpeg image allow</span>';
else if($info == "ndel")
    $msg = '<span style="color:red; font-weight:600; font-size:20px">Sorry..You Cannot Delete This Driver.You have to Delete Comment First in order to delete this blog.</span>';
else
    $msg = "";


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MLP | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("top-link.php"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Attempt Certificate</h3><br/>
                            <?php echo $msg; ?>
                            <form name="searchform" method="post" action="manage-attempt-certi.php">
                                <table style="position: relative;float: right;" >
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><a href="add-attempt-certi.php?act=add" class="btn btn-warning">Add Attempt Certificate</a></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                                <thead  style="text-align: center;">
                                <tr>

                                    <th>Id</th>
                                    <th>Enrollment No</th>
                                    <th>Name</th>
                                    <th>Examination Details</th>
                                    <th>Attempt</th>
                                    <th>Created Date</th>
                                    <th>Print</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $blogQuery = "select * from attampt_certi ";
                                $result = mysqli_query($connect,$blogQuery);
                                $totalrows = mysqli_num_rows($result);
                                if($totalrows>0)
                                {
                                    $i = 1;
                                    while($row = mysqli_fetch_array($result)) {
                                        $id = $row['id'];
                                        $st_id = $row['student_id'];

                                        $clgYear = ("select * from student where id='$st_id'");
                                        $result_clg = mysqli_query($connect,$clgYear);
                                        while($myrow = mysqli_fetch_assoc($result_clg)) {
                                            $enr_no = $myrow['enrollment_no'];
                                            $f_nm = $myrow['first_name'];
                                            $m_nm = $myrow['middle_name'];
                                            $l_nm = $myrow['last_name'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $id;?></td>

                                            <td><?php echo $enr_no;?></td>
                                            <td><?php echo  $f_nm ." ". $m_nm ." ".$l_nm; ?></td>
                                            <td><?php echo $row['exam_year'];?></td>
                                            <td><?php echo $row['attampt'];?></td>
                                            <td><?php echo $row['created_date'];?></td>
                                            <td ><a href="attempt-certi-pdf.php?id=<?php echo $id; ?>" class="btn btn-xs btn-primary">Print</a></td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                    }
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include("footer.php"); ?>
</div>
<?php include("bottom-link.php"); ?>
<script>
    $(function () {
        $("#example1").DataTable();

    });
</script>
</body>
</html>
