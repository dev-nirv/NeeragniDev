<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = "anand.kr.10101010@gmail.com"; // Your email address

    // Retrieve and sanitize form inputs
    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"] ?? "No Subject"));
    $message = htmlspecialchars(trim($_POST["message"] ?? ""));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Create email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Subject: $subject\n";
    $email_content .= "Message: $message\n";

    // Set up email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Debug email content (remove this in production)
    error_log("Attempting to send email:\n$email_content");

    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Error sending email. Please try again later.";
        error_log("Mail function failed.");
    }
} else {
    echo "Invalid request method.";
    exit;
}
?>