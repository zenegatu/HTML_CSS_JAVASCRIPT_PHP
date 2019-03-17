<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/contact-form-attachment.html
*/
require_once("include/fgcontactform.php");
require_once("include/captcha-creator.php");

$formproc = new FGContactForm();
$captcha = new FGCaptchaCreator('scaptcha');

$formproc->EnableCaptcha($captcha);

//1. Add your email address here.
//You can add more than one receipients.
$formproc->AddRecipient('jobs@sharplingo.com'); //<<---Put your email address here


//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('RRCFqcj0B0dgbns');


$formproc->AddFileUploadField('cv','doc,docx,pdf,txt,rtf',2024);

if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
        $formproc->RedirectToURL("thank-you.html");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Sharplingo  - jobs</title>
     <style type="text/css" media="screen">
/* <![CDATA[ */
@import url(../style.css);
/* ]]> */
</style>
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      <script type='text/javascript' src='scripts/fg_captcha_validator.js'></script>
</head>
<body id="jobs">
<div id="wrapper">
 <div id="masthead">
 <img src="../images/masthead.png"/>
 </div id="masthead"> <!--masthead-->
 <div id="menuBar">
  <ul id="navlist">
	<li><a href="../index.html" id="homenav">Home</a></li>
	<li><a href="../courses.html" id ="coursesnav">Courses</a></li>
	<li><a href="../aboutus.html" id ="aboutusnav">About us</a></li>
	<li><a href="contactus.php" id ="contactusnav">Contact Us</a></li>
    <li><a href="jobs.php" id ="jobsnav">Jobs</a></li>
</ul>
 </div> <!--menuBar-->
 <div id="content">
 <div id="contactustxt">
<p >We are always on the lookout for good teachers.  If you can teach any language, send us your CV and we may have just the right job for you.</p>
</div>
<div id="errmessbox">

<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
<span id='jobs_name_errorloc' class='error'></span>
 <span id='jobs_email_errorloc' class='error'></span>
  <span id='jobs_nativeLang_errorloc' class='error'></span>
  <span id='jobs_cv_errorloc' class='error'></span>
   <span id='jobs_scaptcha_errorloc' class='error'></span>
</ul>
</div>
<!-- Form Code Start -->
<form id='jobs' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' enctype="multipart/form-data">

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<input type='text'  id='invis' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />
<p>
 <div id="contact" >
  <h2>Sharplingo</h2
     ><p><b>Tel: O795 507 9386</b></p>
     <p><b>Skype: Sharplingo</b></p>
      <p><b>London, UK</b></p>
    </div> <!--boxout-->
    <label for='name' > Name<abbr>*</abbr>: </label><br/>
    <input type='text' name='name' id='name' value='<?php echo htmlentities($_POST['name']) ?>' maxlength="50" /><br/>
</p>
<p>
    <label for='email' >Email <abbr>*</abbr>:</label><br/>
    <input type='text' name='email' id='email' value='<?php echo htmlentities($_POST['email']) ?>' maxlength="50" /><br/>
</p>

<p>
    <label for='nativeLang' >Your native language<abbr>*</abbr>:</label><br/>
    <input type='text' name='nativeLang' id='nativeLang' value='<?php echo htmlentities($_POST['nativeLang']) ?>' maxlength="50" /><br/>
</p>
<div id="message">
<p>
    <label for='message' >Message:</label><br/>
    <span id='contactus_message_errorloc' class='error'></span>
    <textarea rows="8" cols="45" name='message' id='message'><?php echo htmlentities($_POST['message']) ?></textarea>
</p>
 </div>

<p>
    <label for='cv' >Upload your CV:</label><br/>
    <input type="file" name='cv' id='cv' /><br/>
</p>
<p>
    <div><img alt='Captcha image' src='show-captcha.php?rand=1' id='scaptcha_img' /></div>
    <label for='scaptcha' >Enter the code above here:</label><br/>
    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>
   
    <small>Can't read the image?<a href='javascript: refresh_captcha_img();'>Click here to refresh</a>.</small>
</p>


<p>
    <input type='submit' name='Submit' value='Submit' />
</p>

<p id="reqFld"><abbr>*</abbr> required fields</p>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("jobs");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");
	
     frmvalidator.addValidation("nativeLang","req","Please provide your native language");
	 
    frmvalidator.addValidation("message","maxlen=2048000","The message is too long!(more than 2MB!)");

    frmvalidator.addValidation("cv","file_extn=pdf;doc;docx;rtf;txt","Upload text files only. Supported file types are: pdf,doc,docx,rtf,txt");

    frmvalidator.addValidation("scaptcha","req","Please enter the code in the image ");

    document.forms['jobs'].scaptcha.validator
      = new FG_CaptchaValidator(document.forms['jobs'].scaptcha,
                    document.images['scaptcha_img']);

    function SCaptcha_Validate()
    {
        return document.forms['jobs'].scaptcha.validator.validate();
    }

    frmvalidator.setAddnlValidationFunction("SCaptcha_Validate");

    function refresh_captcha_img()
    {
        var img = document.images['scaptcha_img'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?")) + "?rand="+Math.random()*1000;
    }

// ]]>
</script>
<noscript>
</noscript>

</div> <!--content-->
<div id="footer">
<p> <a href="../index.html">Home</a> |
	<a href="../courses.html">Courses</a> |
	<a href="../aboutus.html">About us</a> |
	<a href="contactus.php">Contact us</a> |
    <a href="jobs.php">Jobs</a>
    
    </p>
</div>
<div>
<b id="copy">&copy;Sharplingo 2010</b> <b id="design">web design: Z.D.Negatu</b>
</div>
</div><!--wrapper-->


</body>
</html>