<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="https://cdn3.iconfinder.com/data/icons/ui-10/512/paper_roll-512.png"/>
<?php include __DIR__ . '/../shared/partials/head.php'; ?>
<script type="text/javascript">
paused = false;
flagTimer='start';
var lastActionTime = 0;
function ajax(funct) {
		var hrs = document.getElementById("hours").innerHTML;
        var mins = document.getElementById("minutes").innerHTML;
        var secs = document.getElementById("seconds").innerHTML;
        var read = hrs+":"+mins+":"+secs;
        var status = document.getElementById(funct).innerHTML;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
console.log(xmlhttp.responseText);
            }
	    else {
	console.log(xmlhttp.status);
	    }
        }
        xmlhttp.open("GET","xm.php?q="+status+"&rdout="+read,true);
        xmlhttp.send();
}
function OvrUnd(funct) {
if (funct == 'Clear') {
/*	document.getElementById("ovrundrhours").innerHTML = "--";
	document.getElementById("ovrundrminutes").innerHTML = "--";
	document.getElementById("ovrundrseconds").innerHTML = "--"; */
}
var ouHrs = document.getElementById("ovrundrhours").innerHTML;
var ouMins = document.getElementById("ovrundrminutes").innerHTML;
var ouSecs = document.getElementById("ovrundrseconds").innerHTML; 
var ouString = document.getElementById("numberSelect").value;

var hrs = document.getElementById("hours").innerHTML;
var mins = document.getElementById("minutes").innerHTML;
var secs = document.getElementById("seconds").innerHTML;
var read = hrs+":"+mins+":"+secs;

if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
} else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	console.log(xmlhttp.responseText);
}
else {
	console.log(xmlhttp.status);
}
}
xmlhttp.open("GET","OverUnder.php?ovund="+ouString+"&rdout="+read+"&funct="+funct,true);
xmlhttp.send();
}

function vote(selection) {
lastActionTime = Date.now();
document.getElementById("bets").classList.remove("visible");
document.getElementById("bets").classList.add("invisible");
if (selection == 'Over') {
	OverCount++;
} else if (selection == 'Under') {
	UnderCount++;
}
OvrUnd(selection);
chart.data.datasets[0].data[0]=[OverCount];
chart.data.datasets[0].data[1]=[UnderCount];
chart.update();
voteCount++;
}

function reset() {
lastActionTime = Date.now();
document.getElementById("hours").innerHTML="00";
document.getElementById("minutes").innerHTML="00";
document.getElementById("seconds").innerHTML="00";
document.getElementById('Pause').innerHTML="start";
document.getElementById('asterisk').innerHTML="";
document.getElementById('warning').innerHTML="";
document.getElementById("bets").classList.remove("visible");
document.getElementById("bets").classList.add("invisible");
document.getElementById('ouToggle').style="display:none";
document.getElementById('inputDropdown').style="";
document.getElementById('slider_left').style.backgroundColor="#13294B";
document.getElementById('slider_left').style.color="#FFF";
document.getElementById('slider_right').style.backgroundColor="#8D9092";
document.getElementById('slider_right').style.color="#8D9092";
chart.data.datasets[0].data[0]=[0];
chart.data.datasets[0].data[1]=[0];
chart.update();
ajax('Clear');
flagTimer='start';
voteCount=0;
}
function pause() {
  lastActionTime = Date.now();
  var ouString = document.getElementById("numberSelect").value;
  console.log(ouString);
  if (flagTimer=='start') {
  	if (ouString) {
  		document.getElementById('asterisk').innerHTML=""
  		document.getElementById('warning').innerHTML=""
	  	chart.data.datasets[0].data[0]=[0];
		chart.data.datasets[0].data[1]=[0];
		chart.update();
	  	var overunder_init = 240 + ((Math.floor((Math.random() * 10) + 1))*60);
		var ou_hrs_init = Math.floor(overunder_init / 3600);
		var ou_mins_init = Math.floor((overunder_init % 3600) / 60);
		var ou_secs_init = Math.floor(overunder_init % 60);	
		ou_hrs_init = ("0" + ou_hrs_init.toString()).slice(-2);
	    ou_mins_init = ("0" + ou_mins_init.toString()).slice(-2);
	    ou_secs_init = ("0" + ou_secs_init.toString()).slice(-2);
	    document.getElementById("overUnderDigit").innerHTML=ouString;
	    document.getElementById("overUnderSelected").innerHTML=" min";
		OvrUnd();
	    ajax('Pause');
	    document.getElementById('Pause').innerHTML="pause";
	    flagTimer='resume';
	    chart.update();
		document.getElementById("bets").classList.add("visible");
		document.getElementById('ouToggle').style="";
		document.getElementById('inputDropdown').style="display:none";
		document.getElementById('slider_left').style.backgroundColor="#8D9092";
		document.getElementById('slider_left').style.color="#8D9092";
		document.getElementById('slider_right').style.backgroundColor="#7BAFD4";
		document.getElementById('slider_right').style.color="#FFF";

	} else {
		document.getElementById('asterisk').innerHTML="*"
		document.getElementById('warning').innerHTML="Select an over/under"
	}
  }  else if (flagTimer=='resume') {
    ajax('Pause');
    document.getElementById('Pause').innerHTML="resume";
    document.getElementById('slider_left').style.backgroundColor="#8D9092";
	document.getElementById('slider_left').style.color="#8D9092";
	document.getElementById('slider_right').style.backgroundColor="#7BAFD4";
	document.getElementById('slider_right').style.color="#FFF";
    flagTimer='pause';
  }
  else {
    ajax('Pause');
    flagTimer='resume';
    document.getElementById('Pause').innerHTML="pause";
    document.getElementById('slider_left').style.backgroundColor="#8D9092";
	document.getElementById('slider_left').style.color="#8D9092";
	document.getElementById('slider_right').style.backgroundColor="#7BAFD4";
	document.getElementById('slider_right').style.color="#FFF";
  }
}

var OverCount = 0;
var UnderCount = 0;
var voteCount = 0;
var startTime = 0;

function fetch(ind,ele,ind2,ele2,ind3,ele3) {
var reqSentAt = Date.now();
if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
           var init_request = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
           var init_request = new ActiveXObject("Microsoft.XMLHTTP");
        }
init_request.onreadystatechange = function() {
if ((init_request.readyState == 4 && init_request.status >= 200 && init_request.status < 300) || (init_request.status === 0 && !!init_request.responseXML)) {
	if (reqSentAt < lastActionTime) {
		// this response was in flight before a more recent button click; drop it
		// so it can't overwrite the optimistic UI state, and poll again shortly
		setTimeout(fetch,200,0,"hours",1,"minutes",2,"seconds");
		return;
	}
	console.log(init_request.responseText);
    var s = init_request.responseText.split(",");
    var r = s[0].split(":");
    var t = s[2].split(":");
    var o = s[3];
    OverCount = s[4];
    UnderCount = s[5];
    var newStart = s[6];
    if (startTime == 0) {
    	startTime = newStart;
    }
    if (startTime != newStart) {
    	voteCount = 0;
    	startTime = newStart;
    }
    var totalHrs = 0;
    var totalMins = 0;
    var totalSecs = 0;
    totalSecs = parseInt(t[2])+parseInt(r[2]);
    if (totalSecs >= 60) {
       totalSecs = totalSecs-60;
       ++totalMins;
       }
    totalMins = totalMins+parseInt(t[1])+parseInt(r[1]);
    if (totalMins >= 60) {
       totalMins = totalMins-60;
       ++totalHrs;
       }
    totalHrs = totalHrs+parseInt(t[0])+parseInt(r[0]);
    totalHrs = ("0" + totalHrs.toString()).slice(-2);
    totalMins = ("0" + totalMins.toString()).slice(-2);
    totalSecs = ("0" + totalSecs.toString()).slice(-2);
if (s[1] == "pause") {
    totalHrs=t[ind];
    totalMins=t[ind2];
    totalSecs=t[ind3];
    document.getElementById('Pause').innerHTML="resume";
    flagTimer='pause';
    if (voteCount == 0) {
    	document.getElementById("bets").classList.add("visible");
		document.getElementById("bets").classList.remove("invisible");
    }
    document.getElementById('ouToggle').style="";
	document.getElementById('inputDropdown').style="display:none";
	document.getElementById('slider_left').style.backgroundColor="#8D9092";
	document.getElementById('slider_left').style.color="#8D9092";
	document.getElementById('slider_right').style.backgroundColor="#7BAFD4";
	document.getElementById('slider_right').style.color="#FFF";

} else if (s[1] == "clear") {
	voteCount=0;
    totalHrs=t[ind];
    totalMins=t[ind2];
    totalSecs=t[ind3];
    document.getElementById('Pause').innerHTML="start";
    flagTimer='start';
    document.getElementById("bets").classList.remove("visible");
	document.getElementById("bets").classList.add("invisible");
    document.getElementById('ouToggle').style="display:none";
	document.getElementById('inputDropdown').style="";
	document.getElementById('slider_left').style.backgroundColor="#13294B";
	document.getElementById('slider_left').style.color="#FFF";
	document.getElementById('slider_right').style.backgroundColor="#8D9092";
	document.getElementById('slider_right').style.color="#8D9092";
	chart.data.datasets[0].data[0]=[0];
	chart.data.datasets[0].data[1]=[0];
	chart.update();
} else {
    document.getElementById('Pause').innerHTML="pause";
	document.getElementById('asterisk').innerHTML="";
	document.getElementById('warning').innerHTML="";
    flagTimer='resume';
    if (voteCount == 0) {
		document.getElementById("bets").classList.add("visible");
		document.getElementById("bets").classList.remove("invisible");
    }
    document.getElementById('ouToggle').style="";
	document.getElementById('inputDropdown').style="display:none";   
	document.getElementById('slider_left').style.backgroundColor="#8D9092";
	document.getElementById('slider_left').style.color="#8D9092";
	document.getElementById('slider_right').style.backgroundColor="#7BAFD4";
	document.getElementById('slider_right').style.color="#FFF"; 

}
document.getElementById(ele).innerHTML=totalHrs;
document.getElementById(ele2).innerHTML=totalMins;
document.getElementById(ele3).innerHTML=totalSecs;

var ou_hours = totalHrs;
var ou_minutes = totalMins;
var ou_seconds = totalSecs;
var rawTime = parseInt(ou_seconds) + (parseInt(ou_minutes) * 60) + (parseInt(ou_hours * 3600));
if ((rawTime % 60 == 0) && (rawTime > 60) && (document.getElementById('Pause').innerHTML=="pause")) {
	var overunder = 240 + rawTime + ((Math.floor((Math.random() * 10) + 1))*60);
	ou_hrs = Math.floor(overunder / 3600);
	ou_mins = Math.floor((overunder % 3600) / 60);
	ou_secs = Math.floor(overunder % 60);
	
	ou_hrs = ("0" + ou_hrs.toString()).slice(-2);
    ou_mins = ("0" + ou_mins.toString()).slice(-2);
    ou_secs = ("0" + ou_secs.toString()).slice(-2);
} else {
	ou_hrs = o[0];
	ou_mins = o[1];
	ou_secs = o[2];
	ou_raw = o
}

if (voteCount == 0) {
	document.getElementById("overUnderDigit").innerHTML=ou_raw;
	document.getElementById("overUnderSelected").innerHTML=" min";
}
/*
document.getElementById("ovrundrhours").innerHTML = ou_hrs;
document.getElementById("ovrundrminutes").innerHTML = ou_mins;
document.getElementById("ovrundrseconds").innerHTML = ou_secs; */

if ((rawTime % 60 == 0) && (rawTime > 60) && (document.getElementById('Pause').innerHTML=="pause")) {
	    OvrUnd('Minute');
}

if (s[1] != "clear") {
chart.data.datasets[0].data[0]=[OverCount];
chart.data.datasets[0].data[1]=[UnderCount];
chart.update();
}
var milliseconds = new Date().getMilliseconds();
var newTimeout = 1000 - milliseconds;
setTimeout(fetch,newTimeout,0,"hours",1,"minutes",2,"seconds")
}
}
init_request.open("GET","req.php", true);
init_request.send();
}
</script>
<style>
#timer {
	font-size: clamp(1.8em, 13vw, 4.5em);
	width: 16em;
	max-width: 100%;
	margin: 0 auto;
	padding-top: 15px;
}
#overunder_row {
	margin-right:10px;
	margin-left:10px;
}
#slider {
	height:80%;
	margin-left:2%;
	margin-right:20%;
}
#slider_left {
	border-radius: 15px 0px 0px 15px;
	margin-top:10px;
	margin-bottom:10px;
	float:left;
	width:50%;
	background-color:#13294B;
	color:#FFF;
	vertical-align:center;
}
#slider_right {
	border-radius: 0px 15px 15px 0px;
	margin-top:10px;
	margin-bottom:10px;
	float:left;
	width:50%;
	background-color:#8D9092;
	color:#8D9092;
	vertical-align:center;
}
.btn {
	height:50px;
	width:150px;
	margin-right:5px;
}
#underButton:hover {
  color:#FFF;
  background-color:#13294B !important;
}

#underButton:focus {
  color:#FFF;
  background-color:#13294B !important;
}

#underButton:active {
  color:#FFF;
  background-color:#13294B !important;
}
#overButton:hover {
  color:#FFF;
  background-color:#7BAFD4 !important;
}

#overButton:focus {
  color:#FFF;
  background-color:#7BAFD4 !important;
}

#overButton:active {
  color:#FFF;
  background-color:#7BAFD4 !important;
}
.visible {
  visibility: visible;
}
.invisible {
  visibility: hidden;
}
.OverUnder {
	width:60px;
    height:60px;
}
</style>
</head>
<body>
  <div class="container-fluid"  id="headerRow">
  	<div class="row">
  	<div class="col-md-12">
  		<div id ="slider">
  			<div id ="slider_left">
  				<h3>
  					Vacant
  				</h3>
  			</div>
  			<div id="slider_right">
  				<h3>
  					Occupied
  				</h3>
  			</div>
  		</div>
  </div>
</div>
</div>
<div class ="row" id="widgets" style="alignment:center;text-align:center;color:#000">
	<div class="col-md-12" id="timer">
		<span id="hours" class="time">00</span>:<span id="minutes" class="time">00</span>:<span id="seconds" class="time">00</span>
	</div>
</div>
<div class="container" style="text-align:center;margin:auto">
	<div class="row" id ="overunder_row" style="color:#000">
		<div class="col-6" id="ovrundr">
				<h3>Over/Under<span id="asterisk" style="color:red"></span></h3>
			   <div class="input-group" id="inputDropdown" style="">
			   <form class="form-inline" style="text-align:center;margin:auto">
			  <select class="custom-select" id="numberSelect" style="width:65px;border-radius: 5px 0px 0px 5px">
			    <option selected></option>
			    <?php for ($i = 1; $i <= 60; $i++) : ?>
      		    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    			<?php endfor; ?>
			  </select>
			<div class="input-group-append">
	        <span class="input-group-text" id="basic-addon2" style="border-radius: 0px 5px 5px 0px">min</span>
	        </div></form></div>
	        <span id="warning" style="color:red"></span>
	            <div id="ouToggle" style="display:none">
        	   	<h5><span id="overUnderDigit"></span><span id="overUnderSelected"></span></h5>
        	   </div>
			  <span id="ovrundrhours" class="time"></span>
			   <span id="ovrundrminutes" class="time"></span>
			   <span id="ovrundrseconds" class="time"></span>
			   <br> 
        </div>
		<div class="col-6" id="bets" style="padding:5px"> 
		   <button id="underButton" class="btn btn-dark btn-lg OverUnder align-items-center" onClick="vote('Under');" style="background-color:#13294B"><div style="margin-top:-5px"><h1>-</h1></div></button>  
		   <button id="overButton" class="btn btn-dark btn-lg OverUnder align-items-center" onClick="vote('Over');" style="background-color:#7BAFD4;border-color:#7BAFD4"><div style="margin-top:-4px"><h1>+</h1></div></button> 
		</div>
	</div>
</div>
<div class = "container" id="charts" style="text-align:center;margin:auto">
	<div class="row my-2">
        <div class="col-md-12">
            <div class="card" style="border:none;background-color:#FFF">
                <div class="card-body">
                    <canvas id="myChart" height="200"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="footer">
		<button type="button" id="Pause" class="btn btn-dark btn-lg" onClick="pause();">start</button>
		<button type="button" id="Clear" class="btn btn-dark btn-lg" onClick="reset();">clear</button>
</div>
</body>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'horizontalBar',

    // The data for our dataset
    data: {
        labels: ["Over","Under"],
        datasets: [{
            label: "Over/Under",
            backgroundColor: ['#7BAFD4','#13294B'],
            borderColor: 'rgb(66, 134, 244)',
            data: [0]
        }]
    },

    // Configuration options go here
    options: {
       scales: {
	        xAxes: [{
	            ticks: {
	                beginAtZero: true,
	                suggestedMax: 10,
	                stepSize: 2,
	                fontColor:'#000',
	                fontSize:20
	            },
	            gridLines: {
	        		display:false,
	        		color: '#000'
	            }
	        }],
	        yAxes: [{
	        	ticks: {
	                fontColor:'#000',
	                fontSize:20
	            },
	        	gridLines: {
	        		display:false,
	        		color:'#000',
	        		fontColor: '#000'
	            }
	        }]
    	},
    	legend: {
    		labels: {
    			fontColor:"#000"
    		},
    		display:false
    	}
    }
});
</script>
<script>
fetch(0,"hours",1,"minutes",2,"seconds");
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
 
