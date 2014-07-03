<?php 
function conectar(){
	$mysql_host="127.0.0.1";
	$mysql_database = "crs2";
	$mysql_user = "crs";
	$mysql_password = "crs";

	//conexion
	$conexion=mysql_connect($mysql_host,$mysql_user,$mysql_password) or die("Problemas en la conexion");
	mysql_select_db($mysql_database,$conexion) or die("Problemas en la seleccion de la base de datos");
	return $conexion;
}

function sendpasswords($passwords, $email){
	
	require './phpmailer/PHPMailerAutoload.php';
	
	$subject = "Login hash";
	$body = " 
	<html> 
	<head> 
	<title>Login hash</title> 
	</head> 
	<body>
	<p>Keep this list of hashes to log in:</p>";

	foreach ($passwords as $key => $pass) {
		$pass=substr($pass, 0, 4) . " " . substr($pass, 4, 4) . " " . substr($pass, 8, 4);
		$body.=($key+1).") $pass<br />";
		if(($key+1) % 5 == 0)
			$body.="<br />";
		
	}

	$body.="<p>Each will be used only once. You will be requested the number of the password each time you log in.</p>
	</body> 
	</html> 
	";
	

	$mail = new PHPMailer;
 
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = '2060.js@gmail.com';		//This mail was created solely for this purpose.
	$mail->Password = 'navemostro';				//That's why it's password is displayed so publicly
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->setFrom('2060.js@gmail.com', 'Julian Sanchez');
	$mail->addAddress($email);
	$mail->WordWrap = 50;
	$mail->isHTML(true);
	 
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = "Use this hash to log in: $hash";
	 
	 
	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   return false;
	}
 
	return true;
	
}

function create_passwords(){

	$seed = crypt("seed");
	$exp = explode("$", $seed);
	$seed = $exp[3];

	$provided_passwords= 30;
	$passwords = array();
	for($i=0; $i < $provided_passwords; $i++){
		$seed = md5($seed);
		$seed = substr($seed, -12);
		array_push($passwords, $seed);
	}

	$passwords = array_reverse($passwords);
	return $passwords;
}
?>