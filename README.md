# **SMS Mtandao API Intergration - PHP Function Documentation**

> **Author**: Crescent Sambila (@CodeWithCrescent)

## Overview

The `notify_by_sms` function is designed to send SMS notifications via the **SMS Mtandao API**. It supports sending messages to one or multiple recipients, with optional support for a push URL for additional functionality. 

This function is particularly useful for systems that require SMS-based notifications to users, providing an easy way to integrate SMS sending capabilities.

## Requirements

- **PHP** version 7.0+ (for proper cURL functionality)
- **cURL** extension enabled in PHP
- **SMS Mtandao API key** for authentication

## Installation

You can simply copy the `notify_by_sms` function into your PHP project. If you're using Composer, you can include this function in your existing project structure by placing it in a relevant file (e.g., `utils.php` or `notifications.php`).

```php
// Include the function in your PHP script
include 'path/to/your/notification_file.php';
```

## Usage

### Function Definition

```php
/**
 * Notify By SMS
 *
 * Send Message to SMS Mtandao for notification
 *
 * @param string $message - Message to send
 * @param string $push_url (optional) - A URL to send push notifications (default: '')
 * @param mixed $recipients - A string or an array of recipients (comma-separated if multiple)
 *
 * @return bool - Returns true on success, false on failure
 */
function notify_by_sms($message, $push_url = '', $recipients);
```

### Parameters

- **$message** (string): The content of the message to be sent via SMS.
- **$push_url** (string, optional): A URL to send notifications to in case of success. This is optional and defaults to an empty string.
- **$recipients** (mixed): A single recipient's phone number as a string or multiple recipients as a comma-separated string. 

### Return Value

The function returns a boolean value:
- `true` if the SMS was successfully sent.
- `false` if the SMS sending failed or there was an error.

### Example Usage

#### 1. Sending a Message to a Single Recipient

```php
<?php
include 'path/to/notification_file.php';

// Define the message and recipient
$message = "Your order has been shipped!";
$recipient = "255701234567"; // single recipient

// Call the function to send the SMS
if (notify_by_sms($message, '', $recipient)) {
    echo "Message sent successfully!";
} else {
    echo "Failed to send message.";
}
?>
```

#### 2. Sending a Message to Multiple Recipients

```php
<?php
include 'path/to/notification_file.php';

// Define the message and multiple recipients
$message = "Your account has been updated!";
$recipients = "255701234567, 254708765432, 254711223344"; // multiple recipients

// Call the function to send the SMS
if (notify_by_sms($message, '', $recipients)) {
    echo "Message sent successfully to all recipients!";
} else {
    echo "Failed to send message.";
}
?>
```

#### 3. Sending a Message with a Push URL

```php
<?php
include 'path/to/notification_file.php';

// Define the message and push URL
$message = "New updates are available!";
$push_url = "https://yourapp.com/notification";
$recipients = "255767234567"; // single recipient

// Call the function to send the SMS with a push URL
if (notify_by_sms($message, $push_url, $recipients)) {
    echo "Message sent with push URL successfully!";
} else {
    echo "Failed to send message.";
}
?>
```

## Function Internals

### 1. **Data Preparation**

The function prepares an associative array with required parameters like `token`, `sender`, `message`, `push`, and `recipient` before encoding it to JSON format.

```php
$data = [
    "token" => 'YOUR_TOKEN',
    "sender" => 'SENDER_ID',
    "message" => $message,
    "push" => $push_url,
    "recipient" => $recipients
];

$json_data = json_encode($data);
```

### 2. **cURL Request**

A cURL session is initiated to send the request to the SMS Mtandao API endpoint. The request is made using POST method with the `Content-Type: application/json` header.

```php

// Define the API URL
$url = "http://login.smsmtandao.com/smsmtandaoapi/send";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data)
]);
```

### 3. **Error Handling**

If cURL encounters any issues, an error message is displayed. Otherwise, the function checks the response for success or failure.

```php
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $response_data = json_decode($response, true);
    if ($response_data['status'] == 'succeed') {
        return true;
    } else {
        return false;
    }
}
```

### 4. **cURL Session Close**

The cURL session is closed after the request is completed.

```php
curl_close($ch);
```

## Troubleshooting

- **cURL Errors**: Ensure that the cURL extension is enabled in your PHP configuration. If cURL is not enabled, enable it by uncommenting `extension=curl` in your `php.ini` file.
- **Invalid Token**: If you receive an invalid token error, ensure that the API token is correct and has sufficient privileges for the operation.
- **API Endpoint Issues**: Make sure the SMS Mtandao service is available. You can check their API documentation or support for further details.

## Contributing

Contributions are welcome! If you have suggestions, bug fixes, or improvements, please feel free to open an issue or submit a pull request.

## Official Documentation

Visit SMS Mtandao official [Documentation](http://smsmtandao.co.tz/wp-content/uploads/2020/05/SMSAPI-V2.0.2_2017.pdf) to learn more nstructions for integration SMS messaging services with
various solutions using HTTP SMS Mtandao Programming Interface.

## License

MIT License - See the [LICENSE](LICENSE) file for more information.
