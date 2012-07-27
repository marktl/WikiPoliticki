<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Flag</title>
<link rel="stylesheet" href="wp.css" />

<script src="utilities/jquery.js"></script>
<script src="utilities/jquery.validate.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
    $("#addnew").validate();
  });
  
 var RecaptchaOptions = {
    theme : 'clean'
 };
 
</script>

</head>
<body>
<?php

$state = trim($_POST["state"]);
$county = trim($_POST["county"]);
 $city = trim($_POST["city"]);
 $id = trim($_POST["id"]);
 $isdistrict = trim($_POST["isdistrict"]);
 
require_once('utilities/config.php');

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  		
		mysql_select_db(DB_DATABASE, $con);
if($isdistrict == 'no'){
$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE individual.individualid = $id 
		order by officenames.officename;";
		}else{
		$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE individual.individualid = $id 
		order by officenames.officename;";
		}
		$result = mysql_query($sql);
		if(isdistrict == 'no'){
		while($row = mysql_fetch_row($result)){
			echo("<h2>$row[7]</h2>");
			echo("<span>");
			echo("<img src=\"images/Uploads/$row[6]\" alt=\"$state $row[0] $row[2]\" class=\"floatLeft\" width=\"$row[9]\" height=\"$row[8]\" />");
			echo("<div id=\"edirectory\"> <h4>$row[0]");
			if(!empty($row[1])){
			echo(" $row[1] $row[2]</h4> ");
			}else{
			echo(" $row[2]</h4> ");
			}
			if(!empty($row[5])){
			echo("- $row[5] ");
			}
			echo("- District $row[15] &nbsp;&nbsp;");
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br /><br />');
			if(!empty($row[3])){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4])){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[15]\">$row[15]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[16]\">$row[16]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[17]\">$row[17]</a>");
			}
			echo('<br />');
			}
			}else{
			while($row = mysql_fetch_row($result)){
			echo("<h2>$row[7]</h2>");
			echo("<span> ");
			echo("<img src=\"images/Uploads/$row[6]\" alt=\"$state $row[0] $row[2]\" class=\"floatLeft\" width=\"$row[9]\" height=\"$row[8]\" />");
			echo("<div id=\"edirectory\"> <h4>$row[0]");
			if(!empty($row[1])){
			echo(" $row[1] $row[2]</h4> ");
			}else{
			echo(" $row[2]</h4> ");
			}
			if(!empty($row[5])){
			echo("- $row[5] ");
			}
			echo("- District $row[15] &nbsp;&nbsp;");
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br /><br />');
			if(!empty($row[3])){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4])){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[15]\">$row[15]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[16]\">$row[16]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[17]\">$row[17]</a>");
			}
			echo('<br />');
			}
			 }
			 
			 mysql_close($con);

 ?>
<div id="add">
<form enctype="multipart/form-data" method="post" id="addflag" name="addflag" class="cmxform" action="verifyflag.php">
<fieldset>
<TEXTAREA name="problemdescription" rows="10" cols="100" class="required" >
Explain what is wrong here
</TEXTAREA>
<h5>problem description required</h5>
<br />
<input type="hidden" name="state" value="<?php echo $_POST["state"] ;?> "/>
<input type="hidden" name="county" value="<?php echo $_POST["county"] ;?> "/>
<input type="hidden" name="city" value="<?php echo $_POST["city"] ;?> "/>
<input type="hidden" name="id" value="<?php echo $_POST["id"] ;?> "/>
<input type="hidden" name="lastname" value="<?php echo $_POST["lastname"] ;?> "/>
<input type="hidden" name="office" value="<?php echo $_POST["office"] ;?> "/>
<div align="center">
<?php
require_once('recaptchalib.php');
  $publickey = "6Lc2UM0SAAAAAKRIAr1QwkfNKC7hz3t2Ave1VVUi"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
  ?>
  </div>
  <br />
<input type="button" value="Cancel" onclick="history.back(-1)" />&nbsp;&nbsp;<input type="submit" name="submit" class="submit"/>
</fieldset>
</form>
</div>

</body>
</html>
