<?php 
function conectar(){
	$mysql_host="127.0.0.1";
	$mysql_database = "crs";
	$mysql_user = "root";
	$mysql_password = "";

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
	</body> 
	</html> 
	";
	
	$mail = new PHPMailer;
 
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = '2060.js@gmail.com';                // SMTP username
	$mail->Password = 'navemostro';         		      // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
	$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
	$mail->setFrom('2060.js@gmail.com', 'Julian Sanchez');     //Set who the message is to be sent from
	$mail->addAddress($email);  // Add a recipient
	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->isHTML(true);                                  // Set email format to HTML
	 
	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = "Use this hash to log in: $hash";
	 
	 
	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}
 
	echo 'Hash sent';
	
	
	
	//echo "$hash<br />";
}
?>