<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php'; 

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'amiraazlf@gmail.com';
    $mail->Password = 'eirp tyha vdma brsz';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587; 

    // Recipients
    $mail->setFrom('mirahasiaa@gmail.com', 'Mailer'); 
    $mail->addAddress('amiraazlf@gmail.com', 'User'); 
    $mail->addAddress('amira.23120@mhs.unesa.ac.id'); 
    $mail->addAddress('rifa.23142@mhs.unesa.ac.id');
    $mail->addAddress('farrel.23121@mhs.unesa.ac.id');
    $mail->addReplyTo('amiraazlf@gmail.com', 'Information');

$mail->isHTML(true);
$mail->Subject = 'Undangan Spesial untuk Tamu Terhormat';
$mail->Body = '
<html>
<head>
    <title>Undangan Acara</title>
</head>
<body>
    <h1 style="color: #2E86C1;">Halo Tamu Terhormat!</h1>
    <p>Dengan senang hati kami mengundang Anda untuk menghadiri acara spesial kami:</p>
    
    <h2>🎉 Nama Acara 🎉</h2>
    <p><strong>Tanggal:</strong> 31 Desember 2024<br>
       <strong>Waktu:</strong> 19:00 WIB - Selesai<br>
       <strong>Tempat:</strong> Grand Ballroom, Hotel Mewah, Jl. Raya No. 1, Jakarta</p>
    
    <p>Acara ini akan diisi dengan berbagai kegiatan menarik, termasuk hiburan live, makanan lezat, dan kesempatan untuk berjejaring dengan tamu lainnya.</p>
    
    <p>Jangan lewatkan kesempatan ini! Kami sangat berharap Anda dapat hadir.</p>
    
    <p>Silakan konfirmasi kehadiran Anda paling lambat tanggal 20 Desember 2024 melalui email ini.</p>

    <p>Terima kasih dan sampai jumpa!</p>
    
    <footer style="margin-top: 20px;">
        <p>Salam hangat,</p>
        <p><strong>Tim Acara</strong><br>
           Hotel Mewah</p>
    </footer>
</body>
</html>
';
$mail->AltBody = 'Halo Tamu Terhormat! Kami mengundang Anda untuk menghadiri Gala Malam Tahun Baru pada 31 Desember 2024 di Grand Ballroom, Hotel Mewah, Jakarta. Silakan konfirmasi kehadiran Anda. Terima kasih!';

$mail->send();
echo 'Undangan telah berhasil dikirim!';

} catch (Exception $e) {
    echo "Invitation could not be sent. Error: {$mail->ErrorInfo}";
}
?>

