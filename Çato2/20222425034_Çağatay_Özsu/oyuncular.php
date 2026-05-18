<?php
session_start();
if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Oyuncularımız</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .oyuncu-karti {
            display: inline-block;
            margin: 15px;
            padding: 15px;
            border: 2px solid #ffcc00;
            border-radius: 15px;
            text-align: center;
            width: 220px;
            background: #1a1a1a;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .oyuncu-karti:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(255, 204, 0, 0.3);
        }

        .oyuncu-karti img {
            width: 180px;
            height: 180px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .oyuncu-karti h4 {
            margin: 8px 0;
            color: #ffcc00;
            font-size: 16px;
        }

        .oyuncu-karti p {
            margin: 5px 0;
            font-size: 13px;
            color: #eee;
        }

        .oyuncu-karti .istatistik {
            background: #222;
            padding: 8px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 12px;
            color: #ffcc00;
        }

        .baslik {
            color: #ffcc00;
            text-align: center;
            font-size: 24px;
            margin: 30px 0 20px 0;
            border-bottom: 2px solid #ffcc00;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>

<?php
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

// İlk 11
echo '<div class="baslik">İLK 11</div>';
foreach ($ilk11 as $oyuncu) {
    echo '<div class="oyuncu-karti">';
    echo '<img src="' . htmlspecialchars($oyuncu['foto']) . '" alt="' . htmlspecialchars($oyuncu['ad']) . '">';
    echo '<h4>' . htmlspecialchars($oyuncu['ad']) . '</h4>';
    echo '<p><strong>#' . $oyuncu['numara'] . '</strong></p>';
    echo '<p>' . htmlspecialchars($oyuncu['mevki']) . '</p>';
    echo '<div class="istatistik">⚽ ' . $oyuncu['gol'] . ' | 🎯 ' . $oyuncu['asist'] . ' | 🏟️ ' . $oyuncu['mac'] . '</div>';
    echo '</div>';
}

// Yedekler
echo '<div class="baslik">YEDEKLER</div>';
foreach ($yedekler as $oyuncu) {
    echo '<div class="oyuncu-karti">';
    echo '<img src="' . htmlspecialchars($oyuncu['foto']) . '" alt="' . htmlspecialchars($oyuncu['ad']) . '">';
    echo '<h4>' . htmlspecialchars($oyuncu['ad']) . '</h4>';
    echo '<p><strong>#' . $oyuncu['numara'] . '</strong></p>';
    echo '<p>' . htmlspecialchars($oyuncu['mevki']) . '</p>';
    echo '<div class="istatistik">⚽ ' . $oyuncu['gol'] . ' | 🎯 ' . $oyuncu['asist'] . ' | 🏟️ ' . $oyuncu['mac'] . '</div>';
    echo '</div>';
}
?>

</main>
<?php include 'footer.php'; ?>
</body>
</html>
