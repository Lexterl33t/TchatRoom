<?php
try{
	$bdd = new PDO("mysql:host=localhost;dbname=tchat_bdd;charset=utf8", 'root', 'root');
}
catch (Exception $e){
	die("Erreur SQL: " . $e->getMessage());
}
session_start();

if (!isset($_SESSION["id"])) {
	header('location: login.php');
}

if (isset($_POST["Send"])) {
	$text = htmlspecialchars($_POST["mess"]);
	if (!empty($text)) {
		$insert = $bdd->prepare("INSERT INTO chat (username, message) VALUES(?, ?)");
		$insert->execute([
			$_SESSION["username"],
			$text
		]);
	}
	else
	{

	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tchat Private Onion by Muham'RB</title>
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+KuaiLe" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei" rel="stylesheet">


	<style type="text/css">
	
		body{
			background: black;
		}
		.border{
			border-radius: 0px 0px 0px 0px;
			-moz-border-radius: 0px 0px 0px 0px;
			-webkit-border-radius: 0px 0px 0px 0px;
			border: 0px solid #C814D6;
		}
		.username{
			font-family: "ZCOOL KuaiLe";
			color: blue;
		}
		.mess{
			color: purple;
			font-family: "ZCOOL XiaoWei";
		}
		textarea{
			font-family: "ZCOOL KuaiLe";
			color: red;
		}
		.bouton{
			color: purple;
			font-family: "ZCOOL KuaiLe";
			background: blue;
		}
		li{
			list-style-type: none; 
		}


	</style>
</head>
<body>
<center><h1><font face="ZCOOL KuaiLe" color="blue">Tchat Private Onion by Muham'RB u r connected with account <font color="red">[ <?= $_SESSION["username"] ?> ]</font></h1></center>
<center><div class="border">
	<?php
	$r = $bdd->query("SELECT * FROM chat ORDER BY id DESC");

	while ($m = $r->fetch()) { ?>
		<li><h3 class="username"><?php echo $m["username"]; ?>: </h3><p class="mess"><?php echo $m["message"]; ?></p></li>
<?php	}


	?>
	


</div></center>
<br>
<br>

<center>
	<form method="POST">
<div>
	<textarea name="mess" placeholder="insert ur text" rows="10" cols="50"></textarea>
	<br>
	<br>
	<button name="Send" class="bouton">Send</button>

</div>
</form>
</center>
</body>
</html>