<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "library_system";

// Koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi ke database gagal");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($nama && $username && $password) {
        // Query untuk memeriksa apakah ada Nama yang cocok
        $check_nama = "SELECT * FROM anggota WHERE nama = '$nama'";
        $result_nama = mysqli_query($koneksi, $check_nama);

        if (mysqli_num_rows($result_nama) > 0) {
            $row = mysqli_fetch_assoc($result_nama);
            if ($row['username'] !== $username) {
                // Nama ditemukan tetapi Username berbeda, arahkan ke signup.php
                header("Location: signup.php?nama=$nama&username=$username");
                exit();
            }
        }

        // Query untuk memeriksa user berdasarkan nama, username, dan password
        $sql = "SELECT * FROM anggota WHERE nama = '$nama' AND username = '$username' AND password = '$password'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Login berhasil, arahkan ke loading.php
            $_SESSION['username'] = $username;
            header("Location: loading.php");
            exit();
        } else {
            // Pengguna tidak ditemukan, arahkan ke signup.php
            $error = "Nama dan username tidak ditemukan. Silakan signup.";
        }
    } else {
        $error = "Silakan isi semua field.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <!-- Welcome Message -->
        <h1 class="text-3xl font-bold text-gray-800 text-center">
            Welcome To<br>
            <span class="text-4xl font-extrabold text-blue-600">Andrew's Library</span>
        </h1>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mt-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="" method="POST" class="mt-6">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama" />
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan username" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan password" />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Login</button>
        </form>

        <!-- Signup Link -->
        <div class="mt-4 text-center">
            <p class="text-gray-700">Belum punya akun?</p>
            <a href="signup.php" class="text-blue-500 hover:underline font-bold">Signup</a>
        </div>
    </div>
</body>

</html>