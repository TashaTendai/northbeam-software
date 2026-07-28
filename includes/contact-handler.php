<?php
/* =========================================================================
   contact-handler.php
   Processes the contact form submission: validates input, then inserts
   it into the contact_messages table using a prepared statement.
   ========================================================================= */

include 'db.php';

$errors = [];

// Only run if the form was actually submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Grab and trim the submitted values
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate or check for required fields. If any are missing, add an error message to the $errors array.
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If no errors, insert into database
    if (empty($errors)) {

        // Prepared statement — protects against SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }

        $stmt->close();
    }
}

$conn->close();

// Redirect back to contact page with a status flag
if (isset($success)) {
    header("Location: ../contact.php?status=success");
    exit;
} else {
    $errorString = urlencode(implode("|", $errors));
    header("Location: ../contact.php?status=error&errors=" . $errorString);
    exit;
}
?>