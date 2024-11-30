<?php
    include_once "includes/header.php";
    include_once "config/database.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $database = new Database();
        $db = $database->getConnection();

        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $link = $_POST['link'];
        $filePath = null;

        // // Upload fișier pentru resurse descărcabile
        // if ($type === 'downloadable' && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        //     $targetDir = "uploads/resources/";
        //     $fileName = uniqid() . "_" . basename($_FILES['file']['name']);
        //     $targetFilePath = $targetDir . $fileName;

        //     if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        //         $filePath = $targetFilePath;
        //     }
        // }

        // $query = "INSERT INTO resources (title, description, type, link, file_path) VALUES (?, ?, ?, ?, ?)";
        // $stmt = $db->prepare($query);
        // $stmt->execute([$title, $description, $type, $link, $filePath]);

        // echo "Resource added successfully!";
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <h2>Upload File</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>
        </div>
        <div>
            <label for="file_type">File Type:</label>
            <select name="file_type" id="file_type" required>
                <option value="pdf">PDF</option>
                <option value="txt">TXT</option>
                <option value="mp3">MP3</option>
            </select>
        </div>
        <div>
            <label for="file">Select File:</label>
            <input type="file" name="file" id="file" required>
        </div>
        <div>
            <button type="submit" name="submit">Upload</button>
        </div>
    </form>
</body>

