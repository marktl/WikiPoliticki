<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="wp.css" />

<script type="text/javascript">
function postlocal(str){
window.location="index.php?"+str;
   }

function fcountyselect(str){
document.getElementById("cityselect").innerHTML="<select><option>select County</option></select>";
if (str=="")
  {
  document.getElementById("countyselect").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("countyselect").innerHTML=xmlhttp.responseText;
    }
	}
xmlhttp.open("GET","utilities/countyselect.php?state="+str,true);
xmlhttp.send();
}
function fcityselect(str){

if (str=="")
  {
  document.getElementById("cityselect").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("cityselect").innerHTML=xmlhttp.responseText;
    }
	}
xmlhttp.open("GET","utilities/cityselect.php?"+str,true);
xmlhttp.send();
}

</script>
<meta property="og:title" content="Wiki Based E-Directory of United States Elected Officials" />
<meta property="og:type" content="non_profit" />
<meta property="og:url" content="http://wikipoliticki.us" />
<meta property="og:image" content="http://wikipoliticki.us/images/wikipoliticki_logofb.jpg" />
<meta property="og:site_name" content="WikiPoliticki.US" />
<meta property="fb:admins" content="503879932" />

<title>Wikipoliticki</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29485006-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=201647413264948";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<body>
<div id="dtop">
<?php
require_once('utilities/config.php');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		echo('<option value="error">Failed to connect to server</option>');
	}
$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		echo('<option value="error">Unable to select database</option>');
	}
$incount = "SELECT distinct individual.Individualid
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid;";
$result = mysql_query($incount);
echo('<span id="count"><b>Currently listing '.mysql_num_rows($result).' elected officials</b></span>');
?>
<span id="top"></span></div><br /><hr />
<link rel="icon" type="image/gif" href="favicon.gif" />
<link rel="shortcut icon" href="favicon.ico" />
<?php
function isValidDateTime($dateTime)
{
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }

    return false;
}
?>
<h1><a href="index.php"><img border="0" src="images/wikipoliticki_logo.jpg" id="wikipoliticki logo" name="logo" /></a></h1>
<h3>Your online and local political community</h3>
<div class="wikilike"><div class="fb-like" data-href="http://wikipoliticki.us" data-send="true" data-width="450" data-show-faces="true" data-font="arial"></div></div>
<br />
Welcome to the first website that allows you to find, review and share information and opinion on your local elected officials. Simply select your location below.  This is a wiki, so if you don't see the elected official you are looking for, add them (it's easy)!
<br />
<br />

<form method="post" name="formlocal">
Select your State<select name="State" onchange="fcountyselect(this.value)">
<option>Select</option>
<?php
$state=$_GET["state"];
if(!$state){
$license_key = 'YQNxXG9bnkun';
$ip= $_SERVER['REMOTE_ADDR'];
$query = "http://geoip.maxmind.com/b?l=" . $license_key . "&i=" . $ip;
$url = parse_url($query);
$host = $url["host"];
$path = $url["path"] . "?" . $url["query"];
$timeout = 10;
$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
if ($fp) {
  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
  while (!feof($fp)) {
    $buf .= fgets($fp, 128);
  }
  $lines = explode("\n", $buf);
  $data = $lines[count($lines)-1];
  fclose($fp);
} else {
  echo('IP lookup Failure, please refresh');
}
//echo $data;
$geo = explode(",",$data);
$country = $geo[0];
$stateabr = $geo[1];
$citygeo = $geo[2];
}
//$lat = $geo[3];
//$lon = $geo[4];
	
$lvstate = "SELECT DISTINCT State,REPLACE(State,' ','+'),StateAbr
			FROM Address
			ORDER BY state;";
$result = mysql_query($lvstate);
if(mysql_num_rows($result) < 1) //no states
    echo('<option value="error">No Results Found</option>');
else
while($row = mysql_fetch_row($result)){
	 if($_GET["state"] == $row[0]){
	 echo("<option value=\"$row[1]\" SELECTED>$row[0]</option>");	 
	 } else if ($stateabr == $row[2] and !$_GET["state"]){
	 echo("<option value=\"$row[1]\" SELECTED>$row[0]</option>");
	 $stateurl = $row[1];
	 }  else{
	 echo("<option value=\"$row[1]\">$row[0]</option>");
	 }	
	 }

?>
</select>

&nbsp; County
	<div id="countyselect">
    <?php
	$state=$_GET["state"];
	
	if(!$stateabr or !citygeo){	
		$sql="SELECT DISTINCT REPLACE(concat('state=',State,'&county=',County),' ','+'),County,StateAbr FROM Address WHERE state = '".$state."' order by county";
		}else{
		$sql="SELECT DISTINCT REPLACE(concat('state=',State,'&county=',County),' ','+'),County,StateAbr FROM Address WHERE  StateAbr = '".$stateabr."' order by county;";
		$sql2="SELECT DISTINCT REPLACE(concat('state=',State,'&county=',County),' ','+'),County,StateAbr FROM Address WHERE  StateAbr = '".$stateabr."' and City = '".$citygeo."' order by county;";
		}
		$result = mysql_query($sql);
		$result2 = mysql_query($sql2);
		
		if(mysql_num_rows($result) < 1){ //no states
			echo("<select id=\"County\" >");
			echo('<option value="error">Select State</option>');
			echo("<select />");
		}
		else{
		echo("<select id=\"County\" onchange=\"fcityselect(this.value)\">");
		echo("<option>Select</option>");
		if(mysql_num_rows($result2) == 1){
		while($row = mysql_fetch_row($result2)){
			$countyname = $row[1];
			}
		}
		while($row = mysql_fetch_row($result)){
			 if($_GET["county"] == $row[1]){
				echo("<option value=\"$row[0]\" SELECTED>$row[1]</option>");
			}else if (mysql_num_rows($result2) == 1 and isset($citygeo) and $countyname == $row[1] and !$_GET["state"]){
				echo("<option value=\"$row[0]\" SELECTED>$row[1]</option>");
				$countyurl = $row[0];
			 }else{			 
			 echo("<option value=\"$row[0]\">$row[1]</option>");			 
			 }
		}
		echo("<select />");
		}
?>
    </div>
&nbsp; City
<div id="cityselect">
    <?php
		$county = $_GET["county"];
		$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		
		mysql_select_db(DB_DATABASE, $con);
		if((!$stateabr or !citygeo) or isset($state)){	
		$sql="SELECT distinct REPLACE(concat('state=',State,'&county=',County,'&city=',city),' ','+'),city FROM Address WHERE county = '".$county."' and state = '".$state."' order by city";
		}else{
		$sql="SELECT distinct REPLACE(concat('state=',State,'&county=',County,'&city=',city),' ','+'),city FROM Address WHERE StateAbr = '".$stateabr."' and County = '".$countyname."' order by city";
		}
		$result = mysql_query($sql);
		if(mysql_num_rows($result) < 1) {//no states
			echo("<select id=\"City\">");
			echo('<option value="error">Select County</option>');
			echo("<select />");
		}
		else{
		echo("<select id=\"City\" onChange=\"postlocal(this.value)\">");
		echo("<option>Select</option>");
		while($row = mysql_fetch_row($result)){
			 if($_GET["city"] <> $row[1] and $citygeo <> $row[1]){
			 echo("<option value=\"$row[0]\">$row[1]</option>");
			 }
			 else{
			 echo("<option value=\"$row[0]\" SELECTED>$row[1]</option>");
			 }
			 }
			 echo("<select />");
			 }
		if(isset($stateurl) and isset($countyurl) and isset($citygeo) and !$state){
		echo("&nbsp;<a href=\"index.php?state=$stateurl&county=$countyurl&city=$citygeo\"><img src=\"images/go.gif\" /></a>");
		}
		
?>

 </div>
 </form>
<br /><br /><hr />
<h1><?php echo $_GET["state"]; ?></h1>
<div class="rsstate">
 <?PHP    
$stcheck = $_GET["state"];
    if (isset($stcheck))
	{
		
				$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 1 
		and office.state = '".$state."' 
		order by officenames.officename;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1) //no states
			echo("No results found at the State level; Contribute to your community by clicking the + button below");
		else
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
			echo("<h2>$row[7] </h2>");
			echo("<span>");
			echo("<img src=\"images/Uploads/$row[6]\" alt=\"$state $row[0] $row[2]\" class=\"floatLeft\" width=\"$row[9]\" height=\"$row[8]\" />");
			echo("<div id=\"edirectory\"> <h4>$row[0]");
			if(!empty($row[1])){
			echo(" $row[1] $row[2]</h4> ");
			}else{
			echo(" $row[2]</h4> ");
			}
			if(!empty($row[5])){
			echo("- $row[5] &nbsp;&nbsp;");
			}
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br /><br />');
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[15])){
			echo("Other Websites: <a href=\"$row[15]\" target=\"_blank\">$row[15]</a>");
			}
			if(!empty($row[16])){
			echo("; <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"no\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[10]\"/> <label name=\"lflag$row[10]\" for=\"flag$row[10]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }
		
	}
?>	
<br />
<form action="add.php" method="post">
<input type="hidden" value="state" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="stateadd"></a>
<input type="image" src="images/plus.jpg" value="submit" id="stateadd" name="stateadd"/> <label for="stateadd">Add state level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rscongress">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];
$city = $_GET['city'];
    if (isset($citycheck))
	{
		
		$sql="SELECT DISTINCT TRIM(districts.congress) FROM districts JOIN Address ON districts.state = Address.State and districts.county = Address.County and districts.city = Address.City where Address.State = '".$stcheck."' and Address.County = '".$cntycheck."' and Address.City = '".$citycheck."' and districts.congress > 0 order by districts.congress";
		
		$result = mysql_query($sql);
		if (!$result){
		$districts = '(no districts set)';
		}else{
		$i = 0;
		while($row = mysql_fetch_row($result)){
		 if ($i > 0){
		 $districts .= ', ';
		 }
		  if ($i == 0 and $row[0] == 0){
		 $districts = '(no districts set)';
		 }else{
		 $districts .= $row[0];
		 }
		 $i = $i + 1;
		}}
		
?>
<h1>Congressional District(s) <?php echo($districts);?></h1>
 <?PHP    

				$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 3
		and office.State = '".$stcheck."'
		and office.County = '".$cntycheck."'
		and office.City = '".$city."'
		order by officenames.officename,office.district;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found at the congressional level; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[18]\" target=\"_blank\">$row[18]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[11]\"/> <label name=\"lflag$row[11]\" for=\"flag$row[11]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17]) or empty($row[18])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county&city=$city#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
}
?>	
<form action="adddistrict.php" method="post">
<input type="hidden" value="congressdistrict" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="congressdistrict"></a>
<input type="image"  src="images/plusblack.jpg" value="submit" id="congressdistrictadd" name="congressdistrictadd" /> <label for="congressdistrictadd">Add congressional level district to the city of <?php echo(trim($_GET["city"]));?></label>
</form>
<form action="add.php" method="post">
<input type="hidden" value="congress" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="congressadd"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="congressadd" name="congressadd" /> <label for="congressadd">Add congressional level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rsstatesenate">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];
    if (isset($citycheck))
	{
		
		$sql="SELECT DISTINCT TRIM(districts.statesenate) FROM districts JOIN Address ON districts.state = Address.State and districts.county = Address.County and districts.city = Address.City where Address.State = '".$stcheck."' and Address.County = '".$cntycheck."' and Address.City = '".$citycheck."' and districts.statesenate > 0 order by districts.statesenate";
		
		$result = mysql_query($sql);
		if (!$result){
		$sdistricts = '(no districts set)';
		}else{
		$i = 0;
		while($row = mysql_fetch_row($result)){
		 if ($i > 0){
		 $sdistricts .= ', ';
		 }
		 if ($i == 0 and $row[0] == 0){
		 $sdistricts = '(no districts set)';
		 }else{
		 $sdistricts .= $row[0];
		 }
		 $i = $i + 1;
		}}
		
?>
<h1><?php echo($state);?> State Senate District(s) <?php echo($sdistricts);?></h1>
 <?PHP    

				$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 4
		and office.State = '".$stcheck."'		and office.City = '".$city."' and office.County = '".$cntycheck."'
		order by officenames.officename,office.district;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found at the state senate level; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[18]\" target=\"_blank\">$row[18]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[11]\"/> <label name=\"lflag$row[11]\" for=\"flag$row[11]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17]) or empty($row[18])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county&city=$city#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
}
?>	
<form action="adddistrict.php" method="post">
<input type="hidden" value="statesenatedistrict" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="statesenatedistrict"></a>
<input type="image"  src="images/plusblack.jpg" value="submit" id="statesenatedistrictadd" name="statesenatedistrictadd" /> <label for="statesenatedistrictadd">Add state senate level district to the city of <?php echo(trim($_GET["city"]));?></label>
</form>
<form action="add.php" method="post">
<input type="hidden" value="statesenate" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="addstatesenate"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="statesenateadd" name="statesenateadd" /> <label for="statesenateadd">Add state senate level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rsstatecongress">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];
    if (isset($citycheck))
	{
		
		$sql="SELECT DISTINCT TRIM(districts.statecongress) FROM districts JOIN Address ON districts.state = Address.State and districts.county = Address.County and districts.city = Address.City where Address.State = '".$stcheck."' and Address.County = '".$cntycheck."' and Address.City = '".$citycheck."' and districts.statecongress > 0 order by districts.statecongress";
		
		$result = mysql_query($sql);
		if (!$result){
		$cdistricts = '(no districts set)';
		}else{
		$i = 0;
		while($row = mysql_fetch_row($result)){
		 if ($i > 0){
		 $cdistricts .= ', ';
		 }
		 if ($i == 0 and $row[0] == 0){
		 $cdistricts = '(no districts set)';
		 }else{
		 $cdistricts .= $row[0];
		 }
		 $i = $i + 1;
		}}
		
?>
<h1><?php echo($state);?> State Congress District(s) <?php echo($cdistricts);?></h1>
 <?PHP    

				$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 5
		and office.State = '".$stcheck."'
		and office.City = '".$city."' and office.County = '".$cntycheck."'
		order by officenames.officename,office.district;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found at the state congressional level; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[18]\" target=\"_blank\">$row[18]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[11]\"/> <label name=\"lflag$row[11]\" for=\"flag$row[11]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17]) or empty($row[18])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county&city=$city#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
}
?>	
<form action="adddistrict.php" method="post">
<input type="hidden" value="statescongressdistrict" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="statesenatedistrict"></a>
<input type="image"  src="images/plusblack.jpg" value="submit" id="statecongressdistrictadd" name="statecongressdistrictadd" /> <label for="statecongressdistrictadd">Add state congress level district to the city of <?php echo(trim($_GET["city"]));?></label>
</form>
<form action="add.php" method="post">
<input type="hidden" value="statecongress" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="addstatecongress"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="statecongressadd" name="statecongressadd" /> <label for="statecongressadd">Add state congress level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rscounty">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];		
?>
<h1><?php echo($cntycheck);?> County</h1>
 <?PHP    
		
		$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 2 
		and office.State = '".$stcheck."' 
		and office.County = '".$cntycheck."' 
		order by officenames.officename;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found for ".$cntycheck. " county; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			echo("- $row[5] &nbsp;&nbsp;");
			}
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br /><br />');
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[15])){
			echo("Other Websites: <a href=\"$row[15]\" target=\"_blank\">$row[15]</a>");
			}
			if(!empty($row[16])){
			echo("; <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[9]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"no\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[10]\"/> <label name=\"lflag$row[10]\" for=\"flag$row[10]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
?>	
<form action="add.php" method="post">
<input type="hidden" value="county" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="countyadd"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="countyadd" name="countyadd" /> <label for="countyadd">Add county level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rscity">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];		
?>
<h1><?php echo($citycheck);?></h1>
 <?PHP    
		
		$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 6
		and office.State = '".$stcheck."' 
		and office.County = '".$cntycheck."'
		and office.City = '".$citycheck."'
		order by officenames.officename;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found for ".$citycheck. "; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			echo("- $row[5] &nbsp;&nbsp;");
			}
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br /><br />');
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if(!empty($row[4]) and $row[4] <> '0/0/0000'){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[15])){
			echo("Other Websites: <a href=\"$row[15]\" target=\"_blank\">$row[15]</a>");
			}
			if(!empty($row[16])){
			echo("; <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[9]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"no\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[10]\"/> <label name=\"lflag$row[10]\" for=\"flag$row[10]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county&city=$city#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
?>	
<form action="add.php" method="post">
<input type="hidden" value="city" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="cityadd"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="cityadd" name="cityadd" /> <label for="cityadd">Add city level elected official</label>
</form>
<br />
<hr />
</div>
<div class="rsschooldist">
<?php
$stcheck = $_GET["state"];
$cntycheck = $_GET['county'];
$citycheck = $_GET['city'];
    if (isset($citycheck))
	{
		
		$sql="SELECT DISTINCT TRIM(districts.schooldist) FROM districts JOIN Address ON districts.state = Address.State and districts.county = Address.County and districts.city = Address.City where Address.State = '".$stcheck."' and Address.County = '".$cntycheck."' and Address.City = '".$citycheck."' and districts.schooldist > 0 order by districts.schooldist";
		
		$result = mysql_query($sql);
		if (!$result){
		$scdistricts = '(no districts set)';
		}else{
		$i = 0;
		while($row = mysql_fetch_row($result)){
		 if ($i > 0){
		 $scdistricts .= ', ';
		 }
		 if ($i == 0 and $row[0] == 0){
		 $scdistricts = '(no districts set)';
		 }else{
		 $scdistricts .= $row[0];
		 }
		 $i = $i + 1;
		}}
		
?>
<h1> <?php echo($citycheck);?> School District(s) <?php echo($scdistricts);?></h1>
 <?PHP    

				$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE office.level = 7
		and office.State = '".$stcheck."'
		and office.City = '".$city."' and office.County = '".$cntycheck."'
		order by officenames.officename,office.district;";
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) < 1){ 
			echo("<br />No results found at the state congressional level; Contribute to your community by clicking the + button below </ br>");
			}
		else{
		while($row = mysql_fetch_row($result)){
			echo("<a name=\"$row[2]-$row[7]\"></a><hr /><div class=\"wd-expando\">");
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
			if(!empty($row[3]) and $row[3] <> '0/0/0000'){
			echo("Assumed Office: $row[3] &nbsp;&nbsp;");
			}
			if($row[4] <> '0/0/0000' and !empty($row[4])){
			echo("Current Term End: $row[4] <br />");
			}else{
			echo('<br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\" target=\"_blank\">$row[11]</a><br />");
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\" target=\"_blank\">$row[12]</a> &nbsp; Handle: $row[13]<br />");
			}elseif(!empty($row[13])){
			echo("Twitter Handle: $row[13]<br />");
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\" target=\"_blank\">$row[14]</a><br />");
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[16]\" target=\"_blank\">$row[16]</a>");
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\" target=\"_blank\">$row[17]</a>");
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[18]\" target=\"_blank\">$row[18]</a>");
			}
			echo('<br />');
			echo("<form action=\"addflag.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"no\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/flag.jpg\" value=\"submit\" id=\"flag$row[11]\"/> <label name=\"lflag$row[11]\" for=\"flag$row[11]\">Flag for review </label>");
			echo("</form>");
			if(empty($row[1]) or empty($row[3]) or empty($row[4]) or empty($row[5]) or empty($row[6]) or empty($row[7]) or empty($row[8]) or empty($row[9]) or empty($row[10]) or empty($row[11]) or empty($row[12]) or empty($row[13]) or empty($row[14]) or empty($row[15]) or empty($row[16]) or empty($row[17]) or empty($row[18])){
			echo("<form action=\"addmore.php\" method=\"post\">");
			echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
			echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
			echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
			echo("<input type=\"hidden\" value=\"$row[10]\" name=\"id\"/>");
			echo("<input type=\"hidden\" value=\"$row[2]\" name=\"lastname\"/>");
			echo("<input type=\"hidden\" value=\"$row[7]\" name=\"office\"/>");
			echo("<input type=\"hidden\" value=\"yes\" name=\"isdistrict\"/>");
			echo("<input type=\"image\"  src=\"images/plusblack.jpg\" height=\"20\" width=\"20\" value=\"submit\" id=\"addmore$row[10]\"/> <label name=\"laddmore$row[10]\" for=\"addmore$row[10]\">Add to elected official</label>");
			echo("</form>");
			}
			echo('</div>');
			echo('<br />');
			echo('<div class="news">');
			echo('<h5>recent news</h5>');
			echo('<span>');
			echo("<iframe frameborder=0 marginwidth=0 marginheight=0 border=0 style=\"border:0;margin:0;width:728px;height:90px;\" src=\"http://www.google.com/uds/modules/elements/newsshow/iframe.html?rsz=large&format=728x90&ned=us&hl=en&q=$row[0]%20$row[2]%20$row[7]%20$state&element=true\" scrolling=\"no\" allowtransparency=\"true\"></iframe>");
			echo('</span></div>');
			echo("<div class=\"fb-comments\" data-href=\"http://wikipoliticki.us?state=$state&county=$county&city=$city#$row[2]-$row[7]\" data-num-posts=\"5\" data-width=\"600\"></div>");
			echo('</span></div><br />');
			 }	
	}
}
?>	
<form action="addschooldistrict.php" method="post">
<input type="hidden" value="schooldistdistrict" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="schooldistdistrict"></a>
<input type="image"  src="images/plusblack.jpg" value="submit" id="schooldistdistrictadd" name="schooldistdistrictadd" /> <label for="schooldistdistrictadd">Add school district to the city of <?php echo(trim($_GET["city"]));?></label>
</form>
<form action="add.php" method="post">
<input type="hidden" value="schooldist" name="level" />
<input type="hidden" value="<?php echo(trim($_GET["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_GET["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_GET["city"]));?>" name="city"/>
<a name="addschooldist"></a>
<input type="image"  src="images/plus.jpg" value="submit" id="schooldistadd" name="schooldistadd" /> <label for="schooldistadd">Add school district level leader</label>
</form>
<br />
<hr />
</div>
<br />
    
<script src="utilities/utility.js"></script>
<script type="text/javascript">
    var expandos = getElementsByClass('wd-expando');
	
    for (var i = 0; i < expandos.length; i++) {
      var expando = expandos[i];
      addClass(expando, 'wd-expando-on');
      var header = expando.getElementsByTagName('h2')[0];
      addEventSimple(header, 'click', toggleExpando);
    }
    
    function toggleExpando () {
      var expando = this.parentNode;
      if (hasClass(expando, 'wd-expando-on')) {
        removeClass(expando, 'wd-expando-on');
        addClass(expando, 'wd-expando-off');
      } else {
        removeClass(expando, 'wd-expando-off');
        addClass(expando, 'wd-expando-on');
      }
    }
	
	var newsx = getElementsByClass('news');
	for (var i = 0; i < newsx.length; i++) {
      var newsxy = newsx[i];
      addClass(newsxy, 'news-on');
      var header = newsxy.getElementsByTagName('h5')[0];
      addEventSimple(header, 'click', toggleNews);
    }
	    
    function toggleNews() {
      var news = this.parentNode;
      if (hasClass(news, 'news-on')) {
        removeClass(news, 'news-on');
        addClass(news, 'news-off');
      } else {
        removeClass(news, 'news-off');
        addClass(news, 'news-on');
      }
    }
		    
    </script>
    <?PHP    
$cntycheck = $_GET["county"];
$ctycheck = $_GET["city"];
$stcheck = $_GET["state"];

if (isset($stcheck) and isset($cntycheck) and isset($ctycheck))
	{
		echo('<script type="text/javascript">');
		echo("var rsstate = getElementsByClass('rsstate');");
		echo("for (var i = 0; i < rsstate.length; i++) {");
		echo("var rsstate = rsstate[i];");
		echo("addClass(rsstate, 'rs-on');}");
		echo("var rscongress = getElementsByClass('rscongress');");
		echo("for (var i = 0; i < rscongress.length; i++) {");
		echo("var rscongress = rscongress[i];");
		echo("addClass(rscongress, 'rs-on');}");
		echo("var rscounty = getElementsByClass('rscounty');");
		echo("for (var i = 0; i < rscounty.length; i++) {");
		echo("var rscounty = rscounty[i];");
		echo("addClass(rscounty, 'rs-on');}");
		echo("var rscity = getElementsByClass('rscity');");
		echo("for (var i = 0; i < rscity.length; i++) {");
		echo("var rscity = rscity[i];");
		echo("addClass(rscity, 'rs-on');}");
		echo("var rsstatesenate = getElementsByClass('rsstatesenate');");
		echo("for (var i = 0; i < rsstatesenate.length; i++) {");
		echo("var rsstatesenate = rsstatesenate[i];");
		echo("addClass(rsstatesenate, 'rs-on');}");
		echo("var rsstatecongress = getElementsByClass('rsstatecongress');");
		echo("for (var i = 0; i < rsstatecongress.length; i++) {");
		echo("var rsstatecongress = rsstatecongress[i];");
		echo("addClass(rsstatecongress, 'rs-on');}");
		echo("var rsschooldist = getElementsByClass('rsschooldist');");
		echo("for (var i = 0; i < rsschooldist.length; i++) {");
		echo("var rsschooldist = rsschooldist[i];");
		echo("addClass(rsschooldist, 'rs-on');}");		
		echo('</script>');
	}
	else{
		echo('<script type="text/javascript">');
		echo("var rscity = getElementsByClass('rscity');");
		echo("for (var i = 0; i < rscity.length; i++) {");
		echo("var rscity = rscity[i];");
		echo("addClass(rscity, 'rs-off');}");
		echo("var rsstatesenate = getElementsByClass('rsstatesenate');");
		echo("for (var i = 0; i < rsstatesenate.length; i++) {");
		echo("var rsstatesenate = rsstatesenate[i];");
		echo("addClass(rsstatesenate, 'rs-off');}");
		echo("var rsstatecongress = getElementsByClass('rsstatecongress');");
		echo("for (var i = 0; i < rsstatecongress.length; i++) {");
		echo("var rsstatecongress = rsstatecongress[i];");
		echo("addClass(rsstatecongress, 'rs-off');}");
		echo("var rsschooldist = getElementsByClass('rsschooldist');");
		echo("for (var i = 0; i < rsschooldist.length; i++) {");
		echo("var rsschooldist = rsschooldist[i];");
		echo("addClass(rsschooldist, 'rs-off');}");	
		echo("var rscongress = getElementsByClass('rscongress');");
		echo("for (var i = 0; i < rscongress.length; i++) {");
		echo("var rscongress = rscongress[i];");
		echo("addClass(rscongress, 'rs-off');}");
		echo('</script>');
	if (isset($stcheck) and isset($cntycheck))
	{
		echo('<script type="text/javascript">');
		echo("var rsstate = getElementsByClass('rsstate');");
		echo("for (var i = 0; i < rsstate.length; i++) {");
		echo("var rsstate = rsstate[i];");
		echo("addClass(rsstate, 'rs-on');}");
		echo("var rscounty = getElementsByClass('rscounty');");
		echo("for (var i = 0; i < rscounty.length; i++) {");
		echo("var rscounty = rscounty[i];");
		echo("addClass(rscounty, 'rs-on');}");
		echo('</script>');
	}
	else{
		echo('<script type="text/javascript">');
		echo("var rscounty = getElementsByClass('rscounty');");
		echo("for (var i = 0; i < rscounty.length; i++) {");
		echo("var rscounty = rscounty[i];");
		echo("addClass(rscounty, 'rs-off');}");
		echo('</script>');
		if (isset($stcheck))
		{
		echo('<script type="text/javascript">');
		echo("var rsstate = getElementsByClass('rsstate');");
		echo("for (var i = 0; i < rsstate.length; i++) {");
		echo("var rsstate = rsstate[i];");
		echo("addClass(rsstate, 'rs-on');}");
		echo('</script>');
		}
		else{
		echo('<script type="text/javascript">');
		echo("var rsstate = getElementsByClass('rsstate');");
		echo("for (var i = 0; i < rsstate.length; i++) {");
		echo("var rsstate = rsstate[i];");
		echo("addClass(rsstate, 'rs-off');}");
		echo('</script>');
		}
	}
}	
mysql_close($con);
   ?>

</body>
</html>
