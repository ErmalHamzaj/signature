<?php
// upload.php

// Define the target directories
$targetDir = "uploads/"; // Directory for uploaded files
$logDir = "logs/";       // Directory for logging IP addresses

// Ensure the uploads and logs directories exist
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true); // Create the uploads directory if it doesn't exist
}
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);    // Create the logs directory if it doesn't exist
}

// Get the uploaded file details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf']) && isset($_POST['name'])) {
    $file = $_FILES['pdf'];
    $name = trim($_POST['name']); // Get the name and surname from the request

    // Validate the file type (only allow PDF files)
    $allowedTypes = ['application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed.']);
        exit;
    }

    // Validate the file size (e.g., limit to 10MB)
    $maxFileSize = 10 * 1024 * 1024; // 10MB in bytes
    if ($file['size'] > $maxFileSize) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File size exceeds the limit of 10MB.']);
        exit;
    }

    // Sanitize the name to avoid invalid characters in the filename
    $sanitized_name = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $name); // Remove special characters
    $sanitized_name = str_replace(' ', '_', $sanitized_name); // Replace spaces with underscores

    // Generate the custom file name
    $fileName = $sanitized_name . '_signed_agreement.pdf';
    $targetFilePath = $targetDir . $fileName;

    // Retrieve the user's IP address
    $user_ip = getUserIP();

    // Log the IP address along with the name and surname
    $logMessage = date("Y-m-d H:i:s") . " - Name: " . $name . " | IP: " . $user_ip . "\n";
    file_put_contents($logDir . "ip_log.txt", $logMessage, FILE_APPEND);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Return success response with the desired message
        echo json_encode([
            'success' => true,
            'message' => 'Your Signed Document Was Sent! Thank You...',
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to upload the file.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing file/name.']);
}

// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>