<html>
	<head>
		<title>Modifica abilitazioni - fase 1</title>
	</head>
	<body>
		<?php
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database del grest");
			$query="SELECT * 
				    FROM giocatori
				    limit 1";
			$risultato=mysql_query($query)
				or die("Non è stato possibile stabilire se la tabella giocatori è popolata");
			$righe=mysql_num_rows($risultato);
			if ($righe>0)
			{
			  echo("<form name='modifica' action='DisabilitaGiocatore1.php' method='POST'>");
			  
			  
			  //inizio sezione di disattivazione
			  echo("<fieldset>"); echo("<legend align='center'>Applica disattivazione</legend>");
			  $query1="SELECT acronimo
			    	        FROM giocatori
				        WHERE disattivato='N'
				        ORDER BY acronimo";
			  $risultato1=mysql_query($query1)
				or die("Impossibile selezionare i dati dei giocatori disabilitabili; chiudere la pagina");
			  $righe1=mysql_num_rows($risultato1);
			  if ($righe1>0)
			  {
				echo("<h3>Seleziona il giocatore che vuoi disabilitare</h3>");
				echo("<table border='0'>");
					echo("<tr>");
						echo("<td>");
							echo("Giocatore");
						echo("</td>");
						echo("<td>");
							echo("<select name='acronimo_disabilitante'>");
								$nessuno='nessuno';
								$i=0;
								echo("<OPTION VALUE=".$nessuno.">Seleziona");
								while ($codice=mysql_fetch_row($risultato1))
								    {
									echo("<OPTION VALUE=".$codice[$i].">".$codice[$i]);			
								    }
							echo("</select>");
						echo("</td>");
					echo("</tr>");
				echo("</table>");
			    }
			  else
			   {
				$nessuno='nessuno';
				echo("<h3>Tutti i giocatori sono disabilitati, non è possibile disabilitarne altri</h3>");
				echo"<INPUT TYPE='hidden' NAME='acronimo_disabilitante' VALUE='$nessuno'>";
			   }
			  echo("</fieldset>"); // fine sezione di disattivazione
				
			  
			  //inizio sezione di attivazione
			  echo("<fieldset>"); echo("<legend align='center'>Applica riabilitazione</legend>");
			  $query2="SELECT acronimo
				        FROM giocatori
			 	        WHERE disattivato='S'
				        ORDER BY acronimo";
			  $risultato2=mysql_query($query2)
				or die("Impossibile selezionare i dati dei giocatori abilitabili; chiudere la pagina");
			  $righe2=mysql_num_rows($risultato2);
			  if ($righe2>0)
			    {
				echo("<h3>Seleziona il giocatore che vuoi riabilitare</h3>");
				echo("<table border='0'>");
					echo("<tr>");
						echo("<td>");
							echo("Giocatore");
						echo("</td>");
						echo("<td>");
							echo("<select name='acronimo_riabilitante'>");
								$nessuno2='nessuno';
								$j=0;
								echo("<OPTION VALUE=".$nessuno2.">Seleziona");
								while ($codice=mysql_fetch_row($risultato2))
								    {
									echo("<OPTION VALUE=".$codice[$j].">".$codice[$j]);			
								    }
							echo("</select>");
						echo("</td>");
					echo("</tr>");
				echo("</table>");
			     }
			  else
			    {
				$nessuno2='nessuno';
				echo("<h3>Tutti i giocatori sono abilitati, non è possibile abilitarne altri</h3>");
				echo"<INPUT TYPE='hidden' NAME='acronimo_riabilitante' VALUE='$nessuno2'>";
			    }
			  echo("</fieldset>");//fine sezione di attivazione
			  echo("<br>");
			  echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Avanti'>");
			  echo("</form>"); // questo tag di chiusura si riferisce al form aperto alla riga 26
			}
			else
				echo("<h3>ATTENZIONE: non sono stati inseriti giocatori!!!</h3>");
			mysql_close($conn);
		?>
		<br>
		<br>
		<a href="GestioneGiocatori.html">Torna alla pagina di gestione dei giocatori</a>
		<br><br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
	</body>
</html>