<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

function removeFileExtension($filename) {
    return pathinfo($filename, PATHINFO_FILENAME);
}

function cleanPath($path) {
    // Remove the leading ".\" and trailing "\"
    return rtrim(ltrim($path, ".\\"), "\\");
}


// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form inputs
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $fileType = htmlspecialchars($_POST['file_type']);
    $hasDownloadPermisions = 0;
    $dbFileType = 'article';
    if($fileType === 'pdf') {
        $hasDownloadPermisions = '1';
    }

    // Directory to store uploaded files
    $uploadDir = '.\\resources\\articles\\';

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle the uploaded file
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed file extensions
    $allowedExts = ['pdf', 'txt'];

    // Validate the file
    if ($fileError === 0) {
        if (in_array($fileExt, $allowedExts)) {
            if ($fileSize <= 5 * 1024 * 1024) { // Limit file size to 5MB
                // Generate a unique file name to avoid conflicts
                $newFileName = uniqid() . '.' . $fileExt;

                // Set the destination path
                $fileDestination = $uploadDir . $newFileName;

                $dbFileName = removeFileExtension($newFileName);
                $dbDirectoryForUpload = cleanPath($uploadDir);

                // Move the uploaded file
                if (move_uploaded_file($fileTmpPath, $fileDestination)) {

                    $query = "INSERT INTO resources (title, description, type, link, fileName, has_download_permission) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($query);
                    $stmt->execute([$title, $description, $dbFileType, $dbDirectoryForUpload, $dbFileName, $hasDownloadPermisions]);

                    // Success message
                    echo "<div style='text-align: center; margin-top: 20px;'>";
                    echo "<h3>File uploaded successfully!</h3>";
                    echo "<p><strong>Title:</strong> $title</p>";
                    echo "<p><strong>Description:</strong> $description</p>";
                    echo "<p><strong>File Type:</strong> $fileType</p>";
                    echo "<p><strong>Uploaded File:</strong> <a href='$fileDestination'>$newFileName</a></p>";
                    echo "</div>";
                    echo "<a class='nav-link' href='resources.php'>Go Back</a>";

                } else {
                    echo "<p style='color: red; text-align: center;'>Error moving the uploaded file!</p>";
                    echo "<a class='nav-link' href='resources.php'>Go Back</a>";
                }
            } else {
                echo "<p style='color: red; text-align: center;'>File size exceeds 5MB limit!</p>";
                echo "<a class='nav-link' href='resources.php'>Go Back</a>";
            }
        } else {
            echo "<p style='color: red; text-align: center;'>Invalid file type. Only PDF, TXT, and MP3 are allowed!</p>";
            echo "<a class='nav-link' href='resources.php'>Go Back</a>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Error uploading file! Code: $fileError</p>";
        echo "<a class='nav-link' href='resources.php'>Go Back</a>";
    }
} else {
    echo "<p style='color: red; text-align: center;'>No file uploaded.</p>";
    echo "<a class='nav-link' href='resources.php'>Go Back</a>";
}
?>