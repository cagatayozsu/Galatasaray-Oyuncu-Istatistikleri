<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header style="background:#800000; color:#fff; padding:15px 20px; display:flex; justify-content:space-between; align-items:center;">
    <h1 style="margin:0; font-size:22px;">Galatasaray Taraftar Uygulaması</h1>
    
    <nav style="display:flex; align-items:center; gap:15px;">
        <a href="index.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Ana Sayfa</a>
        
        <?php if (!empty($_SESSION['login'])): ?>
            <a href="oyuncular.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Oyuncularımız</a>
            <a href="favori.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Favori Oyuncum</a>
            <a href="favori11.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Favori 11'im</a>
            
            <span style="color:#ffcc00; font-weight:bold; margin-left:15px; border-left:2px solid #ffcc00; padding-left:15px;">
                <?php echo htmlspecialchars($_SESSION['kadi']); ?>
            </span>
            
            <a href="logout.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s; background:rgba(255,0,0,0.3);">Çıkış</a>
        <?php else: ?>
            <a href="login.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Giriş</a>
            <a href="register.php" style="color:#fff; text-decoration:none; padding:5px 10px; border-radius:5px; transition:background 0.3s;">Kayıt Ol</a>
        <?php endif; ?>
    </nav>
</header>
