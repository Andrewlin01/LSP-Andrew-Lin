<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "library_system";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi ke database gagal");
}

$error = "";

// Login untuk admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi data admin
    $sql = "SELECT * FROM admin WHERE nama = '$nama' AND username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['is_admin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect ke halaman admin
        exit;
    } else {
        $error = "Nama, Username, atau Password admin salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-6 bg-white rounded-lg shadow-lg w-full max-w-sm">
        <!-- Welcome Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Andrew's Library</h1>

        <?php if ($error) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Admin Login Form -->
        <form action="" method="POST" class="space-y-4">
            <div class="flex flex-col">
                <label for="nama" class="text-left text-gray-700 font-medium">Nama</label>
                <input type="text" name="nama" id="nama" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Nama Admin">
            </div>
            <div class="flex flex-col">
                <label for="username" class="text-left text-gray-700 font-medium">Username</label>
                <input type="text" name="username" id="username" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Username Admin">
            </div>
            <div class="flex flex-col">
                <label for="password" class="text-left text-gray-700 font-medium">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Password Admin">
            </div>
            <button type="submit" 
                    class="w-auto bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 mt-4">
                Login as Admin
            </button>
        </form>

        <!-- Customer Login -->
        <div class="mt-6">
            <a href="pinjam.php">
                <button class="bg-green-500 text-white px-6 py-2 rounded-full hover:bg-green-700 transition duration-300">
                    Continue as Customer
                </button>
            </a>
        </div>
    </div>
</body>

</html>
