<?php
require_once '../config/database.php';
require_once '../app/models/Book.php';

$error = "";
$sukses = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengecek apakah username sudah ada
    $bookModel = new Book($koneksi);
    $existingUser = $bookModel->getByUserName($username);

    if ($existingUser) {
        $error = "Username sudah digunakan, silakan pilih yang lain.";
    } else {
        // Menyimpan user baru ke dalam database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password
        $data = [
            'nama' => $nama,
            'username' => $username,
            'password' => $hashedPassword,
        ];

        if ($bookModel->insertUsername($data)) {
            $sukses = "Berhasil signup, silakan login.";
        } else {
            $error = "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Signup</h2>

        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mt-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($sukses): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mt-4">
                <?php echo $sukses; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="mt-6">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama" />
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan username" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan password" />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Signup</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-700">Sudah punya akun?</p>
            <a href="login.php" class="text-blue-500 hover:underline font-bold">Login</a>
        </div>
    </div>
</body>

</html>
