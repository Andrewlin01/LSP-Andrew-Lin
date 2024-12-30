<?php
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
$sukses = "";

// Tangkap data jika user datang dari login.php
$nama = isset($_GET['nama']) ? $_GET['nama'] : "";
$username = isset($_GET['username']) ? $_GET['username'] : "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($nama && $username && $password) {
        // Cek apakah username sudah ada
        $sql_check = "SELECT * FROM anggota WHERE username = '$username'";
        $result_check = mysqli_query($koneksi, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Masukkan data ke database
            $sql_insert = "INSERT INTO anggota (nama, username, password) VALUES ('$nama', '$username', '$password')";
            $result_insert = mysqli_query($koneksi, $sql_insert);

            if ($result_insert) {
                $sukses = "Signup berhasil. Anda dapat login sekarang.";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
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
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Signup</h2>

        <?php if ($error) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mt-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($sukses) : ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mt-4">
                <?php echo $sukses; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="mt-6">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama" />
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan username" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan password" />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Signup</button>
        </form>

        <!-- Tombol "Back to Login" -->
        <div class="mt-4 text-center">
            <a href="login.php" class="text-white bg-gray-500 py-2 px-4 rounded-lg hover:bg-gray-600">Back to Login</a>
        </div>
    </div>
</body>

</html>
