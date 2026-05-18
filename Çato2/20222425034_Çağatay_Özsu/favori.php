<?php
session_start();
if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$kullanici    = $_SESSION['kadi'];
$cookieFavori = 'favori_oyuncu_' . $kullanici;

$hata  = '';
$mesaj = '';

// OYUNCU VERİLERİ
$ilk11 = [
    [ 'ad' => 'Uğurcan Çakır', 'mevki' => 'Kaleci', 'numara'=> 1, 'foto' => 'img/ugurcan.jpg', 'mac' => 13, 'gol' => 0, 'asist' => 0 ],
    [ 'ad' => 'Davinson Sánchez', 'mevki' => 'Stoper', 'numara'=> 6, 'foto' => 'img/sanchez.jpg', 'mac' => 10, 'gol' => 2, 'asist' => 1 ],
    [ 'ad' => 'Abdülkerim Bardakcı', 'mevki' => 'Stoper', 'numara'=> 42, 'foto' => 'img/abdulkerim.webp', 'mac' => 18, 'gol' => 2, 'asist' => 1 ],
    [ 'ad' => 'Ismail Jakobs', 'mevki' => 'Sol Bek', 'numara'=> 4, 'foto' => 'img/jakobs.webp', 'mac' => 9, 'gol' => 0, 'asist' => 1 ],
    [ 'ad' => 'Victor Osimhen', 'mevki' => 'Santrafor', 'numara'=> 45, 'foto' => 'img/osimhen.jpg', 'mac' => 9, 'gol' => 8, 'asist' => 4 ],
    [ 'ad' => 'Lucas Torreira', 'mevki' => 'Ön Libero', 'numara'=> 34, 'foto' => 'img/torreira.webp', 'mac' => 16, 'gol' => 1, 'asist' => 4 ],
    [ 'ad' => 'Gabriel Sara', 'mevki' => 'Orta Saha', 'numara'=> 8, 'foto' => 'img/sara.jpg', 'mac' => 16, 'gol' => 2, 'asist' => 6 ],
    [ 'ad' => 'İlkay Gündoğan', 'mevki' => 'Orta Saha', 'numara'=> 20, 'foto' => 'img/ilkay.jpg', 'mac' => 15, 'gol' => 1, 'asist' => 1 ],
    [ 'ad' => 'Leroy Sané', 'mevki' => 'Kanat', 'numara'=> 10, 'foto' => 'img/sane.jpg', 'mac' => 11, 'gol' => 3, 'asist' => 0 ],
    [ 'ad' => 'Barış Alper Yılmaz', 'mevki' => 'Kanat', 'numara'=> 53, 'foto' => 'img/baris.jpg', 'mac' => 17, 'gol' => 4, 'asist' => 1 ],
    [ 'ad' => 'Roland Sallai', 'mevki' => 'Kanat / Forvet', 'numara'=> 7, 'foto' => 'img/sallai.webp', 'mac' => 6, 'gol' => 0, 'asist' => 0 ],
];

$yedekler = [
    [ 'ad' => 'Günay Güvenç', 'mevki' => 'Kaleci', 'numara'=> 19, 'foto' => 'img/gunay.jpg', 'mac' => 3, 'gol' => 0, 'asist' => 0 ],
    [ 'ad' => 'Eren Elmalı', 'mevki' => 'Sol Bek', 'numara'=> 17, 'foto' => 'img/eren.jpg', 'mac' => 13, 'gol' => 3, 'asist' => 1 ],
    [ 'ad' => 'Mario Lemina', 'mevki' => 'Orta Saha', 'numara'=> 99, 'foto' => 'img/lemima.jpg', 'mac' => 11, 'gol' => 1, 'asist' => 1 ],
    [ 'ad' => 'Yunus Akgün', 'mevki' => 'Kanat', 'numara'=> 11, 'foto' => 'img/yunus.webp', 'mac' => 16, 'gol' => 6, 'asist' => 2 ],
    [ 'ad' => 'Kaan Ayhan', 'mevki' => 'Sağ Bek', 'numara'=> 23, 'foto' => 'img/kaan.jpg', 'mac' => 16, 'gol' => 0, 'asist' => 1 ],
    [ 'ad' => 'Mauro Icardi', 'mevki' => 'Santrafor', 'numara'=> 9, 'foto' => 'img/icardi.jpg', 'mac' => 14, 'gol' => 8, 'asist' => 2 ],
    [ 'ad' => 'Wilfred Singo', 'mevki' => 'Sağ bek/Stoper', 'numara'=> 90, 'foto' => 'img/singo.jpg', 'mac' => 10, 'gol' => 1, 'asist' => 0 ],
];

$tumOyuncular = array_merge($ilk11, $yedekler);

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favori = trim($_POST['favori'] ?? '');

    if ($favori === '') {
        $hata = 'Oyuncu seç.';
    } else {
        setcookie($cookieFavori, $favori, time() + 86400 * 30, '/');
        $mesaj = 'Favori oyuncun kaydedildi.';
    }
}

$mevcutFavori = $_COOKIE[$cookieFavori] ?? '';

// Seçilen oyuncuyu bul
$secilenOyuncu = null;
if ($mevcutFavori !== '') {
    foreach ($tumOyuncular as $oyuncu) {
        if ($oyuncu['ad'] === $mevcutFavori) {
            $secilenOyuncu = $oyuncu;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Favori Oyuncum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>Favori Oyuncum</h2>

    <?php if ($hata): ?>
        <p style="color:red;"><?php echo htmlspecialchars($hata); ?></p>
    <?php endif; ?>

    <?php if ($mesaj): ?>
        <p style="color:limegreen;"><?php echo htmlspecialchars($mesaj); ?></p>
    <?php endif; ?>

    <?php if ($secilenOyuncu): ?>
        <div class="favori-container">
            <div class="oyuncu-karti" style="width:220px; margin:20px auto;">
                <img src="<?php echo htmlspecialchars($secilenOyuncu['foto']); ?>" alt="<?php echo htmlspecialchars($secilenOyuncu['ad']); ?>">
                <h4><?php echo htmlspecialchars($secilenOyuncu['ad']); ?></h4>
                <p><strong>#<?php echo $secilenOyuncu['numara']; ?></strong></p>
                <p><?php echo htmlspecialchars($secilenOyuncu['mevki']); ?></p>
                <div class="istatistik">⚽ <?php echo $secilenOyuncu['gol']; ?> | 🎯 <?php echo $secilenOyuncu['asist']; ?> | 🏟️ <?php echo $secilenOyuncu['mac']; ?></div>
            </div>
        </div>
    <?php endif; ?>

    <form method="post" class="favori-form">
        <label style="display:block; margin-bottom:15px;">Favori oyuncu seç:</label>
        <select name="favori" required>
            <option value="">-- Oyuncu Seç --</option>
            <?php foreach ($tumOyuncular as $oyuncu): ?>
                <option value="<?php echo htmlspecialchars($oyuncu['ad']); ?>" <?php echo ($mevcutFavori === $oyuncu['ad']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($oyuncu['ad']); ?> (#<?php echo $oyuncu['numara']; ?>)
                </option>
            <?php endforeach; ?>
        </select><br><br>
        <button type="submit">Kaydet</button>
    </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
