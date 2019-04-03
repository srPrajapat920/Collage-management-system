<?php
session_start();
include("connect.php");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$t_id = $_REQUEST['id'];

$clgYear = ("select * from bonafide_certi where id='$t_id'");
$result_clg = mysqli_query($connect,$clgYear);
while($myrow = mysqli_fetch_assoc($result_clg)) {
    $st_id = $myrow['student_id'];
    $f_p = $myrow['from_place'];
    $t_p = $myrow['to_place'];
    $c_date = $myrow['created_date'];

    $st_data = ("select * from student where id='$st_id'");
    $result_student = mysqli_query($connect,$st_data);
    while($row = mysqli_fetch_assoc($result_student)) {
        $enrollment_no = $row['enrollment_no'];
        $f_nm = $row['first_name'];
        $m_nm = $row['middle_name'];
        $l_nm = $row['last_name'];
        $adm_year = $row['admission_year'];
        $gender = $row['gender'];
        $b_date = $row['birth_date'];
        $semester = $row['current_semester'];
        $pro = "His";
        $hasHave = "Have";
        $mr = "Mr.";
        $heshe = "He";
        if($gender == "Male"){
            $pro = "His";
            $hasHave = "Have";
            $mr = "Mr.";
            $heshe = "He";
        }else{
            $pro = "Her";
            $hasHave = "Has";
            $mr = "Miss.";
            $heshe = "She";
        }
    }
}



$html='



<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bonafide-Certificate</title>






  <style>
  #footer{
      float: right;
  }

  ul{
    text-align: left;
  }
  li{
    text-align: left;
    text-decoration:none;
    list-style: none;
    margin-bottom: 10px;
  }
  .section{

    text-align: left;
    width: 100%;
    margin-left: 0px;
    float: left;
    font-size: 130%;
  }


  div{
    text-align:center;

    margin-top: 20px;
  margin-right: 30px;
  margin-left: 30px;

  }

  </style>
  </head>
  <body >
    <div  >
    <img src="image/dd1.jpg" alt="Attampt-Certificate" width="700" height="120" >
  <hr>
  <p style=" font-size:130%" width="700" height="120";>BONAFIDE</p>
</br></br>
<p style="font-size:130%; text-align:left;">Bonafide-No:-'.$t_id.' <span style="float:right; font-size:100%";>Date:-'.$c_date.'<br></p>
  <p style="font-size:130%;text-align:justify;" >This is to certify that '.$mr.' :- '.$f_nm.' '.$m_nm.' '.$l_nm.'&nbsp;was a bonafide student of this college. '.$heshe.' is studing in semester &nbsp;'.$semester.' in the year &nbsp; '.date("Y").'.
  </br><p style="text-align:center;font-size:130%;">According to our college,general register.'.$pro.' date of Birth and caste is as under. </p>
  <div class="section">
    <ul>
    <li>Enrollment No:<b> '. $enrollment_no.'</b></li>
      <li>Birth Date:<b> '.  $b_date.'</b></li>
    <li>  College Timing:<b>8:00 AM To 2:00</b></li>
  </ul>
</div><br>

    <p style="font-size:130%;text-align: justify;">To the best of my knowledge and belief. '.$heshe.' bears a good moral character and conduct.</p>
    <br/>
    <br/>
    <br/>
    <ul id="footer">
    <li id="line"style="font-size:130%">I/C Principal </li>
    <li id="line" style="font-size:130%">M.L Parmar Science College </li>
</ul>
<p style="float:left;font-size:130%;">Date:-'.$c_date.'<br></p>
  </div>

  </body>
  </html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream();
?>

