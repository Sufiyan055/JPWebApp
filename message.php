<?php
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);
$file = $_FILES['pdf'];

if (!empty($email) && !empty($message)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $receiver = "sufiyan007882@gmail.com";
        $subject = "Job Application From: $name <$email>";
        $body = "Name: $name\nEmail: $email\nPhone: $phone \n\nMessage:\n$message\n\nRegards,\n$name";
        $headers = "From: $email";
        
        $boundary = md5(time());
        $headers .= "\nMIME-Version: 1.0";
        $headers .= "\nContent-Type: multipart/mixed; boundary=\"$boundary\"";
        
        $messageBody = "--$boundary\n";
        $messageBody .= "Content-Type: text/plain; charset=UTF-8\n";
        $messageBody .= "Content-Transfer-Encoding: 7bit\n\n";
        $messageBody .= "$body\n";
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileContent = file_get_contents($file['tmp_name']);
            $fileEncoded = chunk_split(base64_encode($fileContent));
            $fileName = $file['name'];
            
            $messageBody .= "--$boundary\n";
            $messageBody .= "Content-Type: application/pdf; name=\"$fileName\"\n";
            $messageBody .= "Content-Transfer-Encoding: base64\n";
            $messageBody .= "Content-Disposition: attachment; filename=\"$fileName\"\n\n";
            $messageBody .= "$fileEncoded\n";
        }
        
        $messageBody .= "--$boundary--";
        
        if (mail($receiver, $subject, $messageBody, $headers)) {
            echo "Your message has been sent with the attachment.";
        } else {
            echo "Sorry, failed to send your message!";
        }
    } else {
        echo "Enter a valid email address!";
    }
} else {
    echo "Email and message field is required!";
}
?>
