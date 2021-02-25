<html>
	</head>
		<title>Inserimento giocatori</title>
	</head>
	</body>
		<center><b>Inserisci i dati dei giocatori</b></center>
		<br>
		<?php
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
				echo("<a href='Chiama2index.php'>Torna alla pagina iniziale</a>");
			echo("</form>");
		?>
	</body>
</html>