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



	define('APIC_DEF_IMG', 'apic_default.jpg');		// Bild für den Fehlerfall, falls Datei als Bild eingebunden ist.



	/*
	 * Methoden:
	 * =========
	 * 
	 * $ID3_daten = new nID3('DATEI');			// Klasse initialisieren und Daten auslesen. DATEI mit relativen Pfadangaben! Nur .mp3-Format!
	 * 
	 * 
	 * $ID3_daten::getStructure()				// Zeigt die Struktur des Daten-Arrays an
	 * 
	 * $ID3_daten::getTagList()				// Listet alle zu durchsuchenden Tags auf
	 * 
	 * 
	 * $ID3_daten->getAllTags()				// Listet alle gefundenen Tags auf
	 * 
	 * $ID3_daten->getTag('TAGNAME')			// Liest einen einzelnen Tag aus
	 * 
	 * $ID3_daten->getArray()				// Gibt alle ermittelten Daten als Array zurück
	 * 
	 * $ID3_daten->getVersion()				// Gibt die ID3-Version aus
	 * 
	 * $ID3_daten->getLayer()				// Gibt den MPEG-Layer aus
	 * 
	 * $ID3_daten->getSampleRate()				// Gibt die SampleRate aus
	 * 
	 * $ID3_daten->getBitRate()				// Gibt die Bitrate aus
	 * 
	 * $ID3_daten->getChannels()				// Gibt die Anzahl der Kanäle aus
	 * 
	 * $ID3_daten->getDuration()				// Gibt die Laufzeit aus
	 * 
	 * 
	 * $ID3_daten->getTitle()				// Gibt den Titel aus
	 * 
	 * $ID3_daten->getArtist()				// Gibt den Initerpreten aus
	 * 
	 * $ID3_daten->getAlbum()				// Gibt den Albumnamen aus
	 * 
	 * $ID3_daten->getGenre()				// Gibt das Genre aus
	 * 
	 * $ID3_daten->getTrack()				// Gibt die Track-Nummer aus
	 * 
	 * $ID3_daten->getBPM()					// Gibt die BPM aus
	 * 
	 * $ID3_daten->getComment()				// Gibt den Kommentar aus
	 * 
	 * 
	 * $ID3_daten->getID3V1Tags()				// Gibt alle ID3V1-Tags in einem assoziativem Array aus
	 * 
	 * 
	 * $ID3_daten->getImage()				// Gibt den HTML-Code des Bildes aus
	 * 
	 * $ID3_daten->getImageType()				// Gibt den Typ des Bildes aus
	 * 
	 * $ID3_daten->saveImage('FILENAME')			// Speichert das Bild auf dem Server. FILENAME ohne Mimetype (wird automatisch ermittelt)!
	 * 
	 * $ID3_daten->apicDefault('FILENAME')			// Überschreibt das Default-Bild für ein nicht gefundenes Cover-Bild. FILENAME ohne Mimetype!
	 * 
	 * $ID3_daten->beAnImage()				// Datei gibt sich als (Cover)Bild aus. <img src="nID3Class.php?datei=DATEI">
	 * 
	 * 
	 * $ID3_daten->getWaveForm(w, h, 'cFill', 'cStroke')	// Zeigt ein Bild der Wellenform an (w = Breite in Pixel, h = Hoehe, Hintergrundfarbe, Strichfarbe z.B. '#00FFFF')
	 * 
	 */




























































































	// ####################################################################################################################################################################################


	// Dateiausgabe als (Cover)Bild
	// ****************************
	if( isset($_GET['datei']) )
	{
		$fileData = new nID3($_GET['datei']);
		$fileData->beAnImage();
	}


	class nID3
	{
		public $file;
		public $nID3data;
		public $tagsNr      = 0;
		public $tagsLength  = 0;
		public $apicDefault = '';
		public $error       = '';


		public static $tagUse = array(
					"TIT2" => "Titel",
					"TPE1" => "Interpret",
					"TALB" => "Album",
					"TIT3" => "Untertitel",
					"TCOM" => "Komponist",
					"TPE2" => "Band",
					"TPE4" => "Remix",
					"TCON" => "Genre",
					"TIT1" => "Kategorie Beschreibung",
					"TLEN" => "Laufzeit",
					"TBPM" => "Beats per Minute",
					"TPOS" => "Teil eines Satzes",
					"TRCK" => "Track",
					"TPUB" => "Herausgeber",
					"TCOP" => "Copyright",
					"TPE3" => "Dirigenten",
					"TDAT" => "Datum",
					"TIME" => "Uhrzeit",
					"TDLY" => "Playlist verzoegerung",
					"TCMP" => "Teil einer Kompilation",
					"TENC" => "Kodiert von",
					"TEXT" => "Autor",
					"TFLT" => "Datei-Typ",
					"TKEY" => "Initial key",
					"TLAN" => "Sprache(n)",
					"TMED" => "Media-Typ",
					"TOAL" => "Original Albumname",
					"TOFN" => "Original Dateiname",
					"TOLY" => "Original Komponist",
					"TOPE" => "Original Interpret",
					"TORY" => "Original Erscheinungsjahr",
					"TOWN" => "Datei-Eigentuemer",
					"TRDA" => "Aufnahmedatum",
					"TRSN" => "Internet-Radiosender Name",
					"TRSO" => "Internet-Radiosender Eigentuemer",
					"TSIZ" => "Groese",
					"TSRC" => "ISRC (international standard recording code)",
					"TSSE" => "Software und Hardware Einstellungen zur Kodierung",

					"TMCL" => "Credits Liste",
					"TMOO" => "Stimmung",
					"TPRO" => "Produktionshinweise",
					"TDEN" => "Kodierungszeitpunkt",
					"TDOR" => "Originaldatum der Herausgabe",
					"TDRC" => "Aufnahmezeitpunkt",
					"TDRL" => "Herausgabezeitpunkt",
					"TDTG" => "Zeitpunkt der Tagerstellung",
					"TSOA" => "Sortierreihenfolge der Albumnamen",
					"TSOP" => "Sortierreihenfolge der Kuenstler",
					"TSOT" => "Sortierreihenfolge der Titel",
					"TXXX" => "User Text",

					"TYER" => "Jahr",
					"TDRC" => "Jahr",

					"TIPL" => "Beteiligte Personen",
					"IPLS" => "Beteiligte Personen",

					"WCOM" => "Kommerzielle Informationen",
					"WCOP" => "Copyright",
					"WOAF" => "Homepage der Audiodateien",
					"WOAR" => "Homepage des Interpreten",
					"WOAS" => "Homepage der Audioquellen",
					"WORS" => "Homepage des Internet-Radiosenders",
					"WPAY" => "Zahlungshinweise",
					"WPUB" => "Homepage des Herausgebers",
					"WXXX" => "User Link",

					"USER" => "Nutzungsbedingungen",
					"PCNT" => "Playcounter",
					"COMM" => "Kommentar",
					"APIC" => "Bild"
					);


		public static $pictureType = array(
					"Other",
					"32x32 pixels 'file icon' (PNG only)",
					"Other file icon",
					"Cover (front)",
					"Cover (back)",
					"Leaflet page",
					"Media (e.g. lable side of CD)",
					"Lead artist/lead performer/soloist",
					"Artist/performer",
					"Conductor",
					"Band/Orchestra",
					"Composer",
					"Lyricist/text writer",
					"Recording Location",
					"During recording",
					"During performance",
					"Movie/video screen capture",
					"A bright coloured fish",
					"Illustration",
					"Band/artist logotype",
					"Publisher/Studio logotype"
					);


		public static $genreList = array(
					'Blues',	'Classic Rock',		'Country',		'Dance',		'Disco',
					'Funk',		'Grunge',		'Hip-Hop',		'Jazz',			'Metal',	
					'New Age',	'Oldies',		'Other',		'Pop',			'R&B',
					'Rap',		'Reggae',		'Rock',			'Techno',		'Industrial',
					'Alternative',	'Ska',			'Death Metal',		'Pranks',		'Soundtrack',
					'Euro-Techno',	'Ambient',		'Trip-Hop',		'Vocal',		'Jazz+Funk',
					'Fusion',	'Trance',		'Classical',		'Instrumental',		'Acid',
					'House',	'Game',			'Sound Clip',		'Gospel',		'Noise',
					'Alt. Rock',	'Bass',			'Soul',			'Punk',			'Space',
					'Meditative',	'Instrumental Pop',	'Instrumental Rock',	'Ethnic',		'Gothic',
					'Darkwave',	'Techno-Industrial',	'Electronic',		'Pop-Folk',		'Eurodance',
					'Dream',	'Southern Rock',	'Comedy',		'Cult',			'Gangsta Rap',
					'Top 40',	'Christian Rap',	'Pop/Funk',		'Jungle',		'Native American',
					'Cabaret',	'New Wave',		'Psychedelic',		'Rave',			'Showtunes',
					'Trailer',	'Lo-Fi',		'Tribal',		'Acid Punk',		'Acid Jazz',
					'Polka',	'Retro',		'Musical',		'Rock & Roll',		'Hard Rock'
					);


		public function __construct( $file = "" )
		{
			$this->file        =  $file;
			$this->file        =         urldecode($this->file);
			$this->file        =        strip_tags($this->file);
			$this->file        =  htmlspecialchars($this->file, ENT_QUOTES);

			$this->apicDefault = '';

			$this->readFile();
		}


		// Liest ID3V2 Header und Tags sowie diverse mp3-Infos aus
		// *******************************************************
		public function readFile()
		{
			if( $this->file != "" )
			{
				if( is_file($this->file) )
				{
					$fileMime     = strtolower(strrchr($this->file, '.'));
					if( $fileMime == ".mp3" )
					{
						$this->filesize  =  filesize($this->file);
						$this->fileName  =  basename($this->file);
						$this->filePath  =  pathinfo($this->file);
						$this->fileMtime = filemtime($this->file);
						$this->fileAtime = fileatime($this->file);

						if( $fp = @fopen($this->file, 'rb') )
						{
							$id3Data                  = array();
							$id3Data['file']          = array();
							$id3Data['file']['size']  = $this->filesize;
							$id3Data['file']['name']  = $this->fileName;
							$id3Data['file']['path']  = $this->filePath['dirname'];
							$id3Data['file']['base']  = $this->filePath['filename'];
							$id3Data['file']['mime']  = $this->filePath['extension'];
							$id3Data['file']['mtime'] = $this->fileMtime;
							$id3Data['file']['atime'] = $this->fileAtime;

							// ID3-Header auslesen
							// ====================================================================================================================================
							$header         = fread($fp, 10);
							$header         = unpack("a3system/c1vmj/c1vmi/c1flags/Nsize", $header);
							$mp3HeaderStart = 0;

							if( $header['system'] != "ID3" )
							{
								$mp3HeaderStart   = 0;
								$this->error      = "ID3-Tags nicht gefunden.";
								$id3Data['error'] = $this->error;
							} else
							if( $header['vmj'] < 3 )
							{
								$mp3HeaderStart   = 0;
								$this->error      = "ID3-Tags sind kleiner als Version 3.";
								$id3Data['error'] = $this->error;
							}

							if( $mp3HeaderStart > -1 )
							{
								$id3Data['id3']                      = array();
								$id3Data['id3']['header']            = array();
								$id3Data['id3']['header']['system']  = $header['system'];
								$id3Data['id3']['header']['major']   = $header['vmj'];
								$id3Data['id3']['header']['minor']   = $header['vmi'];
								$id3Data['id3']['header']['version'] = "V2.".$header['vmj'].".".$header['vmi'];
								$id3Data['id3']['header']['flags']   = str_pad(decbin($header['flags']), 8, "0", STR_PAD_LEFT);
								$id3Data['id3']['header']['size']    = $this->syncSafeToInt($header['size']);

								$mp3HeaderStart = $id3Data['id3']['header']['size'] + 10;

								// Extended Header -> überspringen
								if( $id3Data['id3']['header']['flags'][1] == 1 )
								{
									$extHeader = fread($fp, 4);
									$extSize   = unpack("N", $extHeader);
									$extLength = syncSafeToInt($extSize[1]);
									$extSkip   = fread($fp, $extLength);

									$id3Data['id3']['header']['extended'] = 1;
								} else
								  {
									$id3Data['id3']['header']['extended'] = 0;
								  }

								// ID3-Tags auslesen
								// =================
								$tagData = array();
								$tagSkip = array();

								while( ftell($fp) < $id3Data['id3']['header']['size'] )
								{
									// Tag-Name 4 Bytes
									$tagPosStart = ftell($fp);
									$tag         = fread($fp, 4);
									if( $tag[0] != "\x00" )
									{
										// Frame-Size 4 Bytes
										$sizeInt   = fread($fp, 4);
										$sizeValue = unpack('N', $sizeInt);
										$size      = $sizeValue[1];
										if( $size  > 0 )
										{
											// Flags 2 Bytes
											$flags1 = fread($fp, 1);
											$flags2 = fread($fp, 1);

											$flags1 = str_pad(decbin($flags1), 8, "0", STR_PAD_LEFT);
											$flags2 = str_pad(decbin($flags2), 8, "0", STR_PAD_LEFT);

											// Nur zu untersuchende Tags beachten
											// ==================================
											if( array_key_exists($tag, self::$tagUse) )
											{
												// Content auslesen
												// ================
												if( $tag[0] == "TXXX" )
												{
													// [User-TEXT]
													// -----------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													$subSize = 1;

													// Beschreibung
													$desc    = "";
													$pos     = ftell($fp);
													while( $pos++ )
													{
														$subSize++;
														$nextByte = fread($fp, 1);
														if( $nextByte != "\x00" )
														{
															$desc .= $nextByte;
														} else
														  {
															break;
														  }
													}
													$desc = ( $this->convertCharset($charset, $desc) != "" ) ? $this->convertCharset($charset, $desc) : $desc;

													// Daten
													$data = @fread($fp, $size-$subSize);
													$data = ( $this->convertCharset($charset, $data) != "" ) ? $this->convertCharset($charset, $data) : $data;

													$subArray         = array();
													$subArray['desc'] = $desc;
													$subArray['data'] = $data;
													$content          = $subArray;
												} else
												if( $tag[0] == "T" || $tag == "IPLS" )
												{
													// [Text]
													// ------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													if( $size > 1 )
													{
														$content = fread($fp, $size-1);
														$content = $this->convertCharset($charset, $content);

														// "Jahr" in V2.4.0 als UTC-Timestamp
														if( $tag == "TDRC" )
														{
															$content = substr($content, 0, 4);
														}
													} else
													  {
														$content = "";
													  }
												} else
												if( $tag == "APIC" )
												{
													// [Bild]
													// ------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													$subSize = 1;

													// Mime
													$imgMime = "";
													$pos     = ftell($fp);
													while( $pos++ )
													{
														$subSize++;
														$nextByte = fread($fp, 1);
														if( $nextByte != "\x00" )
														{
															$imgMime .= $nextByte;
														} else
														  {
															break;
														  }
													}

													// Typ
													$subSize++;
													$typeByte    = fread($fp, 1);
													$typeValue   = unpack('c', $typeByte);
													$typeIndex   = $typeValue[1];

													// Beschreibung
													$imgDesc = "";
													$pos     = ftell($fp);
													while( $pos++ )
													{
														$subSize++;
														$nextByte = fread($fp, 1);
														if( $nextByte != "\x00" )
														{
															$imgDesc .= $nextByte;
														} else
														  {
															break;
														  }
													}
													$imgDesc = $this->convertCharset($charset, $imgDesc);

													// Daten
													$data    = @fread($fp, $size-$subSize);
													$data    = base64_encode($data);

													$subArray         = array();
													$subArray['mime'] = $imgMime;
													$subArray['type'] = self::$pictureType[$typeIndex];
													$subArray['desc'] = $imgDesc;
													$subArray['data'] = $data;
													$content          = $subArray;
												} else
												if( $tag == "COMM" )
												{
													// [Kommentar]
													// -----------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													$subSize = 4;

													$lang    = fread($fp, 3);

													// Beschreibung
													$desc    = "";
													$pos     = ftell($fp);
													while( $pos++ )
													{
														$subSize++;
														$nextByte = fread($fp, 1);
														if( $nextByte != "\x00" )
														{
															$desc .= $nextByte;
														} else
														  {
															break;
														  }
													}
													$desc = ( $this->convertCharset($charset, $desc) != "" ) ? $this->convertCharset($charset, $desc) : $desc;

													// Daten
													$data = @fread($fp, $size-$subSize);
													$data = ( $this->convertCharset($charset, $data) != "" ) ? $this->convertCharset($charset, $data) : $data;

													$subArray         = array();
													$subArray['lang'] = $lang;
													$subArray['desc'] = $desc;
													$subArray['data'] = $data;
													$content          = $subArray;
												} else
												if( $tag == "PCNT" )
												{
													// [Playcounter]
													// -------------
													$data    = @fread($fp, $size);
													$content = hexdec($data);
												} else
												if( $tag == "USER" )
												{
													// [Terms of Use]
													// --------------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													$subSize = 4;

													$lang    = fread($fp, 3);

													// Daten
													$data = @fread($fp, $size-$subSize);
													$data = ( $this->convertCharset($charset, $data) != "" ) ? $this->convertCharset($charset, $data) : $data;

													$subArray         = array();
													$subArray['data'] = $data;
													$content          = $subArray;
												} else
												if( $tag == "WXXX" )
												{
													// [User-URL]
													// ----------
													$enByte  = fread($fp, 1);
													$enData  = unpack('c', $enByte);
													$encode  = $enData[1];
													$charset = $this->getCharsetFromByte($encode);

													$subSize = 1;

													// Beschreibung
													$desc    = "";
													$pos     = ftell($fp);
													while( $pos++ )
													{
														$subSize++;
														$nextByte = fread($fp, 1);
														if( $nextByte != "\x00" )
														{
															$desc .= $nextByte;
														} else
														  {
															break;
														  }
													}
													$desc = ( $this->convertCharset($charset, $desc) != "" ) ? $this->convertCharset($charset, $desc) : $desc;

													// Daten
													$data = @fread($fp, $size-$subSize);
													$data = ( $this->convertCharset($charset, $data) != "" ) ? $this->convertCharset($charset, $data) : $data;

													$subArray         = array();
													$subArray['desc'] = $desc;
													$subArray['data'] = $data;
													$content          = $subArray;
												} else
												if( $tag[0] == "W" )
												{
													// [URL]
													// -----
													$content = fread($fp, $size);
												} else
												  {
													// [UNBEKANNT]
													// -----------
													$skip    = fread($fp, $size);
													$encode  = 0;
													$charset = "";
													$content = "";
												  }

												// Werte ins Daten-Array übertragen
												// ================================
												$tagData[$tag]            = array();

												$tagData[$tag]['name']    = self::$tagUse[$tag];
												$tagData[$tag]['size']    = $size;
												$tagData[$tag]['flags_1'] = $flags1;
												$tagData[$tag]['flags_2'] = $flags2;
												$tagData[$tag]['pos']     = $tagPosStart;
												$tagData[$tag]['encode']  = $encode;
												$tagData[$tag]['charset'] = $charset;

												$tagData[$tag]['content'] = $content;	// Bei APIC & COMM weiteres Array !
											} else
											  {
												// Sprung zum nächsten Tag
												// =======================
												$skip = fread($fp, $size+0);

												$tagSkip[$tag]['name']    = $tag;
												$tagSkip[$tag]['size']    = $size;
												$tagSkip[$tag]['flags_1'] = $flags1;
												$tagSkip[$tag]['flags_2'] = $flags2;
												$tagSkip[$tag]['content'] = $skip;
											  }

											$this->tagsLength += 10 + $size;
											$this->tagsNr++;
										} else
										  {
											break;
										  }
									} else
									  {
										break;
									  }
								}

								$id3Data['id3']['header']['counter'] = $this->tagsNr;
								$id3Data['id3']['header']['padding'] = $id3Data['id3']['header']['size'] - $this->tagsLength;
								$id3Data['id3']['tags']              = $tagData;
								$id3Data['id3']['skipped']           = $tagSkip;
							  }

							// mp3-Header für Bitrate, Abtastrate und Laufzeit auslesen
							// ====================================================================================================================================
							if( $mp3HeaderStart > -1 )
							{
								// Bitraten- und Samplingtabellen
								// ------------------------------
								$mp3ArrId         = [0 => "MPEG 2.5", 1 => "-", 2 => "MPEG 2", 3 => "MPEG 1"];

								$mp3ArrLayer      = [0 => "-", 1 => "Layer 3", 2 => "Layer 2", 3 => "Layer 1"];

								$mp3ArrBits       = [1,2];
								$mp3ArrBits[1]    = [1,2,3];
								$mp3ArrBits[2]    = [1,2];
								$mp3ArrBits[1][1] = [0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448];
								$mp3ArrBits[1][2] = [0, 32, 48, 56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 384];
								$mp3ArrBits[1][3] = [0, 32, 40, 48,  56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320];
								$mp3ArrBits[2][1] = [0, 32, 48, 56,  64,  80,  96, 112, 128, 144, 160, 176, 192, 224, 256];
								$mp3ArrBits[2][2] = [0,  8, 16, 24,  32,  40,  48,  56,  64,  80,  96, 112, 128, 144, 160];

								$mp3ArrSamples    = [1,2,3];
								$mp3ArrSamples[1] = [44100, 48000, 32000];
								$mp3ArrSamples[2] = [22050, 24000, 16000];
								$mp3ArrSamples[3] = [11025, 12000,  8000];


								// FilePointer auf Start mp3-Header
								// --------------------------------
								fseek($fp, $mp3HeaderStart, SEEK_SET);

								    $mp3FullByte = unpack("CData", fread($fp, 1));
								if( $mp3FullByte['Data'] == 255 )
								{
									$mp3HeaderByte2 = unpack("CData", fread($fp, 1));
									$mp3HeaderByte2 = decbin($mp3HeaderByte2['Data']);

									$mp3HeaderByte3 = unpack("CData", fread($fp, 1));
									$mp3HeaderByte3 = decbin($mp3HeaderByte3['Data']);

									$mp3HeaderByte4 = unpack("CData", fread($fp, 1));
									$mp3HeaderByte4 = decbin($mp3HeaderByte4['Data']);

									if( substr($mp3HeaderByte2, 0, 3) == "111" )
									{
										// Ersten mp3-Header gefunden
										// --------------------------
										$mp3Data                = array();

										$mp3ID                  = bindec(substr($mp3HeaderByte2, 3, 2));
										$mp3Layer               = bindec(substr($mp3HeaderByte2, 5, 2));
										$mp3BitRate             = bindec(substr($mp3HeaderByte3, 0, 4));
										$mp3SampleRate          = bindec(substr($mp3HeaderByte3, 4, 2));
										$mp3Kanaele             = bindec(substr($mp3HeaderByte4, 0, 2));

										$mp3Data['id']          = $mp3ArrId[$mp3ID];
										$mp3Data['layer']       = $mp3ArrLayer[$mp3Layer];
										$mp3Data['kanaele']     = ( $mp3Kanaele < 2 ) ? 2 : 1;
										$mp3Data['bittype']     = "CBR";

										$samplesPerFrame        = $this->getSamplesPerFrame($mp3ID, $mp3Layer);

										// Bitrate
										if( $mp3ID == 3 )
										{
											if( $mp3Layer == 1 )
											{
												$mp3Data['bitrate'] = $mp3ArrBits[1][3][$mp3BitRate];
											} else
											if( $mp3Layer == 2 )
											{
												$mp3Data['bitrate'] = $mp3ArrBits[1][2][$mp3BitRate];
											} else
											if( $mp3Layer == 3 )
											{
												$mp3Data['bitrate'] = $mp3ArrBits[1][1][$mp3BitRate];
											} else
											  {
												$mp3Data['bitrate'] = "-";
											  }
										} else
										if( $mp3ID == 0 || $mp3ID == 2 )
										{
											if( $mp3Layer == 3 )
											{
												$mp3Data['bitrate'] = $mp3ArrBits[2][1][$mp3BitRate];
											} else
											  {
												$mp3Data['bitrate'] = $mp3ArrBits[2][2][$mp3BitRate];
											  }
										} else
										  {
												$mp3Data['bitrate'] = "-";
										  }

										// Samplerate
										if( $mp3ID == 3 )
										{
											$mp3Data['frequenz'] = $mp3ArrSamples[1][$mp3SampleRate];
										} else
										if( $mp3ID == 2 )
										{
											$mp3Data['frequenz'] = $mp3ArrSamples[2][$mp3SampleRate];
										} else
										if( $mp3ID == 0 )
										{
											$mp3Data['frequenz'] = $mp3ArrSamples[3][$mp3SampleRate];
										} else
										  {
											$mp3Data['frequenz'] = "-";
										  }

										// Laufzeit bei CBR ermitteln (dazu die Dateigröße berechnen)
										// ==========================================================
										$endFrameHeader1 = ftell($fp);
										$CBRfilesize     = $this->filesize - $mp3HeaderStart;

										// ID3V1-Tag suchen
										// ----------------
										fseek($fp, $this->filesize - 128, SEEK_SET);
										$id3V1Tag     = fread($fp, 3);
										if( $id3V1Tag == "TAG" )
										{
											$id3v1Array               = array();
											$id3v1Array['titel']      = trim(fread($fp, 30));
											$id3v1Array['interpret']  = trim(fread($fp, 30));
											$id3v1Array['album']      = trim(fread($fp, 30));
											$id3v1Array['jahr']       = trim(fread($fp,  4));
											$id3v1Array['kommentar']  = trim(fread($fp, 28));

											    $id3v1CommByte1       =      fread($fp,  1);
											    $id3v1CommByte2       =      fread($fp,  1);
											if( $id3v1CommByte1 == "\x00" )
											{
												// ID3V1.1
												$id3v1Array['track']      = unpack("CData", $id3v1CommByte2);
												$id3v1Array['track']      = $id3v1Array['track']['Data'];
											} else
											  {
												// ID3V1.0
												$id3v1Array['track']      = "?";
												$id3v1Array['kommentar'] .= $id3v1CommByte1 . $id3v1CommByte2;
											  }

											$id3v1Array['genre_nr']   = unpack("CData", fread($fp,  1));
											$id3v1Array['genre_nr']   = $id3v1Array['genre_nr']['Data'];
										     //	$id3v1Array['genre_nr']   = ( $id3v1Array['genre_nr'] < sizeof(self::$genreList) ) ? $id3v1Array['genre_nr']                   : 12;
											$id3v1Array['genre_text'] = ( $id3v1Array['genre_nr'] < sizeof(self::$genreList) ) ? self::$genreList[$id3v1Array['genre_nr']] : "?";
											$id3Data['id3v1']         = $id3v1Array;

											$CBRfilesize     -= 128;
											$APEsearchPos     = $this->filesize - 32 - 128;
										} else
										  {
											$id3Data['id3v1'] = "-";
											$APEsearchPos     = $this->filesize - 32;
										  }

										// APE-Tags suchen
										// ---------------
										fseek($fp, $APEsearchPos, SEEK_SET);
										$APETag     = fread($fp, 8);
										if( $APETag == "APETAGEX" )
										{
											fseek($fp, 4, SEEK_CUR);
											$APESize         = unpack("NSize", fread($fp, 4));
											$CBRfilesize    -= $APESize['Size'];
											$id3Data['APE']  = "Ja (Offset: ".$APEsearchPos.", Size: ".$APESize['Size']." Bytes)";
										} else
										  {
											$id3Data['APE']  = "-";
											$LyricssearchPos = $APEsearchPos + 23;
										  }

										// Lyrics-TAG suchen
										// -----------------
										fseek($fp, $LyricssearchPos, SEEK_SET);
										$LyricsTag     = fread($fp, 9);
										if( $LyricsTag == "LYRICS200" )
										{
											fseek($fp, $LyricssearchPos - 6, SEEK_SET);
											$LyricsSize   = "00".fread($fp, 6);
											$LyricsLength = unpack("NSize", $LyricsSize);
											$CBRfilesize -= ( $LyricsLength['Size'] + 15 );
											$id3Data['Lyrics'] =  "Ja (Offset: ".$LyricssearchPos.", Size: ".$LyricsLength['Size']." Bytes)";
										} else
										  {
											$id3Data['Lyrics'] = "-";
										  }

										$mp3Data['duration'] = floor( ( $CBRfilesize * 8 ) / ( $mp3Data['bitrate'] * 1000 ) );

										// FilePointer zurück nach dem ersten Frame-Header
										// -----------------------------------------------
										fseek($fp, $endFrameHeader1, SEEK_SET);
									}

									// Xing Header suchen => VBR
									// =========================
									$mp3Data['xing'] = "-";

									$XingSearchStart     = ftell($fp);
									$XingSearchContent   = fread($fp, 100);

									    $posNr   = 0;
									    $posNr   = strpos($XingSearchContent, 'Xing');
									if( $posNr === false )
									{
									    $posNr   = strpos($XingSearchContent, 'Info');
									}
									if( $posNr != 0 )
									{
										fseek($fp, $XingSearchStart + $posNr, SEEK_SET);

										    $XingByte = fread($fp, 4);
										if( $XingByte == "Xing" )
										{
											// Xing Header gefunden
											// --------------------
											fseek($fp, 3, SEEK_CUR);

											$XingFlagsByte  = unpack("CData", fread($fp, 1));
											$XingFlagsBits  = str_pad(decbin($XingFlagsByte['Data']), 8, "0", STR_PAD_LEFT);

											$XingFlagFrames = $XingFlagsBits[7];
											$XingFlagBytes  = $XingFlagsBits[6];
											$XingFlagTOC    = $XingFlagsBits[5];
											$XingFlagQality = $XingFlagsBits[4];

											if( $XingFlagFrames == 1 && $XingFlagBytes == 1 )
											{
												$XingGetFrames  = unpack("NData", fread($fp, 4));
												$XingGetBytes   = unpack("NData", fread($fp, 4));

												$duration       = floor( $XingGetFrames['Data'] * $samplesPerFrame / $mp3Data['frequenz'] );
												$kbps           = round( ( $XingGetBytes['Data'] * 8 ) / ( 1000 * $duration ), 0 );

												// CBR aus Frame 1 überschreiben
												// =============================
												$mp3Data['bittype']  = "VBR";
												$mp3Data['bitrate']  = $kbps;
												$mp3Data['duration'] = $duration;
											}

											$mp3Data['xing'] = "Flags = ".$XingFlagsByte['Data'].", Frames = ".$XingGetFrames['Data'].", Bytes = ".$XingGetBytes['Data'];
										}
									}

									// Daten aus mp3-Header an id3-Array übergeben
									// ===========================================
									$id3Data['mp3'] = $mp3Data;
								}
							} else
							  {
								// Alte ID3-Tags
								// Startposition des mp3-Headers unbekannt
							  }

							$this->nID3data = $id3Data;

							fclose($fp);
						} else
						  {
							$this->error = "Datei nicht lesbar.";
						  }
					} else
					  {
						$this->error = "Datei hat kein mp3-Format.";
					  }
				} else
				  {
					$this->error = "Datei nicht gefunden.";
				  }
			} else
			  {
				$this->error = "Dateiname leer oder nicht lesbar.";
			  }
		}


		// ============================================================================================================================================================================


		// Gibt alle ermittelten ID3-Daten zurück
		// **************************************
		public function getArray()
		{
			return $this->nID3data;
		}


		// Einen einzelnen Tag auslesen
		// ****************************
		public function getTag($tagName)
		{
			$tagName = strtoupper($tagName);

			if( preg_match("/[0-9A-Z]{4}/", $tagName) )
			{
				if( isset($this->nID3data['id3']['tags'][$tagName]['content']) )
				{
					return $this->nID3data['id3']['tags'][$tagName]['content'];
				} else
				if( isset($this->nID3data['id3']['skipped'][$tagName]['content']) )
				{
					return $this->nID3data['id3']['skipped'][$tagName]['content'];
				} else
				  {
					return "Fehler";
				  }
			} else
			  {
				return "Fehler";
			  }
		}


		// Alle gefundenen Tags auflisten
		// ******************************
		public function getAllTags()
		{
			$retArray = array();
			$allTags  = array_merge($this->nID3data['id3']['tags'], $this->nID3data['id3']['skipped']);

			if( sizeof($allTags) > 0 )
			{
				foreach( $allTags AS $key => $value )
				{
					$retArray[] = $key;
				}
			}

			return $retArray;
		}


		// Gibt die ID3-Version aus
		// ************************
		public function getVersion()
		{
			return ( isset($this->nID3data['id3']['header']['version']) ) ? $this->nID3data['id3']['header']['version'] : "";
		}


		// Gibt die Layer-Nummer aus
		// *************************
		public function getLayer()
		{
			return ( isset($this->nID3data['mp3']['id']) ) ? $this->nID3data['mp3']['id'] : "";
		}


		// Gibt die SampleRate aus
		// ***********************
		public function getSampleRate()
		{
			return ( isset($this->nID3data['mp3']['frequenz']) ) ? $this->nID3data['mp3']['frequenz'] : "";
		}


		// Gibt die Bitrate aus
		// ********************
		public function getBitRate()
		{
			return ( isset($this->nID3data['mp3']['bitrate']) ) ? $this->nID3data['mp3']['bitrate'] : "";
		}


		// Gibt die Anzahl der Kanäle aus
		// ******************************
		public function getChannels()
		{
			return ( isset($this->nID3data['mp3']['kanaele']) ) ? $this->nID3data['mp3']['kanaele'] : "";
		}


		// Gibt die Laufzeit aus
		// *********************
		public function getDuration()
		{
			return ( isset($this->nID3data['mp3']['duration']) ) ? $this->nID3data['mp3']['duration'] : "";
		}


		// Gibt die Dateigröße aus
		// ***********************
		public function getFileSize()
		{
			return $this->filesize;
		}


		// Gibt den Titel aus
		// ******************
		public function getTitle()
		{
			return ( isset($this->nID3data['id3']['tags']['TIT2']) ) ? $this->nID3data['id3']['tags']['TIT2']['content'] : "";
		}


		// Gibt den Interpreten aus
		// ************************
		public function getArtist()
		{
			return ( isset($this->nID3data['id3']['tags']['TPE1']) ) ? $this->nID3data['id3']['tags']['TPE1']['content'] : "";
		}


		// Gibt den Albumnamen aus
		// ***********************
		public function getAlbum()
		{
			return ( isset($this->nID3data['id3']['tags']['TALB']) ) ? $this->nID3data['id3']['tags']['TALB']['content'] : "";
		}


		// Gibt die Track-Nummer aus
		// *************************
		public function getTrack()
		{
			return ( isset($this->nID3data['id3']['tags']['TRCK']) ) ? $this->nID3data['id3']['tags']['TRCK']['content'] : "";
		}


		// Gibt das Genre aus
		// ******************
		public function getGenre()
		{
			if( isset($this->nID3data['id3']['tags']['TCON']) )
			{
				if( $this->nID3data['id3']['tags']['TCON']['content'][0] == "(" )
				{
					$getNumber = explode(")", substr($this->nID3data['id3']['tags']['TCON']['content'], 1, strlen($this->nID3data['id3']['tags']['TCON']['content'])-1));

					return self::$genreList[$getNumber[0]];
				} else
				  {
					return $this->nID3data['id3']['tags']['TCON']['content'];
				  }
			} else
			  {
				return "";
			  }
		}


		// Gibt das Erscheinungsjahr aus
		// *****************************
		public function getYear()
		{
			if( isset($this->nID3data['id3']['tags']['TDRC']) )
			{
				return $this->nID3data['id3']['tags']['TDRC']['content'];
			} else
			if( isset($this->nID3data['id3']['tags']['TYER']) )
			{
				return $this->nID3data['id3']['tags']['TYER']['content'];
			} else
			  {
				return "";
			  }
		}


		// Gibt die BPM aus
		// ****************
		public function getBPM()
		{
			return ( isset($this->nID3data['id3']['tags']['TBPM']) ) ? $this->nID3data['id3']['tags']['TBPM']['content'] : "";
		}


		// Gibt den Kommentar und dessen Beschreibung aus
		// **********************************************
		public function getComment()
		{
			return ( isset($this->nID3data['id3']['tags']['COMM']) ) ? $this->nID3data['id3']['tags']['COMM']['content']['desc'].": ".$this->nID3data['id3']['tags']['COMM']['content']['data'] : "";
		}


		// Gibt alle ID3V1-Tags in einem assoziativem Array aus
		// *****************************************************
		public function getID3V1Tags()
		{
			return ( isset($this->nID3data['id3v1']) ) ? $this->nID3data['id3v1'] : "";
		}


		// Gibt den HTML-Code des Bildes aus
		// *********************************
		public function getImage()
		{
			if( isset($this->nID3data['id3']['tags']['APIC']['content']) )
			{
				return "<img id=\"profileImage\" src=\"data:".$this->nID3data['id3']['tags']['APIC']['content']['mime'].";base64,".$this->nID3data['id3']['tags']['APIC']['content']['data']."\">";
			} else
			  {
				return "";
			  }
		}


		// Gibt den Typ des Bildes aus
		// ***************************
		public function getImageType()
		{
			return ( isset($this->nID3data['id3']['tags']['APIC']['content']['type']) ) ? $this->nID3data['id3']['tags']['APIC']['content']['type'] : "";
		}


		// Gibt die Beschreibung des Bildes aus
		// ************************************
		public function getImageDesc()
		{
			return ( isset($this->nID3data['id3']['tags']['APIC']['content']['desc']) ) ? $this->nID3data['id3']['tags']['APIC']['content']['desc'] : "";
		}


		// Speichert das Bild auf dem Server
		// *********************************
		public function saveImage($newFileName)
		{
			if( isset($this->nID3data['id3']['tags']['APIC']['content']) )
			{
				$imgData  = str_replace(' ', '+', $this->nID3data['id3']['tags']['APIC']['content']['data']);
				$imgData  = base64_decode($imgData);

				$imgName  = $newFileName;
				$imgName .= ( substr($this->nID3data['id3']['tags']['APIC']['content']['mime'], -3) == "png" ) ? ".png" : ".jpg";

				file_put_contents($imgName, $imgData);

				if( is_file($imgName) )
				{
					return "OK";
				} else
				  {
					return "FEHLER";
				  }
			} else
			  {
				return "";
			  }
		}


		// Dateiausgabe als Bild
		// *********************
		public function beAnImage()
		{
			if( isset($this->nID3data['id3']['tags']['APIC']['content']) )
			{
				// Cover-Bild ausgeben
				// ===================
				header("Content-Type: ".$this->nID3data['id3']['tags']['APIC']['content']['mime']);

				$img = imagecreatefromstring(base64_decode($this->nID3data['id3']['tags']['APIC']['content']['data']));
				if( strstr($this->nID3data['id3']['tags']['APIC']['content']['mime'], 'png') ) 
				{
					imagepng($img);
				} else
				  {
					imagejpeg($img);
				  }
			} else
			  {
				    // Fehler-Bild ausgeben
				    // ====================
				    $createImage     = 1;
				    $useApicDefault  = ( $this->apicDefault != "" ) ? $this->apicDefault : APIC_DEF_IMG;
				if( $useApicDefault != "" )
				{
					if( is_file($useApicDefault) )
					{
						$createImage = 0;

						$defMime     = substr(strtolower(strrchr($useApicDefault, '.')), 1);
						$defMime     = ( $defMime == "jpg" ) ? "jpeg" : $defMime;

						$defCreate   = "imagecreatefrom".$defMime;
						$defName     = "image".$defMime;
						$defImg      = $defCreate($useApicDefault);

						header("Content-type: image/".$defMime."");
						$defName($defImg);
						imagedestroy($defImg);
					} else
					  {
						// echo "Fehler: Bilddaten nicht vorhanden.";
					  }
				} else
				  {
					// echo "Fehler: Bilddaten nicht vorhanden.";
				  }

				// Eigenes Fehler-Bild erzeugen
				// ============================
				if( $createImage == 1 )
				{
					$errImg             = array();
					$errImg['width']    = 100;
					$errImg['height']   = 100;
					$errImg['img']      = imagecreate($errImg['width'], $errImg['height']);
					$errImg['black']    = imagecolorallocate($errImg['img'],   0,   0,   0);
					$errImg['turq']     = imagecolorallocate($errImg['img'],   0, 255, 255);
					$errImg['grey']     = imagecolorallocate($errImg['img'],  40,  40,  40);
					$errImg['font']     = 5;
					$errImg['text_1']   = 'Not';
					$errImg['text_2']   = 'Found';
					$errImg['t_w_1']    = imagefontwidth($errImg['font']) * strlen($errImg['text_1']);
					$errImg['t_w_2']    = imagefontwidth($errImg['font']) * strlen($errImg['text_2']);
					$errImg['t_height'] = imagefontheight($errImg['font']);
					$errImg['t_x_1']    = round( ( ( $errImg['width'] - $errImg['t_w_1'] ) / 2), 1) + 1;
					$errImg['t_x_2']    = round( ( ( $errImg['width'] - $errImg['t_w_2'] ) / 2), 1) + 1;
					$errImg['t_y_1']    = round( ( ( $errImg['height'] / 2 ) - $errImg['t_height'] - 5 ), 1);
					$errImg['t_y_2']    = round( ( ( $errImg['height'] / 2 ) + 0 + 2 ), 1);

					imagefilledarc($errImg['img'], ($errImg['width']/2), ($errImg['height']/2), 60, 60, 0, 360, $errImg['turq'],  IMG_ARC_PIE);
					imagefilledarc($errImg['img'], ($errImg['width']/2), ($errImg['height']/2),  5,  5, 0, 360, $errImg['black'], IMG_ARC_PIE);

					for( $c = 62; $c < $errImg['width']; $c++ )
					{
						imagearc($errImg['img'], ($errImg['width']/2), ($errImg['height']/2), $c, $c, 0, 360, $errImg['grey']);
						$c += 4;
					}

					imagestring($errImg['img'], $errImg['font'], $errImg['t_x_1'], $errImg['t_y_1'], $errImg['text_1'], $errImg['black']);
					imagestring($errImg['img'], $errImg['font'], $errImg['t_x_2'], $errImg['t_y_2'], $errImg['text_2'], $errImg['black']);

					header("Content-type: image/png");
					imagepng($errImg['img']);
					imagedestroy($errImg['img']);
				}
			  }
		}


		// Überschreibt das Default-Bild für ein nicht gefundenes Cover-Bild
		// *****************************************************************
		public function apicDefault($defName)
		{
			if( $defName != "" )
			{
				$this->apicDefault = $defName;
			}
		}


		// Wandelt eine SyncSafe-Integer in eine 32-bit um
		// ***********************************************
		public static function syncSafeToInt($integer)
		{
			$intDecimal = decbin($integer);
			$intFilled  = str_pad($intDecimal, 32, "0", STR_PAD_LEFT);

			$sizeByte1  = substr($intFilled,  0, 8);
			$sizeByte2  = substr($intFilled,  8, 8);
			$sizeByte3  = substr($intFilled, 16, 8);
			$sizeByte4  = substr($intFilled, 24, 8);

			$sizeByte1  = substr($sizeByte1, -7);
			$sizeByte2  = substr($sizeByte2, -7);
			$sizeByte3  = substr($sizeByte3, -7);
			$sizeByte4  = substr($sizeByte4, -7);

			$sizeBytes  = "0000".$sizeByte1.$sizeByte2.$sizeByte3.$sizeByte4;

			$sizeNew    = bindec($sizeBytes);

			$t1         = substr($sizeBytes,  0, 8);
			$t2         = substr($sizeBytes,  8, 8);
			$t3         = substr($sizeBytes, 16, 8);
			$t4         = substr($sizeBytes, 24, 8);

			return $sizeNew;
		}


		// Konvertiert Zeichenketten entsprechend dem Charset
		// **************************************************
		public static function convertCharset($charset, $content)
		{
			switch( $charset )
			{
				case 'utf-16':
					$output = @iconv('utf-16',     'utf-8//IGNORE', substr($content, 0));
					break;

				case 'utf-16be':
					$output = @iconv('utf-16be',   'utf-8//IGNORE', substr($content, 0));
					break;

				case 'utf-8':
					$output = $content;
					break;

				// 'iso-8859-1'
				default:
					$output = @iconv('iso-8859-1', 'utf-8//IGNORE', substr($content, 0));
			}

			return $output;
		}


		// Sucht den Charset aus dem encoding-Byte
		// ***************************************
		public static function getCharsetFromByte($encode)
		{
			switch( $encode )
			{
				case 1:
					$charset = 'utf-16';
					break;
				case 2:
					$charset = 'utf-16be';
					break;
				case 3:
					$charset = 'utf-8';
					break;
				default:
					$charset = 'iso-8859-1';
			}

			return $charset;
		}


		// Gibt die "Samples pro Frame" anhand der MPEG-Variante zurück
		// ************************************************************
		public function getSamplesPerFrame($fileID, $fileLayer)
		{
			if( $fileID == 3 )
			{
				// MPEG Version 1
				switch($fileLayer)
				{
					case 3:	// Layer 1
						$spf =  384;
						break;
					case 3:	// Layer 2
						$spf = 1152;
						break;
					case 3:	// Layer 3
						$spf = 1152;
						break;
					default:
						$spf = 1152;
				}
			} else
			  {
				// MPEG Version > 1
				switch($fileLayer)
				{
					case 3:	// Layer 1
						$spf =  384;
						break;
					case 3:	// Layer 2
						$spf = 1152;
						break;
					case 3:	// Layer 3
						$spf = 576;
						break;
					default:
						$spf = 576;
				}
			  }

			return $spf;
		}


		// Zeigt die Struktur des Daten-Array an
		// *************************************
		public static function getStructure()
		{
			$retVal = "<pre>
['file']['size']                                  => Dateigroesse
['file']['name']                                  => Dateiname
['file']['path']                                  => Dateipfad
['file']['base']                                  => Dateiname ohne Endung
['file']['mime']                                  => Dateityp (Endung)
['file']['mtime']                                 => Zeitpunkt der letzten Dateiaenderung
['file']['atime']                                 => Zeitpunkt des letzten Dateizugriffs

['mp3']['id']                                     => Z.B. MPEG 1
['mp3']['layer']                                  => MPEG Layer Nummer 1-3
['mp3']['kanaele']                                => 1 oder 2 = Stereo oder Mono
['mp3']['bittype']                                => Konstante (CBR) oder Variable (VBR) Bitrate
['mp3']['bitrate']                                => Kilo-Bits pro Sekunde
['mp3']['frequenz']                               => SampleRate in Hz
['mp3']['duration']                               => Laufzeit in Sekunden
['mp3']['xing']                                   => Xing oder Info Header vorhanden

['id3']['header']['system']                       => ID3
       ['header']['major']                        => Version hauptnummer 1 oder 2
       ['header']['minor']                        => Version Unternummer
       ['header']['version']                      => Z.B. V2.3.0
       ['header']['flags']                        => 8 Bits als String
       ['header']['size']                         => Groesse der ID3-Datei in Bytes
       ['header']['extended']                     => Erweiteter Header vorhanden 1 oder 0
       ['header']['counter']                      => Anzahl der gefunden Tags
       ['header']['padding']                      => Freiraum in Bytes

['id3']['tags']['TAGNAME']['name']                => Gefundene Tags aus dem Such-Array -> ['id3']['tags'][]...
                          ['size']                => Tag-Groesse
                          ['flags_1']             => Tag-Flags Byte 1
                          ['flags_2']             => Tag-Flags Byte 2
                          ['pos']                 => Startposition des Tags in Byte
                          ['encode']              => Kodierung 0 bis 3
                          ['charset']             => Zeichensatz, z.B. UTF-8
                          ['content']             => String oder weiteres Array

['id3']['skipped']['TAGNAME']['name']             => Gefundene Tags ausserhalb des Such-Arrays -> ['id3']['skipped'][]...
                             ['size']             => Tag-Groesse
                             ['flags_1']          => Tag-Flags Byte 1
                             ['flags_2']          => Tag-Flags Byte 2
                             ['content']          => Daten als String

['id3v1']['titel']                                => Alte ID3V1 Tags - Titel
['id3v1']['interpret']                            => Interpret
['id3v1']['album']                                => Albumname
['id3v1']['jahr']                                 => Erscheinungsjahr
['id3v1']['kommentar']                            => Kommentar
['id3v1']['track']                                => Track-Nummer
['id3v1']['genre_nr']                             => Nummer des Genre-Arrays
['id3v1']['genre_text']                           => Der dazu passende Text

['APE']                                           => APE-Tags    vorhanden \"-\" oder Groessenangaben

['Lyrics']                                        => Lyrics-Tags vorhanden \"-\" oder Groessenangaben

</pre>";

			return $retVal;
		}


		// Listet alle zu durchsuchenden Tags auf
		// **************************************
		public static function getTagList()
		{
			return self::$tagUse;
		}


		// Zeigt ein Bild der Wellenform an
		// ********************************
		public function getWaveForm($width, $height, $fillColor, $strokeColor)
		{
			$retVal = "<canvas id=\"nID3wave\" width=\"".$width."\" height=\"".$height."\" title=\"Wellenform der Datei ".$this->fileName."\" style=\"border: 0px;\"></canvas>
			<script language=\"javascript\">

				function nID3waveLoad()
				{
					try
					{
						ID3audioCtx              = new( window.AudioContext || window.webkitAudioContext )();
						var request              = new XMLHttpRequest();
						    request.open('GET', '".$this->file."', true);
						    request.responseType = 'arraybuffer';
						    request.onload       = function()
						    {
							ID3audioCtx.decodeAudioData(request.response, function(buffer)
							{
								nID3waveDraw(buffer);

							}, function() { alert('Datei nicht lesbar.'); });
						    }
						    request.send();
					} catch(e)
					  {
						console.log(e);
					  }
				}

				function nID3waveDraw(waveFormBuffer)
				{
					channelData  = waveFormBuffer.getChannelData(0);
					renderLength = channelData.length / 1000;
					canvasID     = document.getElementById('nID3wave').getContext('2d');\n\n";

					if( $fillColor   != "" ) { $retVal .= "canvasID.fillStyle   = '".$fillColor."'; canvasID.fillRect( 0, 0, ".$width.", ".$height.");\n"; }
					if( $strokeColor != "" ) { $retVal .= "canvasID.strokeStyle = '".$strokeColor."';\n"; }

					$retVal .= "canvasID.translate(0,".$height." / 2);
					for( i = 0; i < renderLength; i++ )
					{
						x = Math.floor( ".$width." * i / renderLength );
						y = channelData[(i*1000)] * ".$height." / 2;
						canvasID.beginPath();
						canvasID.moveTo(x  , 0);
						canvasID.lineTo(x+1, y);
						canvasID.stroke();
						canvasID.closePath();
					}
					canvasID.translate(0,-(".$height."/2));
				}

				document.onload = window.setTimeout(\"nID3waveLoad()\", 500);
			</script>\n\n";

			return $retVal;
		}
	}

?>