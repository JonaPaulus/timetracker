<?php

	class C42rest {
		
		// no extra config file in this #demo
		private $apiKey = '2b00be1e6847be8b4c751fc2d7caee19862bbb3f';
		private $apiDomain = 'https://demo.calendar42.com/app/django';
		private $calendarID = 'ce4c3446fc4fc86dc67876ad68f1fc850d4dde60';
		
		
		/*
		 * constructor ..
		 */
		public function __construct() {
			date_default_timezone_set('Europe/Amsterdam');
		}
		
		
		/*
		 * communicates with the c42-API
		 * @param: $path (String) - request URI
		 * @param: $method (String) - HTTP request method. make sure the server can handle the choosen method!
		 * @param: $jsonData (JSON-object) - add custom parameters to the request
		 * @return: JSON-object
		 */
		private function apiCall($path, $method, $dataArray) {
			
			// add some HTTP headers to the request
			$headerArray = array (
				'Authorization: Token ' . $this -> getApiKey(),
				'Content-Type: application/json'
			);
			
			$jsonData = json_encode($dataArray);
			
			// cURL magic
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this -> getApiDomain() . $path);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			
			//var_dump(curl_getinfo($ch)); // #debug cURL
			
			if ($result === false) {
				$returnValue = 'Curl error: ' . curl_error($ch); // no proper error handling #demo
			} else {
				$returnValue = json_decode($result, true);
			}
			
			curl_close($ch);
			
			return $returnValue;
		}
		
		
		/*
		 * read out all events from a specific calendar defined in C42::calendarID
		 * @param: $calendar (array) - key value pairs of API parameters (https://demo.calendar42.com/api/docs/)
		 * @return: JSON-object
		 */
		public function getAllEvents() {
			
			$data = array(
				'calendar_ids' => $this -> getCalendarID()
			);
			
			return $this -> apiCall('/api/v2/events/', 'get', $data);
		}
		
		
		/*
		 * The entry is allways related to the calendar with the id from C42rest::calendarID
		 * @param: $timestampStart (int) - unix timestamp
		 * @param: $timestampEnd (int) - unix timestamp
		 * @param: $title (String)
		 * @return: 'success' (String) or error message on failure
		 */
		public function setC42Entry($timestampStart, $timestampEnd, $title) {
			
			// c == ISO-8601 datetime format
			$start = date("c", $timestampStart);
			$end = date("c", $timestampEnd);
			
			//no variable timezone for this #demo
			$data = array(
				'event_type' => 'normal',
				'calendar_ids' => array( $this -> getCalendarID() ),
				'start' => $start,
				'end' => $end,
				'start_timezone' => 'Europe/Amsterdam',
				'end_timezone' => 'Europe/Amsterdam',
				'title' => $title
			);
			
			$answer = $this -> apiCall('/api/v2/events/', 'post', $data);
			//var_dump($answer); // #debug C42
			
			if (isset($answer['error'])) {
				return $answer['error']['message'];
			} else {
				return 'success';
			}
		}
		
		
		/*
		 * standard getter and setter methods we need
		 */
		protected function getApiKey() {
			return $this -> apiKey;
		}
		
		protected function getApiDomain() {
			return $this -> apiDomain;
		}
		
		protected function getCalendarID() {
			return $this -> calendarID;
		}
		
	}
