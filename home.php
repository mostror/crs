<?php
session_start();
if(!isset($_SESSION['id']) )
	header("Location:index.php");
if($_SESSION['second'] == 0)
	header("Location:secondstep.php");


echo "Logged in successfully as ".$_SESSION['username']."<br />";
echo "Here is the source code: <a href=\"https://github.com/mostror/crs\">https://github.com/mostror/crs</a>";
echo "<br /> <br /> Click <a href=\"logout.php\">here</a> to log out."

?>