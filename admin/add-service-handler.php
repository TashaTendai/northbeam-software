<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($description)) {
        header("Location: add-service.php?error=" . urlencode("Title and description are required."));
        exit;
    }

    // Default image path, used if no file was uploaded
    $imagePath = "assets/img/service-placeholder.jpg";

    // Check if a file was actually uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB in bytes

        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $originalName = $_FILES['image']['name'];

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            header("Location: add-service.php?error=" . urlencode("Only JPG, PNG, or WEBP images are allowed."));
            exit;
        }

        // Validate file size
        if ($fileSize > $maxSize) {
            header("Location: add-service.php?error=" . urlencode("Image must be under 2MB."));
            exit;
        }

        // Generate a unique filename to avoid overwriting existing files
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('service_', true) . '.' . $extension;
        $destination = '../assets/img/' . $uniqueName;

        // Move the file from its temporary location to our img folder
        if (move_uploaded_file($fileTmpPath, $destination)) {
            $imagePath = 'assets/img/' . $uniqueName;
        } else {
            header("Location: add-service.php?error=" . urlencode("Failed to upload image. Please try again."));
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO services (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $imagePath);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: manage-services.php");
        exit;
    } else {
        $stmt->close();
        $conn->close();
        header("Location: add-service.php?error=" . urlencode("Something went wrong. Please try again."));
        exit;
    }
}

$conn->close();
header("Location: add-service.php");
exit;
?>