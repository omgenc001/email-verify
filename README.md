# PHP Email Existence Checker via SMTP

This is a simple PHP application that allows users to enter an email address and check if it exists using SMTP verification (via MX records and handshake with the mail server).

> ⚠️ This tool works best on a real web server with outgoing port 25 open. It may not work correctly on localhost environments like XAMPP or WAMP.

---

## 📸 Screenshot

![image](https://github.com/user-attachments/assets/a8de8d72-ea40-4f37-83d0-242d33124c7b)


---

## 🚀 Features

- Validates email format
- Extracts and checks domain MX records
- Connects to mail server using SMTP
- Simulates sending to see if the address is accepted
- Clean HTML + CSS form interface

---

## 🛠 How to Use

1. Clone or download the project.

2. Upload the `email_checker.php` file to a real web server.

3. Open the file in your browser:

4. Enter an email address and click **Verify**.

---

## 📄 Sample Output

- **Success**: The email appears to exist.
- **Failed**: The email does not exist or cannot be verified.

---

## 📌 Notes

- This method uses `fsockopen()` to connect to the mail server and simulate a mail send.
- Not 100% accurate with Gmail, Yahoo, Outlook, etc., due to anti-spam measures.
- May show false positives or negatives based on the target server's configuration.

---

## ✅ Requirements

- PHP 7.0 or higher
- Enabled `fsockopen()` function
- Outgoing port 25 must be allowed on the server
