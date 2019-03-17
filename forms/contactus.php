<?php 
$sharplingo_email ='contact@sharplingo.com';
session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';
$tel='';
$lang='';
$level='Select your level';
$reason = 'Select your reason';

if(isset($_POST['submit']))
{
	
	$name = htmlentities($_POST['name']);  
	$visitor_email = htmlentities($_POST['visitor_email']);
	$user_message = htmlentities($_POST['message']);
	$tel = htmlentities($_POST['tel']);
	$lang = htmlentities($_POST['lang']);
	$level = htmlentities($_POST['level']);
	$reason = htmlentities($_POST['reason']);
	///------------Do Validations-------------
	if(empty($name)||empty($visitor_email))
	{
		$errors .= "<li><b>Name</b> is a required field. </li>";	
	}
	if(empty($visitor_email))
	{
		$errors .= "<li><b>Email </b> is a required field. </li>";	
	}
	if(IsInjected($visitor_email))
	{
		$errors .= "<li>Bad email value!</li>";
	}
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "<li>The captcha <b>code</b> does not match! </li>";
	}
	
	if(empty($errors))
	{
		//send the email to contact@sharplingo.com
		$to = $sharplingo_email;
		$subject="New form submission";
		$from = $sharplingo_email;
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$body = "A user <b> $name</b> submitted the contact form:\n".
		"Name: $name\n".
		"Email: $visitor_email \n".
		"Telephone: $tel \n".
		"Language to learn: $lang \n".
		"level: $level \n".
		"reason: $reason \n".
		"Message: \n ".
		"$user_message\n".
		"IP: $ip\n";	
		
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $visitor_email \r\n";
		
		mail($to, $subject, $body,$headers);
		header('Location: thank-you.html');
		
		//send a confirmation e-mail to the sender
		$to2 = $visitor_email;
		$subject2="Thank you for contaction us";
		$from2 = $sharplingo_email;
	
		
		$body2 = "Thank you for contacting us. We will get back to you as soon as possible\n".
		"Your message was \n".
		"Name: $name\n".
		"Email: $visitor_email \n".
		"Telephone: $tel \n".
		"Language to learn: $lang \n".
		"level: $level \n".
		"reason: $reason \n".
		"Message: \n ".
		"$user_message\n".
		"IP: $ip\n";	
		
		$headers2 = "From: $from2 \r\n";
		$headers2 .= "Reply-To: $visitor_email \r\n";
		
		mail($to2, $subject2, $body2,$headers2);
	}
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="screen">
/* <![CDATA[ */
@import url(../style.css);
/* ]]> */
</style>
<title>Sharplingo - Contact Us</title>
</head>

<body id="contactus">
<div id="wrapper">
 <div id="masthead">
 <img src="../images/masthead.png"/>
 </div id="masthead"> <!--masthead-->
 <div id="menuBar">
  <ul id="navlist">
	<li><a href="../index.html" id="homenav">Home</a></li>
	<li><a href="../courses.html" id ="coursesnav">Courses</a></li>
	<li><a href="../aboutus.html" id ="aboutusnav">About us</a></li>
	<li><a href="contactus.php" id ="contactusnav">Contact us</a></li>
    <li><a href="jobs.php" id ="jobsnav">Jobs</a></li>
   
</ul>

 </div> <!--menuBar-->
 <div id="content">
<!-- a helper script for vaidating the form-->
<script  src="scripts/gen_validatorv31.js" type="text/javascript"></script>	
</head>

<body>
<div id="contactustxt">
<p >Send us your inquiries or message using this form and we will get back to you as soon as possible</p>
</div>
<div id="errmessbox">
<div id='contactform_errorloc' class='error_strings'></div>  
<?php
if(!empty($errors)){
	echo"<ul class='errmess'>";
    echo $errors;
    echo"</ul>";
}
?>
</div>
<form method="POST"  id="contac_form" 
action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 


 <div id="contact" >
  <h2>Sharplingo</h2>
  
     <p><b>Tel: 000 000 0000</b></p>
     <p><b>Skype: Sharplingo</b></p>
      <p><b>London, UK</b></p>
    

    </div> <!--boxout-->


<p>
<label for='name'>Name<abbr>*</abbr></label><br>
<input class="formField"  type="text" name="name" >
</p>
<p>
<label for='visitor_email'>Email<abbr>*</abbr></label><br>
<input class="formField"  type="text" name="visitor_email" >
</p>
<p>
<label for='tel'>Telephone</label><br>
<input class="formField"  type="text" name="tel">
</p>
<div id="lang">
<div id="formopt">

<p >please fill out  also this section if you want to learn a language.</p>

</div>
<p>
<label for='lang'>The language you want to learn</label><br>
<input class="formField"  type="text" name="lang">
</p>
<p>
<label for='level'>Your level of knowledge of the language</label><br>
<select class="formField" name="level" >
        <option selected="selected">Select your level</option>
        <option>beginner</option>
        <option>intermediate</option>
        <option>advanced</option>
        <option>GCSE</option>
        <option>A Level</option>
        <option>University Level</option>
        <option>Others</option>
      </select>
</p>
<p>
<label for='reason'>Your reason for learning</label><br>
<select class="formField"  name="reason" >
 <option selected="selected">Select your reason</option>
        <option>Educational</option>
        <option>Profession</option>
        <option>Holiday</option>
        <option>Pleasures</option>
        <option>Relocation</option>
        <option>Others</option>
        </select>
</p>
</div><!--lang-->
<div id="message">
<p>
<label for='message'> Your Message:</label> <br>
<textarea  name="message" rows=8 cols=45></textarea>
</p>
</div>
<p>
<img src="scripts/captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' alt="captcha_code" ><br>
<label for='6_letters_code'>Enter the code above here :</label><br>
<input id="6_letters_code" name="6_letters_code" type="text"><br>
<small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
</p>
<input type="submit" value="Send" name='submit'>
<p id="reqFld"><abbr>*</abbr> required fields</p>
</form>

<script  type="text/javascript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("contac_form");
//remove the following two lines if you like error message box popups
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();

frmvalidator.addValidation("name","req","Please provide your name"); 
frmvalidator.addValidation("visitor_email","req","Please provide your email"); 
frmvalidator.addValidation("visitor_email","email","Please enter a valid email address"); 
frmvalidator.addValidation("tel","num","Only numbers are allowed for Telephone"); 

</script>
<script  type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<noscript>
this page needs javaScript
</noscript>

</div> <!--content-->
<div id="footer">
<p> <a href="../index.html">Home</a> |
	<a href="../courses.html">Courses</a> |
	<a href="../aboutus.html">about us</a> |
	<a href="contactus.php">contact us</a> |
    
    </p>
</div>
<div>
<b id="copy">&copy;Sharplingo 2010</b> <b id="design">web design: Z.D.Negatu</b>
</div>
</div><!--wrapper-->


</body>
</html>