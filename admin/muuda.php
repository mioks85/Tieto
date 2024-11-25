<?php include('../header.php'); ?>

<?php
    //haarame aadressiribalt ID, et täita väljad
if(empty($_GET['id'])){
 die('Sihtmärk jäi valimata!');
} else {
 $id = $_GET['id'];
    //väljastamise päring
 $paring = "SELECT * FROM firmad WHERE id='$id'";
 $valjund = mysqli_query($yhendus, $paring);
 $rida = mysqli_fetch_assoc($valjund); 

    //muutmise päring
if(!empty($_POST['firma'])){
 $firma = htmlspecialchars(trim($_POST['firma']));
 $aadress = htmlspecialchars(trim($_POST['aadress']));
 $grupp = htmlspecialchars(trim($_POST['grupp_id']));
 $muuda = "UPDATE firmad 
 SET firma='$firma',
 aadress='$aadress',
 grupp_id='$grupp'
 WHERE id='$id'
 ";
 $muuda_db = mysqli_query($yhendus, $muuda);
 if($muuda_db){
 echo "Edukalt muudetud!  <a href=/tieto/Tieto/index.php>Tagasi</a>";
 echo '<META HTTP-EQUIV="Refresh" Content="2; URL="/tieto/Tieto/admin/index.php">';
 die();
 } else {
 echo "mingi jama";
 }
}
?>
<h2>Andmete muutmine</h2>
<form action="#" method="post">
<table>
    <tr><td>Firma: </td><td><input type="text" name="firma" required value="<?php echo $rida['firma']; ?>"></td></tr>
    <tr><td>Aadress:</td><td> <input type="text" name="aadress" required value="<?php echo $rida['aadress']; ?>"></td></tr>
    <tr><td>Grupp: </td><td><input type="number" name="grupp_id" value="<?php echo $rida['grupp_id']; ?>"></td></tr>
    <tr><td><input type="reset" value="Tühjenda"></td><td><input type="submit" value="MUUDA"></td></tr>
</table>
</form>
<?php
}
?>