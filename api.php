<?php 
    $url = "http://localhost:8004/api/v1/cars";

    $urlWithParams = $url;
    $session = curl_init();
    curl_setopt($session, CURLOPT_URL, $urlWithParams);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($session);
    if ($response === false) {
        $error = curl_error($session);
        echo "cURL Error: " . $error;
    } else {
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // Successfully decoded JSON
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        } else {
            echo "JSON Decode Error: " . json_last_error_msg();
        }
    }