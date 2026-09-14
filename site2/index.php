<?php
require __DIR__ . '/config.php';
$countdownTargetIso = date('c', strtotime($countdownTarget));
?>
<!DOCTYPE html>
<html>
<head>
<title>Countdown</title>
<link rel="icon" type="image/svg+xml" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/calendar-heart.svg"/>
<?php include __DIR__ . '/../shared/partials/head.php'; ?>
<style>
#timer {
	font-size: clamp(1.4em, 10vw, 4.5em);
	width: 20em;
	max-width: 100%;
	margin: 0 auto;
	padding-top: 75px;
}
#headerRow {
	min-height: 65px;
}
#levelsModeLink {
	position: absolute;
	top: 10px;
	right: 15px;
	padding: 6px 10px;
	color: #FFF;
	text-decoration: none;
	font-weight: bold;
	line-height: 1.2;
	text-align: right;
}
#levelsModeLink:hover {
	color: #FFF;
	text-decoration: underline;
}
#levelsOverlay {
	display: none;
	position: fixed;
	inset: 0;
	background: #c32222;
	background: linear-gradient(0deg, rgba(195, 34, 34, 1) 0%, rgba(253, 45, 243, 1) 100%);
	z-index: 9999;
	align-items: center;
	justify-content: center;
}
#levelsOverlay.visible {
	display: flex;
}
#levelsCloseLink {
	position: absolute;
	top: 20px;
	right: 25px;
	color: #FFF;
	font-size: 2em;
	text-decoration: none;
	line-height: 1;
}
#levelsOverlay h1 {
	color: #FFF;
	font-weight: bold;
	letter-spacing: 2px;
	text-align: center;
	padding: 0 20px;
}
</style>
</head>
<body>
  <div class="container-fluid" id="headerRow" style="position:relative">
    <div class="row">
      <div class="col-md-12">
        <a href="#" id="levelsModeLink" onclick="toggleLevelsMode(event);">LEVELS<br>MODE</a>
      </div>
    </div>
  </div>
  <div class="row" id="widgets" style="text-align:center;color:#000">
    <div class="col-md-12">
      <h2 style="margin:75px 0 0 0"><?php echo htmlspecialchars($countdownText); ?></h2>
      <div id="timer">
        <span id="days" class="time">00</span>:<span id="hours" class="time">00</span>:<span id="minutes" class="time">00</span>:<span id="seconds" class="time">00</span>
      </div>
    </div>
  </div>
  <div id="levelsOverlay">
    <a href="#" id="levelsCloseLink" onclick="toggleLevelsMode(event);">&times;</a>
    <h1>LEVELS - AVICII</h1>
  </div>
  <script>
  var countdownTarget = new Date("<?php echo $countdownTargetIso; ?>").getTime();

  function updateCountdown() {
    var diff = Math.max(0, countdownTarget - new Date().getTime());

    var days = Math.floor(diff / 86400000);
    var hours = Math.floor((diff % 86400000) / 3600000);
    var minutes = Math.floor((diff % 3600000) / 60000);
    var seconds = Math.floor((diff % 60000) / 1000);

    document.getElementById('days').innerHTML = ("0" + days).slice(-2);
    document.getElementById('hours').innerHTML = ("0" + hours).slice(-2);
    document.getElementById('minutes').innerHTML = ("0" + minutes).slice(-2);
    document.getElementById('seconds').innerHTML = ("0" + seconds).slice(-2);
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);

  function toggleLevelsMode(e) {
    e.preventDefault();
    document.getElementById('levelsOverlay').classList.toggle('visible');
  }
  </script>
</body>
</html>
