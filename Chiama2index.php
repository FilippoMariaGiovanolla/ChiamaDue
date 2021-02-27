<html>
	<head>
		<title>Chiama 2</title>
	</head>
	<body>
		<center><b><h1>Chiama il 2</h1></b></center>
		<br>
		<table align="center" border="0" width="80%">
			<tr>
				<?php
					$hostname='localhost';
					$username='root';
					$conn=mysql_connect($hostname,$username,'')
						or die("Impossibile stabilire una connessione con il server");
					$db=mysql_select_db('chiama2')
						or die("Impossibile selezionare il database di chiamata al due");
						
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
					$query="SELECT DISTINCT datapartita FROM totpuntipartita";
					$risultato=mysql_query($query)
						or die("impossibile estrarre le date delle partite gi&agrave; eseguite");
					$trovato=0;
					while(($dataEstratta=mysql_fetch_row($risultato)) and ($trovato==0))
					{
						if($dataEstratta[0]==$dataOdierna)
							$trovato=1;
					}
					if($trovato==0)
						echo("<td style='text-align: center;' width='33%'><a href='InitGiocatori.php'><h2>Nuova partita</h2></a></td>");
					else
						echo("<td style='text-align: center;' width='33%'><h2><u>Nuova partita</u></h2>
						         funzione non disponibile: <br> partita gi&agrave; effettuata in data odierna</td>");
				?>
				<td style="text-align: center;" width="34%"><a href="VisioStatistiche.php"><h2>Visualizza statistiche</h2></a></td>
				<td style="text-align: center;" width="33%"><a href="GestioneGiocatori.html"><h2>Gestione giocatori</h2></a></td>
			</tr>
		</table>
		<?php
			mysql_close($conn);
		?>
	</body>
</head>