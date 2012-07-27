<?php


$county = $_GET["county"];
$state=$_GET["state"];
require_once('config.php');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db(DB_DATABASE, $con);
		$sql="SELECT distinct REPLACE(concat('state=',State,'&county=',County,'&city=',city),' ','+'),city FROM Address WHERE county = '".$county."' and state = '".$state."' order by city";
		

$result = mysql_query($sql);
if(mysql_num_rows($result) < 1) {
	echo("<select id=\"City\">");
    echo('<option value="error">No Resutls Found</option>');
	echo("<select />");
}
else{
echo("<select id=\"City\" onChange=\"postlocal(this.value)\">");
echo("<option>Select</option>");
while($row = mysql_fetch_row($result)){
     if($_GET["city"] <> $row[1]){
	 echo("<option value=\"$row[0]\">$row[1]</option>");
	 }
	 else{
	 echo("<option value=\"$row[0]\" SELECTED>$row[1]</option>");
	 }
	 }
	 echo("<select />");
	}
mysql_close($con);
?>