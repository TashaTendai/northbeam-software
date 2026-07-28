<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($description)) {
        header("Location: edit-service.php?id=" . $id . "&error=" . urlencode("Title and description are required."));
        exit;
    }

    // First, get the existing image path, in case no new file is uploaded
    $stmt = $conn->prepare("SELECT image FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current = $result->fetch_assoc();
    $stmt->close();

    $imagePath = $current['image']; // default: keep the current image

    // Check if a NEW file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $originalName = $_FILES['image']['name'];

        if (!in_array($fileType, $allowedTypes)) {
            header("Location: edit-service.php?id=" . $id . "&error=" . urlencode("Only JPG, PNG, or WEBP images are allowed."));
            exit;
        }

        if ($fileSize > $maxSize) {
            header("Location: edit-service.php?id=" . $id . "&error=" . urlencode("Image must be under 2MB."));
            exit;
        }

        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('service_', true) . '.' . $extension;
        $destination = '../assets/img/' . $uniqueName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $imagePath = 'assets/img/' . $uniqueName;
        } else {
            header("Location: edit-service.php?id=" . $id . "&error=" . urlencode("Failed to upload image. Please try again."));
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE services SET title = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $imagePath, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: manage-services.php");
        exit;
    } else {
        $stmt->close();
        $conn->close();
        header("Location: edit-service.php?id=" . $id . "&error=" . urlencode("Something went wrong. Please try again."));
        exit;
    }
}

$conn->close();
header("Location: manage-services.php");
exit;
?>