<?php
$password_plain = 'gmsadmin123'; 
$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

echo "Password hash: " . $hashed_password;
?>
