<?php

/**
 * Notify By SMS
 *
 * Send Message to SMS Mtandao for notification
 *
 * @param $recepient - array of recipient or a string( more than one recipient separate by comma)
 * @param $sms - message
 */

function notify_by_sms($message, $push_url = '', $recipients)
{
	// Define the API URL
	$url = "http://login.smsmtandao.com/smsmtandaoapi/send";

	// Prepare the request body as an associative array
	$data = [
		"token" => 'YOUR_TOKEN',
		"sender" => 'SENDER_ID',
		"message" => $message,
		"push" => $push_url,
		"recipient" => $recipients
	];

	// Convert the data array to JSON
	$json_data = json_encode($data);

	// Initialize cURL session
	$ch = curl_init();

	// Set cURL options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	// Set the content type to JSON
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Content-Length: ' . strlen($json_data)
	]);

	// Execute the cURL request and capture the response
	$response = curl_exec($ch);

	// Check for errors
	if (curl_errno($ch)) {
		// Output the error
		echo 'Curl error: ' . curl_error($ch);
	} else {
		// Decode the response (JSON) and print it
		$response_data = json_decode($response, true);
		if ($response_data['status'] == 'succeed') {
			// echo "Message sent successfully!";
		$success = true;
		return $success;
		} else {
			// echo "Failed to send message. Error: " . $response_data['description'];
			return false;
		}
	}

	// Close cURL session
	curl_close($ch);
}
