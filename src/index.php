<?php
$host = 'db';
$user = 'appuser';
$pass = 'apppass';
$dbname = 'nutrition_app';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
} else {
    echo "✅ PHPからMySQLに接続成功！";
}
?>