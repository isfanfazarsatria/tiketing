<?php

// Koneksi ke database
require_once 'database.php';
$pdo = connectDatabase();

// Tangani permintaan HTTP GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Periksa apakah parameter event_id dan ticket_code diberikan
    if (!isset($_GET['event_id']) || !isset($_GET['ticket_code'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing event_id or ticket_code parameter."));
        exit();
    }

    $event_id = $_GET['event_id'];
    $ticket_code = $_GET['ticket_code'];

    // Cari status tiket berdasarkan event_id dan ticket_code
    $stmt = $pdo->prepare("SELECT status FROM tickets WHERE event_id = :event_id AND ticket_code = :ticket_code");
    $stmt->execute(array(':event_id' => $event_id, ':ticket_code' => $ticket_code));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Jika tiket ditemukan, kembalikan status
        http_response_code(200);
        echo json_encode(array("ticket_code" => $ticket_code, "status" => $row['status']));
    } else {
        // Jika tiket tidak ditemukan, kembalikan pesan tiket tidak valid
        http_response_code(404);
        echo json_encode(array("message" => "Ticket not found or invalid."));
    }
} else {
    // Tanggapi metode HTTP selain GET
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
