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
    $selectstudent=$_POST['student_id'];
    $fees=$_POST['fees'];
    $mode=$_POST['mode'];
    $notes=$_POST['notes'];
    $enrollmentno=$_POST['enrollment_no'];
    $semester=$_POST['semester'];
    $year=$_POST['year'];
    $tutionfee=$_POST['tutionfee'];
    $admissionfee=$_POST['admissionfee'];
    $icard=$_POST['icard'];
    $welfareactivitiesfee=$_POST['welfareactivitiesfee'];
    $feeforbooks=$_POST['feeforbooks'];
    $unionfee=$_POST['unionfee'];
    $amenitiesfee=$_POST['amenitiesfee'];
    $campusdevfee=$_POST['campusdevfee'];
    $internalexamfee=$_POST['internalexamfee'];
    $enrollmentfee=$_POST['enrollmentfee'];
    $laboratoryfee=$_POST['laboratoryfee'];
    $librarydeposit=$_POST['librarydeposit'];
    $unicampusdev=$_POST['unicampusdev'];
    $cultureactivities=$_POST['cultureactivities'];
    $complexdevfee=$_POST['complexdevfee'];
    $activityfund=$_POST['activityfund'];
    $latefees=$_POST['latefees'];
    $total=$_POST['total'];

    $total = $total - $latefees;
    $total_amount = $_POST['total'];
    $curr_date=$_POST['curr_date'];
    $time = strtotime($curr_date);
    $date = date('d/m/Y',$time);
    $curr_year = date("Y");
    $curr_month = date("m");

    if($selectstudent != "" && $total != "")
    {
        $userinsertqry="INSERT INTO student_fees_details(student_id,enrollment_no,semester,year,date,fees_month,fees_year,tution_fee,admission_fee,i_card_fee,welfare_activities_fee,fees_for_books,union_fee,amenities_fee,campus_dev_fee,internal_exam_fee,enrollment_fee,laboratory_fee,library_fee,uni_campus_dev_fee,uni_sport_fee,uni_sport_complex_fee,total,late_fees_charges,total_amount,total_fees,payment_mode,payment_details) VALUES ('".$selectstudent."','".$enrollmentno."','".$semester."','".$year."','".$date."','".$curr_month."','".$curr_year."','".$tutionfee."','".$admissionfee."','".$icard."','".$welfareactivitiesfee."','".$feeforbooks."','".$unionfee."','".$amenitiesfee."','".$campusdevfee."','".$internalexamfee."','".$enrollmentfee."','".$laboratoryfee."','".$librarydeposit."','".$unicampusdev."','".$cultureactivities."','".$complexdevfee."','".$total."','".$latefees."','".$total_amount."','".$fees."','".$mode."','".$notes."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-fees-entry.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-fees-entry.php?m=wrong");
                exit;
            }

    }
    else
    {
        header("Location: manage-fees-entry.php?m=wrong");
        exit;
    }
}
else if($_POST['btnsubmit'] == 'Update')
{
    $selectstudent=$_POST['student_id'];
    $fees=$_POST['fees'];
    $mode=$_POST['mode'];
    $notes=$_POST['notes'];
    $enrollmentno=$_POST['enrollment_no'];
    $semester=$_POST['semester'];
    $year=$_POST['year'];
    $tutionfee=$_POST['tutionfee'];
    $admissionfee=$_POST['admissionfee'];
    $icard=$_POST['icard'];
    $welfareactivitiesfee=$_POST['welfareactivitiesfee'];
    $feeforbooks=$_POST['feeforbooks'];
    $unionfee=$_POST['unionfee'];
    $amenitiesfee=$_POST['amenitiesfee'];
    $campusdevfee=$_POST['campusdevfee'];
    $internalexamfee=$_POST['internalexamfee'];
    $enrollmentfee=$_POST['enrollmentfee'];
    $laboratoryfee=$_POST['laboratoryfee'];
    $librarydeposit=$_POST['librarydeposit'];
    $unicampusdev=$_POST['unicampusdev'];
    $cultureactivities=$_POST['cultureactivities'];
    $complexdevfee=$_POST['complexdevfee'];
    $activityfund=$_POST['activityfund'];
    $latefees=$_POST['latefees'];
    $total=$_POST['total'];

    $total = $total - $latefees;
    $total_amount = $_POST['total'];
    $curr_date=$_POST['curr_date'];
    $time = strtotime($curr_date);
    $date = date('d/m/Y',$time);
    $curr_year = date("Y");
    $curr_month = date("m");

    $uid =                  $_POST['fees_id'];

    if($enrollmentno != "")
    {
        $editcatsql = mysqli_query($connect,"select * from student_fees_details where id ='".$uid."'");
        if(mysqli_num_rows($editcatsql) > 0)
        {
            $updqry			=	"update student_fees_details set student_id='".$selectstudent."',enrollment_no='".$enrollmentno."',semester='".$semester."',year='".$year."',date='".$date."',fees_month='".$curr_month."',fees_year='".$curr_year."',tution_fee='".$tutionfee."',admission_fee='".$admissionfee."',i_card_fee='".$icard."',welfare_activities_fee='".$welfareactivitiesfee."',fees_for_books='".$feeforbooks."',union_fee='".$unionfee."',amenities_fee='".$amenitiesfee."',campus_dev_fee='".$campusdevfee."',internal_exam_fee='".$internalexamfee."',enrollment_fee='".$enrollmentfee."',laboratory_fee='".$laboratoryfee."',library_fee='".$librarydeposit."',uni_campus_dev_fee='".$unicampusdev."',uni_sport_fee='".$cultureactivities."',uni_sport_complex_fee='".$complexdevfee."',total='".$total."',late_fees_charges='".$latefees."',total_amount='".$total_amount."',total_fees='".$fees."',payment_mode='".$mode."',payment_details='".$notes."' where id='".$uid."'";
            mysqli_query($connect,$updqry);

            header("Location: manage-fees-entry.php?m=updt");
            exit;
        }
        else
        {
            header("Location: manage-fees-entry.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location:manage-fees-entry.php?m=wrong");
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
    $editcatsql = mysqli_query($connect,"select * from student_fees_details where id='".$stids."'");
    if($row = mysqli_fetch_assoc($editcatsql))
    {
        $student_id		        = $row['student_id'];
        $enrollment_no		    = $row['enrollment_no'];
        $semester		        = $row['semester'];
        $year		            = $row['year'];
        $date                   = $row['date'];
        $tution_fee		        = $row['tution_fee'];
        $admission_fee		    = $row['admission_fee'];
        $i_card_fee		        = $row['i_card_fee'];
        $welfare_activities_fee		            = $row['welfare_activities_fee'];
        $fees_for_books		        = $row['fees_for_books'];
        $union_fee		    = $row['union_fee'];
        $amenities_fee		            = $row['amenities_fee'];
        $campus_dev_fee		        = $row['campus_dev_fee'];
        $internal_exam_fee		        = $row['internal_exam_fee'];
        $enrollment_fee		        = $row['enrollment_fee'];
        $laboratory_fee		            = $row['laboratory_fee'];
        $library_fee		    = $row['library_fee'];
        $uni_campus_dev_fee		= $row['uni_campus_dev_fee'];
        $uni_sport_fee		= $row['uni_sport_fee'];
        $uni_sport_complex_fee		    = $row['uni_sport_complex_fee'];
        $total		= $row['total'];
        $late_fees_charges		    = $row['late_fees_charges'];
        $total_amount		    = $row['total_amount'];
        $total_fees		    = $row['total_fees'];
        $payment_mode		    = $row['payment_mode'];
        $payment_details		    = $row['payment_details'];

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
                    <h3 class="box-title">Add Fees Entry</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-fees-entry.php">
                            <button type="button" class="btn btn-block btn-info">List Fees Entry</button></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" method="post" action="add-fees-entry.php">
                    <input type="hidden" name="fees_id" value="<?php echo $stids;?>">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Select Student</label>
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
                                                $env_no = $myrow['enrollment_no'];

                                                ?>
                                                <option value="<?php echo $st_id;?>"><?php echo $env_no . '-'. $f_name . '-'. $m_name . '-'. $l_name ;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Enrollment No</label>
                                        <div class="col-sm-8">
                                            <input name="enrollment_no" class="form-control"  type="text" value="<?php echo $enrollment_no;?>" placeholder="Enter Enrollment No">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studaddress" class="col-sm-4 control-label">Date</label>
                                        <div class="col-sm-8">
                                            <input name="curr_date" id="curr_date" value="<?php echo $date;?>" class="form-control"  type="text"  >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mode" class="col-sm-4 control-label">Payment Mode</label>
                                        <div class="col-sm-8">
                                            <select  class="form-control" name="mode" id="mode">
                                                <option value="Cash">Cash</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="NEFT">NEFT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fees" class="col-sm-4 control-label">Fees</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" value="<?php echo $total_fees;?>" name="fees" id="fees" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-4 control-label">Select Year</label>
                                        <div class="col-sm-8">
                                            <select name="year" class="form-control" id="current_year">
                                                <option value="FIRST">First (FY) </option>
                                                <option value="SECOND">Second (SY) </option>
                                                <option value="THIRD">Third (TY) </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="studclass" class="col-sm-4 control-label">Student Semester</label>
                                        <div class="col-sm-8">
                                            <select name="semester" class="form-control"  id="current_semester">
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
                                        <label for="notes" class="col-sm-4 control-label">Notes</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" value="<?php echo $payment_details;?>" name="notes" id="notes" type="text">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!--second column-->


                            <div class="col-xs-6">
                                <div class="box-body">

                                    <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Description</th>
                                                <th>Amount (Rs.)</th>
                                            </tr>
                                            </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tution Fee</td>
                                            <td><input name="tutionfee" value="<?php echo $tution_fee;?>" id="tutionfee"  type="text"  class="form-control"/></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td >Admission Fee(One Time)</td>
                                            <td><input  name="admissionfee" value="<?php echo $admission_fee;?>" id="admissionfee" type="text" placeholder="0" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>

                                            <td>3</td>
                                            <td >I-Card(One Time)</td>
                                            <td><input name="icard" value="<?php echo $i_card_fee;?>" id="icard" type="text" placeholder="0" class="form-control form-control-sm"/></td>


                                        </tr>

                                        <tr>

                                            <td>4</td>
                                            <td >Student's & Teacher's Welfare Activities Fee</td>
                                            <td><input name="welfareactivitiesfee" value="<?php echo $welfare_activities_fee; ?>" id="welfareactivitiesfee" type="text" placeholder="150" class="form-control form-control-sm"/></td>

                                        </tr>

                                        <tr>
                                            <td>5</td>
                                            <td  >Fee for books,Equipment,etc</td>
                                            <td><input name="feeforbooks" value="<?php echo $fees_for_books; ?>" id="feeforbooks" type="text" placeholder="250" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td  >Student's Union Fee</td>
                                            <td><input name="unionfee" value="<?php echo $union_fee; ?>" id="unionfee" type="text" placeholder="100" class="form-control form-control-sm"/></td>

                                        </tr>

                                        <tr>
                                            <td>7</td>
                                            <td  >Amenities Fee</td>
                                            <td><input name="amenitiesfee" value="<?php echo $amenities_fee; ?>" id="amenitiesfee" type="text" placeholder="150" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td  >Campus Dev Fee</td>
                                            <td><input name="campusdevfee" value="<?php echo $campus_dev_fee; ?>" id="campusdevfee" type="text" placeholder="100" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td  >Internal Exam Fee</td>
                                            <td><input name="internalexamfee" value="<?php echo $internal_exam_fee; ?>" id="internalexamfee" type="text" placeholder="75" class="form-control form-control-sm"/></td>

                                        </tr>

                                        <tr>
                                            <td>10</td>
                                            <td  >Enrollment Fee(One Time)</td>
                                            <td><input name="enrollmentfee"  value="<?php echo $enrollment_fee; ?>" id="enrollmentfee" type="text" placeholder="100" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>

                                            <td>11</td>
                                            <td >Laboratory Fee(Including Computer Lab)</td>
                                            <td><input name="laboratoryfee"  value="<?php echo $laboratory_fee; ?>" id="laboratoryfee" type="text" placeholder="100" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>

                                            <td>12</td>
                                            <td >Library Deposit(Refundable)(One Time)</td>
                                            <td><input name="librarydeposit" value="<?php echo $library_fee; ?>" id="librarydeposit" type="text" placeholder="100" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>

                                            <td>13</td>
                                            <td  >Uni. Campus Dev Fee</td>
                                            <td><input name="unicampusdev" value="<?php echo $uni_campus_dev_fee; ?>" id="unicampusdev" type="text" placeholder="50" class="form-control form-control-sm"/></td>


                                        </tr>

                                        <tr>

                                            <td>14</td>
                                            <td  >Uni. Sports and Culture Activities</td>
                                            <td><input name="cultureactivities" value="<?php echo $uni_sport_fee; ?>"  id="cultureactivities" type="text" placeholder="20" class="form-control form-control-sm"/></td>

                                        </tr>

                                        <tr>
                                            <td>15</td>
                                            <td  >Uni. Sports Complex Dev Fee</td>
                                            <td><input name="complexdevfee" value="<?php echo $uni_sport_complex_fee; ?>" id="complexdevfee" type="text" placeholder="20" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <!--<tr>
                                            <td>16</td>
                                            <td  >Student Activity Fund</td>
                                            <td><input name="activityfund" value="<?php echo $uni_sport_complex_fee; ?>" id="activityfund" type="text" placeholder="20" class="form-control form-control-sm"/></td>

                                        </tr>-->

                                        <tr>
                                            <td>17</td>
                                            <td  >Late Fees Charges</td>
                                            <td><input name="latefees" value="<?php echo $late_fees_charges;?>" id="latefees" type="text" placeholder="0" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>

                                            <td></td>
                                            <td  ><b>Total Amount</b></td>
                                            <td><input name="total" id="totalvalue" value="<?php echo $total_amount;?>" type="text" placeholder="0" class="form-control form-control-sm"/></td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input  type="submit" class="btn btn-primary" name="btnsubmit" value="<?php echo $btn; ?>"/>
                                            </td>
                                            <td><button type="button" onclick="totalCalculate()" class="btn btn-primary">Calculate Total</button></td>
                                        </tr>

                                        </tbody>
                                    </table>

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
    <script type='text/javascript'>
        function totalCalculate()
        {
            var a =document.getElementById('tutionfee').value;
            var b =document.getElementById('admissionfee').value;
            var c =document.getElementById('icard').value;
            var d =document.getElementById('welfareactivitiesfee').value;
            var e =document.getElementById('feeforbooks').value;
            var f =document.getElementById('unionfee').value;
            var g =document.getElementById('amenitiesfee').value;
            var h =document.getElementById('campusdevfee').value;
            var i =document.getElementById('internalexamfee').value;
            var j =document.getElementById('enrollmentfee').value;
            var k =document.getElementById('laboratoryfee').value;
            var l =document.getElementById('librarydeposit').value;
            var m =document.getElementById('unicampusdev').value;
            var n =document.getElementById('cultureactivities').value;
            var o =document.getElementById('complexdevfee').value;
            var p =document.getElementById('activityfund').value;
            var q =document.getElementById('latefees').value;
            var r = parseFloat(a)+parseFloat(b)+parseFloat(c)+parseFloat(d)+parseFloat(e)+parseFloat(f)+parseFloat(g)+parseFloat(h)+parseFloat(i)+parseFloat(j)+parseFloat(k)+parseFloat(l)+parseFloat(m)+parseFloat(n)+parseFloat(o)+parseFloat(p)+parseFloat(q);
            document.getElementById('totalvalue').value = parseFloat(r);
        }
    </script>

</div>
</div>
<!-- ./wrapper -->


<?php include("bottom-link.php"); ?>
<script>
    $(document).ready(function() {
        $("#student_id").select2();

        //Date picker
        $('#curr_date').datepicker({
            autoclose: true
        })

    });
</script>
<script>
    $(function () {
        $("#student_id").val("<?php echo $student_id;?>");
        $("#mode").val("<?php echo $payment_mode;?>");

        $("#current_year").val("<?php echo $year;?>");
        $("#current_semester").val("<?php echo $semester;?>");

    });
</script>
</body>
</html>
