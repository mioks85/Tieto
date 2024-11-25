<?php
include('config.php');
session_start();

// Kontrollime, kas kasutaja on administraator
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ../login.php');
    exit();
}

// Kontrollime, kas ettevõtte ID on saadetud
if (!isset($_GET['firma_id']) || !is_numeric($_GET['firma_id'])) {
    die('Ettevõtte ID on puudu või vigane!');
}

$firma_id = (int)$_GET['firma_id'];

// Kustutamise funktsioon
if (isset($_GET['kustuta']) && is_numeric($_GET['kustuta'])) {
    $hinnang_id = (int)$_GET['kustuta'];
    $kustuta_paring = "DELETE FROM hinnangud WHERE id = $hinnang_id AND firma_id = $firma_id";
    if (mysqli_query($yhendus, $kustuta_paring)) {
        echo "<p style='color: green;'>Hinnang ID-ga $hinnang_id kustutatud!</p>";
    } else {
        echo "<p style='color: red;'>Tekkis viga kustutamisel: " . mysqli_error($yhendus) . "</p>";
    }
}

// Kuvame ettevõtte nime
$firma_paring = "SELECT firma FROM firmad WHERE id = $firma_id";
$firma_valjund = mysqli_query($yhendus, $firma_paring);
$firma = mysqli_fetch_assoc($firma_valjund);
if (!$firma) {
    die('Ettevõtet ei leitud!');
}

?>

<h1>Hinnangud ettevõttele: <?php echo htmlspecialchars($firma['firma']); ?></h1>

<a href="index.php" class="btn btn-primary">Tagasi admin lehele</a>

<h2>Olemasolevad hinnangud</h2>
<?php
// Pärime ettevõtte hinnangud
$hinnang_paring = "SELECT id, nimi, kommentaar, hinnang FROM hinnangud WHERE firma_id = $firma_id";
$hinnang_valjund = mysqli_query($yhendus, $hinnang_paring);

if ($hinnang_valjund && mysqli_num_rows($hinnang_valjund) > 0) {
    while ($hinnang = mysqli_fetch_assoc($hinnang_valjund)) {
        echo '<div style="margin-bottom: 10px; border: 1px solid #ccc; padding: 10px;">';
        echo '<strong>' . htmlspecialchars($hinnang['nimi']) . '</strong> (' . $hinnang['hinnang'] . '/10)';
        echo '<p>' . htmlspecialchars($hinnang['kommentaar']) . '</p>';
        echo '<a class="btn btn-danger" onclick="return confirm(\'Kas oled kindel, et soovid kustutada?\');" href="hinnang.php?firma_id=' . $firma_id . '&kustuta=' . $hinnang['id'] . '">X</a>';
        echo '</div>';
    }
} else {
    echo '<p>Hetkel pole hinnanguid saadaval.</p>';
}

mysqli_free_result($hinnang_valjund);
mysqli_close($yhendus);
?>

<?php include('../footer.php'); ?>
