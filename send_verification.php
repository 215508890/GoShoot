<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // 需要安裝 PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$verificationLink = $data['link'];

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // 或你的 SMTP 伺服器
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com';
    $mail->Password = 'your-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    $mail->setFrom('noreply@goshoot.com', '天馬陀螺戰榜');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = '驗證您的帳號';
    $mail->Body = "請點擊此連結驗證您的帳號：<a href='$verificationLink'>$verificationLink</a>";
    
    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}
?>
