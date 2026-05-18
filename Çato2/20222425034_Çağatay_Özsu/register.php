<?php
session_start();

$hata = '';
$basari = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kadi  = trim($_POST['kadi'] ?? '');
    $sifre = trim($_POST['sifre'] ?? '');

    if ($kadi === '' || $sifre === '') {
        $hata = 'Kullanıcı adı ve şifre boş olamaz.';
    } else {
        $usersJson = $_COOKIE['users'] ?? '[]';
        $users = json_decode($usersJson, true);
        if (!is_array($users)) {
            $users = [];
        }

        $varMi = false;
        foreach ($users as $u) {
            if ($u['kadi'] === $kadi) {
                $varMi = true;
                break;
            }
        }

        if ($varMi) {
            $hata = 'Bu kullanıcı adı zaten kayıtlı.';
        } else {
            $users[] = ['kadi' => $kadi, 'sifre' => $sifre];
            setcookie('users', json_encode($users), time() + 86400 * 30, '/');
            $basari = 'Kayıt başarılı, şimdi giriş yapabilirsin.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Üye Ol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>Üye Ol</h2>
    <?php if ($hata): ?>
        <p style="color:red;"><?php echo htmlspecialchars($hata); ?></p>
    <?php endif; ?>
    <?php if ($basari): ?>
        <p style="color:limegreen;"><?php echo htmlspecialchars($basari); ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Kullanıcı Adı:</label><br>
        <input type="text" name="kadi" required><br><br>
        <label>Şifre:</label><br>
        <input type="password" name="sifre" required><br><br>
        <button type="submit">Kayıt Ol</button>
    </form>
    <p>Zaten üye misin? <a href="login.php">Giriş yap</a></p>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
