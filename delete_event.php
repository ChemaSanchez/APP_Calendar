<?php
$mysqli = new mysqli("localhost", "root", "", "app_calendar");
$sql = 'DELETE FROM calendar where id = ?';
$query = $mysqli->prepare($sql);
$query->bind_param('s', $_GET['id']);
$query->execute();
header("Location: ./index.php");
exit();