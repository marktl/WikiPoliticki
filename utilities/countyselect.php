<?php
$state=$_GET["state"];
require_once('config.php');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db(DB_DATABASE, $con);

$sql="SELECT distinct concat('state=',State,'&county=',County),County FROM Address WHERE state = '".$state."' order by county";

$result = mysql_query($sql);

if(mysql_num_rows($result) < 1){ //no states
	echo("<select id=\"County\" >");
    echo('<option value="error">No Resutls Found</option>');
	echo("<select />");
}
else{
echo("<select id=\"County\" onchange=\"fcityselect(this.value)\">");
echo("<option>Select</option>");
while($row = mysql_fetch_row($result)){
     if($_GET["county"] <> $row[1]){
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