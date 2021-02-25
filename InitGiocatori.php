<html>
	<head>
		<title>Nuova partita - selezione giocatori</title>
	</head>
	<body>
		<?php
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database di chiamata al due");
			$query_giocatori_validi="SELECT count(*) FROM giocatori WHERE disattivato<>'S'";
			$risultato_query_giocatori_validi=mysql_query($query_giocatori_validi)
				or die("Impossibile stabilire se ci sono giocatori che possono giocare la partita: ".mysql_error());
			while($numero_giocatori_validi_estratti=mysql_fetch_row($risultato_query_giocatori_validi))
				$numGiocatoriValidi=$numero_giocatori_validi_estratti[0];
			if($numGiocatoriValidi>=5)
			{
			   echo("<center><h3>Seleziona i giocatori che giocheranno</h3></center>");
			   $query="SELECT acronimo
				       FROM giocatori
				       WHERE disattivato='N'
				       ORDER BY acronimo";
			   $risultato=mysql_query($query)
				or die("impossibile selezionare i giocatori dalla relativa tabella");
			   echo("<form name='seleziona_giocatori' action='InitMani.php' method='POST'>");
				$quanti=0; /* indica quanti giocatori sono stati portati a video in un record di tabella, per permettere al programma di capire
			   	                 creare un nuovo record nella visualizzazione dei giocatori da abilitare */
				echo("<table align='center' border='0'");
				while ($riga=mysql_fetch_row($risultato))
				{
					if(($quanti % 6)==0) echo("<tr>");
					{
						$giocatori=$riga[0];
						echo("<td> <input type='checkbox' name='$giocatori' value='$giocatori'>".$giocatori.
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>");
					}
					$quanti=$quanti+1;
					if(($quanti % 6)==0) echo("</tr>");
				}
				echo("</table>");
				echo("<input name='quanti' type='hidden' value='$quanti'>");
				echo("<BR>");
				echo("<INPUT TYPE='SUBMIT' NAME='inserisci' VALUE='Avanti'>");
				echo("&nbsp;&nbsp;");
				echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Reset'>");
			   echo("</form>");
			}
			else
				echo("<H2><B>Non sono presenti sufficienti giocatori che possono giocare questa partita (attualmente il numero di giocatori validi &egrave; ".$numGiocatoriValidi.");<br>
				                     accedere alla 
						     <a href='GestioneGiocatori.html'>gestione giocatori</a> per inserirli o abilitarli al gioco</B></H2>");
		?>
		<br>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
		<?php
			mysql_close($conn);
		?>
	</body>
</html>