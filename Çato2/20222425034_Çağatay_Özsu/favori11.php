<?php
session_start();
if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$kullanici = $_SESSION['kadi']; // kullanıcıya özel cookie
$cookieNameFavori11 = 'favori11_' . $kullanici;

// Oyuncu isimleri + mevki + foto (oyuncular.php ile uyumlu olmalı)
$oyuncular = [
    'Uğurcan Çakır'        => ['mevki' => 'Kaleci',            'foto' => 'img/ugurcan.jpg'],
    'Davinson Sánchez'     => ['mevki' => 'Stoper',            'foto' => 'img/sanchez.jpg'],
    'Abdülkerim Bardakcı'  => ['mevki' => 'Stoper',            'foto' => 'img/abdulkerim.webp'],
    'Ismail Jakobs'        => ['mevki' => 'Sol Bek',           'foto' => 'img/jakobs.webp'],
    'Victor Osimhen'       => ['mevki' => 'Santrafor',         'foto' => 'img/osimhen.jpg'],
    'Lucas Torreira'       => ['mevki' => 'Ön Libero',         'foto' => 'img/torreira.webp'],
    'Gabriel Sara'         => ['mevki' => 'Orta Saha',         'foto' => 'img/sara.jpg'],
    'İlkay Gündoğan'       => ['mevki' => 'Orta Saha',         'foto' => 'img/ilkay.jpg'],
    'Leroy Sané'           => ['mevki' => 'Kanat',             'foto' => 'img/sane.jpg'],
    'Barış Alper Yılmaz'   => ['mevki' => 'Kanat / Forvet',    'foto' => 'img/baris.jpg'],
    'Roland Sallai'        => ['mevki' => 'Kanat / Forvet',    'foto' => 'img/sallai.webp'],
    'Günay Güvenç'         => ['mevki' => 'Kaleci',            'foto' => 'img/gunay.jpg'],
    'Eren Elmalı'          => ['mevki' => 'Sol Bek',           'foto' => 'img/eren.jpg'],
    'Mario Lemina'         => ['mevki' => 'Orta Saha',         'foto' => 'img/lemima.jpg'],
    'Yunus Akgün'          => ['mevki' => 'Kanat',             'foto' => 'img/yunus.webp'],
    'Kaan Ayhan'           => ['mevki' => 'Sağ Bek',           'foto' => 'img/kaan.jpg'],
    'Mauro Icardi'         => ['mevki' => 'Santrafor',         'foto' => 'img/icardi.jpg'],
    'Wilfred Singo'        => ['mevki' => 'Sağ bek/Stoper',    'foto' => 'img/singo.jpg'],
];

// Bu oturumdaki geçici favori 11 listesi
if (!isset($_SESSION['favori11_temp']) || !is_array($_SESSION['favori11_temp'])) {
    $_SESSION['favori11_temp'] = [];
}

$mesaj = '';

// Oyuncu ekleme / kaydetme / temizleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Oyuncu Ekle
    if (isset($_POST['ekle'])) {
        $secilen = $_POST['oyuncu'] ?? '';

        if ($secilen === '' || !array_key_exists($secilen, $oyuncular)) {
            $mesaj = 'Lütfen listeden geçerli bir oyuncu seç.';
        } elseif (in_array($secilen, $_SESSION['favori11_temp'], true)) {
            $mesaj = 'Bu oyuncu zaten favori 11\'inde var.';
        } elseif (count($_SESSION['favori11_temp']) >= 11) {
            $mesaj = 'Zaten 11 oyuncu seçtin. Yeni eklemek için birini çıkarabilirsin.';
        } else {
            $_SESSION['favori11_temp'][] = $secilen;
            $mesaj = 'Oyuncu eklendi: ' . htmlspecialchars($secilen);
        }
    }

    // 2) 11'i Kaydet
    if (isset($_POST['kaydet'])) {
        if (count($_SESSION['favori11_temp']) === 0) {
            $mesaj = 'Önce en az bir oyuncu eklemelisin.';
        } else {
            // Kullanıcıya özel favori 11 cookie'si
            setcookie($cookieNameFavori11, json_encode($_SESSION['favori11_temp'], JSON_UNESCAPED_UNICODE), time() + 3600 * 24 * 7);
            $mesaj = 'Favori 11\'in kaydedildi.';
        }
    }

    // 3) Temizle
    if (isset($_POST['temizle'])) {
        $_SESSION['favori11_temp'] = [];
        $mesaj = 'Geçici favori 11 listesi temizlendi.';
    }

    // POST–Redirect–GET
    header('Location: favori11.php');
    exit;
}

// Kalıcı kayıtlı favori 11 (kullanıcıya özel cookie)
$kayitliFavori11 = [];
if (!empty($_COOKIE[$cookieNameFavori11])) {
    $data = json_decode($_COOKIE[$cookieNameFavori11], true);
    if (is_array($data)) {
        $kayitliFavori11 = $data;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Favori 11'im</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h2>Favori 11'ini Oluştur</h2>

    <p>Listeden tek tek oyuncu seçip <strong>Oyuncu Ekle</strong> butonuna basarak kendi favori 11'ini oluşturabilirsin.</p>

    <!-- Oyuncu seçme formu -->
    <form method="post" style="margin-top:15px;">
        <label>Oyuncu seç:
            <select name="oyuncu">
                <option value="">Seçiniz...</option>
                <?php foreach ($oyuncular as $isim => $bilgi): ?>
                    <option value="<?php echo htmlspecialchars($isim); ?>">
                        <?php echo htmlspecialchars($isim . ' - ' . $bilgi['mevki']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" name="ekle">Oyuncu Ekle</button>
        <button type="submit" name="kaydet">11'i Kaydet</button>
        <button type="submit" name="temizle">Temizle</button>
    </form>

    <?php if ($mesaj): ?>
        <p style="margin-top:10px;"><?php echo htmlspecialchars($mesaj); ?></p>
    <?php endif; ?>

    <!-- Bu oturumdaki geçici favori 11 -->
    <?php if (!empty($_SESSION['favori11_temp'])): ?>
        <h3 class="player-section-title" style="margin-top:25px;">Bu oturumda seçtiğin oyuncular (Geçici Favori 11)</h3>
        <div class="player-grid">
            <?php foreach ($_SESSION['favori11_temp'] as $isim): ?>
                <?php if (array_key_exists($isim, $oyuncular)):
                    $bilgi = $oyuncular[$isim]; ?>
                    <div class="player-card">
                        <img src="<?php echo htmlspecialchars($bilgi['foto']); ?>" alt="<?php echo htmlspecialchars($isim); ?>">
                        <div class="player-info">
                            <h3><?php echo htmlspecialchars($isim); ?></h3>
                            <p><?php echo htmlspecialchars($bilgi['mevki']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="margin-top:15px;">Bu oturumda henüz favori 11 listene oyuncu eklemedin.</p>
    <?php endif; ?>

    <!-- Kalıcı kayıtlı 11 -->
    <?php if (!empty($kayitliFavori11)): ?>
        <h3 class="player-section-title" style="margin-top:25px;">Kaydedilmiş Favori 11'in</h3>
        <div class="player-grid">
            <?php foreach ($kayitliFavori11 as $isim): ?>
                <?php if (array_key_exists($isim, $oyuncular)):
                    $bilgi = $oyuncular[$isim]; ?>
                    <div class="player-card">
                        <img src="<?php echo htmlspecialchars($bilgi['foto']); ?>" alt="<?php echo htmlspecialchars($isim); ?>">
                        <div class="player-info">
                            <h3><?php echo htmlspecialchars($isim); ?></h3>
                            <p><?php echo htmlspecialchars($bilgi['mevki']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
