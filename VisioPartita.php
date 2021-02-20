<html>
	</head>
		<title>Visione partita</title>
	</head>
	<body>
		<?php
			$hostname='localhost';
			$username='root';
			$conn=mysql_connect($hostname,$username,'')
				or die("Impossibile stabilire una connessione con il server");
			$db=mysql_select_db('chiama2')
				or die("Impossibile selezionare il database di chiamata al due");
			$partita=$_POST["partita"];
			$query_num_giocatori="SELECT COUNT(*) FROM posizioni WHERE datapartita='$partita'";
			$risultato_num_giocatori=mysql_query($query_num_giocatori)
				or die("Impossibile estrarre il numero di giocatori della partita selezionata");
			while($num_giocatori=mysql_fetch_row($risultato_num_giocatori))
			{
				//echo("Il numero di giocatori della partita selezionata è ".$num_giocatori[0]."<br>");
				$numeroGiocatori=$num_giocatori[0];
			}
			echo("<h2><center><b>Partita del ".$partita."</b></center></h2>"); // PASSAGGIO OK
			echo("<table border=1>");
				echo("<tr>");
					echo("<td width=100><b><center>Data partita</center></b></td>");
					if($numeroGiocatori>5)
						$larghezza_cella=90*$numeroGiocatori+274;
					else
						$larghezza_cella=90*$numeroGiocatori+262;
				echo("<td width='$larghezza_cella'><h2><center>".$partita."</center></h2></td>");
				echo("<td><b>Cappotto</b></td>");
				echo("</tr>");
			echo("</table>");
		?>
		</table>
		<table border=1>
		<tr>
				<td width="100"><b><center>Nome</center></b></td>
			<?php
				$query="SELECT acronimogiocatore FROM posizioni WHERE datapartita='$partita'";
				$risultato=mysql_query($query)
					or die("Impossibile estrarre gli acronimi dei giocatori che hanno giocato questa partita".mysql_error());
				$i=0;
				while($giocatori=mysql_fetch_row($risultato))
				{
					if($numeroGiocatori>5)
						echo("<td width='101'><b><center>".$giocatori[0]."</center></b></td>");
					else
						echo("<td width='102'><b><center>".$giocatori[0]."</center></b></td>");
					$acronimi[$i]=$giocatori[0];
					$i++;
				}
			?>
			<td width="68"><b><center>Carta</center></b></td>   <td width="98"><center><b>Seme</b><center></td>
			<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		</table>
		<table border=1>
		<tr>
			<?php
				if($numeroGiocatori>5)
					echo("<td width='100'><b><center>Chiam/Socio</center></b></td>");
				else
					echo("<td width='100'><b><center>Chiam/Socio</center></b></td>"); 
			?>
				<?php
					for($i=0; $i<$numeroGiocatori; $i++)
					{
						if($numeroGiocatori>5)
							echo("<td width='20'><b><center>C</center></b></td>
							        <td width='20'><b><center>S</center></b></td>
								<td width='20'><b><center>M</center></b></td>
								<td width='23'><b><center>Pti</center></b></td>");
						else
							echo("<td width='25'><b><center>C</center></b></td>
								<td width='25'><b><center>S</center></b></td>
								<td width='40'><b><center>Pti</center></b></td>");
					}
				?>
			<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width='20'><center><b>C</b></center></td>
			<td width='20'><center><b>Q</b></center></td>
			<td width='20'><center><b>F</b></center></td>
			<td width='20'><center><b>P</b></center></td>
			<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
	<table border=1>
		<?php
			$query="SELECT DISTINCT mano FROM chiama2 WHERE datapartita='$partita'";
			$risultato=mysql_query($query)
				or die("Impossibile estrarre le mani della partita selezionata".mysql_error());
			$numeroMani=0;
			while($esisteMano=mysql_fetch_row($risultato))
				$numeroMani++;
			//echo("Numero mani: ".$numeroMani); // conteggio ok
			for($j=0; $j<$numeroGiocatori; $j++)
			   {
				$quanteVolteChiamante[$j]=0;
				$quanteVolteSocio[$j]=0;
				$puntiTotaliGiocatore[$j]=0;
				$quanteVolteMorto[$j]=0;
			   }
			for($i=0; $i<$numeroMani; $i++)
			{
				$mano=$i+1;
				$larghezza=100;
				echo("<tr>");
					echo("<td width='100'><b><center>Mano n. ".$mano."</center></b></td>");
					for($j=0; $j<$numeroGiocatori; $j++)
					{
					  //mando a video i checkbox "chiamante"
					  $query_chiamante="SELECT acronimogiocatore 
								      FROM chiama2 
								      WHERE datapartita='$partita' and mano=$mano and chiamante='S'";
					  $risultato_query_chiamante=mysql_query($query_chiamante)
						or die("Impossibile estrarre l'acronimo giocatore corrispondente al chiamante".mysql_error());
					  while($chiamante_mano=mysql_fetch_row($risultato_query_chiamante))
						$chiamante=$chiamante_mano[0];
					  /*for($k=0;$k<count($acronimi);$k++)
					  {
						 echo("Acronimo ".$acronimi[$k]."<br>");
					  }*/
					  //for($j=0; $j<$numeroGiocatori; $j++)
					  //{
						if(($numeroGiocatori>5) and ($acronimi[$j]==$chiamante))
						{
							echo("<td width='20'><center><input checked type='checkbox' name='$chiamante' value=0></center></td>");
							$quanteVolteChiamante[$j]++;
						}
						elseif(($numeroGiocatori>5) and ($acronimi[$j]!=$chiamante))
							echo("<td width='20'><center><input type='checkbox' name='$chiamante' value=0></center></td>");
						elseif($acronimi[$j]==$chiamante)
						{
							echo("<td width='25'><center><input checked type='checkbox' name='$chiamante' value=0></center></td>");
							$quanteVolteChiamante[$j]++;
						}
						else
							echo("<td width='25'><center><input type='checkbox' name='$chiamante' value=0></center></td>");
					  //}
						
					  //mando a video i checkbox "socio"
					  $query_socio="SELECT acronimogiocatore 
							      FROM chiama2 
							      WHERE datapartita='$partita' and mano=$mano and socio='S'";
					  $risultato_query_socio=mysql_query($query_socio)
						or die("Impossibile estrarre l'acronimo giocatore corrispondente al socio".mysql_error());
					  while($socio_mano=mysql_fetch_row($risultato_query_socio))
						  $socio=$socio_mano[0];
					  //for($j=0; $j<$numeroGiocatori; $j++)
					  //{
						if(($numeroGiocatori>5) and ($acronimi[$j]==$socio))
						{
							echo("<td width='20'><center><input checked type='checkbox' name='$socio' value=0></center></td>");
							$quanteVolteSocio[$j]++;
						}
						elseif($numeroGiocatori>5)
							echo("<td width='20'><center><input type='checkbox' name='$socio' value=0></center></td>");
						elseif($acronimi[$j]==$socio)
						{
							echo("<td width='25'><center><input checked type='checkbox' name='$socio' value=0></center></td>");
							$quanteVolteSocio[$j]++;
						}
						else
							echo("<td width='25'><center><input type='checkbox' name='$socio' value=0></center></td>");
					  //}
						
					  //mando a video il checkbox "morto"
					  $query_morto="SELECT acronimogiocatore 
							      FROM chiama2 
							      WHERE datapartita='$partita' and mano=$mano and morto='S'";
					  $risultato_query_morto=mysql_query($query_morto)
						or die("Impossibile estrarre l'acronimo giocatore corrispondente al morto".mysql_error());
					  while($morto_mano=mysql_fetch_row($risultato_query_morto))
						$morto=$morto_mano[0];
					  //for($j=0; $j<$numeroGiocatori; $j++)
					  //{
						if(($numeroGiocatori>5) and ($acronimi[$j]==$morto))
						{
							echo("<td width='20'><center><input checked type='checkbox' name='$morto' value=0></center></td>");
							$quanteVolteMorto[$j]++;
						}
						elseif($numeroGiocatori>5)
							echo("<td width='20'><center><input type='checkbox' name='$morto' value=0></center></td>");
					  //}
						
					  //mando a video le caselle punti
					  if($numeroGiocatori>5)
						$larg_cella=23;
					  else
						$larg_cella=40;						
					  //estraggo i punti del chiamante nella mano di volta in volta considerata	
						$query_vittoria_chiamante="SELECT punti FROM chiama2 WHERE chiamante='S' and mano=$mano and datapartita='$partita'";
						$risultato_query_vittoria_chiamante=mysql_query($query_vittoria_chiamante)
							or die("Impossibile estrarre i punti dei chiamanti".mysql_error());
						while($punti_chiamante_estratti=mysql_fetch_row($risultato_query_vittoria_chiamante))
							$puntiChiamante=$punti_chiamante_estratti[0];
					  //estraggo i punti del socio nella mano di volta in volta considerata
						$query_vittoria_socio="SELECT punti FROM chiama2 WHERE socio='S' and mano=$mano and datapartita='$partita'";
						$risultato_query_vittoria_socio=mysql_query($query_vittoria_socio)
							or die("Impossibile estrarre i punti dei soci".mysql_error());
						while($punti_socio_estratti=mysql_fetch_row($risultato_query_vittoria_socio))
							$puntiSocio=$punti_socio_estratti[0];
					  //estraggo i punti dei giocatori non chiamanti né soci nella mano di volta in volta considerata
						$query_punti_giocatore="SELECT DISTINCT punti 
										  FROM chiama2 
										  WHERE mano=$mano and datapartita='$partita' and chiamante='N' and socio='N' and morto='N'";
						$risultato_query_punti_giocatore=mysql_query($query_punti_giocatore)
							or die("1 - Impossibile estrarre i punti dei giocatori non chiamanti nè soci".mysql_error());
						while($punti_estratti=mysql_fetch_row($risultato_query_punti_giocatore))
							$puntiGiocatore=$punti_estratti[0];
					  //for($j=0; $j<$numeroGiocatori; $j++)
					  //{
						if(($acronimi[$j]==$chiamante) and ($acronimi[$j]==$socio) and ($puntiChiamante>0))
							echo("<td width='$larg_cella'><b><center>".$puntiChiamante."</center></b></td>");
						elseif(($acronimi[$j]==$chiamante) and ($acronimi[$j]==$socio) and ($puntiChiamante<0))
							echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
						elseif(($acronimi[$j]==$chiamante) and ($acronimi[$j]!=$socio) and ($puntiChiamante>0))
							echo("<td width='$larg_cella'><b><center>".$puntiChiamante."</center></b></td>");
						elseif(($acronimi[$j]==$chiamante) and ($acronimi[$j]!=$socio) and ($puntiChiamante<0))
							echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
						elseif(($acronimi[$j]==$socio) and ($acronimi[$j]!=$chiamante) and ($puntiChiamante>0))
						{
							if($puntiSocio<0)
								echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiSocio."</center></b></font></td>");
							else
								echo("<td width='$larg_cella'><b><center>".$puntiSocio."</center></b></td>");
						}
						elseif(($acronimi[$j]==$socio) and ($acronimi[$j]!=$chiamante) and ($puntiChiamante<0))
						{
							if($puntiSocio<0)
								echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiSocio."</center></b></font></td>");
							else
								echo("<td width='$larg_cella'><b><center>".$puntiSocio."</center></b></td>");
						}
						elseif(($acronimi[$j]!=$socio) and ($acronimi[$j]!=$chiamante) and ($puntiChiamante>0) and ($socio==$chiamante))
						{
							if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto!=$acronimi[$j])))
							{
								if($puntiGiocatore<0)
									echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
								else
									echo("<td width='$larg_cella'><b><center>".$puntiGiocatore."</center></b></td>");
							}
							else
								echo("<td width='$larg_cella'><b><center>0</center></b></td>");
						}
						elseif(($acronimi[$j]!=$socio) and ($acronimi[$j]!=$chiamante) and ($puntiChiamante<0) and ($socio==$chiamante))
						{
							if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto!=$acronimi[$j])))
							{
								if($puntiGiocatore<0)
									echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
								else
									echo("<td width='$larg_cella'><b><center>".$puntiGiocatore."</center></b></td>");
							}
							else
								echo("<td width='$larg_cella'><b><center>0</center></b></td>");
						}
						elseif(($acronimi[$j]!=$chiamante) and ($acronimi[$j]!=$socio) and ($socio!=$chiamante) and ($puntiChiamante>0))
						{
							if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto!=$acronimi[$j])))
							{
								if($puntiGiocatore<0)
									echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
								else
									echo("<td width='$larg_cella'><b><center>".$puntiGiocatore."</center></b></td>");
							}
							else
								echo("<td width='$larg_cella'><b><center>0</center></b></td>");
						}
						elseif(($acronimi[$j]!=$chiamante) and ($acronimi[$j]!=$socio) and ($socio!=$chiamante) and ($puntiChiamante<0))
						{
							if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto!=$acronimi[$j])))
							{
								if($puntiGiocatore<0)
									echo("<td width='$larg_cella'><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
								else
									echo("<td width='$larg_cella'><b><center>".$puntiGiocatore."</center></b></td>");
							}
							else
								echo("<td width='$larg_cella'><b><center>0</center></b></td>");
						}
					  //}
					} // fine for($j=0; $j<$numeroGiocatori; $j++)
				$query_carta_chiamata="SELECT cartaChiamata FROM partita WHERE mano=$mano and datapartita='$partita'";
				$risultato_query_carta_chiamata=mysql_query($query_carta_chiamata)
					or die("Impossibile estrarre la carta chiamata".mysql_error());
				while($carta_chiamata_estratta=mysql_fetch_row($risultato_query_carta_chiamata))
					$cartaChiamata=$carta_chiamata_estratta[0];
				echo("<td width='31'><center><b>".$cartaChiamata."</b></center></td>");
				$query_quota_vittoria="SELECT quotaVittoria FROM partita WHERE mano=$mano and datapartita='$partita'";
				$risultato_query_quota_vittoria=mysql_query($query_quota_vittoria)
					or die("Impossibile estrarre la quota vittoria".mysql_error());
				while($quota_vittoria_estratta=mysql_fetch_row($risultato_query_quota_vittoria))
					$quotaVittoria=$quota_vittoria_estratta[0];
				echo("<td width='31'><center><b>".$quotaVittoria."</b></center></td>");
				$query_seme_chiamato="SELECT seme FROM partita WHERE datapartita='$partita' and mano=$mano";
				$risultato_query_seme_chiamato=mysql_query($query_seme_chiamato)
					or die("Impossibile estrarre il seme chiamato".mysql_error());
				while($seme_chiamato_estratto=mysql_fetch_row($risultato_query_seme_chiamato))
					$semeChiamato=$seme_chiamato_estratto[0];				
				if($semeChiamato=="cuori")
					echo("<td width='20'><center><input checked type='checkbox' name='cuori' value=0></center></td>");
				else
					echo("<td width='20'><center><input type='checkbox' name='cuori' value=0></center></td>");
				if($semeChiamato=="quadri")
					echo("<td width='20'><center><input checked type='checkbox' name='quadri' value=0></center></td>");
				else
					echo("<td width='20'><center><input type='checkbox' name='quadri' value=0></center></td>");
				if($semeChiamato=="fiori")
					echo("<td width='20'><center><input checked type='checkbox' name='fiori' value=0></center></td>");
				else
					echo("<td width='20'><center><input type='checkbox' name='fiori' value=0></center></td>");
				if($semeChiamato=="picche")
					echo("<td width='20'><center><input checked type='checkbox' name='picche' value=0></center></td>");
				else
					echo("<td width='20'><center><input type='checkbox' name='picche' value=0></center></td>");
				$query_estrazione_cappotto="SELECT cappotto FROM partita WHERE datapartita='$partita' and mano=$mano";
				$risultato_query_estrazione_cappotto=mysql_query($query_estrazione_cappotto)
					or die("Impossibile estrarre il dato del cappotto: ".mysql_error());
				while($cappotto_estratto=mysql_fetch_row($risultato_query_estrazione_cappotto))
					$cappotto=$cappotto_estratto[0];
				if($cappotto=="S")
					echo("<td width='61'><center><input checked type='checkbox' name='cappotto' value=0></center></td>");
				else
					echo("<td width='61'><center><input type='checkbox' name='cappotto' value=0></center></td>");
				echo("</tr>");
			} // fine for($i=0; $i<$numeroMani; $i++)
		?>
	</table>
	<table border=1>
		<tr>
			<td width='100'><b><center>Totale punti</center></b></td>
			<?php
				for($j=0; $j<$numeroGiocatori; $j++)
				{
					$query_punti_totali="SELECT totpunti FROM totpuntipartita WHERE datapartita='$partita' and acronimogiocatore='$acronimi[$j]'";
					$risultato_query_punti_totali=mysql_query($query_punti_totali)
						or die("Impossibile estrarre il totale dei punti di ogni giocatore per questa partita: ".mysql_error());
					while($punti_totali_estratti=mysql_fetch_row($risultato_query_punti_totali))
						$puntiTotaliGiocatore=$punti_totali_estratti[0];
					if($numeroGiocatori>5)
					{
						echo("<td width='20'><b><center>".$quanteVolteChiamante[$j]."</center></b></td>");
						echo("<td width='20'><b><center>".$quanteVolteSocio[$j]."</center></b></td>");
						echo("<td width='20'><b><center>".$quanteVolteMorto[$j]."</center></b></td>");
						if($puntiTotaliGiocatore<0)
							echo("<td width='23'><font color='##FF0000'><b><center>".$puntiTotaliGiocatore."</center></b></font></td>");
						else
							echo("<td width='23'><b><center>".$puntiTotaliGiocatore."</center></b></td>");
					}
					else
					{	
						echo("<td width='25'><b><center>".$quanteVolteChiamante[$j]."</center></b></td>");
						echo("<td width='25'><b><center>".$quanteVolteSocio[$j]."</center></b></td>");
						if($puntiTotaliGiocatore<0)
							echo("<td width='40'><font color='##FF0000'><b><center>".$puntiTotaliGiocatore."</center></b></font></td>");
						else
							echo("<td width='40'><b><center>".$puntiTotaliGiocatore."</center></b></td>");
					}
				}
			?>
		</tr>
	</table>
	<table border=1>
		<tr>
			<td width='100'><b><center>POSIZIONE</center></b></td>
			<?php
				for($j=0; $j<$numeroGiocatori; $j++)
				{
					$query_rango_giocatori="SELECT posizione FROM posizioni WHERE datapartita='$partita' and acronimogiocatore='$acronimi[$j]'";
					$risultato_query_rango_giocatori=mysql_query($query_rango_giocatori)
						or die("Impossibile estrarre le posizioni dei giocatori di questa partita: ".mysql_error());
					while($posizioni_estratte=mysql_fetch_row($risultato_query_rango_giocatori))
						$rango=$posizioni_estratte[0];
					if($numeroGiocatori>5)
						echo("<td width='101'><b><center>".$rango."</center></b></td>");
					else
						echo("<td width='102'><b><center>".$rango."</center></b></td>");
				}
			?>
		</tr>
	</table>
	<table border=1>
		<tr>
			<td width='100'><b><center>Pti Classifica</center></b></td>
			<?php
				for($j=0; $j<$numeroGiocatori; $j++)
				{
					$query_punti_classifica="SELECT punticlassifica FROM posizioni WHERE datapartita='$partita' and acronimogiocatore='$acronimi[$j]'";
					$risultato_query_punti_classifica=mysql_query($query_punti_classifica)
						or die("Impossibile estrarre i punti classifica dei giocatori di questa partita: ".mysql_error());
					while($punti_estratti=mysql_fetch_row($risultato_query_punti_classifica))
						$puntiClassificaPartita=$punti_estratti[0];
					if($numeroGiocatori>5)
						echo("<td width='101'><b><center>".$puntiClassificaPartita."</center></b></td>");
					else
						echo("<td width='102'><b><center>".$puntiClassificaPartita."</center></b></td>");
				}
			?>
		</tr>
	</table>
	<br>
	<br>
	<br>
	<a href="VisioStatistiche.php">Torna alla pagina di scelta della statistica da visualizzare</a>
	<br>
	<br>
	<a href="Chiama2index.php">Torna alla pagina iniziale</a>
	<br>
	<br>
	Per tornare alle pagine immediatamente precedenti a questa, utilizzare la freccia "indietro" del browser
	</body>
	<?php
		mysql_close($conn);
	?>
</html>