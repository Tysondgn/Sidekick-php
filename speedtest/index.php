<html>

<head>
	<meta charset="UTF-8">
	<title>Internet Speed Test</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="icon" type="image/png" href="assets/logo-w.png" />
	<!-- <link rel="stylesheet" href="css/style.css"> -->
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analytics_tracking; ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());
		gtag('config', '<?php echo $analytics_tracking; ?>');
	</script>

	<script>function I(id) { return document.getElementById(id); }

		var meterBk = "#1b1e4b";
		var dlColor = "#FF4848",
			ulColor = "#FF4848",
			pingColor = "#FF4848",
			jitColor = "#FF4848";
		var progColor = "#55be00";

		function drawMeter(c, amount, bk, fg, progress, prog) {
			var ctx = c.getContext("2d");
			var dp = window.devicePixelRatio || 1;
			var cw = c.clientWidth * dp, ch = c.clientHeight * dp;
			var sizScale = ch * 0.0055;
			var threadCount = 10;

			if (c.width == cw && c.height == ch) {
				ctx.clearRect(0, 0, cw, ch);
			} else {
				c.width = cw;
				c.height = ch;
			}

			// Draw the background arc
			ctx.beginPath();
			ctx.strokeStyle = bk;
			ctx.lineWidth = 8 * sizScale;  // Thinner line for modern look
			ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, Math.PI * 0.1);
			ctx.stroke();

			// // Draw the foreground arc with gradient
			// var gradient = ctx.createLinearGradient(0, 0, c.width, 0);
			// // gradient.addColorStop(0, "#ff6e6e");
			// gradient.addColorStop(0, "#ff6e6e");
			// gradient.addColorStop(1, fg);
			// ctx.beginPath();
			// ctx.strokeStyle = gradient;
			// ctx.lineWidth = 12 * sizScale;  // Slightly thicker line for the foreground
			// ctx.shadowBlur = 8 * sizScale;
			// ctx.shadowColor = "rgba(0,0,0,0.5)";
			// ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, amount * Math.PI * 1.2 - Math.PI * 1.1);
			// ctx.stroke();

			// Draw the thread animation
			for (var i = 0; i < threadCount; i++) {
				var threadAmount = amount - (i / threadCount) * (amount / 2);
				ctx.beginPath();
				ctx.strokeStyle = "rgba(255, 110, 110, " + (1 - i / threadCount) + ")";
				ctx.lineWidth = (6 - i) * sizScale;
				ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, threadAmount * Math.PI * 1.2 - Math.PI * 1.1);
				ctx.stroke();
			}

			// Draw progress bar if needed
			if (typeof progress !== "undefined") {
				ctx.fillStyle = prog;
				ctx.shadowBlur = 4 * sizScale;
				ctx.fillRect(c.width * 0.3, c.height - 16 * sizScale, c.width * 0.4 * progress, 4 * sizScale);
			}

			// Reset shadow for other elements
			ctx.shadowBlur = 0;
		}

		// Example usage: drawMeter(I("dlMeter"), 0.5, meterBk, dlColor, 0.75, progColor);

		function mbpsToAmount(s) {
			return 1 - (1 / (Math.pow(1.3, Math.sqrt(s))));
		}

		function msToAmount(s) {
			return 1 - (1 / (Math.pow(1.08, Math.sqrt(s))));
		}

		var w = null;
		var data = null;

		function startStop() {
			if (w != null) {
				w.postMessage('abort');
				w = null;
				data = null;
				I("startStopBtn").className = "";
				initUI();
			} else {
				w = new Worker('netspeed/speedtest_worker.min.js');
				w.postMessage('start');
				I("startStopBtn").className = "running";
				w.onmessage = function (e) {
					data = JSON.parse(e.data);
					var status = data.testState;
					if (status >= 4) {
						I("startStopBtn").className = "";
						w = null;
						updateUI(true);
					}
				};
			}
		}

		function updateUI(forced) {
			if (!forced && (!data || !w)) return;
			var status = data.testState;
			I("ip").textContent = data.clientIp;
			I("dlText").textContent = (status == 1 && data.dlStatus == 0) ? "..." : data.dlStatus;
			drawMeter(I("dlMeter"), mbpsToAmount(Number(data.dlStatus * (status == 1 ? oscillate() : 1))), meterBk, dlColor, Number(data.dlProgress), progColor);
			I("ulText").textContent = (status == 3 && data.ulStatus == 0) ? "..." : data.ulStatus;
			drawMeter(I("ulMeter"), mbpsToAmount(Number(data.ulStatus * (status == 3 ? oscillate() : 1))), meterBk, ulColor, Number(data.ulProgress), progColor);
			I("pingText").textContent = data.pingStatus;
			drawMeter(I("pingMeter"), msToAmount(Number(data.pingStatus * (status == 2 ? oscillate() : 1))), meterBk, pingColor, Number(data.pingProgress), progColor);
			I("jitText").textContent = data.jitterStatus;
			drawMeter(I("jitMeter"), msToAmount(Number(data.jitterStatus * (status == 2 ? oscillate() : 1))), meterBk, jitColor, Number(data.pingProgress), progColor);
		}

		function oscillate() {
			return 1 + 0.02 * Math.sin(Date.now() / 100);
		}

		setInterval(function () {
			if (w) w.postMessage('status');
		}, 200);

		window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || (function (callback, element) { setTimeout(callback, 1000 / 60); });

		function frame() {
			requestAnimationFrame(frame);
			updateUI();
		}
		frame();

		function initUI() {
			drawMeter(I("dlMeter"), 0, meterBk, dlColor, 0);
			drawMeter(I("ulMeter"), 0, meterBk, ulColor, 0);
			drawMeter(I("pingMeter"), 0, meterBk, pingColor, 0);
			drawMeter(I("jitMeter"), 0, meterBk, jitColor, 0);
			I("dlText").textContent = "";
			I("ulText").textContent = "";
			I("pingText").textContent = "";
			I("jitText").textContent = "";
			I("ip").textContent = "";
		}
	</script>

	<style>
		
@import url('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i');

* {
	margin: 0;
	padding: 0;
  box-sizing: border-box;
}

body {
	font-family: 'Lato', sans-serif;
	font-size: 14px;
	color: #999999;
	word-wrap:break-word;
	background: #0b0d2c;
}

.topnav {
  overflow: hidden;
  background-color: #fff;
  	max-width: 80%;
	margin: 1em auto;
}

.topnav a {
  float: left;
  display: block;
  color: #333;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #231f20;
  color: #fff;
}

.topnav .selected {
  background-color: #f2f2f2;
  color: #0085c9;
  box-shadow: 0px -2px 0px #0085c9 inset;
  box-shadow: 0px 2px 0px #0085c9 inset;
}

.topnav .home {
  background-color: #0085c9;
  color: #fff;
  font-size: 1.5em;
}

.topnav .home:hover {
  background-color: #0085c9;
  color: #fff;
}

.topnav .icon {
  display: none;
  font-size: 1.5em;
}

@media (min-width: 181px) and (max-width: 868px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media (min-width: 181px) and (max-width: 868px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
}

.container {
	background: #0a0b3b;
	border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
	max-width: 80%;
	margin: 1em auto;
	border-radius: 4px;
	 padding: 1em;
}

.pages {
	padding: 1.3em;
	font-size: 1.3em;
	line-height: 1.8em;
	color: #333;
}

.pages h2 {
	padding-bottom: 1em;
	text-align: center;
	font-size: 2em;
	color: #333;
}

.pages ul{
	padding: 1em 2em;
	color: #666;
}



h1 {
	font-size:2em;
	color:#0085c9;
	font-weight: 900;
	letter-spacing: 2px;
	padding: 0.5em;
	text-align: center;
}

h2 {
	font-size:1em;
	color:#0085c9;
	letter-spacing: 2px;
	padding: 0.5em;
	text-align: center;
	margin: 0.5em;
}

h3 {
	font-size:1em;
	color:#0085c9;
	letter-spacing: 2px;
	padding: 0.5em;
	text-align: center;
	margin: 0.5em;
}

h3 span{
	font-size:0.8em;
	color:#333;
	font-weight: 900;
	letter-spacing: 2px;
	padding: 0.5em;
	text-align: center;
}


.intro {
	text-align:center;
}

.intro p {
	font-size:1em;
	letter-spacing: 2px;
	padding:1em;
}

.outro {
  display: grid;
  grid-template-columns: 29% auto;
  grid-gap: 10px;
  background-color: #fff;
  border-top: 1px solid #c6c6c6;
  padding-top: 1em;
  color: #444;
  margin-top:1em;
   margin-bottom:1em;
   border-radius: 4px;
}

/* 868 */
@media (min-width: 181px) and (max-width: 868px) {
  
	.outro {
	  display: grid;
	  grid-template-columns: 90%;
	}
  
}

.partone img{
  text-align:right;
}

.outro p {
	font-size:1em;
	letter-spacing: 2px;
	padding:1em;
	text-align: justify;
}


#startStopBtn{
  background-color: #0085c9;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 100%;
   border-radius: 4px;
}
#startStopBtn:hover{
  background-color: #0576af;
}
#startStopBtn.running{
	background-color:#c63b1f;
	border-color:#c63b1f;
	color:#FFFFFF;
}
#startStopBtn:before{
	content:"Start Test Now";
}
#startStopBtn.running:before{
	content:"Cancel Test";
}

#test{
	margin-top:6em;
	margin-bottom:2em;
	text-align: center;
}
div.testArea{
	display:inline-block;
	width:16em;
	height:12.5em;
	position:relative;
	box-sizing:border-box;
}
div.testName{
	position:absolute;
	top:-5em; left:0;
	width:100%;
	font-size:1em;
	background:#eeeeee;
	border-radius:0.3em;
	padding: 0.3em;
	letter-spacing: 2px;
	color: #666;
	z-index:9;
}
div.icontest {
	position:absolute;
	top:-0.7em; left:0;
	width:100%;
	font-size:3em;
	color:#eeeeee;
	z-index:9;
}
div.meterText{
	position:absolute;
	bottom:4em; left:30%;
	width:40%;
	font-size:1em;
	z-index:9;
	color:#fff;
	background-color: #55be00;
	border-radius:0.3em;
	padding:0.2em;
}
div.meterText:empty:before{
	content:"0.00";
}
div.unit{
	position:absolute;
	bottom:2em; left:0;
	width:100%;
	z-index:9;
}
div.testArea canvas{
	position:absolute;
	top:0; left:0; width:100%; height:100%;
	z-index:1;
}
div.testGroup{
	display:inline-block;
	height:12.5em;
}

@media (min-width: 560px) and (max-width: 1224px) {
	body{
		font-size:0.8em;
	}
	#test{
		margin-top:6em;
		margin-bottom:1em;
		text-align: center;
	}
	div.testArea {
		width:16em;
		height:12.5em;
	}
	div.testGroup{
		display:inline-block;
		height:12.5em;
		position:relative;
		box-sizing:border-box;
		margin-bottom:6em;
	}
}

@media (min-width: 10px) and (max-width: 560px) {
	body{
		font-size:0.8em;
	}
		
	#test{
		margin-top:6em;
		margin-bottom:1em;
		text-align: center;
	}
	div.testArea {
		width:16em;
		height:12.5em;
		margin-bottom:8em;
	}
	div.testGroup{
		display:inline-block;
		height:32em;
		position:relative;
		box-sizing:border-box;
	}
	#nomob{
		display:none;
	}
}

.fbdiv a { 
  background-color: rgb(60, 90, 153); 
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 100%;
  border-radius: 4px;
}
.fbdiv .fblink:hover { 
	background:rgb(43, 68, 121);
	color: #fff;
}
.fa-facebook-square{ 
	font-size: 1.3em;
	padding: 0px 10px;
}


footer {
	width:100%;
	text-align:center;
	padding:1em;
	margin: 1em 0em;
}

.footer a {
	color: #fff;
	font-size: 1em;
	text-decoration: none;
	padding:0 1em;
}

.footer p {
	color: #fff;
	font-size: 1em;
	text-decoration: none;
	padding:1em 0em;
}

.footer p a {
	color: #fff;
	padding: 0em;
}

.footer p span {
	color: #2d0100;
}

.footer a:hover {
	color: #0f75bc;
	font-size: 1em;
	text-decoration: none;
}



#counter-area {
	padding: 2px;
	background-color: rgba(205, 204, 204, 0.19);
	border-radius: 2px;
	width: 300px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	width: 100%;
}

#counter-winkey {
	color: white;
	background-color: #db8002;
	padding: 3px 9px;
	border-radius: 5px;
}




	</style>

</head>

<body>
	<center style="margin: 5vh;">
		<h1>INTERNET SPEED TEST</h1>
	</center>
	<div class="container">
		<div id="test">
			<div class="testGroup" id="nomob">
				<div class="testArea">
					<div class="icontest"><i class="fas fa-unlink"></i></div>
					<div class="testName">Jitter</div>
					<canvas id="jitMeter" class="meter"></canvas>
					<div id="jitText" class="meterText"></div>
					<div class="unit">ms</div>
				</div>
				<div class="testArea">
					<div class="icontest"><i class="fas fa-link"></i></div>
					<div class="testName">Ping</div>
					<canvas id="pingMeter" class="meter"></canvas>
					<div id="pingText" class="meterText"></div>
					<div class="unit">ms</div>
				</div>
			</div>
			<div class="testGroup">
				<div class="testArea">
					<div class="testAreastyle">
						<div class="icontest"><i class="fas fa-download"></i></div>
						<div class="testName">Download</div>
					</div>
					<canvas id="dlMeter" class="meter"></canvas>
					<div id="dlText" class="meterText"></div>
					<div class="unit">Mbps</div>
				</div>
				<div class="testArea">
					<div class="icontest"><i class="fas fa-upload"></i></div>
					<div class="testName">Upload</div>
					<canvas id="ulMeter" class="meter"></canvas>
					<div id="ulText" class="meterText"></div>
					<div class="unit">Mbps</div>
				</div>
			</div>
			<div style="display: none; " id="ipArea">
				IP Address: <span id="ip"></span>
			</div>
		</div>
		<center>
			<div id="startStopBtn" onclick="startStop()"></div>
		</center>
		<script type="text/javascript">setTimeout(initUI, 100);</script>
		</br>
		<center>
			</br>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<div id="counter-area-winkey">Real time <span id="counter-winkey"></span> visitors right now</div>
			<script>
				function r(t, r) { return Math.floor(Math.random() * (r - t + 1) + t) } var interval = 2e3, variation = 5, c = r(500, 2e3); $("#counter-winkey").text(c), setInterval(function () { var t = r(-variation, variation); c += t, $("#counter-winkey").text(c) }, interval);
			</script>
		</center>
	</div>
	<footer>
		<div class="footer">
			<a href="#" disabled>FAQ's</a>
			<a href="#" disabled>Privacy</a>
			<a href="#" disabled>Terms</a>
			<a href="#" disabled>Contact</a>
		</div>

		<div class="footer">
			<p>
				© SIDEKICKCOMPANY
			</p>
		</div>
	</footer>
</body>

</html>