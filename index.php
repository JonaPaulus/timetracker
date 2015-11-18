<?php

    function __autoload($classname) {
	    $filename = "./lib/". $classname .".class.php";
		include_once($filename);
	}
	
	$demo = new C42rest();
	
	//$events = $demo -> getAllEvents();
	//var_dump($events);


	$timestampStart = mktime(11, 14, 54, 11, 18, 2015);
	$timestampEnd = mktime(15, 14, 54, 11, 18, 2015);
	//$demo -> setC42Entry($timestampStart, $timestampEnd, 'fietsen');

	
	
	
/*
curl 
--request POST \               
--header "Accept: application/json" \      
--header "Content-type: application/json" \      
--header "Authorization: Token {{your_token}}" \      
--data ' {"event_type": "normal", "title": "My tracked time", "start": "2015-02-12T15:00:00Z", "start_timezone": "Europe/Amsterdam", "end": "2015-02-12T17:00:00Z", "end_timezone": "Europe/Amsterdam", "rsvp_status": "attending" } ' \
"https://demo.calendar42.com/api/v2/events/"
*/

?>


<!DOCTYPE html>
<html>
	
	<head>
		<title>Time to Calendar42</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="assets/styles.css">
	</head>
	
	<body>
		
		<header>
			<div class="wrapper">
				<h1 id="pagetitle">
					<a href="./">
						Time to Calendar42
					</a>
				</h1>
			</div>
		</header>
		
		<div id="body">
			<div class="wrapper sheet">
				<div id="main-area">
					<div id="timer">00:00:00</div>
					<div id="button-wrapper">
						<button id="btnStart" class="pause" hidefocus>Run</button>
						<button id="btnReset" hidefocus>Reset</button>
					</div>
					<div id="toC42">
						<!-- pattern doesnt work on safari. here should be done some JS validation aswell -->
						<input type="text" id="action" placeholder="What i am doing .." pattern="([\w äöüïëáóúíéê',\-\.]){3,25}" /><br />
						<button id="btnC42" hidefocus>Send data to Calendar42</button>
					</div>
					<div id="msg-box">
						
					</div>
				</div>
				<!--<div id="sidebar">
					
				</div>-->
				<div class="clear"></div>
			</div>
		</div>
		
		<footer>
			<div class="wrapper">
				<br>
				<p>
					&copy; Jona Paulus
				</p>
			</div>
		</footer>
		
		<script src="assets/jquery.js"></script>
		<script src="assets/scripts.js"></script>
	</body>
	
</html>
