<?php
session_start();
include("connect.php");

$studclass= $_REQUEST["current_semester"];
$gen= $_REQUEST["gender"];
if($studclass == ""){
    $studclass = "FIRST";
}
if($gen == ""){
    $gen = "Male";
}

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
                            <h3 class="box-title">Students Report</h3><br/>
                            <?php echo $msg; ?>
                            <form name="searchform" method="post" action="student-report.php">
                                <table style="position: relative;float: right;" >
                                    <tr>
                                        <td>Select Semester :</td>
                                        <td>
                                            <select name="current_semester" class="form-control"  id="current_semester">
                                                <option value="FIRST">First</option>
                                                <option value="SECOND">Second</option>
                                                <option value="THIRD">Third</option>
                                                <option value="FOURTH">Fourth</option>
                                                <option value="FIFTH">Fifth</option>
                                                <option value="SIX">Six</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="gender" class="form-control"  id="gender">
                                                <option value="Male">Boys</option>
                                                <option value="Female">Girls</option>
                                            </select>
                                        </td>
                                        <td><input type="submit" class="btn btn-info" value="Search"></td>
                                        <td>&nbsp;</td>
                                        <td><a href="add-student.php?act=add" class="btn btn-warning">Add Student</a></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                                <thead  style="text-align: center;">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Enrollment No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th> Semester</th>
                                    <th>Admission Year</th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $blogQuery = "select * from student where current_semester='$studclass' and gender='$gen'";
                                $result = mysqli_query($connect,$blogQuery);
                                $totalrows = mysqli_num_rows($result);
                                if($totalrows>0)
                                {
                                    $i = 1;
                                    while($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row['enrollment_no']?></td>
                                            <td><?php echo  $row['first_name'] ." ". $row['middle_name'] ." ". $row['last_name']?></td>
                                            <td><?php echo  $row['address1'] .",". $row['address2'] .",". $row['city'] ."-". $row['postal_code'];?></td>
                                            <td><?php echo  $row['student_contact_no'] ." / ". $row['parents_contact_no'];?></td>
                                            <td><?php echo  $row['current_semester']?></td>
                                            <td><?php echo  $row['admission_year']?></td>


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
        $("#current_semester").val("<?php echo $studclass;?>");
        $("#gender").val("<?php echo $gen;?>");

    });
</script>
</body>
</html>
