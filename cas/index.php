<?php require_once('../Connections/con.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>ADMIN</title>
<link rel="Shortcut Icon" href="images/train.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="index.css" />
<script language="JavaScript" src="md5.js"
type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
function doKirim() {
document.form1.enc_pass.value=MD5(document.form1.pasword.value);
document.form1.password.value="MAAF_PASSWORD_DISENSOR";
}
</script>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
</head>
<body>
<div id="container">
	<div id="header"></div>
  <div id="leftCol"><img src="images/left.jpg" alt="LeftImage"/></div>

<div id="mainCol">
		<div id="mainHeader">
		  <p align="center">ADMIN LOGIN</p>
	  </div>
		<div id="mainMiddle">
			<form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
			  <table width="41%" border="1" align="center" cellpadding="3" cellspacing="0" onclick="MM_validateForm('username','','R','password','','R');return document.MM_returnValue">
                <tr>
                  <td width="26%"><strong>Username</strong></td>
<td width="74%"><label>
                    <input type="text" name="username" id="username" />
                  </label></td>
                </tr>
                <tr>
                  <td><strong>Password</strong></td>
<td><label>
                    <input type="password" name="password" id="password" />
                  </label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><label>
                    <input type="submit" name="login" id="login" value="LOGIN" />
                  </label>
                    <label>
                  <input type="reset" name="reset" id="reset" value="RESET" />
                  </label></td>
                </tr>
              </table>
          </form>
		  <p>&nbsp;</p>
	  </div>
<div id="mainEnd">
			<div id="footer">
			  <p>Copyright &copy; <a href="../index.php">Tiket Online</a>.2015 | Modife BY <a>CAS</a>.</p>
	  </div>
		</div>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsadmin);
?>
