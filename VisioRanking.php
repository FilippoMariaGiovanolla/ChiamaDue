<html>
	<head>
		<title>Visione ranking</title>
	</head>
	<body>
		<center><h1>Classifica generale</h1></center>
		<?php
		$hostname='localhost';
		$username='root';
		$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server");
		$db=mysql_select_db('chiama2')
			or die("Impossibile selezionare il database di chiamata al due");
			
		//popolo la tabella delle medie
		$query_cancellazione_tabella_medie="DELETE FROM medie";
		$risultato_query_cancellazione_tabella_medie=mysql_query($query_cancellazione_tabella_medie)
			or die("Impossibile cancellare il contenuto precedente della tabella delle medie: ".mysql_error());
		$query_acronimi="SELECT acronimo FROM giocatori ORDER BY puntitotali DESC";
		$risultato_query_acronimi=mysql_query($query_acronimi)
			or die("Impossibile estrarre gli acronimi dei giocatori: ".mysql_error());
		$query_punti_totali="SELECT puntitotali FROM giocatori ORDER BY puntitotali DESC";
		$risultato_punti_totali=mysql_query($query_punti_totali)
			or die("Impossibile estrarre i punti totali di ogni giocatore: ".mysql_error());
		$query_giornate="SELECT giornate FROM giocatori ORDER BY puntitotali DESC";
		$risultato_giornate=mysql_query($query_giornate)
			or die("Impossibile estrarre le giornate giocate da ogni giocatore: ".mysql_error());
		while(($giocatori=mysql_fetch_row($risultato_query_acronimi)) and ($punti_totali=mysql_fetch_row($risultato_punti_totali)) and ($giornate=mysql_fetch_row($risultato_giornate)))
		{
			$puntiGiocatore=$punti_totali[0];
			$giornateGiocatore=$giornate[0];
			if($giornateGiocatore==0)
				$media=0;
			else
				$media=$puntiGiocatore/$giornateGiocatore;
			$query_inserimento="INSERT INTO medie VALUES ('$giocatori[0]',$media)";
			$risultato_query_inserimento=mysql_query($query_inserimento)
				or die("Impossibile completare l'inserimento dei dati nella tabella delle medie".mysql_error());
		}
		
		//mando a video i valori cumulativi di ogni giocatore
		echo("<table border=1>");
			echo("<tr>");
				//mando a video l'acronimo dei giocatori
				echo("<td width='80'><center>Giocatori</center></td>");
				$query_acronimi="SELECT acronimogiocatore FROM medie ORDER BY media DESC";
				$risultato_acronimi=mysql_query($query_acronimi)
					or die("Impossibile estrarre gli acromini dei giocatori");
				$k=0;
				while($acronimi=mysql_fetch_row($risultato_acronimi))
				{
					echo("<td width='80'><center><b>$acronimi[0]</b></center></td>");
					$giocatore[$k]=$acronimi[0];
					$k++;
				}
			echo("</tr>");
			echo("<tr>");
				//mando a video il valore del ranking
				echo("<td width='80'><center><b>RANKING<b></center></td>");
				$j=0;
				$query_estrazione_medie_in_ordine="SELECT media FROM medie ORDER BY media DESC";
				$risultato_query_estrazione_medie_in_ordine=mysql_query($query_estrazione_medie_in_ordine)
					or die("Impossibile estrarre i valori delle medie ordinate in ordine decrescente: ".mysql_error());
				while($medieOrdinate=mysql_fetch_row($risultato_query_estrazione_medie_in_ordine))
				{
					$mediaOrdinataEstratta[$j]=$medieOrdinate[0];
					$j++;
				}
				$query_quanti_giocatori="SELECT COUNT(*) FROM giocatori";
				$risultato_quanti_giocatori=mysql_query($query_quanti_giocatori)
					or die("Impossibile estrarre quanti giocatori sono salvati nella relativa tabella");
				while($numero_giocatori=mysql_fetch_row($risultato_quanti_giocatori))
					$numeroGiocatori=$numero_giocatori[0];
				$posizioneRiferimento=1;
				$posizione[0]=1;
				echo("<td width='80'><center><b>1<b></center></td>");
				for($i=1;$i<$numeroGiocatori;$i++)
				{
					if($mediaOrdinataEstratta[$i]<$mediaOrdinataEstratta[$i-1])
					{
						$posizioneRiferimento=$i+1;
						$posizione[$i]=$i+1;
					}
					elseif($mediaOrdinataEstratta[$i]==$mediaOrdinataEstratta[$i-1])
					{
						$posizione[$i]=$posizioneRiferimento;
					}
					echo("<td width='80'><center><b>$posizione[$i]<b></center></td>");
				}
			echo("</tr>");
			echo("<tr>");
				// mando a video il totale dei punti
				echo("<td width='80'><center><i><b>Totale pti</b></i></center></td>");
				$query_punti_totali="SELECT puntitotali FROM giocatori, medie WHERE acronimo=acronimogiocatore ORDER BY media DESC";
				$risultato_punti_totali=mysql_query($query_punti_totali)
					or die("Impossibile estrarre i punti totali di ogni giocatore");
				while($punti_totali=mysql_fetch_row($risultato_punti_totali))
					echo("<td width='80'><center><b><i>$punti_totali[0]</i></b></center></td>");
			echo("</tr>");
			echo("<tr>");
				//mando a video quante giornate a giocato ogni giocatore
				echo("<td width='80'><center>GIORNATE</center></td>");
				$query_giornate="SELECT giornate FROM giocatori, medie WHERE acronimo=acronimogiocatore ORDER BY media DESC";
				$risultato_giornate=mysql_query($query_giornate)
					or die("Impossibile estrarre le giornate giocate da ogni giocatore");
				while($giornate=mysql_fetch_row($risultato_giornate))
					echo("<td width='80'><center>$giornate[0]</center></td>");
			echo("</tr>");
			echo("<tr>");
				// mando a video la media punti di ogni giocatore
				echo("<td width='80'><center>MEDIA</center></td>");
				for($i=0;$i<$numeroGiocatori;$i++)
					echo("<td width='80'><center>$mediaOrdinataEstratta[$i]</center></td>");
			echo("</tr>");
		echo("</table>");
		echo("<br>");
		echo("<center><h3>Punti di ogni giocatore divisi per partita</h3></center>");
		echo("<table border=1>");
			echo("<tr>");
				echo("<td width='80'><center><b>Data partita</b></center></td>");
				$risultato_acronimi=mysql_query($query_acronimi);
				while($acronimi=mysql_fetch_row($risultato_acronimi))
					echo("<td width='80'><center><b>$acronimi[0]</b></center></td>");
			echo("</tr>");
			$query_date_partite="SELECT DISTINCT datapartita FROM posizioni";
			$risultato_query_date_partite=mysql_query($query_date_partite)
				or die("Impossibile estrarre le date delle singole partite: ".mysql_error());
			$i=0;
			while($date_estratte=mysql_fetch_row($risultato_query_date_partite))
			{
				$anno=substr($date_estratte[0],6);
				$mese=substr($date_estratte[0],3,2);
				$giorno=substr($date_estratte[0],0,2);
				$date[$i]=$anno."/".$mese."/".$giorno;				
				$i++;
				//con questo script faccio in modo che le date estratte con la select della variabile $query_date_partite vengano salvate in un array con il fomato americano, così da poterle ordinare correttamente
			}
			$numeroPartite=count($date);
			sort($date); // ordino le date precedentemente estratte e salvate con formato americano
			for($i=0;$i<$numeroPartite;$i++)
			{
				$giorno=substr($date[$i],8);
				$mese=substr($date[$i],5,2);
				$anno=substr($date[$i],0,4);
				$dataOrdinata=$giorno."/".$mese."/".$anno;
				echo("<tr>");
					echo("<td width='80'><center>$dataOrdinata</center></td>");
					$query_punti="SELECT punticlassifica
							    FROM posizioni, medie
							    WHERE posizioni.acronimogiocatore=medie.acronimogiocatore AND datapartita='$dataOrdinata'
							    ORDER BY media DESC";
					$risultato_query_punti=mysql_query($query_punti)
						or die("Impossibile estrarre i punti partita di ogni giocatore suddivisi per data partita: ".mysql_error());
					$query_giocatori_partita="SELECT posizioni.acronimogiocatore
									    FROM posizioni, medie
									    WHERE posizioni.acronimogiocatore=medie.acronimogiocatore AND datapartita='$dataOrdinata'
									    ORDER BY media DESC";
					$risultato_query_giocatori_partita=mysql_query($query_giocatori_partita)
						or die("Impossibile estrarre i giocatori di ogni partita suddividi per data partita: ".mysql_error());
					$numGiocatoriPartita=mysql_num_rows($risultato_query_giocatori_partita);
					for($x=0;$x<$numeroGiocatori;$x++)
					{
						$risultato_query_giocatori_partita=mysql_query($query_giocatori_partita);
						$j=0;
						$trovato=0;
						while(($j<$numGiocatoriPartita) and ($trovato==0))
						{
							$giocatore_partita=mysql_fetch_row($risultato_query_giocatori_partita);
							if($giocatore[$x]==$giocatore_partita[0])
								$trovato=1;
							$j++;
						}
						if($trovato==1)
						{
							$punti=mysql_fetch_row($risultato_query_punti);
							echo("<td width='80'><center>$punti[0]</center></td>");
						}
						else
							echo("<td width='80'><center>0</center></td>");
					}
				echo("</tr>");
			}
		echo("</table>");
		?>
		<br>
		<br>
		<a href="VisioStatistiche.php">Torna alla pagina precedente</a>
		<br>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
		<?php
			mysql_close($conn);
		?>
	</body>
</html>