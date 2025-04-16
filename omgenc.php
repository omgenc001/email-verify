
<?php
function verifyEmail($email) {
    // Validate format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }

    // Get domain from email
    list($user, $domain) = explode('@', $email);

    // Get MX records for the domain
    if (!getmxrr($domain, $mxhosts)) {
        return "No MX records found for the domain ($domain).";
    }

    // Try connecting to the mail server
    $connect = fsockopen($mxhosts[0], 25, $errno, $errstr, 10);
    if (!$connect) {
        return "Connection to mail server failed: $errstr ($errno)";
    }

    // SMTP conversation
    $output = '';
    $output .= fread($connect, 1024);
    fwrite($connect, "HELO example.com\r\n");
    $output .= fread($connect, 1024);

    fwrite($connect, "MAIL FROM: <check@example.com>\r\n");
    $output .= fread($connect, 1024);
    fwrite($connect, "RCPT TO: <$email>\r\n");
    $response = fread($connect, 1024);
    fwrite($connect, "QUIT\r\n");
    fclose($connect);

    if (strpos($response, '250') !== false) {
        return "Success: The email <strong>$email</strong> appears to exist.";
    } else {
        return "Failed: The email <strong>$email</strong> does not exist or can't be verified.";
    }
}

// Handle form submission
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $result = verifyEmail($email);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Existence Checker</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }

        .box { max-width: 500px; margin: auto; background: #f2f2f2; padding: 20px; border-radius: 8px; }
        input[type="email"] { width: 100%; padding: 10px; margin-bottom: 10px; }
        input[type="submit"] { padding: 10px 20px; }
        .result { margin-top: 15px; padding: 10px; background: #e2e2e2; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Check If Email Exists</h2>
        <form method="POST">
            <label for="email">Enter Email Address:</label>
            <input type="email" name="email" id="email" required>
            <input type="submit" value="Verify">
        </form>

        <?php if (!empty($result)): ?>
            <div class="result"><?= $result ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
