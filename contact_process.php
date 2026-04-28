<?php

require_once "app/dat/DataAccess.php";

// Get DAO instance
$model = DataAccess::getModel();

// Get form data 
$name = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['telefono'] ?? '';
$message = $_POST['mensaje'] ?? '';

// Save in DB
$result = $model->addMessage($name, $email, $phone, $message);

// Send email alert 
$to = "nuriamormag2@gmail.com";
$subject = "New Contact Message - Shooting Mood";

$body = "
You have received a new message:

Name: $name
Email: $email
Phone: $phone

Message:
$message
";

$headers = "From: $email";

// Send email
mail($to, $subject, $body, $headers);

// Answer to user
if ($result) {
    echo "Message sent successfully.";
} else {
    echo "Error sending message.";
}