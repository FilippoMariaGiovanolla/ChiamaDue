<html>
	<head>
		<title>Registrazione partita</title>
	</head>
	<body>
	<?php
		error_reporting (E_ALL ^ E_NOTICE); // questo comando permette di eliminare dall'output a video le NOTICE indesiderate
		$hostname='localhost';
		$username='root';
		$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server");
		$db=mysql_select_db('chiama2')
			or die("Impossibile selezionare il database di chiamata al due");
		$dataPartita=$_POST["data_partita"]; //echo("La data della partita &egrave; ".$dataPartita."<br>"); //CONTROLLATO: PASSAGGIO OK
		$numeroGiocatori=$_POST["numero_giocatori"]; //echo("Il numero dei giocatori &egrave; ".$numeroGiocatori."<br>"); //CONTROLLATO: PASSAGGIO OK
		$numeroMani=$_POST["numero_mani"]; //echo("Il numero delle mani &egrave; ".$numeroMani."<br>"); //CONTROLLATO: PASSAGGIO OK
		for($i=0;$i<$numeroGiocatori;$i++)
		{
			$giocatori[]=$_POST["giocatore$i"];
			$num_gio=$i+1;
			//echo("Giocatore ".$num_gio." ".$giocatori[$i]."<br>");  // CONTROLLATO: PASSAGGIO OK
		}
		for($i=0;$i<$numeroGiocatori;$i++)
		{
			$query="UPDATE giocatori SET giornate=giornate+1 WHERE acronimo='$giocatori[$i]'";
			mysql_query($query)
				or die("Impossibile incrementare il valore delle giornate per i giocatori di questa partita");
		}
		for($i=0;$i<$numeroMani;$i++)
		{
			$num_man=$i+1;
			for($j=0;$j<$numeroGiocatori;$j++)
			{
				$chiamante[$i][$j]=$_POST["chiamante$j"."mano$i"];
				//if(strlen($chiamante[$i][$j])==6)
					//echo("Chiamante mano ".$num_man.": ".$chiamante[$i][$j]."<br>"); // PASSAGGIO OK
				$socio[$i][$j]=$_POST["socio$j"."mano$i"];
				//if(strlen($socio[$i][$j])==6)
					//echo("Socio mano ".$num_man.": ".$socio[$i][$j]."<br>"); // PASSAGGIO OK
					
				// determino se il chiamante si è chiamato in mano	
				if((strlen($chiamante[$i][$j])==6) and (strlen($socio[$i][$j])==6)) // se il chiamante si è chiamato in mano la variabile vale 1, se non si è chiamato in mano vale 0
					$chiamatoInMano[$i]=1;
				else
					$chiamatoInMano[$i]=0;
					
				if($numeroGiocatori>5)
				{
					$morto[$i][$j]=$_POST["morto$j"."mano$i"];
					//if($morto[$i][$j]==$giocatori[$j])
						//echo("Morto mano ".$num_man.": ".$morto[$i][$j]."<br>"); // PASSAGGIO OK
				}
				//$punti[$i][$j]=$_POST["punti$j"."mano$i"];
				//echo("Punti mano".$num_man.": ".$punti[$i][$j]."<br>"); // PASSAGGIO OK
			}
			$cartaChiamata[$i]=$_POST["cartaChiamata$i"];
			//echo("Carta chiamata mano ".$num_man.": ".$cartaChiamata[$i]."<br>"); // PASSAGGIO OK
			$quotaVittoria[$i]=$_POST["quotaVittoria$i"];
			//echo("Quota vittoria mano ".$num_man.": ".$quotaVittoria[$i]."<br>"); // PASSAGGIO OK
			$cuori[$i]=$_POST["cuori$i"];
				if($cuori[$i]=="yes")
					$seme[$i]="cuori";
					//echo("Seme chiamato mano ".$num_man.": cuori<br>"); // PASSAGGIO OK
			$quadri[$i]=$_POST["quadri$i"];
				if($quadri[$i]=="yes")
					$seme[$i]="quadri";
					//echo("Seme chiamato mano ".$num_man.": quadri<br>"); // PASSAGGIO OK
			$fiori[$i]=$_POST["fiori$i"];
				if($fiori[$i]=="yes")
					$seme[$i]="fiori";
					//echo("Seme chiamato mano ".$num_man.": fiori<br>"); // PASSAGGIO OK
			$picche[$i]=$_POST["picche$i"];
				if($picche[$i]=="yes")
					$seme[$i]="picche";
					//echo("Seme chiamato mano ".$num_man.": picche<br>"); // PASSAGGIO OK
			//echo("Seme chiamato mano ".$num_man.":".$seme[$i]."<br>"); // PASSAGGIO OK
			$cappotto[$i]=$_POST["cappotto$i"];
				//if($cappotto[$i]=="yes")
					//echo("Mano ".$num_man.": CAPPOTTO<br>"); // PASSAGGIO OK
			$vittoriaChiamante[$i]=$_POST["vittoriaChiamante$i"];
				//if($vittoriaChiamante[$i]=="yes")
					//echo("Il chiamante ha vinto la mano ".$num_man."<br>"); //PASSAGGIO OK
			if(($quotaVittoria[$i]<=69) and ($cappotto[$i]=="yes"))
				$puntiMano[$i]=6;
			elseif(($quotaVittoria[$i]<=69) and ($cappotto[$i]!="yes"))
				$puntiMano[$i]=2;
			elseif(($quotaVittoria[$i]>=70) and ($quotaVittoria[$i]<=79) and ($cappotto[$i]=="yes"))
				$puntiMano[$i]=8;
			elseif(($quotaVittoria[$i]>=70) and ($quotaVittoria[$i]<=79) and ($cappotto[$i]!="yes"))
				$puntiMano[$i]=4;
			elseif(($quotaVittoria[$i]>=80) and ($cappotto[$i]=="yes"))
				$puntiMano[$i]=10;
			elseif(($quotaVittoria[$i]>=80) and ($cappotto[$i]!="yes"))
				$puntiMano[$i]=6;
			//echo("Punti mano ".$num_man.": ".$puntiMano[$i]."<br>");
			//echo("Sto per inserire questi dati: data partita=".$dataPartita.", mano=".$num_man.", carta chiamata=".$cartaChiamata[$i].", quota vittoria=".$quotaVittoria[$i].", seme chiamato=".$seme[$i].", punti mano=".$puntiMano[$i]."<br>");
			$query="INSERT INTO partita (dataPartita, mano, cartaChiamata, quotaVittoria, seme, puntiMano, cappotto) VALUES ('$dataPartita', $num_man, '$cartaChiamata[$i]', '$quotaVittoria[$i]', '$seme[$i]', $puntiMano[$i],'N')";
			mysql_query($query)
				or die("Impossibile inserire i dati nella tabella partita: ".mysql_error());
		}
		for($i=0; $i<$numeroMani; $i++)
		{
			$mano=$i+1;
			for($j=0;$j<$numeroGiocatori;$j++)
			{
				$query="INSERT INTO chiama2 (acronimoGiocatore, dataPartita, mano, chiamante, socio, morto, punti) VALUES ('$giocatori[$j]', '$dataPartita', '$mano','N','N','N',0)";
				mysql_query($query)
					or die("Impossibile inizializzare la tabella 'chiama2'");
				$query2="INSERT INTO posizioni VALUES ('$dataPartita','$giocatori[$j]',0,0)";
				mysql_query($query2);
					//or die("Impossibile inizializzare la tabella posizioni");
				$query3="INSERT INTO totpuntipartita VALUES ('$dataPartita','$giocatori[$j]',0)";
				mysql_query($query3);
			}
		}
	?>
	<table border=1 width="100%">
		<tr>
			<?php
				if($numeroGiocatori>5) // se i giocatori sono 6
				{
					echo("<td width='8%'><b><center>Data partita</center></b></td>");
					echo("<td colspan=30><font size=5><center><strong>".$dataPartita."</strong></center></font></td>");
					echo("<td width='8%' rowspan=3><b><div align='center'>Cappotto</div></b></td>");
				}
				else // se i giocatori sono 5
				{
					echo("<td width='8%'><b><center>Data partita</center></b></td>");
					echo("<td colspan=21><font size=5><center><strong>".$dataPartita."</strong></center></font></td>");
					echo("<td width='8%' rowspan=3><b><div align='center'>Cappotto</div></b></td>");
					
				}					
			?>
		</tr>
		<tr>
			<?php
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='8%'><b><center>Acronimo</center></b></td>");
				else  // se i giocatori sono 5
					echo("<td width='8%'><b><center>Acronimo</center></b></td>");

				for($i=0; $i<$numeroGiocatori; $i++)
					if($numeroGiocatori>5) // se i giocatori sono 6
						echo("<td colspan=4><b><center>".$giocatori[$i]."</center></b></td>");
					else // se i giocatori sono 5
						echo("<td colspan=3'><b><center>".$giocatori[$i]."</center></b></td>");

				if($numeroGiocatori>5) // se i giocatori sono 6
				echo("<td colspan=2><b><center>Carta</center></b></td>
				      <td colspan=4><center><b>Seme</b><center></td>");
				else  // se i giocatori sono 5
				echo("<td colspan=2><b><center>Carta</center></b></td>
				      <td colspan=4><center><b>Seme</b><center></td>");
			?>
		</tr>
		<tr>
			<?php
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='8%'><b><center>Chiam/Socio</center></b></td>");
				else // se i giocatori sono 5
					echo("<td width='8%'><b><center>Chiam/Socio</center></b></td>"); 
			
				for($i=0; $i<$numeroGiocatori; $i++)
				{
					if($numeroGiocatori>5) // se i giocatori sono 6
						echo("<td width='3.5%'><b><center>C</center></b></td>
							  <td width='3.5%'><b><center>S</center></b></td>
							  <td width='3.5%'><b><center>M</center></b></td>
							  <td width='3.5%'><b><center>Pti</center></b></td>");
					else // se i giocatori sono 5
						echo("<td width='4%'><b><center>C</center></b></td>
							<td width='4%'><b><center>S</center></b></td>
							<td width='4%'><b><center>Pti</center></b></td>");
				}

				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td colspan=2>&nbsp;</td>
					<td width='3.5%'><center><b>C</b></center></td>
					<td width='3.5%'><center><b>Q</b></center></td>
					<td width='3.5%'><center><b>F</b></center></td>
					<td width='3.5%'><center><b>P</b></center></td>");
				else // se i giocatori sono 5
					echo("<td colspan=2>&nbsp;</td>
					<td width='4%'><center><b>C</b></center></td>
					<td width='4%'><center><b>Q</b></center></td>
					<td width='4%'><center><b>F</b></center></td>
					<td width='4%'><center><b>P</b></center></td>");
			?>
		</tr>
	<?php
		//inizializzo a zero i contatori che conteranno quante volte un giocatore è stato chiamante o socio, i punti totali di ogni giocatore e 
		//quante volte ogni giocatore ha fatto il ruolo del morto
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
			echo("<tr>");
			if($numeroGiocatori>5) // se i giocatori sono 6
				echo("<td width='8%'><b><center>Mano n. ".$mano."</center></b></td>");
			else // se i giocatori sono 5
			echo("<td width='8%'><b><center>Mano n. ".$mano."</center></b></td>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				//mando a video i checkbox "chiamante"
				if(($numeroGiocatori>5) and (strlen($chiamante[$i][$j])==6))
					{
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$chiamante' value='$giocatori[$j]'></center></td>");
					$quanteVolteChiamante[$j]++;
					$update_chiama2_chiamante="UPDATE chiama2 
											SET chiamante='S' 
											WHERE acronimoGiocatore='$giocatori[$j]' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_chiamante)
						or die("Impossibile inserire nel db i chiamanti di questa partita");
					}
				elseif(($numeroGiocatori>5) and ($chiamante[$i][$j]!=6))
					echo("<td width='3.5%'><center><input type='checkbox' name='$chiamante' value='$giocatori[$j]'></center></td>");
				elseif(strlen($chiamante[$i][$j])==6)
					{
					echo("<td width='4%'><center><input checked type='checkbox' name='$chiamante' value='$giocatore[$j]'></center></td>");
					$quanteVolteChiamante[$j]++;
					$update_chiama2_chiamante="UPDATE chiama2 
											SET chiamante='S' 
											WHERE acronimoGiocatore='$giocatori[$j]' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_chiamante)
						or die("Impossibile inserire nel db i chiamanti di questa partita");
					}
				else
					echo("<td width='4%'><center><input type='checkbox' name='$chiamante' value='$giocatore[$j]'></center></td>");
				
				//mando a video i checkbox "socio"
				if(($numeroGiocatori>5) and (strlen($socio[$i][$j])==6))
					{
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$socio' value='$giocatori[$j]'></center></td>");
					$quanteVolteSocio[$j]++;
					$update_chiama2_socio="UPDATE chiama2 
										SET socio='S' 
										WHERE acronimoGiocatore='$giocatori[$j]' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_socio)
						or die("Impossibile inserire nel db i soci di questa partita");
					}
				elseif($numeroGiocatori>5)
					echo("<td width='3.5%'><center><input type='checkbox' name='$socio' value='$giocatori[$j]'></center></td>");
				elseif(strlen($socio[$i][$j])==6)
					{
					echo("<td width='4%'><center><input checked type='checkbox' name='$socio' value='$giocatore[$j]'></center></td>");
					$quanteVolteSocio[$j]++;
					$update_chiama2_socio="UPDATE chiama2 
										SET socio='S' 
										WHERE acronimoGiocatore='$giocatori[$j]' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_socio)
						or die("Impossibile inserire nel db i soci di questa partita");
					}
				else
					echo("<td width='4%'><center><input type='checkbox' name='$socio' value='$giocatore[$j]'></center></td>");
				
				//mando a video i checkbox "morto"
				if(($numeroGiocatori>5) and (strlen($morto[$i][$j])==6))
					{
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$morto' value='$giocatori[$j]'></center></td>");
					$quanteVolteMorto[$j]++;
					$update_chiama2_morto="UPDATE chiama2 
										SET morto='S' 
										WHERE acronimoGiocatore='$giocatori[$j]' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_morto)
						or die("Impossibile inserire nel db i morti di questa partita");
					}
				elseif($numeroGiocatori>5)
					echo("<td width='3.5%'><center><input type='checkbox' name='$morto' value='$giocatori[$j]'></center></td>");
					
				//mando a video le caselle punti
				if($numeroGiocatori>5) // se i giocatori sono 6
					$larg_cella="'3.5%'";
				else // se i giocatori sono 5
					$larg_cella="'4%'";
				if((strlen($chiamante[$i][$j])==6) and (strlen($socio[$i][$j])==6) and ($vittoriaChiamante[$i]=="yes"))
					{
					$puntiChiamante=$puntiMano[$i]*2;
					$chiHaChiamato=$chiamante[$i][$j]; // necessito di inserire questa variabile perchè se nell'update qui sotto metto la variabile $chiamante[$i][$j] l'update non funziona
					if($puntiChiamante<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiChiamante."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiChiamante 
										WHERE acronimoGiocatore='$chiHaChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun chiamante per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiChiamante;
					}
				elseif((strlen($chiamante[$i][$j])==6) and (strlen($socio[$i][$j])==6) and ($vittoriaChiamante[$i]!="yes"))
					{
					$puntiChiamante=($puntiMano[$i]*(-2));
					$chiHaChiamato=$chiamante[$i][$j]; // necessito di inserire questa variabile perchè se nell'update qui sotto metto la variabile $chiamante[$i][$j] l'update non funziona
					if($puntiChiamante<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiChiamante."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiChiamante 
										WHERE acronimoGiocatore='$chiHaChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun chiamante per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiChiamante;
					}
				elseif((strlen($chiamante[$i][$j])==6) and (strlen($socio[$i][$j])!=6) and ($vittoriaChiamante[$i]=="yes"))
					{
					$puntiChiamante=$puntiMano[$i];
					$chiHaChiamato=$chiamante[$i][$j]; // necessito di inserire questa variabile perchè se nell'update qui sotto metto la variabile $chiamante[$i][$j] l'update non funziona
					if($puntiChiamante<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiChiamante."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiChiamante 
										WHERE acronimoGiocatore='$chiHaChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun chiamante per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiChiamante;
					}
				elseif((strlen($chiamante[$i][$j])==6) and (strlen($socio[$i][$j])!=6) and ($vittoriaChiamante[$i]!="yes"))
					{
					$puntiChiamante=$puntiMano[$i]*(-1);
					$chiHaChiamato=$chiamante[$i][$j]; // necessito di inserire questa variabile perchèè se nell'update qui sotto metto la variabile $chiamante[$i][$j] l'update non funziona
					if($puntiChiamante<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiChiamante."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiChiamante."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiChiamante 
										WHERE acronimoGiocatore='$chiHaChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun chiamante per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiChiamante;
					}
				elseif((strlen($socio[$i][$j])==6) and (strlen($chiamante[$i][$j])!=6) and ($vittoriaChiamante[$i]=="yes"))
					{
					$puntiSocio=$puntiMano[$i]/2;
					$chiEStatoChiamato=$socio[$i][$j]; // necessito di inserire questa variabile perchè se nell'update qui sotto metto la variabile $socio[$i][$j] l'update non funziona
					if($puntiSocio<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiSocio."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiSocio."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiSocio 
										WHERE acronimoGiocatore='$chiEStatoChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun socio per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiSocio;
					}
				elseif((strlen($socio[$i][$j])==6) and (strlen($chiamante[$i][$j])!=6) and ($vittoriaChiamante[$i]!="yes"))
					{
					$puntiSocio=($puntiMano[$i]/2)*(-1);
					$chiEStatoChiamato=$socio[$i][$j]; // necessito di inserire questa variabile perchè se nell'update qui sotto metto la variabile $socio[$i][$j] l'update non funziona
					if($puntiSocio<0)
						echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiSocio."</center></b></font></td>");
					else
						echo("<td width=".$larg_cella."><b><center>".$puntiSocio."</center></b></td>");
					$update_chiama2_punti="UPDATE chiama2 
										SET punti=$puntiSocio
										WHERE acronimoGiocatore='$chiEStatoChiamato' AND dataPartita='$dataPartita' AND mano='$mano'";
					mysql_query($update_chiama2_punti)
						or die("Impossibile inserire nel db i punti di ciascun socio per ogni mano");
					$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiSocio;
					}
				elseif((strlen($chiamante[$i][$j])!=6) and (strlen($socio[$i][$j])!=6) and ($chiamatoInMano[$i]==1) and ($vittoriaChiamante[$i]=="yes"))
					{
					if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto[$i][$j]!=$giocatori[$j])))
					{
						$puntiGiocatore=(($puntiMano[$i]*2)/(-4));
						if($puntiGiocatore<0)
							echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
						else
							echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
						$update_chiama2_punti="UPDATE chiama2 
										SET punti='$puntiGiocatore' 
										WHERE chiamante='N' AND socio='N' AND dataPartita='$dataPartita' AND mano='$mano' and punti=0";
						mysql_query($update_chiama2_punti)
							or die("1 - Impossibile inserire nel db i punti dei giocatori non chiamenti n&eacute; soci");
						//}
						$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiGiocatore;
					}
					else
					{
						$puntiGiocatore=0;
						echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
					}
					}
				elseif((strlen($chiamante[$i][$j])!=6) and (strlen($socio[$i][$j])!=6) and ($chiamatoInMano[$i]==1) and ($vittoriaChiamante[$i]!="yes"))
					{
					if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto[$i][$j]!=$giocatori[$j])))
					{
						$puntiGiocatore=(($puntiMano[$i]*2)/(4));
						if($puntiGiocatore<0)
							echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
						else
							echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
						$update_chiama2_punti="UPDATE chiama2 
										SET punti='$puntiGiocatore' 
										WHERE chiamante='N' AND socio='N' AND dataPartita='$dataPartita' AND mano='$mano' and punti=0"; 
						mysql_query($update_chiama2_punti)
							or die("2 - Impossibile inserire nel db i punti dei giocatori non chiamenti n&eacute; soci");
						$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiGiocatore;
					}
					else
					{
						$puntiGiocatore=0;
						echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
					}
					}
				elseif((strlen($chiamante[$i][$j])!=6) and (strlen($socio[$i][$j])!=6) and ($chiamatoInMano[$i]==0) and ($vittoriaChiamante[$i]=="yes"))
					{
					if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto[$i][$j]!=$giocatori[$j])))
					{
						$puntiGiocatore=((($puntiMano[$i]+($puntiMano[$i]/2))/3))*(-1);
						if($puntiGiocatore<0)
							echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
						else
							echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
						$update_chiama2_punti="UPDATE chiama2 
										SET punti='$puntiGiocatore' 
										WHERE chiamante='N' AND socio='N' AND dataPartita='$dataPartita' AND mano='$mano' and punti=0";
						mysql_query($update_chiama2_punti)
							or die("3 - Impossibile inserire nel db i punti dei giocatori non chiamenti n&eacute; soci");
						$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiGiocatore;
					}
					else
					{
						$puntiGiocatore=0;
						echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
					}
					}
				elseif((strlen($chiamante[$i][$j])!=6) and (strlen($socio[$i][$j])!=6) and ($chiamatoInMano[$i]==0) and ($vittoriaChiamante[$i]!="yes"))
					{
					if(($numeroGiocatori<=5) or (($numeroGiocatori>5) and ($morto[$i][$j]!=$giocatori[$j])))
					{
						$puntiGiocatore=((($puntiMano[$i]+($puntiMano[$i]/2))/3));
						if($puntiGiocatore<0)
							echo("<td width=".$larg_cella."><font color='##FF0000'><b><center>".$puntiGiocatore."</center></b></font></td>");
						else
							echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
						$update_chiama2_punti="UPDATE chiama2 
										SET punti='$puntiGiocatore' 
										WHERE chiamante='N' AND socio='N' AND dataPartita='$dataPartita' AND mano='$mano' and punti=0";
						mysql_query($update_chiama2_punti)
							or die("4 - Impossibile inserire nel db i punti dei giocatori non chiamenti n&eacute; soci");
						$puntiTotaliGiocatore[$j]=$puntiTotaliGiocatore[$j]+$puntiGiocatore;
					}
					else
					{
						$puntiGiocatore=0;
						echo("<td width=".$larg_cella."><b><center>".$puntiGiocatore."</center></b></td>");
					}
					}
			} // fine for($j=0; $j<$numeroGiocatori; $j++)
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				if($numeroGiocatori>5)
				{
					for($j=0; $j<$numeroGiocatori; $j++)
					{
						if($morto[$i][$j]==$giocatori[$j])
						{
							$update_punti_morto="UPDATE chiama2
											SET punti=0
											WHERE chiamante='N' and socio='N' and datapartita='$dataPartita' and mano='$mano' and morto='S'";
							mysql_query($update_punti_morto)
								or die("Impossibile impostare a zero i punti dei giocatori che, nelle varie mani, hanno saltato il turno");
						}
					}
				}
			}
			if($numeroGiocatori>5) // se i giocatori sono 6
			{
				echo("<td width='3.5%'><center><b>".$cartaChiamata[$i]."</b></center></td>");
				echo("<td width='3.5%'><center><b>".$quotaVittoria[$i]."</b></center></td>");
			}
			else // se i giocatori sono 5
			{
				echo("<td width='4%'><center><b>".$cartaChiamata[$i]."</b></center></td>");
				echo("<td width='4%'><center><b>".$quotaVittoria[$i]."</b></center></td>");
			}
			
			if($cuori[$i]=="yes")
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$cuori[$i]' value='$cuori[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input checked type='checkbox' name='$cuori[$i]' value='$cuori[$i]'></center></td>");
			else
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input type='checkbox' name='$cuori[$i]' value='$cuori[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input type='checkbox' name='$cuori[$i]' value='$cuori[$i]'></center></td>");
			if($quadri[$i]=="yes")
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$quadri[$i]' value='$quadri[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input checked type='checkbox' name='$quadri[$i]' value='$quadri[$i]'></center></td>");
			else
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input type='checkbox' name='$quadri[$i]' value='$quadri[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input type='checkbox' name='$quadri[$i]' value='$quadri[$i]'></center></td>");
			if($fiori[$i]=="yes")
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$fiori[$i]' value='$fiori[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input checked type='checkbox' name='$fiori[$i]' value='$fiori[$i]'></center></td>");
			else
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input type='checkbox' name='$fiori[$i]' value='$fiori[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input type='checkbox' name='$fiori[$i]' value='$fiori[$i]'></center></td>");
			if($picche[$i]=="yes")
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input checked type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='4%'><center><input checked type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
			else
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='3.5%'><center><input type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
				else // se i giocatori sono 5
				echo("<td width='4%'><center><input type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
			if($cappotto[$i]=="yes")
			{
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='8%'><center><input checked type='checkbox' name='$cappotto[$i]' value='$cappotto[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='8%'><center><input checked type='checkbox' name='$cappotto[$i]' value='$cappotto[$i]'></center></td>");
				$update_cappotto="UPDATE partita
								SET cappotto='S'
								WHERE datapartita='$dataPartita' and mano='$mano'";
				mysql_query($update_cappotto)
					or die("Impossibile impostare ad S il valore del campo cappotto".mysql_error());
			}
			else
			{
				if($numeroGiocatori>5) // se i giocatori sono 6
					echo("<td width='8%'><center><input type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
				else // se i giocatori sono 5
					echo("<td width='8%'><center><input type='checkbox' name='$picche[$i]' value='$picche[$i]'></center></td>");
				$update_cappotto="UPDATE partita
								SET cappotto='N'
								WHERE datapartita='$dataPartita' and mano='$mano'";
				mysql_query($update_cappotto)
					or die("Impossibile impostare ad N il valore del campo cappotto".mysql_error());
			}
			echo("</tr>");
		} // fine for($i=0; $i<$numeroMani; $i++)
		echo("<tr>");
			if($numeroGiocatori>5) // se i giocatori sono 6
				echo("<td width='8%'><b><center>Totale punti</center></b></td>");
			else // se i giocatori sono 5
				echo("<td width='8%'><b><center>Totale punti</center></b></td>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				if($numeroGiocatori>5) // se i giocatori sono 6
					{
					echo("<td width='3.5%'><b><center>".$quanteVolteChiamante[$j]."</center></b></td>");
					echo("<td width='3.5%'><b><center>".$quanteVolteSocio[$j]."</center></b></td>");
					echo("<td width='3.5%'><b><center>".$quanteVolteMorto[$j]."</center></b></td>");
					if($puntiTotaliGiocatore[$j]<0)
						echo("<td width='3.5%'><font color='##FF0000'><b><center>".$puntiTotaliGiocatore[$j]."</center></b></font></td>");
					else
						echo("<td width='3.5%'><b><center>".$puntiTotaliGiocatore[$j]."</center></b></td>");
					}
				else // se i giocatori sono 5
					{
					echo("<td width='4%'><b><center>".$quanteVolteChiamante[$j]."</center></b></td>");
					echo("<td width='4%'><b><center>".$quanteVolteSocio[$j]."</center></b></td>");
					if($puntiTotaliGiocatore[$j]<0)
						echo("<td width='4%'><font color='##FF0000'><b><center>".$puntiTotaliGiocatore[$j]."</center></b></font></td>");
					else
						echo("<td width='4%'><b><center>".$puntiTotaliGiocatore[$j]."</center></b></td>");
					}
				$query="UPDATE totpuntipartita 
						SET totPunti=$puntiTotaliGiocatore[$j]
						WHERE dataPartita='$dataPartita' AND acronimoGiocatore='$giocatori[$j]'";
				mysql_query($query)
					or die("Impossibile compilare il campo 'totPunti' della tabella totpuntipartita: ".mysql_error());
			}
			echo("<td colspan=7 rowspan=3>&nbsp;</td>");
		echo("</tr>");
		



		//algoritmo per mandare a video i valori delle posizioni
		echo("<tr>");
			if($numeroGiocatori>5) // se i giocatori sono 6
				echo("<td width='8%'><b><center>POSIZIONE</center></b></td>");
			else // se i giocatori sono 5
				echo("<td width='8%'><b><center>POSIZIONE</center></b></td>");
			
			// creo un array bidimensionale dove inserire, nella prima colonna, i punteggi che poi andrò ad ordinare in ordine decrescente e, nella seconda colonna, inizializzo il primo elemento ad 1, perché poi la prima colonna conterrà il primo classificato della mano (la seconda colonna della matrice contiene la classifica finale della partita)
			//echo("Punteggi ordinati per giocatore:<br>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				$punteggio[$j][0]=round($puntiTotaliGiocatore[$j]+($quanteVolteChiamante[$j]*1/10)+($quanteVolteSocio[$j]*1/100), 2);
				$perConfronto[$j]=$punteggio[$j][0];
				if($j==0) // se siamo nella prima riga dell'array bidimensionale
					$punteggio[$j][1]=1;
				else // se non siamo nella prima riga dell'array bidimensionale
					$punteggio[$j][1]=0;
				//echo($punteggio[$j][0]."<br>");
			}
			do
			{
				$effettuatiScambi=0;
				for($j=0; $j<$numeroGiocatori-1; $j++)
				{
					if($punteggio[$j][0]<$punteggio[$j+1][0])
					{
						$ausiliaria=$punteggio[$j][0];
						$punteggio[$j][0]=$punteggio[$j+1][0];
						$punteggio[$j+1][0]=$ausiliaria;
						$effettuatiScambi=1;
					}
				}
			}
			while($effettuatiScambi==1); //fine while che ordina la variabile $punteggio, facendole contenere tutti i punteggi in ordine decrescente

			// la variabile $punteggio contiene i punteggi in ordine decrescente, mentre $perConfronto contiene i punteggi nell'orgine originale
			/*echo("<br>Punteggi ordinati in ordine decrescrescente affiancati dalla seconda colonna della matrice:<br>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				echo($punteggio[$j][0]." - ".$punteggio[$j][1]."<br>");
			}
			echo("<br>Punteggi nell'ordine originali memorizzati nella variabile PerConfronto<br>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				echo($perConfronto[$j]."<br>");
			}*/

			$rif=1; //inizializzo la posizione di riferimento per la stesura della classifica finale della partita

			//per ogni elemento della matrice, controllo se i punti dell'elemento corrente sono uguali a quelli dell'elemento precedente: se i punti sono uguali, nella seconda colonna della matrice inserisco la posizione in classifica del giocatore in questione impostandola uguale all'attuale valore di riferimento ($rif), mentre se sono diversi la imposto al numero di posizione occupato dal giocatore nella matrice: se è in seconda posizione il numero sarà 2, se è in quarta sarà 4 e così via
			for($j=1;$j<$numeroGiocatori;$j++)
			{
				if($punteggio[$j][0]==$punteggio[$j-1][0])
					$punteggio[$j][1]=$rif;
				else
					{
						$punteggio[$j][1]=$j+1;
						$rif=$j+1;
					}
			}
			/*
			echo("<br>Punteggi ordinati in ordine decrescrescente affiancati dalla seconda colonna della matrice:<br>");
			for($j=0; $j<$numeroGiocatori; $j++)
			{
				echo($punteggio[$j][0]." - ".$punteggio[$j][1]."<br>");
			}*/

			// ora che ho costruito un array bidimensionale dove ad ogni punteggio (prima colonna) corrisponde la posizione in classifica (seconda colonna), faccio un confronto con i punteggi nell'ordine originale presenti nell'array $perConfronto[]: quando ad ogni punteggio dell'array $perConfronto[], mando a video la corrispettiva posizione in classifica presa dall'array bidimensionale $punteggio[][]
			for($j=0;$j<$numeroGiocatori;$j++)
			{
				$trovato=0;
				$k=0;
				do
				{
					if($perConfronto[$j]==$punteggio[$k][0])
					{
						if($numeroGiocatori>5) // se i giocatori sono 6
						{
							echo("<td colspan=4><b><center>".$punteggio[$k][1]."</center></b></td>");
							$rango[$j]=$punteggio[$k][1];
						}
						else // se i giocatori sono 5
						{
							$rango[$j]=$punteggio[$k][1];
							echo("<td colspan=3><b><center>".$punteggio[$k][1]."</center></b></td>");
						}
						$trovato=1;
						$query="UPDATE posizioni 
						        SET posizione='$rango[$j]' 
						        WHERE dataPartita='$dataPartita' AND acronimoGiocatore='$giocatori[$j]'";
						$risultato=mysql_query($query)
							or die("Impossibile compilare il campo 'posizione' della tabella posizioni: ".mysql_error());
					}
					$k++;
				}
				while(($trovato==0) and ($k<$numeroGiocatori));
			}
		echo("</tr>");



		//algoritmo per mandare a video i punti classifica
		echo("<tr>");
			if($numeroGiocatori>5) // se i giocatori sono 6
				echo("<td width='8%'><b><center>Pti Classifica</center></b></td>");
			else // se i giocatori sono 5
				echo("<td width='8%'><b><center>Pti Classifica</center></b></td>");
		/*echo("Elenco posizioni in ordine di giocatore:<br>");
		for($j=0; $j<$numeroGiocatori; $j++)
			echo($rango[$j]."<br>");*/
		for($j=0; $j<$numeroGiocatori; $j++)
		{
			if($rango[$j]==1)
				$puntiClassificaPartita[$j]=((0.1*$puntiTotaliGiocatore[$j])+14);
			elseif($rango[$j]==2)
				$puntiClassificaPartita[$j]=((0.1*$puntiTotaliGiocatore[$j])+10);
			elseif($rango[$j]==3)
				$puntiClassificaPartita[$j]=((0.1*$puntiTotaliGiocatore[$j])+7);
			elseif($rango[$j]==4)
				$puntiClassificaPartita[$j]=((0.1*$puntiTotaliGiocatore[$j])+4);
			else
				$puntiClassificaPartita[$j]=((0.1*$puntiTotaliGiocatore[$j])+1);

			if($numeroGiocatori>5)  // se i giocatori sono 6
				echo("<td colspan=4><b><center>".$puntiClassificaPartita[$j]."</center></b></td>");
			else // se i giocatori sono 5
				echo("<td colspan=3><b><center>".$puntiClassificaPartita[$j]."</center></b></td>");
			$query="UPDATE posizioni 
					SET puntiClassifica=$puntiClassificaPartita[$j] 
					WHERE dataPartita='$dataPartita' AND acronimoGiocatore='$giocatori[$j]'";
			mysql_query($query)
				or die("Impossibile compilare il campo 'puntiClassifica' della tabella posizioni");
			$query2="UPDATE giocatori
						SET puntitotali=puntitotali+$puntiClassificaPartita[$j]
						WHERE acronimo='$giocatori[$j]'";
			mysql_query($query2)
				or die("Impossibile compilare il campo 'puntiTotali' della tabella giocatori: ".mysql_error());
		}
			//echo("<td colspan=7>&nbsp;</td>");
		echo("</tr>");
	echo("</table>");
	?>
	<br>
	<h3>Partita registrata correttamente</h3>
	</body>
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
</html>