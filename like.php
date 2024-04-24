<?php
session_start();
include "koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, arahkan ke halaman login
    $_SESSION['message'] = "Anda harus login untuk memberikan like.";
    header('Location: login.php');
    exit();
}

$foto_id = $_GET['foto_id'];
$user_id = $_SESSION['user']['user_id'];
$tanggal_like = date('Y-m-d');

$q = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id = $foto_id AND user_id = $user_id");

if (mysqli_num_rows($q) > 0 ) {
    // Jika sudah memberikan like, hapus like
    mysqli_query($koneksi, "DELETE FROM like_foto WHERE foto_id = $foto_id AND user_id = $user_id");
    $_SESSION['message'] = "Unlike berhasil.";
} else {
    // Jika belum memberikan like, tambahkan like
    mysqli_query($koneksi, "INSERT INTO like_foto VALUES ('', '$foto_id', '$user_id', '$tanggal_like')");
    $_SESSION['message'] = "Like berhasil.";
}

// Redirect kembali ke halaman sebelumnya dengan pesan konfirmasi
header('Location:' . $_SERVER['HTTP_REFERER']); 
exit();
?>