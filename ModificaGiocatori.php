<html>
	<head>
		<title>Selezione del giocatore da modificare</title>
	</head>
	<body>
		<?php
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$i=0;
			$query1="SELECT * 
				      FROM giocatori
				      limit 1";
			$risultato1=mysql_query($query1)
				or die("Non � stato possibile stabilire se la tabella giocatori � popolata");
			$righe1=mysql_num_rows($risultato1);
			if ($righe1>0)
			  {
				echo("<h3>Seleziona il giocatore di cui vuoi modificare i dati</h3>");
				echo("<br><br>");
				echo("<FORM NAME='modifica' ACTION='ModificaGiocatori1.php' METHOD='POST'>");
				echo("<TABLE BORDER='0'>");
				echo("<TR>");
					echo("<TD>Giocatore</TD>");
					echo("<TD>");
						echo("<SELECT NAME='acronimo_vecchio'>");
						$nessuno='nessuno';
						$query="SELECT acronimo
							    FROM giocatori
							    ORDER BY acronimo";
						$risultato=mysql_query($query)
							or die("Impossibile selezionare i dati dei giocatori da modificare; chiudere la pagina");
						echo("<OPTION VALUE=".$nessuno.">Seleziona");
						while ($codice=mysql_fetch_row($risultato))
						      {
							echo("<OPTION VALUE=".$codice[$i].">".$codice[$i]);			
						      }
						echo("</SELECT>");
					echo("</TD>");
					echo("<td>");
						echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Avanti'>");
					echo("</td>");
				echo("</TR>");
				echo("</TABLE>");
				echo("<BR>");			
				echo("</FORM>");
			  }
			else
				echo("<h3>ATTENZIONE: non sono stati inseriti giocatori!!!</h3>");
			?>
		<br>
		<a href="GestioneGiocatori.html">Torna alla pagina di gestione dei giocatori</a>
		<br>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
		<?php
			mysql_close($conn);
		?>
	</body>
</html>