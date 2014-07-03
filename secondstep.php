<?php
	session_start();
	if(!isset($_SESSION['id']))
		header("Location:index.php");

	if($_SESSION['second'] == 1)
		header("Location:home.php");

	include "funciones.php";
	conectar();

	$query=mysql_query($string = "SELECT `password`, `second_password`, `remaining_passwords` FROM users WHERE username='".$_SESSION['username']."'") or die ($string);

	$query=mysql_fetch_assoc($query);

	$second_password=$query['second_password'];
	$remaining_passwords=$query['remaining_passwords'];
	$input_second_password=explode(" ", $_POST['second_password']);
	$input_second_password=implode("", $input_second_password); //remove spaces that might have been added
	$max_passwords= 30;

	if ($remaining_passwords == 0){
		$passwords=create_passwords();
		if (sendpasswords($passwords, $_SESSION['email']))
		{
			echo "The passwords run out. Check your email for a new list.<br />";
			mysql_query($string="UPDATE users SET second_password = \"".$passwords[0]."\", remaining_passwords=".$max_passwords." WHERE id=".$_SESSION['id'])or die($string);
			$remaining_passwords=$max_passwords;
		}
		else
			die("An error ocurred!");
	}

	if (isset($_POST['second_password'])){
		for ($i=$remaining_passwords; $i < $max_passwords ; $i++) {
			$input_second_password = md5($input_second_password);
			$input_second_password = substr($input_second_password, -12);
		}

		if ($input_second_password == $second_password){
			$_SESSION['second']=1;
			mysql_query($string="UPDATE users SET remaining_passwords=remaining_passwords-1 WHERE id=".$_SESSION['id'])or die($string);
			header("Location:home.php");
		}
		else{
			echo "The second password didn't match, please try again.<br/>";
		}
	}



?>

<form name="formLogin" method="post" action="secondstep.php">

	Please insert the password number <?php echo $max_passwords - $remaining_passwords + 1 ?> here (spacing is optional):
	<input type="text" name="second_password"><br />
	<input type="submit" value="Login">
</form>
<br /> <br /> Click <a href="logout.php">here</a> to log out.
