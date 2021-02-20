<html>
	<head>
		<title>Conferma inserimento</title>
	</head>
	<body>
		<?php
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$quanti=$_POST["numero"]; // quanti giocatori l'utente ha deciso di inserire
			for($i=0; $i<$quanti; $i++)
			{
				$acronimo_inserito=$_POST["acronimo$i"];
				$acronimo[]=strtoupper($acronimo_inserito);
				$cognome_inserito=$_POST["cognome$i"];
				$cognome[]=strtoupper($cognome_inserito);
				$nome_inserito=$_POST["nome$i"];
				$nome[]=strtoupper($nome_inserito);
			}
			for($i=0;$i<$quanti;$i++)
			{
				$query="INSERT INTO giocatori VALUES ('$acronimo[$i]', '$cognome[$i]', '$nome[$i]', 'N', '00-00-0000','00-00-0000',0,0)";
				$risultato=mysql_query($query)
					or die("Impossibile inserire i dati dei giocatori: ".mysql_error());
			}
			echo("Inserimento effettuato con successo");
			echo("<br>");
			echo("<br>");
			/*echo("I dati dei giocatori presenti in tabella sono:<br>");
			$query1="SELECT *
				      FROM giocatori";
			$risultato1=mysql_query($query1)
				or die("Impossibile interrogare la tabella giocatori");
			$righe=mysql_num_rows($risultato1);
			$colonne=mysql_num_fields($risultato1);
			echo"<BR>";
			echo("<TABLE BORDER='1' ALIGN='CENTER'");
				while ($riga=mysql_fetch_row($risultato1))
				{
					echo("<TR>");
					for ($j=0;$j<$colonne;$j++)
						echo("<TD><CENTER>".$riga[$j]."</CENTER></TD>");
					echo("</TR>");
				}
			echo("</TABLE>");*/
			mysql_close($conn);
		?>
		<a href="GestioneGiocatori.html">Torna alla pagina di gestione dei giocatori</a>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
	</body>
</html>