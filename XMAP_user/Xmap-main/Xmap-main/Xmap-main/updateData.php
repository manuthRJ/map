<?php
// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Set headers for CORS
    header("Access-Control-Allow-Origin: *"); // Replace * with the specific origin if known
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    // Respond with 200 OK status
    header("HTTP/1.1 200 OK");
    exit; // End the script here for OPTIONS requests
}

// Normal request handling (POST, GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Serve the JSON file
    $data = file_get_contents('people_count.json');
    if ($data === false) {
        http_response_code(500);
        echo json_encode(['status' => 'Error', 'message' => 'Error reading file']);
    } else {
        echo $data;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the JSON file
    $input = file_get_contents('php://input');
    $jsonData = json_decode($input, true);
    if ($jsonData === null) {
        http_response_code(400);
        echo json_encode(['status' => 'Error', 'message' => 'Invalid JSON']);
    } else {
        $currentData = json_decode(file_get_contents('people_count.json'), true);
        if ($currentData === null) {
            http_response_code(500);
            echo json_encode(['status' => 'Error', 'message' => 'Error reading current data']);
        } else {
            foreach ($jsonData as $key => $value) {
                if (array_key_exists($key, $currentData)) {
                    $currentData[$key] = (int)$value;
                }
            }
            $result = file_put_contents('people_count.json', json_encode($currentData, JSON_PRETTY_PRINT));
            if ($result === false) {
                http_response_code(500);
                echo json_encode(['status' => 'Error', 'message' => 'Error writing file']);
            } else {
                echo json_encode(['status' => 'Success', 'message' => 'File updated']);
            }
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'Error', 'message' => 'Method not allowed']);
}
?>
