<?php
session_start();
include("connect.php");

$fees_month= $_REQUEST["fees_month"];
$fees_year= $_REQUEST["fees_year"];
if($fees_month == ""){
    $studclass = "01";
}
if($fees_year == ""){
    $fees_year = "2015";
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
                            <h3 class="box-title">Fees Report</h3><br/>
                            <?php echo $msg; ?>
                            <form name="searchform" method="post" action="fees-report.php">
                                <table style="position: relative;float: right;" >
                                    <tr>
                                        <td>Select Month /Year :</td>
                                        <td>

                                            <select name="fees_month" class="form-control" id="fees_month">
                                                <option value="01">January </option>
                                                <option value="02">February</option>
                                                <option value="03">March </option>
                                                <option value="04">April</option>
                                                <option value="05">May </option>
                                                <option value="06">June </option>
                                                <option value="07">July </option>
                                                <option value="08">August </option>
                                                <option value="09">September </option>
                                                <option value="10">October </option>
                                                <option value="11">November </option>
                                                <option value="12">December </option>
                                            </select>

                                        </td>
                                        <td>
                                            <select name="fees_year" class="form-control"  id="fees_year">

                                                <?php
                                                $clgYear = mysqli_query($connect,"select *from admission_year");
                                                while($myrow = mysqli_fetch_assoc($clgYear))
                                                {
                                                    $ad_year   = $myrow['admission_year'];
                                                    $ad_desc   = $myrow['ad_desc'];
                                                    ?>
                                                    <option value="<?php echo $ad_year;?>"><?php echo $ad_year;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="submit" class="btn btn-info" value="Search"></td>
                                        <td>&nbsp;</td>

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
                                    <th>Total Semester Fees</th>
                                    <th>Total Fees Paid</th>
                                    <th>Remaining Fees</th>
                                    <th>Late Fees Charge</th>
                                    <th>Print</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $blogQuery = "select * from student_fees_details where fees_month='$fees_month' and fees_year='$fees_year'";
                                $result = mysqli_query($connect,$blogQuery);
                                $totalrows = mysqli_num_rows($result);
                                if($totalrows>0)
                                {
                                    $i = 1;
                                    while($row = mysqli_fetch_array($result)) {
                                        $p_id = $row['student_id'];
                                        $receipt_id = $row['id'];
                                        $clgYear = ("select * from student where id='$p_id'");
                                        $result_clg = mysqli_query($connect,$clgYear);
                                        while($myrow = mysqli_fetch_assoc($result_clg)) {
                                            $enr_no = $myrow['enrollment_no'];
                                            $f_nm = $myrow['first_name'];
                                            $m_nm = $myrow['middle_name'];
                                            $l_nm = $myrow['last_name'];
                                        }

                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $enr_no; ?></td>
                                            <td><?php echo  $f_nm ." ". $m_nm ." ".$l_nm; ?></td>
                                            <td><?php echo  $row['total_fees'];?></td>
                                            <td><?php echo  $row['total_amount'];?></td>
                                            <td><?php echo  $row['total_fees'] - $row['total_amount'];?></td>
                                            <td><?php echo  $row['late_fees_charges'];?></td>
                                            <td ><a href="fees-receipt-pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger">Print</a></td>
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
        $("#fees_month").val("<?php echo $fees_month;?>");
        $("#fees_year").val("<?php echo $fees_year;?>");

    });
</script>
</body>
</html>
