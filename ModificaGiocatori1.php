<html>
	<head>
		<title>Modifica dati</title>
	</head>
	<body>
		<?php
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$acronimo_vecchio=$_POST["acronimo_vecchio"];
			$nessuno=strcmp($acronimo_vecchio, 'nessuno'); // la funzione strcmp() restituisce 0 se le stringhe comparate sono uguali
			if ($nessuno!=0)
			{
			$query="SELECT acronimo, cognome, nome
				    FROM giocatori
			            WHERE acronimo='$acronimo_vecchio'";
			$risultato=mysql_query($query)
				or die("Impossibile selezionare i dati del giocatore selezionato; chiudere la pagina o tornare indietro");
			$riga=mysql_fetch_row($risultato);
			echo("<h3>Modifica ora i campi del modulo sottostante con tutti i dati aggiornati relativi al giocatore</h3>");
			echo("<FORM NAME='Modifica' ACTION='ModificaGiocatori2.php' METHOD='POST'>");
				echo("<TABLE BORDER='0'>");
					echo"<TR>";
						echo"<TD>Acronimo</TD>";
						echo"<TD><INPUT TYPE='TEXT' NAME='acronimo' SIZE='6' VALUE=$riga[0]></TD>";
					echo"</TR>";
					echo"<TR>";
						echo"<TD>Cognome</TD>";
						echo"<TD><INPUT TYPE='TEXT' NAME='cognome' VALUE=$riga[1]></TD>";
					echo"</TR>";
					echo"<TR>";
						echo"<TD>Nome</TD>";
						echo"<TD><INPUT TYPE='TEXT' NAME='nome' VALUE=$riga[2]></TD>";
					echo"</TR>";
				echo"</TABLE>";// Fine tabella contenente il modulo form per l'inserimento dei dati
				echo"<INPUT TYPE='hidden' NAME='acronimo_vecchio' VALUE='$acronimo_vecchio'";
				echo"<BR>";
				echo("<BR>");	      
				echo("<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Attua modifica'>");
				echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Ripristina valori'>");
			echo("</FORM>");
			} // fine if ($acronimo_vecchio!=0)
			else
			{
				echo("<h3>Non hai selezionato nessun giocatore da modificare!!!</h3>");
				echo("<br>");
			}
		?>
		<A HREF="ModificaGiocatori.php">Torna alla pagina di selezione del giocatore da modificare</A>
	<?php
		mysql_close($conn);
	?>
	</body>
</html>