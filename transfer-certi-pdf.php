<?php
session_start();
include("connect.php");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$t_id = $_REQUEST['id'];

$clgYear = ("select * from transfer_certi where id='$t_id'");
$result_clg = mysqli_query($connect,$clgYear);
while($myrow = mysqli_fetch_assoc($result_clg)) {
    $st_id = $myrow['student_id'];
    $c_year = $myrow['current_year'];
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
  li{
      margin-top: 10px;
    text-decoration: none;
    list-style: none;
      text-align: left;
        font-size: 130%;
  }
  div{
    text-align:center;
  margin-right: 30px;
  margin-left: 30px;

  }

  </style>
  </head>
  <body >
    <div  >
    <img src="image/dd1.jpg" alt="Attampt-Certificate" width="700" height="120" >
  <hr>
  <p style=" font-size:150%" width="700" height="120";>TRANSFER-CERTIFICATE</p>
</br></br>
<p style="font-size:140%; text-align:left;">No:-'.$t_id.' <span style="float:right; font-size:100%";> Date:'. $c_date .'<br></p>
  <p style="font-size:150%;text-align:left;" >This is certified that '.$mr.' :<b> '.$f_nm.' '.$m_nm.' '.$l_nm.'</b> has been a student of this college.
</P>

      <ul>
      <li>(A) Since '.$heshe.' passed the T.Y.B.Sc Examination. '.$heshe.' '.$hasHave.' kept all six semesters in this college during '.$adm_year.' to '.$c_year.' </li><br>

        <li> (B) '.$pro.' Enrollment number was :-<b> '.$enrollment_no.'</b></li><br>

        <li>   (C) '.$pro.' work in college examination was as follows:</li><br>

          <li>   (D) '.$pro.' '.$hasHave.' no books issued by this college , in '.$pro.' Possession.</li><br>

          <li>     (E) '.$heshe.' owes no due to this college </li><br>
          <li>     (F) '.$heshe.' bear a good moral character.</li><br>




              <li>     (G) '.$pro.' date of birth as entered in the college register is :-  <b> '.$b_date.'</b></li><br>

              <li>       (H) '.$heshe.' attended courses of instruction at this college in voluntary subjects or groups of subjects. English Medium Computer Sciences all subjects are compulsory.</li><br>

                <li>       (I) '.$pro.' University Enrollment and Date Was <b> '.$enrollment_no.'</b></li><br>

                  <li>       (J) '.$heshe.' '.$hasHave.' satisfactorily gone through the course of Physical Training prescribed by the university Surat.</li><br>
<br><br>
                      <li>    Date : -'. $c_date.'</li><br>
                       </ul>



  </body>
  </html> ';
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream();
?>

