<?php
session_start();
include "funciones.php";
conectar();


if(isset($_POST['action']))
{
	if ($_POST['action'] == "signup"){

		$email=mysql_real_escape_string($_POST['email']);
		$username=mysql_real_escape_string($_POST['username']);
		$password=mysql_real_escape_string($_POST['password']);

		
		
		if ($password!=$_POST['password2']) die ("Passwords do not match. <a href=\"index.php\">Return</a>");
		if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) //expresion regular para comprobar email valido
		{
			die("Invalid mail. <a href=\"index.php\">Return</a>");
		}
		$ePattern = "/^[[:space:]]*$/";
		if(preg_match($ePattern,$username) OR preg_match($ePattern,$password)) die ("Invalid username or password. <a href=\"index.php\">Return</a>");
		
		$query=mysql_query($string = "SELECT * FROM users WHERE email='$email' OR username='$username'") or die ($string);
		
		if (mysql_num_rows($query) > 0)
		{
			while($result=mysql_fetch_assoc($query))
				if ($result['email'] == $email AND $result['username'] == $username OR mysql_num_rows($query) > 1) die("Email and username in use. <a href=\"index.php\">Return</a>");
				if ($result['email'] == $email) die("Email in use. <a href=\"index.php\">Return</a>");
				if ($result['username'] == $username) die("Username in use. <a href=\"index.php\">Return</a>");	
		}
		
		mysql_query("INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$username', '$email',PASSWORD('$password'))");
		
		$_SESSION['id']=mysql_insert_id();
		$_SESSION['username']=$username;
		$_SESSION['email']=$email;
		$_SESSION['second']=0;
		
		
		die("Successfull account signup. Click <a href=\"secondstep.php\">here</a> to begin the second step authentication.");
	}
	
	
}

	if ($_POST['action'] == "login"){
		$username=mysql_real_escape_string($_POST['username']);
		$password=mysql_real_escape_string($_POST['password']);
		
		$query=mysql_query("SELECT id, username, email FROM users WHERE username='$username' AND password=PASSWORD('$password')");
		
		if(mysql_num_rows($query)==1)
		{
			$query=mysql_fetch_assoc($query);
			
			$_SESSION['id']=$query['id'];
			$_SESSION['username']=$query['username'];
			$_SESSION['email']=$query['email'];
			$_SESSION['second']=0;
			header("Location:secondstep.php");
		}
		if (mysql_num_rows($query)==0)
		{
			die ("Wrong username or password. <a href=\"index.php\">Return</a>");
		}
	}
?>
