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
    $enrollment=$_POST['enrollment'];
    $group=$_POST['group'];
    $mode=$_POST['mode'];
    $firstname=$_POST['firstname'];
    $middlename=$_POST['middlename'];
    $lastname=$_POST['lastname'];
    $age=$_POST['age'];
    $caste=$_POST['caste'];
    $subcaste=$_POST['subcaste'];
    $birthdate=$_POST['birthdate'];
    $gender=$_POST['gender'];
    $category=$_POST['category'];
    $nativeplace=$_POST['nativeplace'];
    $addressline1=$_POST['addressline1'];
    $adresline2=$_POST['addressline2'];
    $postalcode=$_POST['postalcode'];
    $city=$_POST['city'];
    $studentcontactno=$_POST['studentcontactno'];
    $parentcontactno=$_POST['parentcontactno'];
    $selectyear=$_POST['selectyear'];
    $selectsemester=$_POST['selectsemester'];
    $admissionyear=$_POST['admissionyear'];


    if($enrollment != "" )
    {
        $editcatsql = mysqli_query($connect,"select * from student where enrollment_no='".$enrollment."' ");
        if(mysqli_num_rows($editcatsql) == 0)
        {
            $userinsertqry = "INSERT INTO student (enrollment_no,group_name,admission_mode,first_name,middle_name,last_name,caste,birth_date,age,sub_caste,native_place,gender,category,address1,address2,city,postal_code,parents_contact_no,student_contact_no,current_year,current_semester,admission_year) VALUES ('".$enrollment."','".$group."','".$mode."','".$firstname."','".$middlename."','".$lastname."','".$caste."','".$birthdate."','".$age."', '".$subcaste."', '".$nativeplace."', '".$gender."', '".$category."', '".$addressline1."', '".$adresline2."', '".$city."', '".$postalcode."', '".$parentcontactno."', '".$studentcontactno."','".$selectyear."', '".$selectsemester."', '".$admissionyear."')";
            $bgresultuser	=  mysqli_query($connect,$userinsertqry);
            if($bgresultuser)
            {
                header("Location: manage-students.php?m=s");
                exit;
            }
            else
            {
                header("Location: manage-students.php?m=wrong");
                exit;
            }
        }
        else
        {
            header("Location: manage-students.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-students.php?m=wrong");
        exit;
    }
}
else if($_POST['btnsubmit'] == 'Update')
{
    $enrollment=$_POST['enrollment'];
    $group=$_POST['group'];
    $mode=$_POST['mode'];
    $firstname=$_POST['firstname'];
    $middlename=$_POST['middlename'];
    $lastname=$_POST['lastname'];
    $age=$_POST['age'];
    $caste=$_POST['caste'];
    $subcaste=$_POST['subcaste'];
    $birthdate=$_POST['birthdate'];
    $gender=$_POST['gender'];
    $category=$_POST['category'];
    $nativeplace=$_POST['nativeplace'];
    $addressline1=$_POST['addressline1'];
    $addressline2=$_POST['addressline2'];
    $postalcode=$_POST['postalcode'];
    $city=$_POST['city'];
    $studentcontactno=$_POST['studentcontactno'];
    $parentcontactno=$_POST['parentcontactno'];
    $selectyear=$_POST['selectyear'];
    $selectsemester=$_POST['selectsemester'];
    $admissionyear=$_POST['admissionyear'];
    $uid =                  $_POST['f_id'];

    if($enrollment != "")
    {
        $editcatsql = mysqli_query($connect,"select * from student where id ='".$uid."'");
        if(mysqli_num_rows($editcatsql) > 0)
        {
            $updqry			=	"update student set enrollment_no='".$enrollment."',group_name='".$group."',admission_mode='".$mode."',first_name='".$firstname."',middle_name='".$middlename."',last_name='".$lastname."',caste='".$caste."',birth_date='".$birthdate."',age='".$age."',sub_caste='".$subcaste."',native_place='".$nativeplace."',gender='".$gender."',category='".$category."',address1='".$addressline1."',address2='".$addressline2."',city='".$city."',postal_code='".$postalcode."',parents_contact_no='".$parentcontactno."',student_contact_no='".$studentcontactno."',current_year='".$selectyear."',current_semester='".$selectsemester."',admission_year='".$admissionyear."' where id='".$uid."'";
            mysqli_query($connect,$updqry);

            header("Location: manage-students.php?m=updt");
            exit;
        }
        else
        {
            header("Location: manage-students.php?&m=exist");
            exit;
        }
    }
    else
    {
        header("Location: manage-students.php?m=wrong");
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
    $editcatsql = mysqli_query($connect,"select * from student where id='".$stids."'");
    if($row = mysqli_fetch_assoc($editcatsql))
    {
        $enrollment_no		= $row['enrollment_no'];
        $group_name		        = $row['group_name'];
        $admission_mode		        = $row['admission_mode'];
        $first_name		        = $row['first_name'];
        $middle_name		        = $row['middle_name'];
        $last_name		        = $row['last_name'];
        $caste		        = $row['caste'];
        $birth_date		        = $row['birth_date'];
        $age		        = $row['age'];
        $sub_caste		        = $row['sub_caste'];
        $native_place		        = $row['native_place'];
        $gender		        = $row['gender'];
        $category		        = $row['category'];
        $address1		        = $row['address1'];

        $address2		        = $row['address2'];
        $city		        = $row['city'];
        $postal_code		        = $row['postal_code'];
        $parents_contact_no		        = $row['parents_contact_no'];

        $student_contact_no		        = $row['student_contact_no'];
        $current_year		        = $row['current_year'];
        $current_semester		        = $row['current_semester'];
        $admission_year		        = $row['admission_year'];






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
                    <h3 class="box-title">Add Student</h3>

                    <div class="box-tools pull-right">
                        <a href="manage-students.php">
                            <button type="button" class="btn btn-block btn-info">List Student</button></a>
                    </div>
                </div>
        <!-- /.box-header -->
        <form class="form-horizontal" method="post" action="add-student.php">
            <input type="hidden" name="f_id" value="<?php echo $stids;?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Enrollment No</label>
                                <div class="col-sm-8">
                                    <input name="enrollment"class="form-control"  type="text" value="<?php echo $enrollment_no;?>" placeholder="Enter Enrollment No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Group</label>
                                <div class="col-sm-8">
                                    <select name="group" id="group" class="form-control" id="inlineFormCustomSelectPref">
                                        <option value="CPM">CPM</option>
                                        <option value="MATHS">MATHS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Admission Mode</label>
                                <div class="col-sm-8">
                                    <select name="mode" class="form-control" id="mode">
                                        <option value="ONLINE">ONLINE</option>
                                        <option value="OFFLINE">OFFLINE</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">First Name</label>
                                <div class="col-sm-8">
                                    <input name="firstname" class="form-control"  type="text" value="<?php echo $first_name;?>" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Middle Name</label>
                                <div class="col-sm-8">
                                    <input name="middlename" class="form-control" value="<?php echo $middle_name;?>" type="text" aria-describedby="nameHelp" placeholder="Enter middle name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Last Name</label>
                                <div class="col-sm-8">
                                    <input name="lastname" class="form-control" value="<?php echo $last_name;?>" type="text" aria-describedby="nameHelp" placeholder="Enter last name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Age</label>
                                <div class="col-sm-8">
                                    <input name="age" class="form-control" value="<?php echo $age;?>" type="text" placeholder="Age">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Cast</label>
                                <div class="col-sm-8">
                                    <input name="caste" class="form-control" value="<?php echo $caste;?>" type="text" aria-describedby="CasteHelp" placeholder="Caste">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Sub Cast</label>
                                <div class="col-sm-8">
                                    <input name="subcaste" class="form-control" value="<?php echo $sub_caste;?>" type="text" placeholder="Sub Caste">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Birthdate</label>
                                <div class="col-sm-8">
                                    <input name="birthdate" class="form-control" type="text" value="<?php echo $birth_date;?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Gender</label>
                                <div class="col-sm-8">
                                    <select name="gender" class="form-control" id="gender" >
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
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

                    <!--second column-->


                    <div class="col-xs-6">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="studaddress" class="col-sm-4 control-label">Category</label>
                                <div class="col-sm-8">
                                    <select name="category"class="form-control" id="category">
                                            <option value="OPEN">OPEN </option>
                                            <option value="OBC">OBC </option>
                                            <option value="SC">SC </option>
                                            <option value="ST">ST </option>
                                            <option value="OTHER">OTHER </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Native Place</label>
                                <div class="col-sm-8">
                                    <input name="nativeplace" class="form-control" value="<?php echo $native_place;?>" type="text"  placeholder="Enter Native Place">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Address Line 1</label>
                                <div class="col-sm-8">
                                    <input name="addressline1" class="form-control" value="<?php echo $address1;?>" type="text" aria-describedby="AddressLine1Help" placeholder="Address Line1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Address Line 2</label>
                                <div class="col-sm-8">
                                    <input name="addressline2" class="form-control" value="<?php echo $address2;?>" type="text" aria-describedby="AddressLine1Help" placeholder="Address Line1">
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">City</label>
                                <div class="col-sm-8">
                                    <input name="city" class="form-control" value="<?php echo $city;?>" type="text" aria-describedby="CityHelp" placeholder="City">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Pin Code</label>
                                <div class="col-sm-8">
                                    <input name="postalcode" class="form-control" value="<?php echo $postal_code;?>" type="text" aria-describedby="PostalCodeHelp" placeholder="Postal Code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Student Contact No</label>
                                <div class="col-sm-8">
                                    <input name="studentcontactno" class="form-control" value="<?php echo $student_contact_no;?>" type="text"  placeholder="Student Contact No">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Parent's Contact No</label>
                                <div class="col-sm-8">
                                    <input name="parentcontactno" class="form-control" value="<?php echo $parents_contact_no;?>" type="text"  placeholder="Parents Contact No.">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Select Year</label>
                                <div class="col-sm-8">
                                    <select name="selectyear" class="form-control" id="current_year">
                                        <option value="FIRST">First (FY) </option>
                                        <option value="SECOND">Second (SY) </option>
                                        <option value="THIRD">Third (TY) </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="studclass" class="col-sm-4 control-label">Student Semester</label>
                                <div class="col-sm-8">
                                    <select name="selectsemester" class="form-control"  id="current_semester">
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
                                <label for="studclass" class="col-sm-4 control-label">Admission Year</label>
                                <div class="col-sm-8">
                                    <select name="admissionyear" class="form-control"  id="admission_year">

<?php
                                        $clgYear = mysqli_query($connect,"select *from admission_year");
                                        while($myrow = mysqli_fetch_assoc($clgYear))
                                        {
                                            $ad_year   = $myrow['admission_year'];
                                            $ad_desc   = $myrow['ad_desc'];
                                            ?>
                                        <option value="<?php echo $ad_year;?>"><?php echo $ad_desc;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
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
        $("#group").val("<?php echo $group_name;?>");
        $("#mode").val("<?php echo $admission_mode;?>");
        $("#gender").val("<?php echo $gender;?>");
        $("#category").val("<?php echo $category;?>");
        $("#current_year").val("<?php echo $current_year;?>");
        $("#current_semester").val("<?php echo $current_semester;?>");
        $("#admission_year").val("<?php echo $admission_year;?>");


    });
</script>
</body>
</html>
