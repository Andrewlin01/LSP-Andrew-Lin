<?php

class Admin {
    private $koneksi;

    // Konstruktor untuk menginisialisasi koneksi database
    public function __construct($db) {
        if (!$db) {
            die("Koneksi database gagal: " . $db->connect_error);
        }
        $this->koneksi = $db; // Koneksi diteruskan ke properti $this->koneksi
    }

    // Fungsi untuk memverifikasi login admin
    public function authenticateAdmin($username, $password) {
        // Query untuk mengambil data admin berdasarkan username
        $query = "SELECT * FROM admin WHERE username = ?";

        // Persiapkan query
        $stmt = $this->koneksi->prepare($query);

        // Cek apakah persiapan query berhasil
        if ($stmt === false) {
            die('MySQL error: ' . $this->koneksi->error);
        }

        // Binding parameter untuk username
        $stmt->bind_param("s", $username);

        // Jalankan query
        $stmt->execute();

        // Ambil hasil query
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // Verifikasi password jika admin ditemukan
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;  // Jika login berhasil, kembalikan data admin
        }

        return null;  // Jika login gagal
    }
}
?>
