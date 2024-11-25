<?php
session_start();

// kontrollime, kas kasutaja on juba sisselogitud
if (isset($_SESSION['tuvastamine'])) {
    header('Location: admin/index.php');
    exit();
}

$viga = ''; // veateate muutuja

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sisendi puhastamine
    $kasutajanimi = htmlspecialchars(trim($_POST['kasutajanimi']));
    $parool = htmlspecialchars(trim($_POST['parool']));

    // kontrollime sisselogimise andmeid
    if ($kasutajanimi === 'admin' && $parool === 'admin') { 
        $_SESSION['tuvastamine'] = true;
        header('Location: admin/index.php');
        exit();
    } else {
        // viga sisselogimisel
        $viga = 'Vale kasutajanimi või parool!';
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisselogimine</title>
</head>
<body>
    <h1>Logi sisse</h1>
    <?php if (!empty($viga)): ?>
        <p style="color: red;"><?php echo $viga; ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label>Kasutajanimi:</label>
        <input type="text" name="kasutajanimi" required>
        <br>
        <label>Parool:</label>
        <input type="password" name="parool" required>
        <br>
        <button type="submit">Logi sisse</button>
    </form>
</body>
</html>
