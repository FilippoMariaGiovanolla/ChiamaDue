<html>
	<head>
		<title>Partita</title>
	</head>
	<body>
		<?php
			error_reporting (E_ALL ^ E_NOTICE); // questo comando permette di eliminare dall'output a video le NOTICE indesiderate
			$numero_giocatori=$_POST["numero_giocatori"]; //echo("Il numero di giocatori arrivato a questa pagina &egrave; ".$numero_giocatori);
			for($i=0; $i<$numero_giocatori; $i++)
				$giocatore[]=$_POST["giocatore$i"];
			$mani_libere=$_POST["mani_libere"];
			if($mani_libere=="yes")
				$numero_mani=14;
			else
				$numero_mani=$_POST["mani"]; //echo("Il numero di mani arrivato a questa pagina &egrave; ".$numero_mani);
			
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
		?>
		<form name='partita' ACTION='RegistrazionePartita.php' METHOD='POST'>
			<table border=1>
			<tr>
				<?php
					echo("<td width='100'><b><center>Data partita</center></b></td>");
					if($numero_giocatori>5)
						$larghezza_cella=90*$numero_giocatori+162+20+26;
					else
						$larghezza_cella=90*$numero_giocatori+162+20+20;
					echo("<td width='$larghezza_cella'><h2><center>".$dataOdierna."</center></h2></td>");
					echo("<INPUT NAME='data_partita' TYPE='hidden' VALUE='$dataOdierna'>");
				?>
				<td><b>Cappotto</b></td>   <!--<td><b>Punti mano</b></td>-->
			</tr>
			</table>
			<table border=1>
			<tr>
				<td width="100"><b><center>Nome</center></b></td>
				<?php
					for($i=0; $i<$numero_giocatori; $i++)
					{
						$name_acronimo="giocatore".$i;
						echo("<td width='90'><b><center>".$giocatore[$i]."</center></b></td>");
						echo("<INPUT NAME=$name_acronimo TYPE='hidden' VALUE=$giocatore[$i]>");
					}
				?>
				<td width="68"><b><center>Carta</center></b></td>   <td width="98"><center><b>Seme</b><center></td>
				<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
			</tr>
			</table>
			<table border=1>
				<tr>
					<td width="100"><center><b>Chiam/Socio</b></center></td>
					<?php
						for($i=0; $i<$numero_giocatori; $i++)
						{
							if($numero_giocatori>5)
								echo("<td width='26'><b><center>C</center></b></td><td width='26'><b><center>S</center></b></td></td><td width='26'><b><center>M</center></b></td>");
							else
								echo("<td width='42'><b><center>C</center></b></td><td width='42'><b><center>S</center></b></td>");
							echo("<!--<td width='38'><b><center>Punti</center></b></td>-->");
						}
					?>
					<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width='20'><center><b>C</b></center></td>
					<td width='20'><center><b>Q</b></center></td>
					<td width='20'><center><b>F</b></center></td>
					<td width='20'><center><b>P</b></center></td>
					<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
				</tr>
			</table>
			<table border=1>
				<?php
					for($i=0; $i<$numero_mani; $i++)
					{
						$mano=$i+1;
						$larghezza=100;
						echo("<tr>");
						echo("<td width='100'><b><center>Mano n. ".$mano."</center></b></td>");
						for($j=0; $j<$numero_giocatori; $j++)
						{
							$chiamante="chiamante".$j."mano".$i;
							if($numero_giocatori>5)
								echo("<td width='26'><center><input type='checkbox' name='$chiamante' value='$giocatore[$j]'></center></td>");
							else	
								echo("<td width='42'><center><input type='checkbox' name='$chiamante' value='$giocatore[$j]'></center></td>");
							$socio="socio".$j."mano".$i;
							if($numero_giocatori>5)
								echo("<td width='26'><center><input type='checkbox' name='$socio' value='$giocatore[$j]'></center></td>");
							else
								echo("<td width='42'><center><input type='checkbox' name='$socio' value='$giocatore[$j]'></center></td>");
							$morto="morto".$j."mano".$i;
							if($numero_giocatori>5)
								echo("<td width='26'><center><input type='checkbox' name='$morto' value='$giocatore[$j]'></center></td>");
							//$punti="punti".$j."mano".$i;
							//echo("<td width='38'><textarea name='$punti' rows='1' cols='1'></textarea></td>");
						}
						$cartaChiamata="cartaChiamata".$i;
						echo("<td><textarea name='$cartaChiamata' rows='1' cols='1'></textarea></td>");
						$quotaVittoria="quotaVittoria".$i;
						echo("<td><textarea name='$quotaVittoria' rows='1' cols='1'></textarea></td>");
						$cuori="cuori".$i;
						echo("<td><input type='checkbox' name='$cuori' value='yes'></td>");
						$quadri="quadri".$i;
						echo("<td><input type='checkbox' name='$quadri' value='yes'></td>");
						$fiori="fiori".$i;
						echo("<td><input type='checkbox' name='$fiori' value='yes'></td>");
						$picche="picche".$i;
						echo("<td><input type='checkbox' name='$picche' value='yes'></td>");
						$cappotto="cappotto".$i;
						echo("<td width='61'><center><input type='checkbox' name='$cappotto' value='yes'></center></td>");
						$vittoriaChiamante="vittoriaChiamante".$i;
						if($numero_giocatori>5)
							echo("<td>Vittoria chiam.<input type='checkbox' name='$vittoriaChiamante' value='yes'></td>");
						else
							echo("<td><b>Vittoria chiamante</b><input type='checkbox' name='$vittoriaChiamante' value='yes'></td>");
						echo("</tr>");
					}
				?>
			</table>
			<table border=1>
				<tr>
					<td width="100">&nbsp;</td>
					<?php
						for($i=0; $i<$numero_giocatori; $i++)
						{
							if($numero_giocatori>5)
								echo("<td width='26'><b><center>C</center></b></td><td width='26'><b><center>S</center></b></td></td><td width='26'><b><center>M</center></b></td>");
							else
								echo("<td width='42'><b><center>C</center></b></td><td width='42'><b><center>S</center></b></td>");
							echo("<!--<td width='38'><b><center>Punti</center></b></td>-->");
						}
					?>
					<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="31">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width='20'><center><b>C</b></center></td>
					<td width='20'><center><b>Q</b></center></td>
					<td width='20'><center><b>F</b></center></td>
					<td width='20'><center><b>P</b></center></td>
					<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
				</tr>
			</table>
			<table border=1>
			<tr>
				<td width="100"><b><center>&nbsp;</center></b></td>
				<?php
					for($i=0; $i<$numero_giocatori; $i++)
					{
						$name_acronimo="giocatore".$i;
						echo("<td width='90'><b><center>".$giocatore[$i]."</center></b></td>");
						echo("<INPUT NAME=$name_acronimo TYPE='hidden' VALUE=$giocatore[$i]>");
					}
				?>
				<td width="68"><b><center>Carta</center></b></td>   <td width="98"><center><b>Seme</b><center></td>
				<td width="61">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
			</tr>
			</table>
			<br>
			<!--<table border=1>
				<tr>
					<td width="100"><b><center>Classificato</center></b></td>
					<td><b><center>Punti premio</center></b></td>
				</tr>
				<?php
					/*for($i=0; $i<$numero_giocatori; $i++)
					{
						$posizione_classifica=$i+1;
						$puntiPremio="puntiPremio".$i;
						echo("<tr>");
							echo("<td><center>".$posizione_classifica."</center></td>");
							echo("<td><INPUT TYPE='TEXT' NAME=$puntiPremio SIZE 2></td>");
						echo("</tr>");
					} */
				?>
			</table>
			<br> -->
			<?php
				echo("<INPUT NAME='numero_giocatori' TYPE='hidden' VALUE=$numero_giocatori>");
				echo("<INPUT NAME='numero_mani' TYPE='hidden' VALUE=$numero_mani>");
			?>
			<INPUT TYPE='SUBMIT' NAME='invio' VALUE='Registra partita'>
		</form>
	</body>
</html>