<?php
session_start();
session_destroy(); 
setcookie('remembered_user', '', time() - 3600, '/'); 

// Redirect to the homepage after logout
header("Location: index.php"); 
exit();
?>
