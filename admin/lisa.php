<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ../login.php');
    exit();
}

include('../header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firma = htmlspecialchars(trim($_POST['firma']));
    $aadress = htmlspecialchars(trim($_POST['aadress']));
    $tyyp = htmlspecialchars(trim($_POST['tyyp']));

    $paring = "INSERT INTO firmad (firma, aadress, grupp_id) VALUES ('$firma', '$aadress', '$tyyp')";
    mysqli_query($yhendus, $paring);
    header('Location: index.php');
    exit();
}
?>

<h1>Lisa uus söögikoht</h1>
<form action="lisa.php" method="post">
    <label>Nimi:</label>
    <input type="text" name="firma" required>
    <br>
    <label>Aadress:</label>
    <input type="text" name="aadress" required>
    <br>
    <label>Tüüp:</label>
    <input type="text" name="tyyp" required>
    <br>
    <button type="submit">Salvesta</button>
    <a href="index.php">Tagasi</a>
</form>

</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
        </script>

    </form>
</div>
</body>

</html>
