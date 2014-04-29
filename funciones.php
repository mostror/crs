<?php 
function conectar(){
	$mysql_host="127.0.0.1";
	$mysql_database = "crs";
	$mysql_user = "crs";
	$mysql_password = "crs";

	//conexion
	$conexion=mysql_connect($mysql_host,$mysql_user,$mysql_password) or die("Problemas en la conexion");
	mysql_select_db($mysql_database,$conexion) or die("Problemas en la seleccion de la base de datos");
	return $conexion;
}

function sendhash($hash, $email){
	
	require './phpmailer/PHPMailerAutoload.php';
	
	$subject = "Login hash";
	$body = " 
	<html> 
	<head> 
	<title>Login hash</title> 
	</head> 
	<body>
	<p>Use this hash to log in: $hash</p>
	<p>This is only going to be valid for one try. You will have to request a new one if the authentication fails.</p>
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
	   exit;
	}
 
	echo 'Hash successfully sent. Note that it will be valid for only one try.';
	
	
	
	//echo "$hash<br />";
}
?>