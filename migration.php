<?php

// Koneksi ke database
require_once 'database.php';
$pdo = connectDatabase();

// Buat tabel tickets
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    ticket_code VARCHAR(10) NOT NULL,
    status VARCHAR(20) DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

$pdo->exec($sqlCreateTable);

// Tambahkan data dummy secara otomatis
$sqlInsertDummyData = "INSERT INTO tickets (event_id, ticket_code) VALUES (:event_id, :ticket_code)";

$stmt = $pdo->prepare($sqlInsertDummyData);

// Buat 200 data dummy
for ($i = 0; $i < 200; $i++) {
    $event_id = rand(1, 10); // Misalnya, event_id dipilih secara acak antara 1 dan 10
    $ticket_code = generateTicketCode(); // Generate kode tiket acak
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':ticket_code', $ticket_code);
    $stmt->execute();
}

function generateTicketCode() {
    $prefix = 'LCS';
    $random = generateRandomAlphaNumeric(7);
    return $prefix . $random;
}

function generateRandomAlphaNumeric($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
