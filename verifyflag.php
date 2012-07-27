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

$state = trim($_POST["state"]);
$county = trim($_POST["county"]);
 $city = trim($_POST["city"]);
$lastname = trim($_POST["lastname"]);
$office = trim($_POST["office"]);
$id = trim($_POST["id"]);
	echo('<SCRIPT LANGUAGE="JavaScript">');
		echo('function go_now () {');
		if(!$county and !$city){
			echo("window.location.href = \"http://wikipoliticki.us?state=$state#$lastname-$office\";");
		}
		else if(!$city)
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county#$lastname-$office\";");
		}
		else 
		{
		echo("window.location.href = \"http://wikipoliticki.us?state=$state&county=$county&city=$city#$lastname-$office\";");
		}		
		echo('}');
		echo('setTimeout("go_now()",2500);');
	echo('</SCRIPT>');
	echo("<br /><br /><br /><h2>The record has been flagged and will be reviewed as soon as possible.  Thank you!  Sending you back to Wikipoliticki.us now....</h2>");
	
	require_once('utilities/config.php');

	$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  		
		mysql_select_db(DB_DATABASE, $con);
	
		$id = trim($_POST["id"]);
		$problemdescription = trim($_POST["problemdescription"]);
	
		$sql="INSERT INTO flag (individualid,notes) VALUES ('$id','$problemdescription');";
		
		
	mysql_query($sql);
		
	mysql_close($con);

// Email

mail('levymt@gmail.com', "Error for ID $id", $problemdescription);

	
}//outer if
  ?>
</body>
</html>
