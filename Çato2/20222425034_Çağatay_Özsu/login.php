<?php
session_start();

$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kadi  = trim($_POST['kadi'] ?? '');
    $sifre = trim($_POST['sifre'] ?? '');
    $beniHatirla = !empty($_POST['beni_hatirla']);

    if ($kadi === '' || $sifre === '') {
        $hata = 'Kullanıcı adı ve şifre boş olamaz.';
    } else {
        $usersJson = $_COOKIE['users'] ?? '[]';
        $users = json_decode($usersJson, true);
        if (!is_array($users)) {
            $users = [];
        }

        $bulundu = false;
        foreach ($users as $u) {
            if ($u['kadi'] === $kadi && $u['sifre'] === $sifre) {
                $bulundu = true;
                break;
            }
        }

        if ($bulundu) {
            $_SESSION['login'] = true;
            $_SESSION['kadi']  = $kadi;

            // "Beni Hatırla" seçildiyse
            if ($beniHatirla) {
                setcookie('remember_user', $kadi, time() + 86400 * 30, '/');
                setcookie('remember_pass', $sifre, time() + 86400 * 30, '/');
            } else {
                // Değilse eski cookie'leri sil
                setcookie('remember_user', '', time() - 3600, '/');
                setcookie('remember_pass', '', time() - 3600, '/');
            }

            header('Location: index.php');
            exit;
        } else {
            $hata = 'Kullanıcı adı veya şifre hatalı ya da kayıtlı değilsin.';
        }
    }
}

// Eski "Beni Hatırla" verilerini formu doldururken kullan
$rememberUser = $_COOKIE['remember_user'] ?? '';
$rememberPass = $_COOKIE['remember_pass'] ?? '';
$isRemembered = !empty($rememberUser);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>Giriş Yap</h2>

    <?php if ($hata): ?>
        <p style="color:red;"><?php echo htmlspecialchars($hata); ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Kullanıcı Adı:</label><br>
        <input type="text" name="kadi" value="<?php echo htmlspecialchars($rememberUser); ?>" required><br><br>

        <label>Şifre:</label><br>
        <input type="password" name="sifre" value="<?php echo htmlspecialchars($rememberPass); ?>" required><br><br>

        <label style="display:flex; align-items:center; font-weight:normal; color:#ddd;">
            <input type="checkbox" name="beni_hatirla" <?php echo $isRemembered ? 'checked' : ''; ?> style="width:auto; margin-right:8px; cursor:pointer;">
            Beni Hatırla
        </label><br><br>

        <button type="submit">Giriş Yap</button>
    </form>

    <p style="margin-top:15px;">
        Henüz üye değil misin? <a href="register.php">Kayıt ol</a>
    </p>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
