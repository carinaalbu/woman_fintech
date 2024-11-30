<?php
include_once "config/database.php";
include_once "includes/header.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $profilePicture = null;
    
    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
        $filePath = 'images/' . $fileName;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $filePath)) {
            $profilePicture = $fileName;
        } else {
            echo "<p>Error uploading file.</p>";
        }
    }
    $query = "INSERT INTO members 
    (first_name, last_name, email, profession, company, expertise, linkedin_profile, profile_image)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";   
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            $_POST['profession'],
            $_POST['company'],
            $_POST['expertise'],
            $_POST['linkedin_profile'],
            $profilePicture
        ]);

        // Get the last inserted member ID
        $memberId = $db->lastInsertId();

        // Insert a notification for the new member
        $notificationQuery = "INSERT INTO notifications (member_id, message) VALUES (?, ?)";
        $notificationStmt = $db->prepare($notificationQuery);
        $notificationStmt->execute([$memberId, "A new member has joined: " . $_POST['first_name'] . " " . $_POST['last_name']]);

        // Redirect to members page after successful insertion
        header("Location: members.php");
        exit();

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

}

?>
<div class="form-container">
    <h2>Add New Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Profession</label>
            <input type="text" name="profession" class="form-control">
        </div>

        <div class="form-group">
            <label>Company</label>
            <input type="text" name="company" class="form-control">
        </div>

        <div class="form-group">
            <label>Expertise</label>
            <textarea name="expertise" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>LinkedIn Profile</label>
            <input type="url" name="linkedin_profile" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Member</button>
    </form>
</div>
<?php
include_once "includes/footer.php";
?>