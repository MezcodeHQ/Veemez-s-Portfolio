<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["subject"]) || empty($_POST["message"])) {
        echo "<script>alert('All fields are required!'); window.location.href='index.html#contact';</script>";
        exit;
    }

    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = nl2br(htmlspecialchars($_POST["message"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href='index.html#contact';</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gssunpro@gmail.com';
        $mail->Password   = 'defv zodc sqwn eclb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('gssunpro@gmail.com', 'GS SUN PRO SDN.BHD.');
        $mail->addAddress('gssunpro@gmail.com');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Contact Request: " . $subject;
        $mail->Body    = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background: #f4f4f4; padding: 20px; }
                    .container { width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                    .header { text-align: center; padding-bottom: 20px; }
                    .header img { width: 180px; }
                    .subject { background: #007bff; color: white; padding: 15px; text-align: center; font-size: 20px; font-weight: bold; border-radius: 10px 10px 0 0; }
                    .content { padding: 20px; font-size: 16px; line-height: 1.5; }
                    .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; }
                    .footer a { color: #007bff; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class='container'>
                   
                    <div class='subject'>
                        Contact Us
                    </div>
                    <div class='content'>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> <a href='mailto:$email'>$email</a></p>
                        <p><strong>Subject:</strong> $subject</p>
                        <p><strong>Message:</strong></p>
                        <p>$message</p>
                    </div>
                    <div class='footer'>
                        <p>Thank you for reaching out I will respond as soon as possible.</p>
                      
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->send();
        echo "<script>alert('Your message has been successfully sent I will get back to you shortly.'); window.location.href='index.html#contact';</script>";
    } catch (Exception $e) {
        echo "<script>alert('There was an issue sending your message. Please try again later.'); window.location.href='index.html#contact';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='index.html#contact';</script>";
}
?>
