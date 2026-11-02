<!DOCTYPE html>
<html>
<head>
    <title>Form Data Mahasiswa</title>
</head>
<body>

<h2>Form Data Mahasiswa</h2>

<form method="POST">

    <label>NIM:</label>
    <input type="text" name="nim">
    <br><br>

    <label>Nama:</label>
    <input type="text" name="nama">
    <br><br>

    <label>Jurusan:</label>
    <select name="jurusan">
        <option value="Sistem Informasi">Sistem Informasi</option>
        <option value="Informatika">Informatika</option>
        <option value="Teknik Komputer">Teknik Komputer</option>
    </select>
    <br><br>

    <button type="submit" name="submit">Kirim</button>

</form>

<?php

if (isset($_POST['submit'])) {

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    echo "<h3>Data Mahasiswa</h3>";
    echo "NIM: " . htmlspecialchars($nim) . "<br>";
    echo "Nama: " . htmlspecialchars($nama) . "<br>";
    echo "Jurusan: " . htmlspecialchars($jurusan) . "<br>";
}

?>

</body>
</html>