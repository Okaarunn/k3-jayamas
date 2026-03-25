<?php
$password = 'garudabiru002';
$prepared = base64_encode(hash('sha384', $password, true));
$hash = password_hash($prepared, PASSWORD_DEFAULT);

$db = new mysqli('127.0.0.1', 'root', '', 'k3', 3306);
$db->query("UPDATE users SET password_hash = '$hash' WHERE username = 'samuel'");
echo "Password samuel diupdate dengan hash yang benar.<br>";
echo "Verify: " . (password_verify($prepared, $hash) ? 'COCOK' : 'TIDAK COCOK') . "<br>";
