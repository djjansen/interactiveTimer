<?php 
ini_set("display_errors",1);
require __DIR__ . '/../shared/db.php';

$q = (string)$_GET['q'];
$rdout = (string)$_GET['rdout'];

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}

$sql = "INSERT INTO timer (time,status,readout) VALUES (now(),?,?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $q, $rdout);
$result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo $result;

mysqli_close($conn);
?>
