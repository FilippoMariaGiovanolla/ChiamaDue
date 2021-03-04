<html>
	<head>
		<title>Modifica abilitazioni - fase 2</title>
	</head>
	<body>
		<?php
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database del grest");
			$acronimo_disabilitante=$_POST["acronimo_disabilitante"];
			$acronimo_riabilitante=$_POST["acronimo_riabilitante"];
				
			//inizio fase di costruzione della data odierna
			$oggi=getdate();
			$giorno_calcolato=$oggi['mday'];
			if(strlen($giorno_calcolato)==1)
				$giorno='0'.$giorno_calcolato;
			else
				$giorno=$giorno_calcolato;
			$mese_stringa=$oggi['month'];
			if (strcmp($mese_stringa, 'January')==0)
				$mese='01';
			elseif (strcmp($mese_stringa, 'February')==0)
				$mese='02';
			elseif (strcmp($mese_stringa, 'March')==0)
				$mese='03';
			elseif (strcmp($mese_stringa, 'April')==0)
				$mese='04';
			elseif (strcmp($mese_stringa, 'May')==0)
				$mese='05';
			elseif (strcmp($mese_stringa, 'June')==0)
				$mese='06';
			elseif (strcmp($mese_stringa, 'July')==0)
				$mese='07';
			elseif (strcmp($mese_stringa, 'August')==0)
				$mese='08';
			elseif (strcmp($mese_stringa, 'September')==0)
				$mese='09';
			elseif (strcmp($mese_stringa, 'October')==0)
				$mese='10';
			elseif (strcmp($mese_stringa, 'November')==0)
				$mese='11';
			elseif (strcmp($mese_stringa, 'December')==0)
				$mese='12';
			$anno=$oggi['year'];
			$dataOdierna=$giorno.'/'.$mese.'/'.$anno;
			//fine fase di costruzione della data odierna
			
			//inizio fase di disattivazione
			$nessuno1=strcmp($acronimo_disabilitante, 'nessuno'); // la funzione strcmp() restituisce 0 se le stringhe comparate sono uguali
			if ($nessuno1!=0)
			  {				
				$query1="UPDATE giocatori 
					      SET dataDisattivazione='$dataOdierna', disattivato='S' 
					      WHERE acronimo='$acronimo_disabilitante'";
				$risultato1=mysql_query($query1)
					or die("Impossibile disabilitare ".$acronimo_disabilitante."; lo script si &egrave; interrotto. <br>
						  Se si era scelto di riabilitare un altro giocatore, anche questa operazione non &egrave; stata effettuata");
				if ($risultato1)
					echo("<h3>".$acronimo_disabilitante." &egrave; stato correttamente disabilitato.</h3><br>");
			  }
			// fine fase di disattivazione
			
			//inizio fase di riattivazione
			$nessuno2=strcmp($acronimo_riabilitante, 'nessuno'); // la funzione strcmp() restituisce 0 se le stringhe comparate sono uguali
			if ($nessuno2!=0)
			  {
				$query2="UPDATE giocatori 
					      SET dataRiattivazione='$dataOdierna', disattivato='N' 
					      WHERE acronimo='$acronimo_riabilitante'";
				$risultato2=mysql_query($query2)
					or die("Impossibile riabilitare ".$acronimo_riabilitante."; lo script si &egrave; interrotto.");
				if ($risultato2)
					echo("<h3>".$acronimo_riabilitante." &egrave; stato correttamente riabilitato.</h3><br>");
			  }
			// fine fase di riattivazione
			
			if($nessuno1==0 and $nessuno2==0)
				echo("<h3>Non &egrave; stato selezionato nessun giocatore, n&eacute; da abilitare n&eacute; da disabilitare</h3>");
		?>
		<br>
		<br>
		<a href="DisabilitaGiocatore.php">Torna alla pagina dove attivare o disattivare un'abilitazione</a>
		<br><br>
		<a href="GestioneGiocatori.php">Torna alla pagina di gestione dei giocatori</a>
		<br><br>
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