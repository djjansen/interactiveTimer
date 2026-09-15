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
	padding-bottom: 75px;
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
	font-size: clamp(3em, 15vw, 8em);
	letter-spacing: 2px;
	text-align: center;
	padding: 0 20px;
}
#levelsOverlay h1 span {
	display: block;
}
#levelsOverlay h1 span:last-child {
	margin-top: 0.2em;
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
      <h2 id="countdownCaption" style="margin:75px 0 0 0"></h2>
      <div id="timer">
        <span id="days" class="time">00</span>:<span id="hours" class="time">00</span>:<span id="minutes" class="time">00</span>:<span id="seconds" class="time">00</span>
      </div>
    </div>
  </div>
  <div id="levelsOverlay">
    <a href="#" id="levelsCloseLink" onclick="toggleLevelsMode(event);">&times;</a>
    <h1><span>LEVELS -</span><span>AVICII</span></h1>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
  <script>
  var countdownTarget = new Date("<?php echo $countdownTargetIso; ?>").getTime();

  var farTexts = [
    "Not yet...",
    "Check back later...",
    "Ask Caroline (or Ryan)...",
    "Do horses fly?",
    "Is water wet? (it's not)",
    "No (en español)..."
  ];
  var nearTexts = [
    "Getting closer...",
    "Get your Red Bulls ready...",
    "Any day now...",
    "Stocking the bar...",
    "Prepping the dance floor...",
    "Less than a month...",
    "OMG..."
  ];
  var currentTier = null;

  function pickRandom(arr) {
    return arr[Math.floor(Math.random() * arr.length)];
  }

  function fireConfetti() {
    if (typeof confetti !== 'function') {
      return;
    }
    confetti({ particleCount: 200, spread: 90, origin: { y: 0.6 } });
    setTimeout(function () {
      confetti({ particleCount: 150, spread: 120, origin: { y: 0.4 } });
    }, 400);
  }

  function updateCaption(diff, days) {
    var tier = diff <= 0 ? 'done' : (days > 30 ? 'far' : 'near');
    if (tier === currentTier) {
      return;
    }
    currentTier = tier;
    var caption = document.getElementById('countdownCaption');
    if (tier === 'done') {
      caption.innerHTML = "Finally!! Let's party!";
      fireConfetti();
    } else if (tier === 'far') {
      caption.innerHTML = pickRandom(farTexts);
    } else {
      caption.innerHTML = pickRandom(nearTexts);
    }
  }

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

    updateCaption(diff, days);
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
