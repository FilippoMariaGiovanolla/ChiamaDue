<html>
	<head>
		<title>Mese da considerare</title>
	</head>
	<body>
		<?php
			error_reporting (E_ALL ^ E_NOTICE); // questo comando permette di eliminare dall'output a video le NOTICE indesiderate
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$anno=$_POST["anno"];
			if(strlen($anno)==4)
			{
			echo("<center><h1>L'anno selezionato &egrave; il ".$anno.".</h1></center>");
			echo("<center><h2>Ora seleziona il mese</h2></center>");
			$query="SELECT DISTINCT datapartita FROM partita";
			$risultato=mysql_query($query)
				or die("Impossibile selezionare le date delle partite per estrapolarne l'anno");
			$i=0;	
			$j=0;
			$mese[$i]=0;
			while($riga=mysql_fetch_row($risultato))
			{
				$data=$riga[0];
				if($j==0)
					$mese[$i]=substr($data,3,2);
				else
				{
					$meseEstratto=substr($data,3,2);
					$numElementiInArray=count($mese);
					$trovato=0;
					$k=0;
					while(($trovato==0) and ($k<$numElementiInArray))
					{
						if($meseEstratto==$mese[$k])
							$trovato=1;
						$k++;
					}
					if($trovato==0)
						$mese[count($mese)]=$meseEstratto;
				}
				$j++;	
			}
			/*for($i=0;$i<count($mese);$i++)
			{
				$posizione=$i+1;
				echo("Mese in posizione ".$posizione.": ".$mese[$i]."<br>");
			}*/
			$trovatoGennaio=0; $trovatoFebbraio=0; $trovatoMarzo=0; $trovatoAprile=0; $trovatoMaggio=0; $trovatoGiugno=0;
			$trovatoLuglio=0; $trovatoAgosto=0; $trovatoSettembre=0; $trovatoOttobre=0; $trovatoNovembre=0; $trovatoDicembre=0;
			for($i=0;$i<count($mese);$i++)
			{
				if($mese[$i]=="01")
					$trovatoGennaio=1;
				elseif($mese[$i]=="02")
					$trovatoFebbraio=1;
				elseif($mese[$i]=="03")
					$trovatoMarzo=1;
				elseif($mese[$i]=="04")
					$trovatoAprile=1;
				elseif($mese[$i]=="05")
					$trovatoMaggio=1;
				elseif($mese[$i]=="06")
					$trovatoGiugno=1;
				elseif($mese[$i]=="07")
					$trovatoLuglio=1;
				elseif($mese[$i]=="08")
					$trovatoAgosto=1;
				elseif($mese[$i]=="09")
					$trovatoSettembre=1;
				elseif($mese[$i]=="10")
					$trovatoOttobre=1;
				elseif($mese[$i]=="11")
					$trovatoNovembre=1;
				elseif($mese[$i]=="12")
					$trovatoDicembre=1;
			}
			echo("<fieldset>");
			echo("<FORM NAME='mese' ACTION='SelPartita.php' METHOD='post'>");
				echo("<table align='center' border='0'");
					echo("<tr>");
						echo("<td>");
							if($trovatoGennaio==1)
								echo("<input type='radio' name='mese' value='gennaio'>Gennaio&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Gennaio&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoFebbraio==1)
								echo("<input type='radio' name='mese' value='febbraio'>Febbraio&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Febbraio&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoMarzo==1)
								echo("<input type='radio' name='mese' value='marzo'>Marzo&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Marzo&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoAprile==1)
								echo("<input type='radio' name='mese' value='aprile'>Aprile&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Aprile&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoMaggio==1)
								echo("<input type='radio' name='mese' value='maggio'>Maggio&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Maggio&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoGiugno==1)
								echo("<input type='radio' name='mese' value='giugno'>Giugno&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Giugno&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>&nbsp;</td>");
					echo("</tr>");
					echo("<tr>");
						echo("<td>");
							if($trovatoLuglio==1)
								echo("<input type='radio' name='mese' value='luglio'>Luglio&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Luglio&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoAgosto==1)
								echo("<input type='radio' name='mese' value='agosto'>Agosto&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Agosto&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoSettembre==1)
								echo("<input type='radio' name='mese' value='settembre'>Settembre&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Settembre&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoOttobre==1)
								echo("<input type='radio' name='mese' value='ottobre'>Ottobre&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Ottobre&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoNovembre==1)
								echo("<input type='radio' name='mese' value='novembre'>Novembre&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Novembre&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
						echo("<td>");
							if($trovatoDicembre==1)
								echo("<input type='radio' name='mese' value='dicembre'>Dicembre&nbsp;&nbsp;&nbsp;&nbsp;");
							else
								echo("<font color='808080'><i>Dicembre&nbsp;&nbsp;&nbsp;&nbsp;</i></font>");
						echo("</td>");
					echo("</tr>");
				echo("</table>");
				echo("<br><br>");
				echo("<i><center>I mesi scritti in grigio sono quelli in cui, nell'anno selezionato, non &egrave; stata registrata nessuna partita</center></i>");
				echo("</fieldset>");
				echo("<input type='hidden' name='anno' value='$anno'>");
				echo("<INPUT TYPE='SUBMIT' NAME='inserisci' VALUE='Avanti'>");
				echo("&nbsp;&nbsp;");
				echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Reset'>");
			echo("</FORM>");
			} // fine if(strlen($anno)==4)
			else
				echo("<h2>Non hai selezionato nessun anno</h2>");
		?>
		<br>
		<br>
		<br>
		<a href="SelAnno.php">Torna alla pagina precedente</a>
		<br>
		<br>
		<a href="VisioStatistiche.php">Torna alla pagina di scelta della statistica da visualizzare</a>
		<br>
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