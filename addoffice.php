<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wikipoliticki Add Office</title>
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
 
 
require_once('utilities/config.php');

 ?>
<div id="add">
<h1>Add Office</h1>

<form enctype="multipart/form-data" method="post" id="addnew" name="addnew" class="cmxform" action="verifyoffice.php">
<fieldset>
<label id="laddoffice" for="addoffice">*Office:</label><input name="addoffice" id="addoffice" type="text" class="required"/>
<h5>(*) denotes required field</h5>
<br />
<input type="hidden" name="level" value="<?php echo $_POST["level"] ;?>"/>
<input type="hidden" name="state" value="<?php echo $_POST["state"] ;?> "/>
<input type="hidden" name="county" value="<?php echo $_POST["county"] ;?> "/>
<input type="hidden" name="city" value="<?php echo $_POST["city"] ;?> "/>
<input type="hidden" name="levelsub" value="<?php echo $_POST["levelsub"] ;?>"/>
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
