<?php
	require "db_connect.php";
	require "header-index.php";
	session_start();
	
	if(empty($_SESSION['type']));
	else if(strcmp($_SESSION['type'], "librarian") == 0)
		header("Location: librarian/home.php");
	else if(strcmp($_SESSION['type'], "member") == 0)
		header("Location: member/home.php");
?>

<html>
	<head>
		<title>BIBLIOTECA DIGITAL</title>
		<link rel="stylesheet" type="text/css" href="css/index_style.css" />
	</head>
	<body>
		<div id="allTheThings">
			<div id="member">
				<a href="member">
					<img src="img/ic_member.svg" width="150px" height="auto"/><br />
					&nbsp;LEITOR
				</a>
			</div>
			<div id="verticalLine">
				<div id="librarian">
					<a id="librarian-link" href="librarian">
						<img src="img/ic_librarian.svg" width="150px" height="auto" /><br />
						&nbsp;&nbsp;&nbsp;BIBLOTECÁRIO
					</a>
				</div>
			</div>
			<br><br>
			<h2 align="center">"O homem não é nada além daquilo que a educação faz dele."<h2>
			<h5 align="center">- Emannuel Kant<h5>
		</div>
		
	</body>
</html>