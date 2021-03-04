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
				echo("<!-- Il valore di Sacronimo &egrave; ".$acronimo."-->");
				if(strlen($acronimo)==6)
				{
					$name_progressivo="giocatore".$quanti;
					$quanti++;
					echo("<input name=$name_progressivo type='hidden' value='$acronimo'>");					
				}
			}
			if($quanti<5)
			{
				echo("<b>Sono stati selezionati ".$quanti." giocatori; &egrave; necessario selezionarne almeno 5</b>");
				echo("</form>"); // tag di chiusura del form aperto dopo la definizione della variabile $quanti
			}
			elseif($quanti>6)
			{
				echo("<b>Sono stati selezionati ".$quanti." giocatori; &egrave; necessario selezionarne al massimo 6</b>");
				echo("</form>"); // tag di chiusura del form aperto dopo la definizione della variabile $quanti
			}
			else
			{
				echo("<h3>Determina quante mani si potranno fare, al massimo, in questa partita:</b> <input type='number' name='mani' step=1></h3>");
				echo("<h3>Non so quante mani si potranno fare in questa partita <input type='checkbox' name='mani_libere' value='yes'></h3>");
				echo("<input name='numero_giocatori' type='hidden' value='$quanti'>");
				echo("<br><br>");
				echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Avanti'>");
				echo("</form>"); // tag di chiusura del form aperto dopo la definizione della variabile $quanti
			}
		?>
		<br>
		<br>
		<a href="InitGiocatori.php">Torna alla pagina di selezione dei giocatori di questa partita</a>
		<br>
		<br>
		<?php
			$query="select count(*) from partita";
			$risultato=mysql_query($query)
				or die("Impossibile contare il numero di partite gi&agrave; registrate");
			while($riga=mysql_fetch_row($risultato))
				$quantePartiteRegistrate=$riga[0];
			if($quantePartiteRegistrate==0)
				echo("<a href='Chiama2index.html'>Torna alla pagina iniziale</a>");
			else
				echo("<a href='Chiama2index.php'>Torna alla pagina iniziale</a>");
			mysql_close($conn);
		?>
	</body>
</html>