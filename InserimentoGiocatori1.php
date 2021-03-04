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
		?>
		<a href="GestioneGiocatori.php">Torna alla pagina di gestione dei giocatori</a>
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