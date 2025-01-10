<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Buku</title>
</head>
<body>
    <h1><?= isset($buku) ? "Edit Buku" : "Tambah Buku" ?></h1>
    <form method="POST">
        <input type="text" name="nama_buku" placeholder="Nama Buku" value="<?= $buku['nama_buku'] ?? '' ?>">
        <input type="text" name="penulis" placeholder="Penulis" value="<?= $buku['penulis'] ?? '' ?>">
        <input type="text" name="penerbit_buku" placeholder="Penerbit" value="<?= $buku['penerbit_buku'] ?? '' ?>">
        <input type="text" name="isbn" placeholder="ISBN" value="<?= $buku['isbn'] ?? '' ?>">
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
