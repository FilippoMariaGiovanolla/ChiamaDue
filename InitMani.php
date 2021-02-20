<html>
	<head>
		<title>Nuova partita - init mani</title>
	</head>
	<body>
		<?php
			error_reporting (E_ALL ^ E_NOTICE); // questo comando permette di eliminare dall'output a video le NOTICE indesiderate
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database di chiamata al due");
			$query="SELECT acronimo
				    FROM giocatori
				    ORDER BY acronimo";
			$risultato=mysql_query($query)
				or die("impossibile selezionare i giocatori dalla relativa tabella");
			$numero_giocatori=$_POST["quanti"];
			$quanti=0;
			echo("<form NAME='giocatori_e_mani' ACTION='CompilaPartita.php' METHOD='POST'>");
			while ($riga=mysql_fetch_row($risultato))
			{
				$acronimo=$_POST["$riga[0]"];
				echo("<!-- Il valore di Sacronimo è ".$acronimo."-->");
				if(strlen($acronimo)==6)
				{
					//echo("Giocatore ".$quanti.": ".$acronimo."<br>");
					$name_progressivo="giocatore".$quanti;
					$quanti++;
					echo("<input name=$name_progressivo type='hidden' value='$acronimo'>");					
				}
			}
			if($quanti<5)
			{
				echo("<b>Sono stati selezionati ".$quanti." giocatori; è necessario selezionarne almeno 5</b>");
				echo("</form>"); // tag di chiusura del form aperto dopo la definizione della variabile $quanti
			}
			else
			{
				echo("<table border='0'>");
					echo("<tr>");
						echo("<td><b>Determina quante mani si potranno fare, al massimo, 
							 in questa partita</b> &nbsp;&nbsp;&nbsp;&nbsp;</td>");
						echo("<td>");
							echo("<select name='mani'>
									<OPTION VALUE='1'>1
									<OPTION VALUE='2'>2
									<OPTION VALUE='3'>3
									<OPTION VALUE='4'>4
									<OPTION VALUE='5'>5
									<OPTION VALUE='6'>6
									<OPTION VALUE='7'>7
									<OPTION VALUE='8'>8
									<OPTION VALUE='9'>9
									<OPTION VALUE='10'>10
									<OPTION VALUE='11'>11
									<OPTION VALUE='12'>12
									<OPTION VALUE='13'>13
									<OPTION VALUE='14'>14
									<OPTION VALUE='15'>15
								</select>");
						echo("</td>");
					echo("</tr>");
				echo("</table>");
				echo("<br>");
				echo("Non so quante mani si potranno fare in questa partita ");
				echo("<input type='checkbox' name='mani_libere' value='yes'>");
				echo("<input name='numero_giocatori' type='hidden' value='$quanti'>");
				echo("<br><br>");
				echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Avanti'>");
				echo("</form>"); // tag di chiusura del form aperto dopo la definizione della variabile $quanti
			}
			mysql_close($conn);
		?>
		<br>
		<br>
		<a href="InitGiocatori.php">Torna alla pagina di selezione dei giocatori di questa partita</a>
		<br>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
	</body>
</html>