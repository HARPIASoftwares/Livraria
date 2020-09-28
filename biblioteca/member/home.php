<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";
	require "header_member.php";
?>

<html>
	<head>
		<title>Bem-Vindo</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="css/home_style.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_radio_button_style.css">
	</head>
	<body>
		<?php
			$query = $con->prepare("SELECT * FROM book ORDER BY title");
			$query->execute();
			$result = $query->get_result();
			if(!$result)
				die("ERRO: Não foi possível buscar livros");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>Sem livros disponíveis</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>Livros disponíveis</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
						<th></th>
						<th>ISBN<hr></th>
						<th>Título<hr></th>
						<th>Autor<hr></th>
						<th>Categoria<hr></th>
						<th>Preço<hr></th>
						<th>Cópias<hr></th>
					</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>
							<td>
								<label class='control control--radio'>
									<input type='radio' name='rd_book' value=".$row[0]." />
								<div class='control__indicator'></div>
							</td>";
					for($j=0; $j<6; $j++)
						if($j == 4)
							echo "<td>$".$row[$j]."</td>";
						else
							echo "<td>".$row[$j]."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<br /><br /><input type='submit' name='m_request' value='Solicitar livro' />";
				echo "</form>";
			}
			
			if(isset($_POST['m_request']))
			{
				if(empty($_POST['rd_book']))
					echo error_without_field("Selecione um livro para emitir");
				else
				{
					$query = $con->prepare("SELECT copies FROM book WHERE isbn = ?;");
					$query->bind_param("s", $_POST['rd_book']);
					$query->execute();
					$copies = mysqli_fetch_array($query->get_result())[0];
					if($copies == 0)
						echo error_without_field("Não há cópias disponíveis no livro selecionado.");
					else
					{
						$query = $con->prepare("SELECT request_id FROM pending_book_requests WHERE member = ?;");
						$query->bind_param("s", $_SESSION['username']);
						$query->execute();
						if(mysqli_num_rows($query->get_result()) == 1)
							echo error_without_field("Você só pode pedir um livro de cada vez");
						else
						{
							$query = $con->prepare("SELECT book_isbn FROM book_issue_log WHERE member = ?;");
							$query->bind_param("s", $_SESSION['username']);
							$query->execute();
							$result = $query->get_result();
							if(mysqli_num_rows($result) >= 3)
								echo error_without_field("Você não pode emitir mais de 3 livros por semana!");
							else
							{
								$rows = mysqli_num_rows($result);
								for($i=0; $i<$rows; $i++)
									if(strcmp(mysqli_fetch_array($result)[0], $_POST['rd_book']) == 0)
										break;
								if($i < $rows)
									echo error_without_field("Você já solicitou uma cópia deste livro.");
								else
								{
									$query = $con->prepare("SELECT balance FROM member WHERE username = ?;");
									$query->bind_param("s", $_SESSION['username']);
									$query->execute();
									$memberBalance = mysqli_fetch_array($query->get_result())[0];
									
									$query = $con->prepare("SELECT price FROM book WHERE isbn = ?;");
									$query->bind_param("s", $_POST['rd_book']);
									$query->execute();
									$bookPrice = mysqli_fetch_array($query->get_result())[0];
									if($memberBalance < $bookPrice)
										echo error_without_field("Você não tem crédito suficiente para adquirir este livro!");
									else
									{
										$query = $con->prepare("INSERT INTO pending_book_requests(member, book_isbn) VALUES(?, ?);");
										$query->bind_param("ss", $_SESSION['username'], $_POST['rd_book']);
										if(!$query->execute())
											echo error_without_field("ERRO: Faltou a solicitar o livro");
										else
											echo success("Livro solicitado com sucesso! Você será notificado por e-mail quando o livro for emitido em sua conta.");
									}
								}
							}
						}
					}
				}
			}
		?>
	</body>
</html>