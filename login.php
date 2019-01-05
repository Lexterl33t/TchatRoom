<?php
try{
	$bdd = new PDO("mysql:host=localhost;dbname=tchat_bdd;charset=utf8", 'root', 'root');
}
catch (Exception $e){
	die("Erreur SQL: " . $e->getMessage());
}
session_start();
if (isset($_SESSION["id"])) {
	header("location: index.php");
}

if (isset($_POST["conn"])) {
	$username = htmlspecialchars($_POST["username"]);
	$password = $_POST["pass"];

	if (!empty($username) AND !empty($password)) {
		$reqpseudo = $bdd->prepare("SELECT * FROM members WHERE username = ? AND password = ?");
		$reqpseudo->execute([
			$username,
			$password
		]);

		$d = $reqpseudo->rowCount();
		if ($d == 1) {
			$userinfo = $reqpseudo->fetch();
			$_SESSION["id"] = $userinfo["id"];
			$_SESSION["username"] = $userinfo["username"];

			header("location: index.php");
		}
		else
		{
			$error = "Username or password incorrectly";
		}
	}
	else
	{
		$error = "Please type all champs";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - TchatRoom</title>
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+KuaiLe" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei" rel="stylesheet">
	<style type="text/css">
		
		body{
			background:black;
		}
	</style>
</head>
<body>
	<div align="center">
		<h1><font color="blue" face="ZCOOL XiaoWei">Login - Tchat Private Onion By Muham'RB</font></h1>
		<form method="POST">
			<div>
				<div>
					<p><font face="ZCOOL KuaiLe" color="purple">Username</font></p>
					<input type="text" name="username">

				</div>

				<div>
					<p><font face="ZCOOL KuaiLe" color="purple">Password</font></p>
					<input type="password" name="pass">
				</div>

				<div>
					<button name="conn">Connection</button>
				</div>
				<br>
				<?php

				if (isset($error)) {
					echo "<font color=\"red\" face=\"ZCOOL KuaiLe\">".$error."</font>";
				}

				?>
			</div>
		</form>
	</div>
</body>
</html>