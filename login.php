<?php

/**
 * @author Manuel Zarat
 */

include "load.php";

require ("config.php"); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Login</title>
  <link href="../content/themes/simplepress/css/menu.css" rel="stylesheet" type="text/css" />
  <link href="../content/themes/simplepress/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="sp-main-wrapper">

<!-- HTML Header -->
    <div class="sp-main-header"> 

        <div class="sp-main-header-logo">

            <h1>SimplePress</h1>
            <h4>Einfaches, kostenloses Blog CMS</h4>
    
        </div>
    
    </div>
<!-- HTML Header Ende -->

<?php
$nav = new menu();
$nav->config(array("id" => 1));
$nav->html();
?>


<div class="sp-main-body">
<div class='sp-content'>

<!-- Hier kommt der Login -->

<?php if(!isset($_POST['formlogin'])) { ?>

<form action="login.php" method="post" name="frm">
<center>
<table cellspacing="4" cellpadding="4" style="">
	<tr>
		<td>Email</td>
		<td><input type="text" name="formlogin" class="cssborder" autofocus></td>

		<td>Passwort</td>
		<td><input type="password" name="formpass" class="cssborder"></td>
    <td><input type="submit" value="login" class="cssborder"></td>
	</tr>
</table>
</center> 	 
</form>

<?php } else { 

    $formlogin = $_POST['formlogin'];
    $formpass = md5($_POST['formpass']);      

    $system = new system();    

    if( $user = $system->auth($formlogin,$formpass) ) {
    
    $token = md5( $user . time() );
    $cfg = array( "table" => "user", "set" => "token='$token' where id=" . $user );
    $system->update( $cfg );    
        /**
         * Cookie clientseitig setzen wg Zeitzonen Offset
         */
        echo "
        <script>
        function setCookie(name, value, hours) {
            var d = new Date();
            d.setTime(d.getTime() + (hours*60*60*1000));
            var expires = \"expires=\" + d.toUTCString();
            document.cookie = name + \"=\" + value + \";\" + expires + \";path=/\";
        }
        setCookie('sp-uid','$token',1); 
        </script>";
        
        echo "Du wurdest erfolgreich angemeldet.";
        
    } else {
    
        echo "Anmeldeversuch gescheitert.";
        
    }

}

?>

</div>

<div class='sp-sidebar'>

    <div class="sp-sidebar-item-box">
        <div class="sp-sidebar-item-box-head">Hinweis</div>
        <div class="sp-sidebar-item-box-body">Achte immer darauf, das dir keiner beim anmelden zusieht!</div>
    </div>

</div>

<div style='clear:both;'></div><!-- Der Footer -->

<div class="sp-footer" style="padding:10px;"></div>

</div>

</div> 

</body>
</html>
