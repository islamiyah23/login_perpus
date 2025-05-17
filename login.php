<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM anggota WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['id_anggota'] = $user['id_anggota'];
            $_SESSION['nama'] = $user['nama_anggota'];
            $_SESSION['email'] = $user['email'];

            // Arahkan ke dashboard anggota
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Anggota Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f4e6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            background-color: #f0fff0;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .btn-green {
            background-color: #81c784;
            color: white;
            border: none;
        }

        .btn-green:hover {
            background-color: #66bb6a;
        }

        .form-label {
            color: #388e3c;
        }

        .info-text {
            font-size: 0.9rem;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login Anggota</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <button type="submit" class="btn btn-green w-100">Login</button>
            <p class="info-text text-center mt-3">Masukkan email dan password anggota perpustakaan Anda</p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>