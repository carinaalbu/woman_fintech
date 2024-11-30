<?php
    include_once "includes/header.php";
    include_once "config/database.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Upload File</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
            <!-- Title Field -->
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter file title" required>
            </div>
            <!-- Description Field -->
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter file description" required></textarea>
            </div>
            <!-- File Type Selection -->
            <div class="mb-3">
                <label for="file_type" class="form-label">File Type:</label>
                <select name="file_type" id="file_type" class="form-select" required>
                    <option value="pdf">PDF</option>
                    <option value="txt">TXT</option>
                    <!-- <option value="mp3">MP3</option> -->
                </select>
            </div>
            <!-- File Upload Field -->
            <div class="mb-3">
                <label for="file" class="form-label">Select File:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


