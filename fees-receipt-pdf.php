<?php
session_start();
include("connect.php");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$t_id = $_REQUEST['id'];

$clgYear = ("select * from student_fees_details where id='$t_id'");
$result_clg = mysqli_query($connect,$clgYear);
while($myrow = mysqli_fetch_assoc($result_clg)) {
    $st_id = $myrow['student_id'];
    $c_date = $myrow['created_date'];
    $enrollment_no = $myrow['enrollment_no'];
    $sem = $myrow['semester'];
    $pay_mode = $myrow['payment_mode'];

    $number = $myrow['total_amount'];

    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    $amtDispl =  ($Rupees ? $Rupees . 'Rupees ' : '') . $paise ;


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




$html='
<!DOCTYPE html>
<html lang="en">
    <head>
        <style type="text/css">
        body{
          margin-left:20px;
          margin-right:20px;
          font-size:18px;
          border:1px solid black;
         }
        .space{
            padding-bottom:5px;
         }
        ul{
            list-style: none;
            margin-bottom:0px;
        }
        table{
          border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            border-bottom: none;
            border-left:0;
        }
        .table .td,.th{
            border-right:0;
        }
        .center{
          text-align:center;
        }
        .right{
          text-align:right;
        }
        img{
            border:1px solid black;
            border-bottom:0;
            border-right:0;
        }
        </style>
        <title>Fees Receipt</title>
      </head>
<body>
<div >
     <img src="image/dd1.jpg" alt="collage-name" width="99%" height="140px"></div> <hr>
     
     <ul>
       <li class="space"> Receipt no : '.$t_id.'        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:01/02/2016</li>
    <li class="space">Enrollment No.: '.$enrollment_no.' &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Semester:'.$sem.'</li>
    <li class="space">Received from '.$mr.': <b>'.$f_nm.' '.$m_nm.' '.$l_nm.'</b></li>
    <li>towards the payment of the following fees. <b>Payment : '.$pay_mode.'</b></li>
  </ul>
  <div>
    <table  class="table-responsive table" width="100%" >
        <thead>
            <tr>
                <th scope="col"> &nbsp; Sr No.</th>
                <th scope="col">&nbsp;Description</th>
                <th class="th" scope="col">&nbsp;Amount(Rs)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td style="padding:3px;">Tution Fee</td>
                <td style="padding:3px;" class="right td "> '.$myrow['tution_fee'].'</td>
            </tr>
            <tr>
                <td class="center">2</td>
                <td style="padding:3px;">Admission Fee (One Time)</td>
                <td class="right td ">'.$myrow['admission_fee'].'</td>
            </tr>
            <tr>
                <td class="center">3</td>
                <td style="padding:3px;"> I - Card (One Time)</td>
                <td style="padding:3px;" class="right td ">'.$myrow['i_card_fee'].'</td>
            </tr>
            <tr>
                <td class="center">4</td>
                <td style="padding:3px;" >Student\'s and Teacher\'s Welfare Activities Fee</td>
                <td style="padding:3px;" class="right td">'.$myrow['welfare_activities_fee'].'</td>
            </tr>
            <tr>
                <td class="center">5</td>
                <td style="padding:3px;">Fee for books,Equipment,etc</td>
                <td style="padding:3px;" class="right td">'.$myrow['fees_for_books'].'</td>
            </tr>
            <tr>
                <td class="center">6</td>
                <td style="padding:3px;">Student\'s Union Fee</td>
                <td style="padding:3px;" class="right td">'.$myrow['union_fee'].'</td>
            </tr>
             <tr>
                <td class="center">7</td>
                <td style="padding:3px;">Amenities Fee</td>
                 <td style="padding:3px;" class="right td">'.$myrow['amenities_fee'].'</td>
              </tr>
              <tr>
                <td class="center">8</td>
                  <td style="padding:3px;">Campus Dev. Fee</td>
                  <td style="padding:3px;" class="right td">'.$myrow['campus_dev_fee'].'</td>
              </tr>

              <tr>
                <td class="center">9</td>
                  <td style="padding:3px;">Internal Exam Fee</td>
                    <td style="padding:3px;" class="right td">'.$myrow['internal_exam_fee'].'</td>
              </tr>

              <tr>
                <td class="center">10</td>
                  <td style="padding:3px;">Enrollment Fee (One Time)</td>
                    <td style="padding:3px;" class="right td">'.$myrow['enrollment_fee'].'</td>
              </tr>
              <tr>
                <td class="center">11</td>
                  <td style="padding:3px;">Laboratory Fee (including Computer Lab) </td>
                    <td style="padding:3px;" class="right td" >'.$myrow['laboratory_fee'].'</td>
              </tr>

              <tr>
                <td class="center">12</td>
                  <td style="padding:3px;">Library Deposit (Refundable) (One Time)</td>
                    <td style="padding:3px;" class="right td ">'.$myrow['library_fee'].'</td>
              </tr>
              <tr>
                <td class="center">13</td>
                  <td style="padding:3px;">Uni.Campus Dev.Fee</td>
                    <td style="padding:3px;" class="right td">'.$myrow['uni_campus_dev_fee'].'</td>
              </tr>
              <tr>
                <td class="center">14</td>
                  <td style="padding:3px;"> Uni.Sports and Culture Activities</td>
                    <td style="padding:3px;" class="right td">'.$myrow['uni_sport_fee'].'</td>
              </tr>
              <tr>
                <td class="center">15</td>
                  <td style="padding:3px;">Uni.Sports Complex Dev.Fees</td>
                    <td style="padding:3px;" class="right td">'.$myrow['uni_sport_complex_fee'].'</td>
              </tr>
              <tr>
                <td class="center">16</td>
                  <td style="padding:3px;"></td>
                    <td style="padding:3px;" class="right td" ></td>
              </tr>
              <tr>
                <td class="center"></td>
                  <td style="padding:3px;" class="right"><b>Total</b></td>
                    <td style="padding:3px;" class="right td">'.$myrow['total'].'</td>
              </tr>
              <tr>
                <td class="center">17</td>
                  <td >Late fee Charges</td>
                    <td style="padding:3px;" class="right td">'.$myrow['late_fees_charges'].'</td>
              </tr>
              <tr>
                <td class="center"></td>
                  <td class="right" ><b>Total Amount</b></td>
                    <td class="right td" >'.$myrow['total_amount'].'</td>
              </tr>
              <tr>
                <td  colspan="3">Amount in Words : '.$amtDispl.' Only</td>
              </tr>
              <tr>
                <td  colspan="3">
     <b>Notice:</b> 
                 <ol>
           <li> Fees once paid will not be refund under any circumstances.<br>
           Any request for refund of fee will not be entertained</li>
           <li> This receipt will be valid only if signed by the accountant. </li>
           <li> This receipt must be produced when required.</li>
           <li>Cheque / Bank Draft subject to realization.</li>

         </ol>
</td>
              </tr>
            </tbody>
          </table>
 </div>

 </div>
    </body>
                
               ';
}






$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream();
?>

