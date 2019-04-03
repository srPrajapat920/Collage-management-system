<?php
/* sql injection */
if(isset($_REQUEST))
{
	$reqvars = $_REQUEST;    
   foreach($reqvars as $keys=>$vals)
   {
       invdata($keys,$vals);
   }
}

function invdata($keys,$d)
{
	$opdata = 0;

   	$string = strtolower($d);

	$fstr = array("show ","select ","<script","</script>","table ","table","database","","*\\","column","information_schema","substring","union","*","users","users_devices","temppushnote","orders","order_detail","category","requested_design","broadcast_message","tblblock","alert(","prompt(","javascript","javascript:","onload=","<iframe","</iframe>","<object","<embed");

   	foreach($fstr as $key => $val)
   	{
		$pos = strchr($string, $val);
		if ($pos === false)
		{
		   //  $opdata = 0;
		}
		else
		{
			include("connect.php");
			
			$ip				= $_SERVER['REMOTE_ADDR'];
			$pagename		= basename($_SERVER['PHP_SELF']); 
			$arraystring	= print_r($_REQUEST, true); 
			$date			= date('Y:m:d H:i:s');
		
			$query	= "INSERT INTO `tblblock` (`ip`, `stringquery`, `pagename`, `performat`) VALUES('$ip', '$arraystring', '$pagename', '$date')";
			
			$result = mysqli_query($connect,$query);
			$opdata++;			
		}
    }

	if($opdata > 0)
	{
			$_SESSION['sql'] = "perform";			
	}
}
/* sql injection */
?>