<html>
	<head>
		<title>Partita da considerare</title>
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
			$mese=$_POST["mese"];
			//echo("Mese selezionato: ".$mese."<br>");
			//echo("Anno considerato: ".$anno."<br>");
			if(($mese!="gennaio") and ($mese!="febbraio") and ($mese!="marzo") and ($mese!="aprile") and ($mese!="maggio") and ($mese!="giugno") and ($mese!="luglio") and ($mese!="agosto") and ($mese!="settembre") and ($mese!="ottobre") and ($mese!="novembre") and ($mese!="dicembre"))
				echo("<h2>Non hai selezionato nessun mese</h2>");
			else
			{
				if($mese=="gennaio")
					$codiceMese="01";
				elseif($mese=="febbraio")
					$codiceMese="02";
				elseif($mese=="marzo")
					$codiceMese="03";
				elseif($mese=="aprile")
					$codiceMese="04";
				elseif($mese=="maggio")
					$codiceMese="05";
				elseif($mese=="giugno")
					$codiceMese="06";
				elseif($mese=="luglio")
					$codiceMese="07";
				elseif($mese=="agosto")
					$codiceMese="08";
				elseif($mese=="settembre")
					$codiceMese="09";
				elseif($mese=="ottobre")
					$codiceMese="10";
				elseif($mese=="novembre")
					$codiceMese="11";
				elseif($mese=="dicembre")
					$codiceMese="12";
				$like="/".$codiceMese."/".$anno;
				//echo("Like= ".$like);
				$query="SELECT DISTINCT datapartita FROM partita WHERE datapartita LIKE '%".$like."'";
				$risultato=mysql_query($query)
					or die("Impossibile selezionare le date delle partite nell'anno e nel mese selezionato");
				//while($riga=(mysql_fetch_row($risultato)))
					//echo($riga[0]."<br>");
				$i=0;
				echo("<center><h2>Seleziona la data della partita di cui vuoi visualizzare le statistiche</h2></center><br><br>");
				echo("<FORM NAME='partita' ACTION='VisioPartita.php' METHOD='post'>");
					echo("<table border='0' align='center'>");
					while($riga=(mysql_fetch_row($risultato)))
					{
						if(($i==0) and (($i%5)==0))
							echo("<tr>");
						elseif(($i!=0) and (($i%5)==0))
							echo("</tr><tr>");
						echo("<td><input type='radio' name='partita' value='$riga[0]'>".$riga[0]."&nbsp;&nbsp;</td>");
						$i++;
					}
					echo("</table>");
				echo("<BR>");
				echo("<BR>");
				echo("<DIV ALIGN='center'>");
					echo("<INPUT TYPE='SUBMIT' NAME='inserisci' VALUE='Avanti'>");
					echo("&nbsp;&nbsp;");
					echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Reset'>");
				echo("</DIV>");
				echo("</FORM>");
			}
		?>
		<br>
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