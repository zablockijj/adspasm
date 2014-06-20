<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::get('push/message', function()
{
	Queue::push('PushQueue', array(
		'message' => 'stauffermatt'
	));
	return Response::json(array('status' => 400));
	/*
	if (Input::has('msg') && Input::has('msg')) {
		//
	} else {
		return Response::json(array('status' => 400));
	}*/
});
Route::get('foo/bar', function() {
	
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
	
	$validator = Validator::make(Input::all(), array(
		'message' => 'required'
	));
	if ($validator->passes()) {
	/*	$response = pwCall('createMessage', [
			'application' => '7C0DE-37FBD',
			'auth' => '6E0cIwLJ0b3jTg5RKjrR5H9R27G1hCakyaYfyGsyzdUPXLRAn2foUmdMA5K2G7pwcblDzT6b4PgRO6vy8EO1',
			'notifications' => [
					[
						'send_date' => 'now',
						'content' => Input::get('message'),
					//	'data' => ['custom' => 'json data'],
					//	'link' => 'http://pushwoosh.com/',
						'devices' => Input::get('to')
						[
							'APA91bFcqdEFW9PJPOxNlLnJxhdd8u7k2G3AI78W3vg2ZJ-C2lYrltOZgHabD3Ma1CtuuPWN47IoKuxJJBPjS2Luz4UuZsfnDcKMn92SWvaTBS1aMVTtzucvhce4jN5LQiQFki8yEozBz5fVrtvLXOyYD0aL9-CNIVHI-iNstYd2KyNrl01un3M'
						]
					]
				]
			]
		);
		$response = json_decode($response);*/
		
		return Response::json(array('status' => 200));
			
	//	if ($response['status_code'] == 200)
	//		return Response::json(array('status' => 200));
	//	else
	//		return Response::json(array('status' => 400, 'message' => 'Unable to send that message'));
	}
	return Response::json(array('status' => 400, 'message' => 'No valid input passed'));
});