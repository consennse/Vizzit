<?php

$apiUrl = "https://vizzit.onrender.com/run";

$data = [
    "source_url" => "https://manda.propertybase.com/api/v2/feed/00DWx000007hlhBMAQ/XML2U/a0hSb000005y8ELIAY/full",
    "ftp_host" => "ftp.vizzit.com",
    "ftp_username" => "property_base",
    "ftp_password" => "AS8KnC5i",
    "ftp_target_path" => "33079a.zip"
];

$ch = curl_init($apiUrl);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
} 
else {

    $result = json_decode($response, true);

    if (isset($result['logs'])) {

        $logFile = __DIR__ . "/logs/vizzit.log";

        $logText = implode("\n", $result['logs']);

        file_put_contents($logFile, $logText . "\n", FILE_APPEND);

        echo "Logs saved successfully";
    }

    echo "<pre>";
    print_r($result);
    echo "</pre>";
}

curl_close($ch);
