<?php

// Sertakan file database.php
require_once 'database.php';

// Tangani argumen yang diberikan
if ($argc != 3) {
    echo "Usage: php generate-ticket.php {event_id} {total_ticket}\n";
    exit(1);
}

$event_id = $argv[1];
$total_ticket = $argv[2];

// Generate kode tiket sesuai dengan format yang diberikan
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

try {
    // Koneksi ke database menggunakan fungsi yang sudah dibuat di file database.php
    $pdo = connectDatabase();

    $stmt = $pdo->prepare("INSERT INTO tickets (event_id, ticket_code) VALUES (:event_id, :ticket_code)");

    for ($i = 0; $i < $total_ticket; $i++) {
        $ticket_code = generateTicketCode();
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':ticket_code', $ticket_code);
        $stmt->execute();
    }

    echo "Successfully generated $total_ticket ticket codes for event $event_id.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
