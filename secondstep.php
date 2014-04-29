<?php
	session_start();
	if(!isset($_SESSION['id']))
		header("Location:index.php");
	
	if($_SESSION['second'] == 1)
		header("Location:home.php");
	
	include "funciones.php";
	conectar();
	
	$query=mysql_query($string = "SELECT `password`, `hash`, `validhashtime` FROM users WHERE username='".$_SESSION['username']."'") or die ($string);
	
	$query=mysql_fetch_assoc($query);
	
	$hash=$query['hash'];
	$hashvt=$query['validhashtime'];
	
	
	if (isset($_POST['hash'])){
		mysql_query("UPDATE users SET hash = null, validhashtime = null WHERE id=".$_SESSION['id']);
		if ($hash == $_POST['hash']){
			$_SESSION['second']=1;
			header("Location:home.php");
		}
		else
		{
			session_destroy();
			echo "Invalid hash. please click <a href=\"index.php\">here</a> to log in again.";
			die("");
		}
	}
	
	
	
?>
<form name="formLogin" method="post" action="secondstep.php">

	Please insert you hash here:
	<input type="text" name="hash" id="hash"><br />
	(Note that a fail input will result in the invalidation of the authentication, and you will have to request a new hash)
	<input type="submit" value="Login" id="buttonLogin">
</form>
<?php
	
			//echo "diferencia: ".(strtotime($hashvt) - time());
	
	if (($hash == null OR ((strtotime($hashvt) - time()) <= 0)) AND (!isset($_POST['hash']))){
		
		if ((strtotime($hashvt) - time()) > 0)
		{
			echo "The last hash has expired, you will receive a new one.<br />"; 
		}
				
		$newhash=md5($_SESSION['email'].$query['password'].$_SESSION['username'].date("Y-m-d H:i:s").rand(0,100000));
		$newvalidhashdate = date("Y-m-d H:i:s", strtotime("+2 minutes"));
		mysql_query("UPDATE users SET hash = '$newhash', validhashtime = '$newvalidhashdate' WHERE id=".$_SESSION['id']);
		
		sendhash($newhash, $_SESSION['email']);
				
	}
	
	//mail: 2060.js@gmail.com / pass: navemostro
	
?>