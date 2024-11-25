<?php include('header.php'); ?>

<?php
// Kontrolli, kas 'id' on olemas URL-is
if (empty($_GET['id'])) {
    die('Sihtmärk jäi valimata!');
} else {
    $id = $_GET['id'];

    // Päring söögikoha andmete saamiseks
    $paring = "SELECT firma FROM firmad WHERE id = '$id'";
    $valjund = mysqli_query($yhendus, $paring);

    if ($valjund) {
        $rida = mysqli_fetch_assoc($valjund);
        if (!$rida) {
            die('Söögikohta ei leitud!');
        }
    } else {
        die('Päringu viga: ' . mysqli_error($yhendus));
    }
}

// Kontrolli ja salvesta kasutaja sisestatud andmed
$veateade = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = isset($_POST['nimi']) ? htmlspecialchars(trim($_POST['nimi'])) : '';
    $kommentaar = isset($_POST['kommentaar']) ? htmlspecialchars(trim($_POST['kommentaar'])) : '';
    $hinnang = isset($_POST['hinnang']) ? (int) $_POST['hinnang'] : 0;

    if (empty($nimi) || empty($kommentaar) || $hinnang < 1 || $hinnang > 10) {
        $veateade = 'Kõik väljad on kohustuslikud ja hinnang peab olema vahemikus 1-10.';
    } else {
        // Sisesta andmed andmebaasi
        $lisa = "INSERT INTO hinnangud (firma_id, nimi, kommentaar, hinnang) 
                 VALUES ('$id', '$nimi', '$kommentaar', '$hinnang')";
        $muuda_db = mysqli_query($yhendus, $lisa);

        if ($muuda_db) {
            // Uuenda keskmist hinnangut ja hinnangute arvu
            $uuenda = "UPDATE firmad 
                       SET hinnang = (SELECT AVG(hinnang) FROM hinnangud WHERE firma_id = '$id') 
                       WHERE id = '$id'";
            mysqli_query($yhendus, $uuenda);

            // Suuna kasutaja tagasi avalehele
            header("Location: index.php");
            exit;
        } else {
            $veateade = 'Tekkis viga andmete salvestamisel.';
        }
    }
}
?>

<h3>Hindate söögikohta: <?php echo htmlspecialchars($rida['firma']); ?></h3>

<?php if (!empty($veateade)): ?>
    <p style="color: red;"><?php echo $veateade; ?></p>
<?php endif; ?>

<form action="hinnang.php?id=<?php echo $id; ?>" method="post">
    <table>
        <tr>
            <td>Teie nimi:</td>
            <td><input type="text" name="nimi" value="<?php echo isset($nimi) ? htmlspecialchars($nimi) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Teie kommentaar:</td>
            <td><textarea name="kommentaar" rows="3" required><?php echo isset($kommentaar) ? htmlspecialchars($kommentaar) : ''; ?></textarea></td>
        </tr>
        <tr>
            <td>Teie hinnang:</td>
            <td>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <label>
                        <input type="radio" name="hinnang" value="<?php echo $i; ?>" <?php echo (isset($hinnang) && $hinnang == $i) ? 'checked' : ''; ?> required>
                        <?php echo $i; ?>
                    </label>
                <?php endfor; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit">Saada hinnang</button>
                <a href="index.php">Tagasi avalehele</a>
            </td>
        </tr>
    </table>
</form>

<h3>Teiste hinnangud</h3>

<?php
// Päring teiste hinnangute kuvamiseks
$hinnangud_paring = "SELECT nimi, hinnang, kommentaar FROM hinnangud WHERE firma_id = '$id'";
$hinnangud_valjund = mysqli_query($yhendus, $hinnangud_paring);

if ($hinnangud_valjund && mysqli_num_rows($hinnangud_valjund) > 0) {
    while ($hinnang_rida = mysqli_fetch_assoc($hinnangud_valjund)) {
        echo '<div>';
        echo '<strong>' . htmlspecialchars($hinnang_rida['nimi']) . '</strong> hindas: <strong>' . $hinnang_rida['hinnang'] . '</strong>';
        echo '<p>' . htmlspecialchars($hinnang_rida['kommentaar']) . '</p>';
        echo '</div><hr>';
    }
} else {
    echo '<p>Hetkel ei ole hinnanguid saadaval.</p>';
}
?>

<?php include('footer.php'); ?>
