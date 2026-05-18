<?php
session_start();
if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$kullanici = $_SESSION['kadi'];
$cookieFavori = 'favori_oyuncu_' . $kullanici;
$cookie11     = 'favori11_' . $kullanici;

$favoriAd = $_COOKIE[$cookieFavori] ?? '';
$favori11 = $_COOKIE[$cookie11] ?? '';

// Son giriş zamanı
$sonGiris = date('d.m.Y H:i:s');
setcookie('last_login', $sonGiris, time() + 86400 * 30, '/');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Galatasaray Ana Sayfa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <h2>GALATASARAY TARİH</h2>
    
    <p>
        Galatasaray Spor Kulübü, Türk Spor Tarihindeki öncü olma özelliğini hiç kuşkusuz içinden doğduğu 
        ve gene öncü bir kurum olan Galatasaray Lisesinden almıştır. Okul ile kulüp arasındaki koparılmaz bağ, 
        yadsınamayacak bir gereklilik ve övünç kaynağıdır. Devlet adamı yetiştirmek amacıyla II. Beyazıt tarafından 
        1481'de kurulan mektep, adını kurulduğu bölgeden alır ve Galata Sarayı olarak adlandırılmaya başlar.
    </p>

    <p>
        Okul'un yeniden yapılanmasıyla birlikte, Türkiye'de de gerçek anlamda ilk sportif çalışmalar başlamış olur. 
        1905 yılında Ali Sami Yen ve arkadaşları tarafından kurulan Galatasaray Spor Kulübü, başta futbol olmak üzere, 
        Türkiye'nin en başarılı kulüplerinden biridir.
    </p>

    <div style="margin:20px 0;">
        <img src="img/arena1.webp" width="45%" style="margin-right:5%; border-radius:10px;">
        <img src="img/arena2.webp" width="45%; border-radius:10px;">
    </div>

    <?php
    $lastLogin = $_COOKIE['last_login'] ?? '';
    if ($lastLogin): ?>
        <p style="margin-top:15px; font-size:13px; color:#ccc;">
            Son giriş zamanı: <?php echo htmlspecialchars($lastLogin); ?>
        </p>
    <?php endif; ?>

    <p style="margin-top:20px;">
        <strong>Hoşgeldiniz, <?php echo htmlspecialchars($kullanici); ?></strong>
    </p>

    <?php if ($favoriAd): ?>
        <p><strong>Favori oyuncun:</strong> <?php echo htmlspecialchars($favoriAd); ?> 
            <a href="favori.php" style="color:#ffcc00;">Değiştir</a>
        </p>
    <?php else: ?>
        <p><a href="favori.php" style="color:#ffcc00;">Favori oyuncunu seç</a></p>
    <?php endif; ?>

    <?php if ($favori11): ?>
        <p><a href="favori11.php" style="color:#ffcc00;">Favori 11'ini görüntüle / değiştir</a></p>
    <?php else: ?>
        <p><a href="favori11.php" style="color:#ffcc00;">Favori 11'ini oluştur</a></p>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
