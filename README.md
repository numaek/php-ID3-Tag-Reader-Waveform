```
PHP ID3 TagReader Class with APIC & Waveform-Image.
Gather information about File properties, mp3-Header und -properties, ID3V1 und -V3 Tags, APE- und Lyrics Tags (available).


PHP ID3 TagReader Klasse mit APIC & Anzeige der Wellenform als Bild.
Stellt Infos zusammen über Dateieigenschaften, mp3-Header und -Eigenschaften, ID3V1 und -V3 Tags, APE- und Lyrics Tags (vorhanden).


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
```
