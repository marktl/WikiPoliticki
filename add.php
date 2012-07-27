<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Add</title>
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
<script type="text/javascript">
            var windowSizeArray = [ "width=200,height=200",
                                    "width=300,height=400,scrollbars=yes" ];
 
            $(document).ready(function(){
                $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
                    var windowSize = windowSizeArray[$(this).attr("rel")];
 
                    window.open(url, windowName, windowSize);
 
                    event.preventDefault();
 
                });
            });
        </script>
</head>
<body>
<?php
$levelin = trim($_POST["level"]);
$display = $levelin;
if ($levelin == 'statesenate'){
$display = 'state senate';
}
if ($levelin == 'statecongress'){
$display = 'state congress';
}
if ($levelin == 'schooldist'){
$display = 'school district';
}

if($levelin == "state"){
$place = trim($_POST["state"]);
$levelsub = '1';
}
if($levelin == "county"){
$place = trim($_POST["county"]);
$levelsub = '2';
}
if($levelin == "congress"){
$place = trim($_POST["city"]);
$levelsub = '3';
}
if($levelin == "statesenate"){
$place = trim($_POST["city"]);
$levelsub = '4';
}
if($levelin == "statecongress"){
$place = trim($_POST["city"]);
$levelsub = '5';
}
if($levelin == "city"){
$place = trim($_POST["city"]);
$levelsub = '6';
}
if($levelin == "schooldist"){
$place = trim($_POST["city"]);
$levelsub = '7';
}


$state = trim($_POST["state"]);
$county = trim($_POST["county"]);
 $city = trim($_POST["city"]);
 
 
require_once('utilities/config.php');

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		
		mysql_select_db(DB_DATABASE, $con);
		$sql="SELECT DISTINCT officenames.officenameid,officenames.officename FROM officenames WHERE level = '$levelsub' ORDER BY officename;";
		
		$officenames = mysql_query($sql);
		
		
		if(($levelin == "congress" or $levelin == "statesenate" or $levelin == "statecongress" or $levelin == "schooldist") and $city != ""){
		if($levelin == "congress"){
		$sql="SELECT DISTINCT TRIM(districts.congress) FROM districts WHERE districts.state = '$state' and districts.county = '$county' and districts.city = '$city' and congress > 0 ORDER BY districts.congress;";
		}else if($levelin == "statesenate"){
		$sql="SELECT DISTINCT TRIM(districts.statesenate) FROM districts WHERE districts.state = '$state' and districts.county = '$county' and districts.city = '$city' and statesenate > 0 ORDER BY districts.statesenate;";
		}else if($levelin == "statecongress"){
		$sql="SELECT DISTINCT TRIM(districts.statecongress) FROM districts WHERE districts.state = '$state' and districts.county = '$county' and districts.city = '$city' and statecongress > 0 ORDER BY districts.statecongress;";
		}else if($levelin == "schooldist"){
		$sql="SELECT DISTINCT TRIM(districts.schooldist) FROM districts WHERE districts.state = '$state' and districts.county = '$county' and districts.city = '$city' and schooldist IS NOT NULL ORDER BY districts.schooldist;";
		}
		
		$disctricts = mysql_query($sql);
		}
		mysql_close($con);

 ?>
<div id="add">
<h1>Add <?php echo($display);?> level politician for <?php echo($place);?></h1>
<?php 
if ($levelin <> 'statesenate' and $levelin <> 'statecongress' and $levelin <> 'congress'){
$level = trim($_POST['level']);
$state = trim($_POST['state']);
$county = trim($_POST['county']);
$city = trim($_POST['city']);
echo('<form id="addoffice" action="addoffice.php" method="post" style="display:inline;">');
echo("<input type=\"hidden\" value=\"$level\" name=\"level\" />");
echo("<input type=\"hidden\" value=\"$state\" name=\"state\"/>");
echo("<input type=\"hidden\" value=\"$county\" name=\"county\"/>");
echo("<input type=\"hidden\" value=\"$city\" name=\"city\"/>");
echo("<input type=\"hidden\" value=\"$levelsub\" name=\"levelsub\"/>");
echo('<input type="image"  src="images/plusblack.jpg" height="20" width="20" value="submit" id="addoffice" name="addoffice" /> <label for="addoffice">Add office</label>');
echo('</form>');
}
?>
<form enctype="multipart/form-data" method="post" id="addnew" name="addnew" class="cmxform" action="verify.php">
<table class="tableadd" align="center" border="0">
<tr>
<td align="right"><label id="loffice" for="office">*Office:</label></td>
<td align="left"><select name="office" id="office" class="required" /><option value="">Select</option>
<?php
while($row = mysql_fetch_row($officenames)){
		 echo("<option value=\"$row[0]\">$row[1]</option>");
		}
?></select>
</td></tr>
<?php 
 if($levelin == "congress" or $levelin == "statesenate" or $levelin == "statecongress" or $levelin == "schooldist"){
?>
<tr><td align="right"><label id="ldistrict" for="district">*District:</label>
</td><td align="left">
<?php 
if(!$disctricts){
echo('No districts found.  Please press back or cancel and add district to this level and city.</td></tr>');
}else{
echo('<select name="district" id="district" class="required" />');
echo('<option value="">Select</option>');
while($row = mysql_fetch_row($disctricts)){
		 echo("<option value=\"$row[0]\">$row[0]</option>");
		}
echo('</select></td></tr>');
}}
?><tr><td align="right">
<label id="lfname" for="fname">*First Name:</label>
</td><td align="left"><input type="text" name="fname" id="fname" class="required" minlength="2" /></td></tr>
<tr><td align="right"><label id="lmname" for="mname">Middle Name:</label></td><td align="left"><input type="text" name="mname" id="mname"/></td></tr>
<tr><td align="right"><label id="llname" for="lname">*Last Name:</label></td><td align="left"><input type="text" name="lname" id="lname" class="required" minlength="2" /></td></tr>
<tr><td align="right"><label id="lparty" for="party">Party:</label></td><td align="left"><select name="party" id="party"><option value="">Select</option><option value="Constitution Party">Constitution Party</option>
<option value="Democrat">Democrat</option>
<option value="Green Party">Green Party</option>
<option value="Independent">Independent</option>
<option value="Libertarian">Libertarian</option>
<option value="No Party Affiliation">No Party Affiliation</option>
<option value="Republican">Republican</option>
</select></td></tr>
<tr><td align="right"><label id="ltsyear" for="tsyear">Assumed Office Date:</label></td><td align="left"><select name="tsmonth" id="tsmonth"><option value="">Select</option><option value="01">01 - Jan</option>
            <option value="02">02 - Feb</option>
            <option value="03">03 - Mar</option>
            <option value="04">04 - Apr</option>
            <option value="05">05 - May</option>
            <option value="06">06 - Jun</option>
            <option value="07">07 - Jul</option>
            <option value="08">08 - Aug</option>
            <option value="09">09 - Sep</option>
            <option value="10">10 - Oct</option>
            <option value="11">11 - Nov</option>
            <option value="12">12 - Dec</option>
          </select>
          <select name="tsday" id="tsday"><option value="">Select</option>
          	<option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            </select>
            <select name="tsyear" id="tsyear"><option value="">Select</option>
            <option value="1980">1980</option>
            <option value="1981">1981</option>
            <option value="1982">1982</option>
            <option value="1983">1983</option>
            <option value="1984">1984</option>
            <option value="1985">1985</option>
            <option value="1986">1986</option>
            <option value="1987">1987</option>
            <option value="1988">1988</option>
            <option value="1989">1989</option>
            <option value="1990">1990</option>
            <option value="1991">1991</option>
            <option value="1992">1992</option>
            <option value="1993">1993</option>
            <option value="1994">1994</option>
            <option value="1995">1995</option>
            <option value="1996">1996</option>
            <option value="1997">1997</option>
            <option value="1998">1998</option>
            <option value="1999">1999</option>
            <option value="2000">2000</option>
            <option value="2001">2001</option>
            <option value="2002">2002</option>
            <option value="2003">2003</option>
            <option value="2004">2004</option>
            <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            </select></td></tr>
            <tr><td align="right"><label id="lteyear" for="teyear">Current Term End Date:</label></td><td align="left"><select name="temonth" id="temonth"><option value="">Select</option><option value="01">01 - Jan</option>
            <option value="02">02 - Feb</option>
            <option value="03">03 - Mar</option>
            <option value="04">04 - Apr</option>
            <option value="05">05 - May</option>
            <option value="06">06 - Jun</option>
            <option value="07">07 - Jul</option>
            <option value="08">08 - Aug</option>
            <option value="09">09 - Sep</option>
            <option value="10">10 - Oct</option>
            <option value="11">11 - Nov</option>
            <option value="12">12 - Dec</option>
          </select><select name="teday" id="teday"><option value="">Select</option>
          	<option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            </select>
            <select name="teyear" id="teyear"><option value="">Select</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>            
            </select></td></tr>
            <tr><td align="right">Link to <a href="http://facebook.com" target="_blank"><img src="images/facebook.png" /></a></td><td align="left" valign="bottom"><input type="text" name="facebook" id="facebook" class="url" value=""/>(include http://)</td></tr>
            <tr><td align="right">Link to <a href="http://twitter.com" target="_blank"><img src="images/twitter.png" /></a></td><td align="left" valign="bottom"><input type="text" name="twitter" id="twitter" class="url" value="" />(include http://)</td></tr>
            <tr><td align="right"><label id="ltwitthandle" for="twitthandle">Twitter Handle:</label></td><td align="left"><input type="text" name="twitthandle" id="twitthandle" value=""/></td></tr>
            <tr><td align="right">Link to <a href="http://www.wikipedia.org/" target="_blank"><img src="images/wikipedia.png" /></a></td><td align="left" valign="bottom"><input type="text" name="wikipedia" id="wikipedia" class="url" value="" />(include http://)</td></tr>
            <tr><td align="right"><label id="lother1" for="other1">Other Link 1:</label></td><td align="left" ><input type="text" name="other1" id="otherone" class="url" value="" />(include http://)</td></tr>
            <tr><td align="right"><label id="lother2" for="other2">Other Link 2:</label></td><td align="left"><input type="text" name="other2" id="othertwo" class="url" value="" />(include http://)</td></tr>
            <tr><td align="right"><label id="lother3" for="other3">Other Link 3:</label></td><td align="left"><input type="text" name="other3" id="otherthree" class="url" value="" />(include http://)</td></tr>
            <tr><td align="right"><label id="lfile" for="file">*Picture:</label></td><td align="left"><input class="required" type="file" name="file" onchange="showFileSize();" id="file"/></td></tr></table>
<h5>(*) denotes required field</h5>
<br />
<input type="hidden" name="level" value="<?php echo $_POST["level"] ;?>"/>
<input type="hidden" name="state" value="<?php echo $_POST["state"] ;?> "/>
<input type="hidden" name="county" value="<?php echo $_POST["county"] ;?> "/>
<input type="hidden" name="city" value="<?php echo $_POST["city"] ;?> "/>
<div align="center">
Please enter reCAPTCHA text below and click Submit
<?php
require_once('recaptchalib.php');
  $publickey = "6Lc2UM0SAAAAAKRIAr1QwkfNKC7hz3t2Ave1VVUi"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
  ?>
  </div>
  <br />
<input type="button" value="Cancel" onclick="history.back(-1)" />&nbsp;&nbsp;<input type="submit" name="submit" class="submit"/>
</form>
</div>

</body>
</html>
