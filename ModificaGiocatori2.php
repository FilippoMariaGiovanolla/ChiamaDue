<html>
	<head>
		<title>Conferma modifica giocatore</title>
	</head>
	<body>
		<?php
			$acronimo_vecchio=$_POST["acronimo_vecchio"];
			$acronimo_inserito=$_POST["acronimo"];
			$acronimo=strtoupper($acronimo_inserito);
			$cognome_inserito=$_POST["cognome"];
			$cognome=strtoupper($cognome_inserito);
			$nome_inserito=$_POST["nome"];
			$nome=strtoupper($nome_inserito);
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database di chiamata al due");
			$query="UPDATE giocatori
				    SET acronimo='$acronimo', cognome='$cognome', nome='$nome' 
				    WHERE acronimo='$acronimo_vecchio' ";
			$risultato=mysql_query($query);
			if ($risultato)
			  {	
				echo("Modifica effettuata con successo, i nuovi dati del giocatore considerato sono i seguenti: <BR><BR>");
				$query2="SELECT acronimo, cognome, nome
					      FROM giocatori
					      WHERE acronimo='$acronimo' ";
				$risultato2=mysql_query($query2)
					or die("Impossibile mostrare i nuovi dati del giocatore");
				$righe=mysql_num_rows($risultato2);
				$colonne=mysql_num_fields($risultato2);
				if ($righe>0)
				  {
					echo("<TABLE BORDER='1' ALIGN='CENTER'
							<TR>
								<TD><B>Acronimo</B></TD>
								<TD><B>Cognome</B></TD>
								<TD><B>Nome</B></TD>
							</TR>");
					while ($riga=mysql_fetch_row($risultato2))
					  {
						echo("<TR>");
						for ($j=0;$j<$colonne;$j++)
							echo("<TD>".$riga[$j]."</TD>");
						echo("</TR>");
					   } // fine while
					echo("</TABLE>");
				  } // fine if($righe>0)
			   } // fine if($risultato)
			else
			   {
				echo("Modifica fallita <BR>");
				echo("".mysql_error()); // visualizza il messaggio di errore del server MySQL
			   }
		?>
		<BR>
		<A HREF="ModificaGiocatori.php">Torna alla pagina di selezione del giocatore da modificare</A><BR><BR>
		<a href="GestioneGiocatori.php">Torna alla pagina di gestione dei giocatori</a><br><br>
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