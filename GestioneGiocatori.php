<html>
	<head>
		<title>Gestione giocatori</title>
	</head>
	<body>
		<center><h1>Gestione giocatori</h1></center>
		<br>
		<table align="center" border="0" width="80%">
			<tr>
				<td style="text-align: center;" width="33%"> <a href="InserimentoGiocatori.html"><h2>Inserimento</h2></a></td>
				<td style="text-align: center;" width="33%"><a href="ModificaGiocatori.php"><h2>Modifica</h2></a></td>
				<td style="text-align: center;" width="34%"><a href="DisabilitaGiocatore.php"><h2>Attiva/Disattiva abilitazione</h2></a></td>
			</tr>
		</table>
	</body>
	<br>
	<br>
	<?php
		$host_name='localhost';
		$user_name='root';
		$conn=@mysql_connect($host_name,$user_name,'')
			or die ("<BR>Impossibile stabilire una connessione con il server");
		@mysql_select_db('chiama2')
			or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
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
</head>