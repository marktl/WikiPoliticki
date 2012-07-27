<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Submit</title>
<link rel="stylesheet" href="wp.css" />
</head>
<body>
  <?php
  require_once('recaptchalib.php');
  $privatekey = "6Lc2UM0SAAAAABbnXnuUinclkUHtdEidYaYjjQoR";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("<br /><br /><br /><h2>Sorry, the reCAPTCHA wasn't entered correctly. Press the back button on your browser and try it again.</h2>" .
         "<br /><h4>(reCAPTCHA said: " . $resp->error . ")</h4>");
  } else {
    // Your code here to handle a successful verification
	
	$levelin = trim($_POST["level"]);

if($levelin == "state"){
$place = trim($_POST["state"]);
$levelsub = '1';
}
if($levelin == "county"){
$place = trim($_POST["county"]);
$levelsub = '2';
}
if($levelin == "congress"){
$place = $city;
$levelsub = '3';
}
if($levelin == "statesenate"){
$place = $city;
$levelsub = '4';
}
if($levelin == "statecongress"){
$place = $city;
$levelsub = '5';
}
if($levelin == "city"){
$place = trim($_POST["city"]);
$levelsub = '6';
}
if($levelin == "schooldist"){
$place = $city;
$levelsub = '7';
}

$state = trim($_POST["state"]);
$county = trim($_POST["county"]);
 $city = trim($_POST["city"]);
	echo('<SCRIPT LANGUAGE="JavaScript">');
		echo('function go_now () {');
		if($levelin == 'state'){
			echo("window.location.href = \"http://wikipoliticki.us?state=$state#addstate\";");
		}
		else if($levelin == 'congress')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#addcongress\";");
		}
		else if($levelin == 'statesenate')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#addstatesenate\";");
		}
		else if($levelin == 'statecongress')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#addstatecongress\";");
		}
		else if($levelin == 'congressdistrict')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#congressdistrict\";");
		}
		else if($levelin == 'statesenatedistrict')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#statesenatedistrict\";");
		}
		else if($levelin == 'statecongressdistrict')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#statecongressdistrict\";");
		}
		else if($levelin == 'schooldistdistrict')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#schooldistdistrict\";");
		}
		else if($levelin == 'county')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county#addcounty\";");
		}
		else if($levelin == 'city')
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#addcity\";");
		}
		else
		{
		echo("window.location.href = \"http://wikipoliticki.us\";");
		}
		echo('}');
		echo('setTimeout("go_now()",2500);');
	echo('</SCRIPT>');
	echo("<br /><br /><br /><h2>Thank you for your submission!  Sending you back to Wikipoliticki.us now....</h2>");
	
	require_once('utilities/config.php');

	$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  		
		mysql_select_db(DB_DATABASE, $con);
	if(	$levelin == 'congressdistrict' or $levelin == 'statesenatedistrict' or $levelin == 'statecongressdistrict' or $levelin == 'schooldistdistrict'){
	
	$district = $_POST["adddistrict"];	
		if($levelin == 'congressdistrict'){
		$sql="INSERT INTO districts (congress,state,county,city) VALUES ('$district','$state','$county','$city');";
		}else if($levelin == 'statesenatedistrict'){
		$sql="INSERT INTO districts (statesenate,state,county,city) VALUES ('$district','$state','$county','$city');";
		}else if($levelin == 'statecongressdistrict'){
		$sql="INSERT INTO districts (statecongress,state,county,city) VALUES ('$district','$state','$county','$city');";
		}else if($levelin == 'schooldistdistrict'){
		$sql="INSERT INTO districts (schooldist,state,county,city) VALUES ('$district','$state','$county','$city');";
		}
		
	mysql_query($sql);
		
	mysql_close($con);
	
	}else{
	
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 define ("MAX_SIZE","5000");

 $errors=0;
 
 if(isset($_POST['submit']))
 {
        $image =$_FILES["file"]["name"];
 $uploadedfile = $_FILES['file']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['file']['name']);
        $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
   $size=filesize($_FILES['file']['tmp_name']);
 
if ($size > MAX_SIZE*1024)
{
 echo "You have exceeded the size limit of 5 MB";
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);

$newheight=180;
$newwidth=($newheight/$height)*$width;
$newwidth=round($newwidth,0);
$tmp=imagecreatetruecolor($newwidth,$newheight);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,

 $width,$height);

$filename = "images/Uploads/".trim($state).trim($_POST["fname"]).str_replace(".","",trim($_POST["lname"])).'.'.$extension;

imagejpeg($tmp,$filename,100);

imagedestroy($src);
imagedestroy($tmp);
}
}
}	
	if($levelin == "state")
 {
   		
		$mname = '';
		$party = '';
		$termstart = '';
		$termend = '';
		$facebook = '';
		$twitter = '';
		$twitthandle = '';
		$wikipedia = '';
		$otherone = '';
		$othertwo = '';
		$otherthree = '';
		$state=$_POST["state"];
		$office=$_POST["office"];
		$fname = $_POST["fname"];
		if (isset($_POST["mname"])){
		$mname = $_POST["mname"];
		}
		$lname = $_POST["lname"];
		if($_POST["party"]){
		$party = $_POST["party"];
		}
		if(isset($_POST["tsyear"]) and isset($_POST["tsmonth"]) and isset($_POST["tsday"])){
		$termstart = $_POST["tsyear"].'-'.$_POST["tsmonth"].'-'.$_POST["tsday"];
		}
		if(isset($_POST["teyear"]) and isset($_POST["temonth"]) and isset($_POST["teday"])){
		$termend = $_POST["teyear"].'-'.$_POST["temonth"].'-'.$_POST["teday"];
		}
		if (isset($_POST["facebook"])){
		$facebook = $_POST["facebook"];	
		}
		if (isset($_POST["twitter"])){
		$twitter = $_POST["twitter"];
		}
		if (isset($_POST["twitthandle"])){
		$twitthandle = $_POST["twitthandle"];
		}
		if (isset($_POST["wikipedia"])){
		$wikipedia = $_POST["wikipedia"];
		}
		if (isset($_POST["other1"])){
		$otherone = $_POST["other1"];
		}
		if (isset($_POST["other2"])){
		$othertwo = $_POST["other2"];
		}
		if (isset($_POST["other3"])){
		$otherthree = $_POST["other3"];
		}
		$imgname = 	trim($state) . str_replace(".","",trim($fname)) . str_replace(".","",trim($lname)) . '.' . $extension;		
		
		$sql="INSERT INTO individual (firstname, middlename, lastname,party,img,pheight,pwidth,facebookurl,twitterurl,twitterhandle,wikipediaurl,other1,other2,other3)
VALUES (\"$fname\",\"$mname\",\"$lname\",\"$party\",\"$imgname\",\"180\",\"$newwidth\",\"$facebook\",\"$twitter\",\"$twitthandle\",\"$wikipedia\",\"$otherone\",\"$othertwo\",\"$otherthree\");";
		
		mysql_query($sql);
		
		$sql="SELECT individualid FROM individual ORDER BY individualid DESC LIMIT 1;";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_row($result)){
		 $newid = $row[0];
		}
		
		$sql="INSERT INTO office (officenameid,State,level,individualid,TermStart,TermEnd) VALUES (\"$office\",\"$state\",\"$levelsub\",\"$newid\",\"$termstart\",\"$termend\")";
		
		mysql_query($sql);
		
	mysql_close($con);
	
 } else if($levelin == "county")
 {
   		$mname = '';
		$party = '';
		$termstart = '';
		$termend = '';
		$facebook = '';
		$twitter = '';
		$twitthandle = '';
		$wikipedia = '';
		$otherone = '';
		$othertwo = '';
		$otherthree = '';
		$district=$_POST['district'];
		$office=$_POST["office"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		if (isset($_POST["mname"])){
		$mname = $_POST["mname"];
		}
		$lname = $_POST["lname"];
		if($_POST["party"]){
		$party = $_POST["party"];
		}
		if(isset($_POST["tsyear"]) and isset($_POST["tsmonth"]) and isset($_POST["tsday"])){
		$termstart = $_POST["tsyear"].'-'.$_POST["tsmonth"].'-'.$_POST["tsday"];
		}
		if(isset($_POST["teyear"]) and isset($_POST["temonth"]) and isset($_POST["teday"])){
		$termend = $_POST["teyear"].'-'.$_POST["temonth"].'-'.$_POST["teday"];
		}
		if (isset($_POST["facebook"])){
		$facebook = $_POST["facebook"];	
		}
		if (isset($_POST["twitter"])){
		$twitter = $_POST["twitter"];
		}
		if (isset($_POST["twitthandle"])){
		$twitthandle = $_POST["twitthandle"];
		}
		if (isset($_POST["wikipedia"])){
		$wikipedia = $_POST["wikipedia"];
		}
		if (isset($_POST["other1"])){
		$other1 = $_POST["other1"];
		}
		if (isset($_POST["other2"])){
		$other2 = $_POST["other2"];
		}
		if (isset($_POST["other3"])){
		$other3 = $_POST["other3"];
		}
		$imgname = 	trim($state) . str_replace(".","",trim($fname)) . str_replace(".","",trim($lname)) . '.' . $extension;		
		
		$sql="INSERT INTO individual (firstname, middlename, lastname,party,img,pheight,pwidth,facebookurl,twitterurl,twitterhandle,wikipediaurl,other1,other2,other3)
VALUES (\"$fname\",\"$mname\",\"$lname\",\"$party\",\"$imgname\",\"180\",\"$newwidth\",\"$facebook\",\"$twitter\",\"$twitthandle\",\"$wikipedia\",\"$other1\",\"$other2\",\"$other3\");";
		
		mysql_query($sql);
		
		$sql="SELECT individualid FROM individual ORDER BY individualid DESC LIMIT 1;";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_row($result)){
		 $newid = $row[0];
		}
		
		$sql="INSERT INTO office (officenameid,State,level,individualid,TermStart,TermEnd,County) VALUES (\"$office\",\"$state\",\"$levelsub\",\"$newid\",\"$termstart\",\"$termend\",\"$county\")";
		
		mysql_query($sql);
		
	
	mysql_close($con);
 }else if($levelin == "congress" or $levelin == "statesenate" or $levelin == "statecongress" or $levelin == "schooldist")
 {
   		$mname = '';
		$party = '';
		$termstart = '';
		$termend = '';
		$facebook = '';
		$twitter = '';
		$twitthandle = '';
		$wikipedia = '';
		$otherone = '';
		$othertwo = '';
		$otherthree = '';
		$district=$_POST['district'];
		$office=$_POST["office"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		if (isset($_POST["mname"])){
		$mname = $_POST["mname"];
		}
		$lname = $_POST["lname"];
		if($_POST["party"]){
		$party = $_POST["party"];
		}
		if(isset($_POST["tsyear"]) and isset($_POST["tsmonth"]) and isset($_POST["tsday"])){
		$termstart = $_POST["tsyear"].'-'.$_POST["tsmonth"].'-'.$_POST["tsday"];
		}
		if(isset($_POST["teyear"]) and isset($_POST["temonth"]) and isset($_POST["teday"])){
		$termend = $_POST["teyear"].'-'.$_POST["temonth"].'-'.$_POST["teday"];
		}
		if (isset($_POST["facebook"])){
		$facebook = $_POST["facebook"];	
		}
		if (isset($_POST["twitter"])){
		$twitter = $_POST["twitter"];
		}
		if (isset($_POST["twitthandle"])){
		$twitthandle = $_POST["twitthandle"];
		}
		if (isset($_POST["wikipedia"])){
		$wikipedia = $_POST["wikipedia"];
		}
		if (isset($_POST["other1"])){
		$other1 = $_POST["other1"];
		}
		if (isset($_POST["other2"])){
		$other2 = $_POST["other2"];
		}
		if (isset($_POST["other3"])){
		$other3 = $_POST["other3"];
		}
		$imgname = 	trim($state) . str_replace(".","",trim($fname)) . str_replace(".","",trim($lname)) . '.' . $extension;		
		
		$sql="INSERT INTO individual (firstname, middlename, lastname,party,img,pheight,pwidth,facebookurl,twitterurl,twitterhandle,wikipediaurl,other1,other2,other3)
VALUES (\"$fname\",\"$mname\",\"$lname\",\"$party\",\"$imgname\",\"180\",\"$newwidth\",\"$facebook\",\"$twitter\",\"$twitthandle\",\"$wikipedia\",\"$other1\",\"$other2\",\"$other3\");";
		
		mysql_query($sql);
		
		$sql="SELECT individualid FROM individual ORDER BY individualid DESC LIMIT 1;";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_row($result)){
		 $newid = $row[0];
		}
		
		$sql="INSERT INTO office (officenameid,State,level,individualid,TermStart,TermEnd,district,County,City) VALUES (\"$office\",\"$state\",\"$levelsub\",\"$newid\",\"$termstart\",\"$termend\",\"$district\",\"$county\",\"$city\")";
		
		mysql_query($sql);
		
	
	mysql_close($con);
 }else if($levelin == "city")
 {
   		$mname = '';
		$party = '';
		$termstart = '';
		$termend = '';
		$facebook = '';
		$twitter = '';
		$twitthandle = '';
		$wikipedia = '';
		$otherone = '';
		$othertwo = '';
		$otherthree = '';
		$office=$_POST["office"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		if (isset($_POST["mname"])){
		$mname = $_POST["mname"];
		}
		$lname = $_POST["lname"];
		if($_POST["party"]){
		$party = $_POST["party"];
		}
		if(isset($_POST["tsyear"]) and isset($_POST["tsmonth"]) and isset($_POST["tsday"])){
		$termstart = $_POST["tsyear"].'-'.$_POST["tsmonth"].'-'.$_POST["tsday"];
		}
		if(isset($_POST["teyear"]) and isset($_POST["temonth"]) and isset($_POST["teday"])){
		$termend = $_POST["teyear"].'-'.$_POST["temonth"].'-'.$_POST["teday"];
		}
		if (isset($_POST["facebook"])){
		$facebook = $_POST["facebook"];	
		}
		if (isset($_POST["twitter"])){
		$twitter = $_POST["twitter"];
		}
		if (isset($_POST["twitthandle"])){
		$twitthandle = $_POST["twitthandle"];
		}
		if (isset($_POST["wikipedia"])){
		$wikipedia = $_POST["wikipedia"];
		}
		if (isset($_POST["other1"])){
		$other1 = $_POST["other1"];
		}
		if (isset($_POST["other2"])){
		$other2 = $_POST["other2"];
		}
		if (isset($_POST["other3"])){
		$other3 = $_POST["other3"];
		}
		$imgname = 	trim($state) . str_replace(".","",trim($fname)) . str_replace(".","",trim($lname)) . '.' . $extension;		
		
		$sql="INSERT INTO individual (firstname, middlename, lastname,party,img,pheight,pwidth,facebookurl,twitterurl,twitterhandle,wikipediaurl,other1,other2,other3)
VALUES (\"$fname\",\"$mname\",\"$lname\",\"$party\",\"$imgname\",\"180\",\"$newwidth\",\"$facebook\",\"$twitter\",\"$twitthandle\",\"$wikipedia\",\"$other1\",\"$other2\",\"$other3\");";
		
		mysql_query($sql);
		
		$sql="SELECT individualid FROM individual ORDER BY individualid DESC LIMIT 1;";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_row($result)){
		 $newid = $row[0];
		}
		
		$sql="INSERT INTO office (officenameid,State,level,individualid,TermStart,TermEnd,County,City) VALUES (\"$office\",\"$state\",\"$levelsub\",\"$newid\",\"$termstart\",\"$termend\",\"$county\",\"$city\")";
		
		mysql_query($sql);
		
	
	mysql_close($con);
 }
}
}//outer if
  ?>
</body>
</html>
