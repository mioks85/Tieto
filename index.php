<?php include('header.php'); ?>

<h1>Söögikohtade nimekiri</h1>

<?php
  //tabeli sorteerimise ja otsingu käsitlemine
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'firma';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
$search = isset($_GET['otsi']) ? htmlspecialchars(trim($_GET['otsi'])) : '';

  // lehekülgede arvutamine
$kirjeid_lehel = 10;
$kirjeid_kokku_paring = "SELECT COUNT(DISTINCT id) AS total FROM firmad";
$lehtede_vastus = mysqli_query($yhendus, $kirjeid_kokku_paring);
$kirjeid_kokku = mysqli_fetch_assoc($lehtede_vastus)['total'];
$lehti_kokku = ceil($kirjeid_kokku / $kirjeid_lehel);

$leht = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($leht < 1) $leht = 1;
if ($leht > $lehti_kokku) $leht = $lehti_kokku;
$start = ($leht - 1) * $kirjeid_lehel;

  // SQL päring söögikohtade kuvamiseks
$paring = "
    SELECT f.id, f.firma, f.aadress, 
           AVG(h.hinnang) AS keskmine_hind, 
           COUNT(h.id) AS hinnangute_arv
    FROM firmad f
    LEFT JOIN hinnangud h ON f.id = h.firma_id
    WHERE f.firma LIKE '%$search%'
    GROUP BY f.id, f.firma, f.aadress
    ORDER BY $sort_column $sort_order
    LIMIT $start, $kirjeid_lehel";

$valjund = mysqli_query($yhendus, $paring);

if ($valjund) {
    echo '<form method="get" action="index.php">';
    echo 'Otsi: <input type="text" name="otsi" value="' . $search . '">';
    echo '<button type="submit">Otsi</button>';
    echo '</form>';

    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><a href="?sort=firma&order=' . ($sort_order == 'asc' ? 'desc' : 'asc') . '">Nimi</a></th>';
    echo '<th><a href="?sort=aadress&order=' . ($sort_order == 'asc' ? 'desc' : 'asc') . '">Asukoht</a></th>';
    echo '<th><a href="?sort=keskmine_hind&order=' . ($sort_order == 'asc' ? 'desc' : 'asc') . '">Keskmine hinnang</a></th>';
    echo '<th><a href="?sort=hinnangute_arv&order=' . ($sort_order == 'asc' ? 'desc' : 'asc') . '">Hinnangute arv</a></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($rida = mysqli_fetch_assoc($valjund)) {
        echo '<tr onclick="location.href=\'hinnang.php?id=' . $rida['id'] . '\'">';
        echo '<td>' . htmlspecialchars($rida['firma']) . '</td>';
        echo '<td>' . htmlspecialchars($rida['aadress']) . '</td>';
        echo '<td>' . (is_null($rida['keskmine_hind']) ? 'Puudub' : number_format($rida['keskmine_hind'], 2)) . '</td>';
        echo '<td>' . $rida['hinnangute_arv'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    //lehtede vahel navigeerimine
    echo '<nav>';
    echo '<ul class="pagination">';
    if ($leht > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($leht - 1) . '">&lt; Eelmised</a></li>';
    }
    for ($i = 1; $i <= $lehti_kokku; $i++) {
        echo '<li class="page-item ' . ($i == $leht ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    if ($leht < $lehti_kokku) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($leht + 1) . '">Järgmised &gt;</a></li>';
    }
    echo '</ul>';
    echo '</nav>';
} else {
    echo "Tekkis viga andmete päringul: " . mysqli_error($yhendus);
}

mysqli_free_result($valjund);
mysqli_close($yhendus);
?>

<?php include('footer.php'); ?>
