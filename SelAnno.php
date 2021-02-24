<html>
	<head>
		<title>Anno da considerare</title>
	</head>
	<body>
		<h2><center>Seleziona l'anno di cui vuoi visualizzare le partite</center></h2>
		<?php
			$host_name='localhost';
			$user_name='root';
			$conn=@mysql_connect($host_name,$user_name,'')
				or die ("<BR>Impossibile stabilire una connessione con il server");
			@mysql_select_db('chiama2')
				or die ("Impossibile selezionare il database per la chiamata al 2, chiudere il programma e riprovare");
			$query="SELECT DISTINCT datapartita FROM partita";
			$risultato=mysql_query($query)
				or die("Impossibile selezionare le date delle partite per estrapolarne l'anno");
			$i=0;	
			$j=0;
			$anno[$i]=0;
			while($riga=mysql_fetch_row($risultato))
			{
				$data=$riga[0];
				if($j==0)
					$anno[$i]=substr($data,6);
				else
				{
					$annoEstratto=substr($data,6);
					$numElementiInArray=count($anno);
					$trovato=0;
					$k=0;
					while(($trovato==0) and ($k<$numElementiInArray))
					{
						if($annoEstratto==$anno[$k])
							$trovato=1;
						$k++;
					}
					if($trovato==0)
						$anno[count($anno)]=$annoEstratto;
				}
				$j++;	
			}
			rsort($anno); // con questa funzione ordino in modo decrescente gli elementi dell'array $anno, così saranno pronti per essere mandati a video
			/*for($i=0;$i<count($anno);$i++)
			{
				$posizione=$i+1;
				echo("Anno in posizione ".$posizione.": ".$anno[$i]."<br>");
			}*/
			echo("<FORM NAME='anno' ACTION='SelMese.php' METHOD='post'>");
				echo("<table align='center' border='0'");
				for($i=0;$i<count($anno);$i++)
				{
					if((($i%10)==0) and ($i==0)) 
						echo("<tr>");
					elseif ((($i%10)==0) and ($i!=0))
						echo("</tr><tr>");
					echo("<td><input type='radio' name='anno' value='$anno[$i]'>".$anno[$i]."&nbsp;&nbsp;</td>");
				}
				echo("</table>");
			$numAnniArray=count($anno);
			//echo("<input type='hidden' name='num_anni_array' value='$numAnniArray'>");
			echo("<BR>");
			echo("<BR>");
			echo("<DIV ALIGN='center'>");
				echo("<INPUT TYPE='SUBMIT' NAME='inserisci' VALUE='Avanti'>");
				echo("&nbsp;&nbsp;");
				echo("<INPUT TYPE='RESET' NAME='cancellazione' VALUE='Reset'>");
			echo("</DIV>");
			echo("</FORM>");
			mysql_close($conn);
		?>
		<br>
		<br>
		<a href="VisioStatistiche.php">Torna alla pagina precedente</a>
		<br>
		<br>
		<a href="Chiama2index.php">Torna alla pagina iniziale</a>
	</body>
</html>