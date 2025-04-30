<?php
session_start();
require 'db.php';

$error = '';
$mode = $_POST['mode'] ?? 'login';

$admin_user = 'admin';
$admin_pass = 'adminpass';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($mode === 'register') {
        $first = trim($_POST['first_name'] ?? '');
        $last = trim($_POST['last_name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $zipcode = null; // or hardcode a valid one like 12345 if inserted

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username already exists.";
        } else {
            $hashed = hash('sha256', $password);
            $stmt = $pdo->prepare("INSERT INTO Users (username, first_name, last_name, address, zipcode, phone, password)
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $first, $last, $address, $zipcode, $phone, $hashed]);

            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header('Location: index.php');
            exit;
        }
    } else {
        // Check hardcoded admin first
        if ($username === $admin_user && $password === $admin_pass) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $admin_user;
            $_SESSION['role'] = 'admin';
            header('Location: index.php');
            exit;
        }

        // Check database users
        $hashed = hash('sha256', $password);
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $hashed]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $mode === 'register' ? 'Register' : 'Login' ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 5% auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .toggle-link {
            margin-top: 20px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><?= $mode === 'register' ? 'Register' : 'Login' ?></h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="hidden" name="mode" value="<?= htmlspecialchars($mode) ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <?php if ($mode === 'register'): ?>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="text" name="phone" placeholder="Phone" required>
            <?php endif; ?>

            <button type="submit"><?= $mode === 'register' ? 'Register' : 'Login' ?></button>
        </form>

        <div class="toggle-link">
            <form method="POST">
                <input type="hidden" name="mode" value="<?= $mode === 'register' ? 'login' : 'register' ?>">
                <button type="submit">
                    <?= $mode === 'register' ? 'Already have an account? Login' : 'Create an account' ?>
                </button>
            </form>
        </div>
    </div>
</body>
</html>