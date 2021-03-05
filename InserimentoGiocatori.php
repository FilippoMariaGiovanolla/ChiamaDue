<html>
	</head>
		<title>Inserimento giocatori</title>
	</head>
	</body>
		<center><b>Inserisci i dati dei giocatori</b></center>
		<br>
		<?php
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database di chiamata al due");
			$quanti=$_POST["numero"];
			echo("<form NAME='giocatori' ACTION='InserimentoGiocatori1.php' METHOD='POST'>");				
				for($i=0;$i<$quanti; $i++)
				{
					$valore_fieldset=$i+1;
					$name_acronimo="acronimo".$i;
					$name_cognome="cognome".$i;
					$name_nome="nome".$i;
					echo("<fieldset>"); echo("<legend align='center'>Giocatore $valore_fieldset</legend>");
					echo("<table border='0'>");
						echo("<tr>");
							echo("<TD>Acronimo</TD>");
							echo("<TD><INPUT TYPE='TEXT' NAME=$name_acronimo SIZE='6'></TD>");
							echo("<TD>Cognome</TD>");
							echo("<TD><INPUT TYPE='TEXT' NAME=$name_cognome SIZE='30'></TD>");
							echo("<TD>Nome</TD>");
							echo("<TD><INPUT TYPE='TEXT' NAME=$name_nome SIZE='30'></TD>");
						echo("</tr>");
					echo("</table>");					
					echo("</fieldset>");
					echo("<br>");
				}
				echo("<INPUT TYPE='hidden' NAME='numero' value=$quanti>");
				echo("<br>");
				echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Inserisci'>");
				echo("&nbsp;&nbsp;");
				echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Reset'>");
				echo("<br>");
				echo("<br>");
				echo("<br>");
				echo("<a href='InserimentoGiocatori.html'>Torna alla pagina di inserimento del numero di giocatori da inserire</a>");
				echo("<br>");
				echo("<br>");
				$query="select count(*) from partita";
				$risultato=mysql_query($query)
					or die("Impossibile contare il numero di partite gi&agrave; registrate");
				while($riga=mysql_fetch_row($risultato))
					$quantePartiteRegistrate=$riga[0];
				if($quantePartiteRegistrate==0)
					echo("<a href='Chiama2index.html'>Torna alla pagina iniziale</a>");
				else
					echo("<a href='Chiama2index.php'>Torna alla pagina iniziale</a>");
			echo("</form>");
			mysql_close($conn);
		?>
	</body>
</html>