<?php include ('config.php') ?>
<?php include ('header.php') ?>

<?php
	session_start();
	if (isset($_SESSION['tuvastamine'])) {
	  header('Location: admin/index.php');
	  exit();
	  }
	if (!empty($_POST['login']) && !empty($_POST['pass'])) {
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		if ($login=='admin' && $pass=='admin') {
			$_SESSION['tuvastamine'] = 'misiganes';
			if (isset($_POST['cookie'])) {

				setcookie("login", 0, time()+7200);
		   }
		   header('Location: admin/index.php');
	   }
	}
?>
<h1>Login</h1>
<form action="#" method="post">
	Login: <input type="text" name="login"><br>
	Password: <input type="password" name="pass"><br>
	<div class="form-check">
     <input class="form-check-input" type="checkbox" value="check" name="cookie">
     <label class="form-check-label" >Jäta mind sisse logituks</label>
   </div>
	<input type="submit" value="Logi sisse">
	
</form>
<?php include ('footer.php') ?>