<?php

	require_once('lib/class.database.php');	
	require_once('lib/config.php');
	

	$BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );	


		      $qry = "SELECT *
                        FROM adm_usuario";
                $rst = $BD->query($qry) or die ($qry);
                while($row = $BD->fetch_array($rst))
                {
                    echo "rom ".md5($row['password'])."<br>";
                    echo addslashes(htmlspecialchars($row['password']));
                }
               

	?>