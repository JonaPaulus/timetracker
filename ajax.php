<?php

	function __autoload($classname) {
	    $filename = "./lib/". $classname .".class.php";
		include_once($filename);
	}
	
	$demo = new C42rest();
	
	
	// choose the correct functionality
	$targetFunction = $_POST['target'];
	
	switch ($targetFunction) {
	    case 'saveTimer':
	        $answer = saveTimer($demo);
			echo $answer;
	        break;
	    case 'anyOtherCaseToBeDefined':
	        // room for more ajax functionalities
	        break;
		default:
	        echo "No target functionality detected";
	        break;
	}
	
	
	/*
	 * saves a timer to the Calender42 application
	 * an action and a timer must be sent per POST to execute successfully
	 * @return: 'success' (String) on success or Error Msg on failure
	 */
	function saveTimer($demo) {
		
		// check for complete data 
		$postTitle = ( isset($_POST['title']) ) ? $_POST['title'] : false;
		$postTimer = ( isset($_POST['timer']) ) ? $_POST['timer'] : false;

		if (!$postTitle || !$postTimer) {
			return 'Incompleate data has been send - Execution failed';
		}
		
		// check for valid input
		$pattern = "/\w/";
		$test1 = preg_match($pattern, $postTitle);
		$test2 = preg_match($pattern, $postTimer);
		
		if (!$test1 || !$test2) {
			return 'The sent data match some invalid characters - Execution failed';
		}
		
		// convert time numbers into UNIX timestamps
		$seconds = timerToSeconds($postTimer);
		
		$start = time() - $seconds;
		$end = time();
		
		// send the Data to the C42 API and wait excited for the answer
		$result = $demo -> setC42Entry($start, $end, $postTitle);
		
		echo $result;
		
	}
	
	
	/*
	 * converts a timer into a number of seconds
	 * @param: $timer (String) - format: 'hh:mm:ss'
	 * @return: seconds (int)
	 */
	function timerToSeconds($timer) {
		
		$a = explode(':', $timer);
		$h = $a[0];
		$m = $a[1];
		$s = $a[2];
		
		return intval($h) * 3600 + intval($m) * 60 + intval($s);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
