<?php
ini_set('display_errors', 1); 
require __DIR__ . '/../shared/db.php';

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}
$sql = "SELECT * FROM timer ORDER BY id DESC LIMIT 1;";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sql2 = "SELECT TIMEDIFF(NOW(),(SELECT MAX(time) from timer)) AS DIFF;";
$res2 = mysqli_query($conn,$sql2);
$row2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);

$sql3 = "SELECT * FROM OverUnder ORDER BY id DESC LIMIT 1;";
$res3 = mysqli_query($conn,$sql3);
$row3 = mysqli_fetch_array($res3, MYSQLI_ASSOC);

$sql4 = "SELECT MAX(time) FROM timer WHERE status='start';";
$res4 = mysqli_query($conn,$sql4);
$row4 = mysqli_fetch_array($res4, MYSQLI_ASSOC);

$time = $row4["MAX(time)"];

$sql5 = "SELECT * FROM OverUnder Where time > '$time' AND vote='Over';";
$res5 = mysqli_query($conn,$sql5);
$overs = mysqli_num_rows($res5);

$sql6 = "SELECT * FROM OverUnder Where time > '$time' AND vote='Under';";
$res6 = mysqli_query($conn,$sql6);
$unders = mysqli_num_rows($res6);

$package = array($row2["DIFF"],$row["status"],$row["readout"],$row3["OverUnder"],$overs,$unders,$time);
echo $package[0] . "," . $package[1] . "," . $package[2] . "," . $package[3] . "," . $package[4] . "," . $package[5] . "," . $package[6];
mysqli_close($conn);
?>
