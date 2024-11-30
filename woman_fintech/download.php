<?php

// Make sure to sanitize the filename to prevent directory traversal attacks
$file = isset($_GET['file']) ? basename($_GET['file']) : '';
var_dump('------>',$file);
// Define the full path to the file you want to allow for download
$filePath = '.\\resources\\articles\\' . $file . '.pdf';  // Adjust this path

// Check if the file exists
if (file_exists($filePath) && !empty($file)) {
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream'); // Tells browser to download the file
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Expires: 0');
    
    // Clear any previous output
    ob_clean();
    flush();

    // Read the file and send it to the browser
    readfile($filePath);
    
    exit;
} else {
    // If the file doesn't exist, show an error message
    echo 'File not found!';
}
?>
