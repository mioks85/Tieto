<?php include('../header.php'); ?>

<?php
session_start();
if (!isset($_SESSION['tuvastamine']) && !isset($_COOKIE["login"])) {
    header('Location: ../login.php');
    exit();
}
?>

<script>
    function checkDelete() {
        return confirm('Kas oled kindel, et soovid kustutada?');
    }
</script>

<div class="container">
    <form action="../logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
    <a class="btn btn-warning" href="lisa.php">Lisa uus firma</a>
</div>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // turvalisuse jaoks teisendame ID täisarvuks
    $id = (int)$_GET['id'];

    // kontrollime, kas ID eksisteerib
    $valik_paring = "SELECT * FROM firmad WHERE id='$id'";
    $valik_valjund = mysqli_query($yhendus, $valik_paring);

    if (mysqli_num_rows($valik_valjund) > 0) {
        // kustutame firma
        $kustuta_paring = "DELETE FROM firmad WHERE id='$id'";
        $kustuta_valjund = mysqli_query($yhendus, $kustuta_paring);

        if ($kustuta_valjund) {
            echo "<p style='color: green;'>Firma ID-ga $id on edukalt kustutatud!</p>";
        } else {
            echo "<p style='color: red;'>Kustutamine ebaõnnestus: " . mysqli_error($yhendus) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Firma ID-ga $id ei leitud!</p>";
    }
}

// kuvame tabeli
$paring = "
    SELECT f.id, f.firma, f.aadress, 
           AVG(h.hinnang) AS keskmine_hind
    FROM firmad f
    LEFT JOIN hinnangud h ON f.id = h.firma_id
    GROUP BY f.id, f.firma, f.aadress
";
$valjund = mysqli_query($yhendus, $paring);

if ($valjund && mysqli_num_rows($valjund) > 0) {
    echo '<table class="table table-striped table-bordered border-dark bg-info text-white">';
    echo '<thead>
            <tr>
                <th scope="col">Firma</th>
                <th scope="col">Aadress</th>
                <th scope="col">Keskmine hinne</th>
                <th scope="col">KUSTUTA</th>
                <th scope="col">MUUDA</th>
            </tr>
          </thead>';
    echo '<tbody>';
    while ($rida = mysqli_fetch_assoc($valjund)) {
        echo '<tr>';
        echo '<td><a href="hinnang.php?id=' . $rida['id'] . '">' . htmlspecialchars($rida['firma']) . '</a></td>';
        echo '<td>' . htmlspecialchars($rida['aadress']) . '</td>';
        echo '<td>' . (is_null($rida['keskmine_hind']) ? 'Puudub' : number_format($rida['keskmine_hind'], 2)) . '</td>';
        echo '<td><a onclick="return checkDelete();" class="btn btn-danger" href="?id=' . $rida['id'] . '">Kustuta</a></td>';
        echo '<td><a class="btn btn-warning" href="muuda.php?id=' . $rida['id'] . '">Muuda</a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>Ühtegi kirjet ei leitud.</p>';
}

mysqli_free_result($valjund);
mysqli_close($yhendus);
?>

<?php include('../footer.php'); ?>
