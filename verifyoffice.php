<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Submit Office</title>
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

$state = trim($_POST["state"]);
$county = trim($_POST["county"]);
 $city = trim($_POST["city"]);
$level = trim($_POST["level"]);
	echo('<SCRIPT LANGUAGE="JavaScript">');
	echo('function go_now () {');
	echo('document.forms["addoffices"].submit();');
		echo('}');
		echo('setTimeout("go_now()",500);');
	echo('</SCRIPT>');
	
	require_once('utilities/config.php');

	$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  		
		mysql_select_db(DB_DATABASE, $con);
	
		$addoffice = trim($_POST["addoffice"]);
		$levelsub = trim($_POST["levelsub"]);
	
		$sql="INSERT INTO officenames (officename,level) VALUES ('$addoffice','$levelsub');";
		
		
	mysql_query($sql);
		
	mysql_close($con);
	
}//outer if
  ?>
 <form action="add.php" method="post" id="addoffices">
<input type="hidden" value="<?php echo(trim($_POST["level"]));?>" name="level" />
<input type="hidden" value="<?php echo(trim($_POST["state"]));?>" name="state"/>
<input type="hidden" value="<?php echo(trim($_POST["county"]));?>" name="county"/>
<input type="hidden" value="<?php echo(trim($_POST["city"]));?>" name="city"/>
</form>
</body>
</html>
