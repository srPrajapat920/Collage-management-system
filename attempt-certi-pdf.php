<?php
session_start();
include("connect.php");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$t_id = $_REQUEST['id'];

$clgYear = ("select * from attampt_certi where id='$t_id'");
$result_clg = mysqli_query($connect,$clgYear);
while($myrow = mysqli_fetch_assoc($result_clg)) {
    $st_id = $myrow['student_id'];
    $c_year = $myrow['exam_year'];
    $attempt = $myrow['attampt'];
    $c_date = $myrow['created_date'];

    $st_data = ("select * from student where id='$st_id'");
    $result_student = mysqli_query($connect,$st_data);
    while($row = mysqli_fetch_assoc($result_student)) {
        $enrollment_no = $row['enrollment_no'];
        $f_nm = $row['first_name'];
        $m_nm = $row['middle_name'];
        $l_nm = $row['last_name'];

        $gender = $row['gender'];
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
        <title>Attampt-Certificate</title>
                <style>
                        div{
                          text-align:center;
                          margin-top: 20px;
                        margin-right: 30px;
                        margin-left: 30px;
                    }


    body
    {
        margin: 0px;
    }
                 </style>

      </head>
  <body>
    <div>
     <img src="image/dd1.jpg" alt="Attampt-Certificate" width="700" height="120"> </div><hr>
    <div> <p style=" font-size:150%" width="700" height="120";>ATTEMPT & CHARACTER CERTIFICATE</p> </br></br>


  <p style="font-size:140%; text-align:left;";>No:-'.$t_id.' <span style="float:right; font-size:140%";>Date :'.$c_date.' <br></p>
  <p style="font-size:150%;text-align: justify;" > &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;This is to certify that  '.$mr.' <b> '.$f_nm.' '.$m_nm.' '.$l_nm.' </b> &nbsp;was a bonafide student of this college. '.$heshe.' '.$hasHave.' passed T.Y.B.Sc. Examination  '.$c_year.' &nbsp;at the '.$attempt.' attempt.
  </br></br>
  </p>
  <p style="font-size:150%;text-align: justify;" >To the best of my knowledge '.$heshe.' bears a good moral character. </p>
  </div>
  </body>
  </html> ';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream();
?>

