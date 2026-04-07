<?php
function clean($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

$countryCode = clean($_POST['country_code'] ?? '');
$phoneRaw    = $_POST['phone'] ?? '';
$phone = preg_replace('/[^0-9]/', '', $phoneRaw);
if (strlen($phone) < 7 || strlen($phone) > 15) {
    die("Invalid phone number");
}
$fullPhone = $countryCode . ' ' . $phone;
$firstName   = clean($_POST['first_name'] ?? '');
$lastName    = clean($_POST['last_name'] ?? '');
$email       = clean($_POST['email'] ?? '');
$country     = clean($_POST['country'] ?? '');
$residence   = clean($_POST['residence_type'] ?? '');
$contactPref = clean($_POST['contact_preference'] ?? '');
$source      = clean($_POST['heard_about'] ?? '');
$broker      = clean($_POST['broker'] ?? 'No');

if (!$firstName || !$lastName || !$email || !$phone || !$source || !$broker || !$country) {
    die("Missing data");
}

$to = 'sales@paradisebreeze.com';
$subject = 'New Website Form Submission';

$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = "
New Lead Submission

First Name: $firstName
Last Name: $lastName
Email: $email
Phone: $fullPhone
Country: $country
Heard About Us: $source
Broker: $broker
";

$headers = "From: Website Inquiry <no-reply@paradisebreeze.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $message, $headers)) {
    header('Location: thank-you.html');
    exit;
} else {
    echo 'Mail sending failed.';
}
