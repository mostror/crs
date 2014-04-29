<?php
session_start();

mysql_query("UPDATE users SET hash = nul, validhashtime = null WHERE id=".$_SESSION['id']);

session_destroy();
header("Location:index.php");

?>