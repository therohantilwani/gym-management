<?php
$fname=$_POST["fname"];
$lname=$_POST["lname"];
$email=$_POST["email"];
$contact=$_POST["contact"];
$docapp=$_POST["docapp"];
$indexf=fopen("num.txt","rw") or die("Unable to open file!");
fseek($indexf, 0, SEEK_END);
fwrite($indexf, $fname."|".$lname."|".$email."|".$contact."|".$docapp."\n");
header("Location:admin-panel.php");
?>
