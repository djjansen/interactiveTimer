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
</head>
<body>
  <div class="container-fluid" id="headerRow">
    <div class="row">
      <div class="col-md-12">
        <h2 style="color:#FFF;padding:20px 0;margin:0"><?php echo htmlspecialchars($countdownText); ?></h2>
      </div>
    </div>
  </div>
  <div class="row" id="widgets" style="text-align:center;color:#000">
    <div class="col-md-12" id="timer" style="font-size: 4.5em; width: 20em; margin:auto">
      <span id="days" class="time">00</span>:<span id="hours" class="time">00</span>:<span id="minutes" class="time">00</span>:<span id="seconds" class="time">00</span>
    </div>
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
  </script>
</body>
</html>
