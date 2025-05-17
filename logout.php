<?php
session_start(); // Memulai sesi untuk memastikan kita bisa mengakses data sesi

// Hapus semua data sesi yang tersimpan
session_unset();

// Hancurkan sesi sepenuhnya
session_destroy();

// Redirect ke halaman login anggota
header("Location: login.php");
exit();
?>