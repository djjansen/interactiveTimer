<?php 
ini_set("display_errors",1);
include("/var/cred.php");

$rdout = (string)$_GET['rdout'];
$OU = (string)$_GET['ovund'];
$status = (string)$_GET['funct'];

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}

if ($status === 'Over' || $status === 'Under') {
	$sql = "INSERT INTO OverUnder (time,readout,OverUnder,vote) VALUES (now(),?,?,?)";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "sss", $rdout, $OU, $status);
} else {
	$sql = "INSERT INTO OverUnder (time,readout,OverUnder) VALUES (now(),?,?)";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $rdout, $OU);
}

$result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo $result;

mysqli_close($conn);
?>
