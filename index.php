<?php
session_start();
if(isset($_SESSION['id']))
header("Location:home.php");
?>

Login:
<form name="formLogin" method="post" action="login.php">
<table>
	<tr>
		<td>
		<p>Username</p>
		</td>
		<td><input type="text" name="username" id="username"></td>
	</tr>
	<tr>
		<td>
		<p>Password</p>
		</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<input type="hidden" name="action" value="login">
		<td><input type="submit" value="Login"></td>
	</tr>
	
</table>
</form>

<br /><br />

Register:
<form name="formRegister" method="post" action="login.php">
<table>
	<tr>
		<td>
		<p>Username:</p>
		</td>
		<td colspan="3"><input type="text" name="username" id="firstName"></td>
	</tr>
	<tr>
		<td>
		<p>Email:</p>
		</td>
		<td colspan="3"><input type="text" name="email"></td>
	</tr>
	<tr>
		<td>
		<p>New Password:</p>
		</td>
		<td colspan="3"><input type="password" name="password"></td>
	</tr>
	<tr>
		<td>
		<p>Retype password:</p>
		</td>
		<td colspan="3"><input type="password" name="password2"></td>
	</tr>
	<tr>
		<td></td>
		<input type="hidden" name="action" value="signup">
		<td colspan="3"><input type="submit" value="Sign Up"></td>
	</tr>
</table>
</form>
