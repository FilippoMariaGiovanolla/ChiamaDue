<html>
	<head>
		<title>Visione statistiche</title>
	</head>
	<body>
		<?php
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$query="SELECT count(*) FROM partita";
			$risultato=mysql_query($query)
				or die ("Impossibile stabilire se sono state memorizzate partite all'interno del database");
			if($risultato==0)
				echo("<h3>Non sono state ancora gestite partite con questo programma: impossibile visualizzare statistiche</h3>");
			else
			{
				echo("<table border=0 align='center'>");
				echo("<tr>");
					echo("<td>");
						echo("<a href='SelAnno.php'><h2><center>Visualizza storico partite giocate</center></h2></a>");
					echo("<td>");
				echo("</tr>");
				echo("<tr>");
					echo("<td>");
						echo("<a href='VisioRanking.php'><h2><center>Visualizza ranking</center></h2></a>");
					echo("<td>");
				echo("</tr>");
				echo("</table>");
			}
			echo("<br>");
			echo("<br>");
			echo("<a href='Chiama2index.php'>Torna alla pagina iniziale</a>");
			mysql_close($conn);
		?>
	</body>
</html>