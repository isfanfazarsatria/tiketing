<?php

// Koneksi ke database
require_once 'database.php';
$pdo = connectDatabase();

// Tangani permintaan HTTP POST atau PUT
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Baca data dari body permintaan
    $data = json_decode(file_get_contents("php://input"), true);

    // Periksa apakah data yang diperlukan ada
    if (!isset($data['event_id']) || !isset($data['ticket_code']) || !isset($data['status'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing event_id, ticket_code, or status parameter."));
        exit();
    }

    $event_id = $data['event_id'];
    $ticket_code = $data['ticket_code'];
    $status = $data['status'];

    // Perbarui status tiket berdasarkan event_id dan ticket_code
    $stmt = $pdo->prepare("UPDATE tickets SET status = :status, updated_at = NOW() WHERE event_id = :event_id AND ticket_code = :ticket_code");
    $stmt->execute(array(':status' => $status, ':event_id' => $event_id, ':ticket_code' => $ticket_code));

    // Periksa apakah tiket berhasil diperbarui
    if ($stmt->rowCount() > 0) {
        // Jika berhasil, kembalikan respons sukses
        http_response_code(200);
        echo json_encode(array(
            "ticket_code" => $ticket_code,
            "status" => $status,
            "updated_at" => date('Y-m-d H:i:s')
        ));
    } else {
        // Jika tidak, kembalikan pesan tiket tidak ditemukan
        http_response_code(404);
        echo json_encode(array("message" => "Ticket not found or invalid."));
    }
} else {
    // Tanggapi metode HTTP selain POST atau PUT
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
