<?php
// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $companyName = strip_tags(trim($_POST["companyName"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $interest = trim($_POST["interest"]);

    // Check that data was sent to the mailer.
    if ( empty($companyName) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($interest) ) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Recipient email
    $recipient = "your@email.com";

    // Set the email subject.
    $subject = "New partnership inquiry from $companyName";

    // Build the email content.
    $email_content = "Company Name: $companyName\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Interest:\n$interest\n";

    // Build the email headers.
    $email_headers = "From: $companyName <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
