```markdown
# Tiketing System

Sistem manajemen tiket untuk acara.

## Deskripsi

Proyek ini adalah aplikasi sederhana yang memungkinkan pengguna untuk mengelola tiket acara. Aplikasi ini memiliki fitur untuk menghasilkan kode tiket unik, memeriksa status kode tiket, dan mengubah status kode tiket.

## Setup

1. Pastikan Anda telah menginstal PHP dan MySQL.
2. Clone repositori ini ke dalam direktori lokal Anda:

    ```bash
    git clone https://github.com/isfanfazarsatria/tiketing.git
    ```

3. Masuk ke direktori proyek:

    ```bash
    cd tiketing
    ```

4. Impor database dengan menjalankan perintah migrasi:

    ```bash
    php migration.php
    ```
    note: saya melakukan random dummy data untuk migrasi data ke database.

5. Setelah migrasi selesai, Anda dapat menjalankan server web lokal Anda (misalnya, Apache) dan akses aplikasi di browser Anda.

## Penggunaan

### 1. Generate Ticket

Untuk membuat sejumlah kode tiket berdasarkan event ID, jalankan perintah berikut di terminal:

```bash
php generate-ticket.php {event_id} {total_ticket}
```

Contoh:

```bash
php generate-ticket.php 2 3000
```

### 2. Check Ticket Status

Untuk memeriksa status kode tiket, kirimkan permintaan HTTP GET ke endpoint API berikut:

```
GET http://localhost/tiketing/check-ticket-status.php?event_id={event_id}&ticket_code={ticket_code}
```

Contoh:

```
GET http://localhost/tiketing/check-ticket-status.php?event_id=2&ticket_code=LCS01AHB89
```

### 3. Update Ticket Status

Untuk mengubah status kode tiket, kirimkan permintaan HTTP POST atau PUT dengan data JSON ke endpoint API berikut:

```
POST http://localhost/tiketing/update-ticket-status.php
```

Contoh Body (JSON):

```json
{
    "event_id": 2,
    "ticket_code": "LCS01AHB89",
    "status": "claimed"
}
```

Pastikan untuk mengganti nilai `event_id`, `ticket_code`, dan `status` sesuai dengan kebutuhan Anda.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
```

Pastikan untuk mengganti placeholder seperti `{event_id}` atau `{total_ticket}` dengan nilai yang sesuai, dan sesuaikan instruksi setup dan penggunaan dengan kebutuhan dan struktur proyek Anda.