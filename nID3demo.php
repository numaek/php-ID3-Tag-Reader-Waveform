<?php

	/* 
	 * .mp3 ID3-Tag Reader
	 * -------------------
	 * 
	 * Script:        nID3
	 * 
	 * Version:       1.0
	 * Release:       01.06.2020
	 * 
	 * Author:        numaek   
	 * Copyright (c): 2004-2020 by www.numaek.de
	 * 
	 * ************************************************************************************************************************************************************************************
	 */


	// Ein Beispiel gibt es auch hier: http:player.numaek.de
	// ===============================




	// Demo-DATEI eintragen:
	// =====================
	$testdatei = "nPlayer_1.mp3";




	include('nID3class.php');

	$fileData = new nID3($testdatei);


	if( 1 == 1 )
	{
		// Datei in Browser-Player laden
		// #############################
		if( 1 == 1 )
		{
			echo "<audio src=\"".$testdatei."\" controls></audio><br><br>";
		}


		// Fehlermeldungen anzeigen
		// ########################
		if( $fileData->error != "" )
		{
			echo "<span style=\"font-weight: bold;\">Ein Fehler ist aufgetreten:</span> ".$fileData->error."<br><br><hr>";
		}


		// Struktur des Daten-Array anzeigen
		// #################################
		if( 1 == 1 )
		{
			echo "<span style=\"font-weight: bold;\">Struktur des Daten-Arrays:</span><br>";
			echo nID3::getStructure();
		}


		// Einzelne Header sowie gesamtes Daten-Array anzeigen
		// ###################################################
		if( 1 == 1 )
		{
			$dataArray = $fileData->getArray();

			echo "<hr><span style=\"font-weight: bold;\">Datei-Infos:</span><br><br>";

			echo "Dateiname             = ".$dataArray['file']['name']."<br>";
			echo "Dateigr&ouml;&szlig;e = ".$fileData->getFileSize()." Bytes<br>";
			echo "Letzte &Auml;nderung  = ".date("d.m.Y - H:i",$dataArray['file']['mtime'])." Uhr<br>";
			echo "Letzter Zugriff       = ".date("d.m.Y - H:i",$dataArray['file']['atime'])." Uhr<br>";
			echo "ID3-Version           = ".$fileData->getVersion()."<br>";
			echo "MPEG-Layer            = ".$fileData->getLayer()."<br>";
			echo "SampleRate            = ".$fileData->getSampleRate()." Hz<br>";
			echo "Bitrate               = ".$fileData->getBitRate()." Kbits/s<br>";
			echo "Channels              = ".$fileData->getChannels()."<br>";
			echo "Laufzeit              = ".$fileData->getDuration()." Sekunden<br>";

			echo "<hr><span style=\"font-weight: bold;\">Die wichtigsten Tags:</span><br><br>";

			echo "Gefundene Tags        = ".$dataArray['id3']['header']['counter']."<br>";		// Einzelnen Array-Wert anzeigen
			echo "Titel:                ".$fileData->getTitle()."<br>";
			echo "Interpret:            ".$fileData->getArtist()."<br>";
			echo "Album:                ".$fileData->getAlbum()."<br>";
			echo "Genre:                ".$fileData->getGenre()."<br>";
			echo "Track:                ".$fileData->getTrack()."<br>";
			echo "Jahr:                 ".$fileData->getYear()."<br>";
			echo "BPM:                  ".$fileData->getBPM()."<br>";
			echo "Kommentar             ".$fileData->getComment()."<br>";

			echo "<hr><span style=\"font-weight: bold;\">Einen einzelnen Tag suchen:</span><br><br>";

			echo "Titel:                ".$fileData->getTag('TIT2')."<br>";

			echo "<hr><span style=\"font-weight: bold;\">Cover-Bild:</span><br><br>";

			echo "Bild-Typ:             ".$fileData->getImageType()."<br>";
			echo "Bild-Beschr.:         ".$fileData->getImageDesc()."<br>";
			echo "Bild:<br>             ".$fileData->getImage()."<br><br>";
		//	echo "Speichern:            ".$fileData->saveImage('TestImage')."<br><br>";

			echo "<hr><span style=\"font-weight: bold;\">Alle gefundenen Tags:</span><br><pre>";  echo var_dump($fileData->getAllTags());   echo "</pre>";
			echo "<hr><span style=\"font-weight: bold;\">Alle gesuchten Tags:</span><br><pre>";   echo var_dump(nID3::getTagList());        echo "</pre>";
			echo "<hr><span style=\"font-weight: bold;\">Alle ID3V1 Tags:</span><br><pre>";       echo var_dump($fileData->getID3V1Tags()); echo "</pre>";
			echo "<hr><span style=\"font-weight: bold;\">Alle gefundenen Daten:</span><br><pre>"; echo var_dump($dataArray);                echo "</pre>";
		}


		// Dateiausgabe als Bild (Diese Datei darf dabei kein anderes Zeichen ausgeben!)
		// #############################################################################
		if( 1 == 2 )
		{
			// Default-Bild vorher überschreiben
			// $fileData->apicDefault('src/table.gif');

			   $fileData->beAnImage();
		}


		// Zeigt ein Bild der Wellenform an
		// ################################
		if( 1 == 1 )
		{
			echo "<hr><span style=\"font-weight: bold;\">Wellenform:</span><br><br>";
			echo $fileData->getWaveForm(350, 50, '#000000', '#00FFFF')."<br><br>";
		}


		// Einzelne Tags anzeigen
		// ######################
		if( 1 == 2 )
		{
			    $tagValue  = $fileData->getTag('TIT2');
			if( $tagValue != "Fehler" )
			{
				echo "TIT2 = ".$tagValue;
			} else
			  {
				echo "Der TAG wurde nicht gefunden.";
			  }
		}


		// Tabelle mit den Tags welche durchsucht werden ausgeben
		// ######################################################
		if( 1 == 2 )
		{
			$sucheTags = nID3::getTagList();

			$tabStr    = "<table border=\"1\">\n";
			$tabStr   .= "<tr><th>Tags-Name</th><th>Bedeutung</th></tr>\n";
			if( sizeof($sucheTags) > 0 )
			{
				foreach( $sucheTags AS $key => $value )
				{
					$tabStr .= "<tr><td>".$key."</td><td>".$value."</td></tr>\n";
				}
			}
			$tabStr .= "</table>\n";
			echo $tabStr;
		}
	}

?>