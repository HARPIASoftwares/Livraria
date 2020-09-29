<?php
	require "../db_connect.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>Livraria</title>
		<link rel="stylesheet" type="text/css" href="css/home_style.css" />
	</head>
	<body>
		<div id="allTheThings">
			<a href="pending_registrations.php">
				<input type="button" value="SOLICITAÇÕES DE NOVO USUÁRIO" />
			</a><br />
			<a href="pending_book_requests.php">
				<input type="button" value="AUTORIZAR LIVROS" />
			</a><br />
			<a href="insert_book.php">
				<input type="button" value="NOVO LIVRO" />
			</a><br />
			<a href="update_copies.php">
				<input type="button" value="NÚMERO DE CÓPIAS" />
			</a><br />
			<a href="update_balance.php">
				<input type="button" value="ATUALIZAR CASHBACK DE USUÁRIO" />
			</a><br />
			<a href="due_handler.php">
				<input type="button" value="LEMBRETES" />
			</a><br /><br />
			<h2 align="center">"Trocava toda a minha tecnologia por uma tarde com Sócrates."<h2>
		</div>
		<h2 align="center">- Steve Jobs<h2>
	</body>
</html>