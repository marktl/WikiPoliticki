<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Add More</title>
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
<div id="addmore">
<?php
$datetest = date("Y-m-d",'1950-01-01');
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
$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,individual.other1,individual.other2,individual.other3,office.officeid
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE individual.individualid = $id 
		order by officenames.officename;";
		}else{
		$sql="SELECT distinct individual.firstname, individual.middlename, individual.lastname, DATE_FORMAT(office.TermStart,'%c/%e/%Y'),DATE_FORMAT(office.TermEnd,'%c/%e/%Y'),individual.Party,individual.img, officenames.officename,individual.pheight,individual.pwidth,individual.individualid,individual.facebookurl,individual.twitterurl,individual.twitterhandle,individual.wikipediaurl,office.district,individual.other1,individual.other2,individual.other3,office.officeid
		FROM individual
		JOIN office
		ON individual.individualid= office.individualid
		JOIN officenames
		ON officenames.officenameid = office.officenameid
		WHERE individual.individualid = $id 
		order by officenames.officename;";
		}
		$result = mysql_query($sql);
		echo('<form enctype="multipart/form-data" method="post" id="update" name="update" class="cmxform" action="verifymore.php">');
		if(isdistrict == 'no'){
		while($row = mysql_fetch_row($result)){
			echo("<h2>$row[7] </h2>");
			echo("<span>");
			echo("<img src=\"images/Uploads/$row[6]\" alt=\"$state $row[0] $row[2]\" class=\"floatLeft\" width=\"$row[9]\" height=\"$row[8]\" />");
			echo("<div id=\"addmoreedirectory\"> <h4>$row[0]");
			if(!empty($row[1])){
			echo(" $row[1] $row[2]</h4> ");
			}else{
			echo(" $row[2]</h4> ");
			}
			if(!empty($row[5])){
			echo("- $row[5]<input type=\"hidden\" name=\"party\" id=\"party\" value=\"$row[5]\" /> &nbsp;&nbsp;");
			}else{
			echo('Party: <select name="party" id="party"><option value="">Select</option><option value="Constitution Party">Constitution Party</option>');
			echo('<option value="Democrat">Democrat</option>');
			echo('<option value="Green Party">Green Party</option>');
			echo('<option value="Independent">Independent</option>');
			echo('<option value="Libertarian">Libertarian</option>');
			echo('<option value="No Party Affiliation">No Party Affiliation</option>');
			echo('<option value="Republican">Republican</option>');
			echo('</select>');
			}
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br />');
			if(!empty($row[3]) and $row[3] != '0/0/0000' ){
			echo("Assumed Office: $row[3] <input type=\"hidden\" name=\"tsmonth\" value=\"$row[3]\" />&nbsp;&nbsp;");
			}else{
			echo('Assumed Office:<select name="tsmonth" id="tsmonth"><option value="">Select</option><option value="01">01 - Jan</option>');
            echo('<option value="02">02 - Feb</option>');
            echo('<option value="03">03 - Mar</option>');
            echo('<option value="04">04 - Apr</option>');
            echo('<option value="05">05 - May</option>');
            echo('<option value="06">06 - Jun</option>');
            echo('<option value="07">07 - Jul</option>');
            echo('<option value="08">08 - Aug</option>');
            echo('<option value="09">09 - Sep</option>');
            echo('<option value="10">10 - Oct</option>');
            echo('<option value="11">11 - Nov</option>');
            echo('<option value="12">12 - Dec</option>');
          echo('</select>');
          echo('<select name="tsday" id="tsday"><option value="">Select</option>');
          	echo('<option value="1">1</option>');
            echo('<option value="2">2</option>');
            echo('<option value="3">3</option>');
            echo('<option value="4">4</option>');
            echo('<option value="5">5</option>');
            echo('<option value="6">6</option>');
            echo('<option value="7">7</option>');
            echo('<option value="8">8</option>');
            echo('<option value="9">9</option>');
            echo('<option value="10">10</option>');
            echo('<option value="11">11</option>');
            echo('<option value="12">12</option>');
            echo('<option value="13">13</option>');
            echo('<option value="14">14</option>');
            echo('<option value="15">15</option>');
            echo('<option value="16">16</option>');
            echo('<option value="17">17</option>');
            echo('<option value="18">18</option>');
            echo('<option value="19">19</option>');
            echo('<option value="20">20</option>');
            echo('<option value="21">21</option>');
            echo('<option value="22">22</option>');
            echo('<option value="23">23</option>');
            echo('<option value="24">24</option>');
            echo('<option value="25">25</option>');
            echo('<option value="26">26</option>');
            echo('<option value="27">27</option>');
            echo('<option value="28">28</option>');
            echo('<option value="29">29</option>');
            echo('<option value="30">30</option>');
            echo('<option value="31">31</option>');
            echo('</select>');
            echo('<select name="tsyear" id="tsyear"><option value="">Select</option>');
            echo('<option value="1980">1980</option>');
            echo('<option value="1981">1981</option>');
            echo('<option value="1982">1982</option>');
            echo('<option value="1983">1983</option>');
            echo('<option value="1984">1984</option>');
            echo('<option value="1985">1985</option>');
            echo('<option value="1986">1986</option>');
            echo('<option value="1987">1987</option>');
            echo('<option value="1988">1988</option>');
            echo('<option value="1989">1989</option>');
            echo('<option value="1990">1990</option>');
            echo('<option value="1991">1991</option>');
            echo('<option value="1992">1992</option>');
            echo('<option value="1993">1993</option>');
            echo('<option value="1994">1994</option>');
            echo('<option value="1995">1995</option>');
            echo('<option value="1996">1996</option>');
            echo('<option value="1997">1997</option>');
            echo('<option value="1998">1998</option>');
            echo('<option value="1999">1999</option>');
            echo('<option value="2000">2000</option>');
            echo('<option value="2001">2001</option>');
            echo('<option value="2002">2002</option>');
            echo('<option value="2003">2003</option>');
            echo('<option value="2004">2004</option>');
            echo('<option value="2005">2005</option>');
            echo('<option value="2006">2006</option>');
            echo('<option value="2007">2007</option>');
            echo('<option value="2008">2008</option>');
            echo('<option value="2009">2009</option>');
            echo('<option value="2010">2010</option>');
            echo('<option value="2011">2011</option>');
            echo('<option value="2012">2012</option>');
            echo('</select><br />');
			}
			if(!empty($row[4]) and $row[3] != '0/0/0000' ){
			echo("Current Term End: $row[4] <input type=\"hidden\" name=\"temonth\" value=\"$row[4]\" /> <br />");
			}else{
			echo('Current Term End:<select name="temonth" id="temonth"><option value="">Select</option><option value="01">01 - Jan</option>');
            echo('<option value="02">02 - Feb</option>');
            echo('<option value="03">03 - Mar</option>');
            echo('<option value="04">04 - Apr</option>');
            echo('<option value="05">05 - May</option>');
            echo('<option value="06">06 - Jun</option>');
            echo('<option value="07">07 - Jul</option>');
            echo('<option value="08">08 - Aug</option>');
            echo('<option value="09">09 - Sep</option>');
            echo('<option value="10">10 - Oct</option>');
            echo('<option value="11">11 - Nov</option>');
            echo('<option value="12">12 - Dec</option>');
          echo('</select><select name="teday" id="teday"><option value="">Select</option>');
          	echo('<option value="1">1</option>');
            echo('<option value="2">2</option>');
            echo('<option value="3">3</option>');
            echo('<option value="4">4</option>');
            echo('<option value="5">5</option>');
            echo('<option value="6">6</option>');
            echo('<option value="7">7</option>');
            echo('<option value="8">8</option>');
            echo('<option value="9">9</option>');
            echo('<option value="10">10</option>');
            echo('<option value="11">11</option>');
            echo('<option value="12">12</option>');
            echo('<option value="13">13</option>');
            echo('<option value="14">14</option>');
            echo('<option value="15">15</option>');
            echo('<option value="16">16</option>');
            echo('<option value="17">17</option>');
            echo('<option value="18">18</option>');
            echo('<option value="19">19</option>');
            echo('<option value="20">20</option>');
            echo('<option value="21">21</option>');
            echo('<option value="22">22</option>');
            echo('<option value="23">23</option>');
            echo('<option value="24">24</option>');
            echo('<option value="25">25</option>');
            echo('<option value="26">26</option>');
            echo('<option value="27">27</option>');
            echo('<option value="28">28</option>');
            echo('<option value="29">29</option>');
            echo('<option value="30">30</option>');
            echo('<option value="31">31</option>');
            echo('</select>');
            echo('<select name="teyear" id="teyear"><option value="">Select</option>');
            echo('<option value="2012">2012</option>');
            echo('<option value="2013">2013</option>');
            echo('<option value="2014">2014</option>');
            echo('<option value="2015">2015</option>');
            echo('<option value="2016">2016</option>');
            echo('<option value="2017">2017</option>');
            echo('<option value="2018">2018</option>');            
            echo('</select><br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\">$row[11]</a><input type=\"hidden\" name=\"facebook\" value=\"$row[11]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://facebook.com" target="_blank"><img src="images/facebook.png" /></a> <input type="text" name="facebook" id="facebook" class="url" value=""/>(include http://)</span><br />');
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\">$row[12]</a> &nbsp; Handle: $row[13]<input type=\"hidden\" name=\"twitter\" value=\"$row[12]\" /><input type=\"hidden\" name=\"twitthandle\" value=\"$row[13]\" /><br />");
			}elseif(!empty($row[13])){
			echo('<span id="weblink"><a href="http://twitter.com" target="_blank"><img src="images/twitter.png" /></a> <input type="text" name="twitter" id="twitter" class="url" value="" />(include http://)</span><br />');
			echo("Twitter Handle: $row[13]<input type=\"hidden\" name=\"twitthandle\" value=\"$row[13]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://twitter.com" target="_blank"><img src="images/twitter.png" /></a> <input type="text" name="twitter" id="twitter" class="url" value="" />(include http://)</span><br />');
			echo('Twitter Handle: <input type="text" name="twitthandle" id="twitthandle" value=""/><br />');
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\">$row[14]</a><input type=\"hidden\" name=\"wikipedia\" value=\"$row[14]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://www.wikipedia.org" target="_blank"><img src="images/wikipedia.png" /></a> <input type="text" name="wikipedia" id="wikipedia" class="url" value="" />(include http://)</span><br />');
			}
			if(!empty($row[15])){
			echo("Other Websites: <a href=\"$row[15]\">$row[15]</a><input type=\"hidden\" name=\"other1\" value=\"$row[15]\" /><br />");
			}else{
			echo('Other Website 1: <input type="text" name="other1" id="other1" class="url" value="" />(include http://)<br />');
			}
			if(!empty($row[16])){
			echo("; <a href=\"$row[16]\">$row[16]</a><input type=\"hidden\" name=\"other2\" value=\"$row[16]\" /><br />");
			}else{
			echo('Other Website 2: <input type="text" name="other2" id="other2" class="url" value="" />(include http://)<br />');
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\">$row[17]</a><input type=\"hidden\" name=\"other3\" value=\"$row[17]\" /><br />");
			}else{
			echo('Other Website 3: <input type="text" name="other3" id="other3" class="url" value="" />(include http://)<br />');			
			}
			echo("<br /><input type=\"hidden\" name=\"officeid\" value=\"$row[18]\" />");
			}
	}else{
			while($row = mysql_fetch_row($result)){
			echo("<h2>$row[7]</h2>");
			echo("<span> ");
			echo("<img src=\"images/Uploads/$row[6]\" alt=\"$state $row[0] $row[2]\" class=\"floatLeft\" width=\"$row[9]\" height=\"$row[8]\" />");
			echo("<div id=\"addmoreedirectory\"> <h4>$row[0] $row[2]</h4> ");
			if(!empty($row[5])){
			echo("- $row[5] <input type=\"hidden\" name=\"party\" value=\"$row[5]\" />");
			}else{
			echo('Party: <select name="party" id="party"><option value="">Select</option><option value="Constitution Party">Constitution Party</option>');
			echo('<option value="Democrat">Democrat</option>');
			echo('<option value="Green Party">Green Party</option>');
			echo('<option value="Independent">Independent</option>');
			echo('<option value="Libertarian">Libertarian</option>');
			echo('<option value="No Party Affiliation">No Party Affiliation</option>');
			echo('<option value="Republican">Republican</option>');
			echo('</select>');
			}
			echo("- District $row[15] &nbsp;&nbsp;");
			if(!empty($row[11])){
			echo("<div class=\"fb-like\" data-href=\"$row[11]\" data-send=\"false\" data-layout=\"button_count\" data-width=\"80\" data-show-faces=\"false\"></div>");
			}
			echo('<br />');
			if(!empty($row[3]) and  $row[3] != '0/0/0000' ){
			echo("Assumed Office: $row[3] <input type=\"hidden\" name=\"tsmonth\" value=\"$row[3]\" />&nbsp;&nbsp;");
			}else{
			echo('Assumed Office:<select name="tsmonth" id="tsmonth"><option value="">Select</option><option value="01">01 - Jan</option>');
            echo('<option value="02">02 - Feb</option>');
            echo('<option value="03">03 - Mar</option>');
            echo('<option value="04">04 - Apr</option>');
            echo('<option value="05">05 - May</option>');
            echo('<option value="06">06 - Jun</option>');
            echo('<option value="07">07 - Jul</option>');
            echo('<option value="08">08 - Aug</option>');
            echo('<option value="09">09 - Sep</option>');
            echo('<option value="10">10 - Oct</option>');
            echo('<option value="11">11 - Nov</option>');
            echo('<option value="12">12 - Dec</option>');
          echo('</select>');
          echo('<select name="tsday" id="tsday"><option value="">Select</option>');
          	echo('<option value="1">1</option>');
            echo('<option value="2">2</option>');
            echo('<option value="3">3</option>');
            echo('<option value="4">4</option>');
            echo('<option value="5">5</option>');
            echo('<option value="6">6</option>');
            echo('<option value="7">7</option>');
            echo('<option value="8">8</option>');
            echo('<option value="9">9</option>');
            echo('<option value="10">10</option>');
            echo('<option value="11">11</option>');
            echo('<option value="12">12</option>');
            echo('<option value="13">13</option>');
            echo('<option value="14">14</option>');
            echo('<option value="15">15</option>');
            echo('<option value="16">16</option>');
            echo('<option value="17">17</option>');
            echo('<option value="18">18</option>');
            echo('<option value="19">19</option>');
            echo('<option value="20">20</option>');
            echo('<option value="21">21</option>');
            echo('<option value="22">22</option>');
            echo('<option value="23">23</option>');
            echo('<option value="24">24</option>');
            echo('<option value="25">25</option>');
            echo('<option value="26">26</option>');
            echo('<option value="27">27</option>');
            echo('<option value="28">28</option>');
            echo('<option value="29">29</option>');
            echo('<option value="30">30</option>');
            echo('<option value="31">31</option>');
            echo('</select>');
            echo('<select name="tsyear" id="tsyear"><option value="">Select</option>');
            echo('<option value="1980">1980</option>');
            echo('<option value="1981">1981</option>');
            echo('<option value="1982">1982</option>');
            echo('<option value="1983">1983</option>');
            echo('<option value="1984">1984</option>');
            echo('<option value="1985">1985</option>');
            echo('<option value="1986">1986</option>');
            echo('<option value="1987">1987</option>');
            echo('<option value="1988">1988</option>');
            echo('<option value="1989">1989</option>');
            echo('<option value="1990">1990</option>');
            echo('<option value="1991">1991</option>');
            echo('<option value="1992">1992</option>');
            echo('<option value="1993">1993</option>');
            echo('<option value="1994">1994</option>');
            echo('<option value="1995">1995</option>');
            echo('<option value="1996">1996</option>');
            echo('<option value="1997">1997</option>');
            echo('<option value="1998">1998</option>');
            echo('<option value="1999">1999</option>');
            echo('<option value="2000">2000</option>');
            echo('<option value="2001">2001</option>');
            echo('<option value="2002">2002</option>');
            echo('<option value="2003">2003</option>');
            echo('<option value="2004">2004</option>');
            echo('<option value="2005">2005</option>');
            echo('<option value="2006">2006</option>');
            echo('<option value="2007">2007</option>');
            echo('<option value="2008">2008</option>');
            echo('<option value="2009">2009</option>');
            echo('<option value="2010">2010</option>');
            echo('<option value="2011">2011</option>');
            echo('<option value="2012">2012</option>');
            echo('</select><br />');
			}
			if(!empty($row[4]) and  $row[3] != '0/0/0000' ){
			echo("Current Term End: $row[4] <input type=\"hidden\" name=\"temonth\" value=\"$row[4]\" /><br />");
			}else{
			echo('Current Term End:<select name="temonth" id="temonth"><option value="">Select</option><option value="01">01 - Jan</option>');
            echo('<option value="02">02 - Feb</option>');
            echo('<option value="03">03 - Mar</option>');
            echo('<option value="04">04 - Apr</option>');
            echo('<option value="05">05 - May</option>');
            echo('<option value="06">06 - Jun</option>');
            echo('<option value="07">07 - Jul</option>');
            echo('<option value="08">08 - Aug</option>');
            echo('<option value="09">09 - Sep</option>');
            echo('<option value="10">10 - Oct</option>');
            echo('<option value="11">11 - Nov</option>');
            echo('<option value="12">12 - Dec</option>');
          echo('</select><select name="teday" id="teday"><option value="">Select</option>');
          	echo('<option value="1">1</option>');
            echo('<option value="2">2</option>');
            echo('<option value="3">3</option>');
            echo('<option value="4">4</option>');
            echo('<option value="5">5</option>');
            echo('<option value="6">6</option>');
            echo('<option value="7">7</option>');
            echo('<option value="8">8</option>');
            echo('<option value="9">9</option>');
            echo('<option value="10">10</option>');
            echo('<option value="11">11</option>');
            echo('<option value="12">12</option>');
            echo('<option value="13">13</option>');
            echo('<option value="14">14</option>');
            echo('<option value="15">15</option>');
            echo('<option value="16">16</option>');
            echo('<option value="17">17</option>');
            echo('<option value="18">18</option>');
            echo('<option value="19">19</option>');
            echo('<option value="20">20</option>');
            echo('<option value="21">21</option>');
            echo('<option value="22">22</option>');
            echo('<option value="23">23</option>');
            echo('<option value="24">24</option>');
            echo('<option value="25">25</option>');
            echo('<option value="26">26</option>');
            echo('<option value="27">27</option>');
            echo('<option value="28">28</option>');
            echo('<option value="29">29</option>');
            echo('<option value="30">30</option>');
            echo('<option value="31">31</option>');
            echo('</select>');
            echo('<select name="teyear" id="teyear"><option value="">Select</option>');
            echo('<option value="2012">2012</option>');
            echo('<option value="2013">2013</option>');
            echo('<option value="2014">2014</option>');
            echo('<option value="2015">2015</option>');
            echo('<option value="2016">2016</option>');
            echo('<option value="2017">2017</option>');
            echo('<option value="2018">2018</option>');            
            echo('</select><br />');
			}
			if(!empty($row[11])){			
			echo("Facebook: <a href=\"$row[11]\">$row[11]</a><input type=\"hidden\" name=\"facebook\" value=\"$row[11]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://facebook.com" target="_blank"><img src="images/facebook.png" /></a> <input type="text" name="facebook" id="facebook" class="url" value=""/>(include http://)</span><br />');
			}
			if(!empty($row[12]) and !empty($row[13])){	
			echo("Twitter: <a href=\"$row[12]\">$row[12]</a> &nbsp; Handle: $row[13]<input type=\"hidden\" name=\"twitter\" value=\"$row[12]\" /><input type=\"hidden\" name=\"twitthandle\" value=\"$row[13]\" /><br />");
			}elseif(!empty($row[13])){
			echo('<span id="weblink"><a href="http://twitter.com" target="_blank"><img src="images/twitter.png" /></a> <input type="text" name="twitter" id="twitter" class="url" value="" />(include http://)</span><br />');
			echo("Twitter Handle: $row[13]<input type=\"hidden\" name=\"twitthandle\" value=\"$row[13]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://twitter.com" target="_blank"><img src="images/twitter.png" /></a> <input type="text" name="twitter" id="twitter" class="url" value="" />(include http://)</span><br />');
			echo('Twitter Handle: <input type="text" name="twitthandle" id="twitthandle" value=""/><br />');
			}
			if(!empty($row[14])){
			echo("Wikipedia: <a href=\"$row[14]\">$row[14]</a><input type=\"hidden\" name=\"wikipedia\" value=\"$row[14]\" /><br />");
			}else{
			echo('<span id="weblink"><a href="http://www.wikipedia.org" target="_blank"><img src="images/wikipedia.png" /></a> <input type="text" name="wikipedia" id="wikipedia" class="url" value="" />(include http://)</span><br />');
			}
			if(!empty($row[16])){
			echo("Other Websites: <a href=\"$row[16]\">$row[16]</a><input type=\"hidden\" name=\"other1\" value=\"$row[16]\" /><br />");
			}else{
			echo('Other Website 1: <input type="text" name="other1" id="other1" class="url" value="" />(include http://)<br />');
			}
			if(!empty($row[17])){
			echo("; <a href=\"$row[17]\">$row[17]</a><input type=\"hidden\" name=\"other2\" value=\"$row[17]\" /><br />");
			}else{
			echo('Other Website 2: <input type="text" name="other2" id="other2" class="url" value="" />(include http://)<br />');
			}
			if(!empty($row[18])){
			echo("; <a href=\"$row[18]\">$row[18]</a><input type=\"hidden\" name=\"other3\" value=\"$row[18]\" /><br />");
			}else{
			echo('Other Website 3: <input type="text" name="other3" id="other3" class="url" value="" />(include http://)');			
			}
			echo("<br /><input type=\"hidden\" name=\"officeid\" value=\"$row[18]\" />");
			}
			 }
			 
			 mysql_close($con);

 ?>

</div>

<br />
<input type="hidden" name="level" value="<?php echo $_POST["level"] ;?>"/>
<input type="hidden" name="state" value="<?php echo $_POST["state"] ;?> "/>
<input type="hidden" name="county" value="<?php echo $_POST["county"] ;?> "/>
<input type="hidden" name="city" value="<?php echo $_POST["city"] ;?> "/>
<input type="hidden" name="id" value="<?php echo $_POST["id"] ;?> "/>
<div align="center">
Please enter reCAPTCHA text below and click Submit
<?php
require_once('recaptchalib.php');
  $publickey = "6Lc2UM0SAAAAAKRIAr1QwkfNKC7hz3t2Ave1VVUi"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
  ?>
  
  <br />
<input type="button" value="Cancel" onclick="history.back(-1)" />&nbsp;&nbsp;<input type="submit" name="submit" class="submit"/>
</form>
</div>


</body>
</html>
