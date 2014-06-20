<?php

class PushQueue {

	/**
	 *	date = array('message', '')
	 */
	public function fire($job, $data) {
		function pwCall($method, $data) {
			$url = 'https://cp.pushwoosh.com/json/1.3/' . $method;
			$request = json_encode(['request' => $data]);
		 
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		 
			$response = curl_exec($ch);
			//$info = curl_getinfo($ch);
			curl_close($ch);
			
			return $response;
		}
		 
		 
		$response = pwCall('createMessage', [
			'application' => '7C0DE-37FBD',
			'auth' => '6E0cIwLJ0b3jTg5RKjrR5H9R27G1hCakyaYfyGsyzdUPXLRAn2foUmdMA5K2G7pwcblDzT6b4PgRO6vy8EO1',
			'notifications' => [
					[
						'send_date' => 'now',
						'content' => $data['message'],
						'data' => ['custom' => 'json data'],
					//	'link' => 'http://pushwoosh.com/',
						'devices' => [
							'APA91bFcqdEFW9PJPOxNlLnJxhdd8u7k2G3AI78W3vg2ZJ-C2lYrltOZgHabD3Ma1CtuuPWN47IoKuxJJBPjS2Luz4UuZsfnDcKMn92SWvaTBS1aMVTtzucvhce4jN5LQiQFki8yEozBz5fVrtvLXOyYD0aL9-CNIVHI-iNstYd2KyNrl01un3M'
						]
					]
				]
			]
		);
		
		$response = json_decode($response);
		
		if ($response['status_code'] != 200 && $job->attempts() < 3) {
			$job->release(60);
		} else {
			$job->delete();
		}
	}

}
