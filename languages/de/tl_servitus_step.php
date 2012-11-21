<?php


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_servitus_step']['type']				= array('Type', 'Wählen Sie die durchzuführende Operation.');
$GLOBALS['TL_LANG']['tl_servitus_step']['name']				= array('Name', 'Hier kann ein opionaler Namen für den Schritt eingegeben werden.');
$GLOBALS['TL_LANG']['tl_servitus_step']['description']		= array('Beschreibung/Notizen', 'Hier können Sie Bemerkungen hinterlegen.');
$GLOBALS['TL_LANG']['tl_servitus_step']['useRounds']		= array('Diesen Schritt rundenweise durchführen', 'Wählen Sie diese Option um die Abarbeitung des Schritts rundenweise durchzuführen. Dies kann nötig sein, wenn die maximale Ausführungszeit überschritten wird.');
$GLOBALS['TL_LANG']['tl_servitus_step']['perRound']			= array('Operationen pro Runde', 'Hier können Sie die Anzahl der Operationen festlegen, die in einer Runde durchgeführt werden.');
$GLOBALS['TL_LANG']['tl_servitus_step']['tbl']				= array('Tabelle', 'Wählen Sie die Tabelle.');
$GLOBALS['TL_LANG']['tl_servitus_step']['renameTo']			= array('Umbenennen nach', 'Tragen Sie den neuen Namen der Tabelle ein.');
$GLOBALS['TL_LANG']['tl_servitus_step']['copyTo']			= array('Kopieren nach', 'Tragen Sie den Namen der Kopie-Tabelle ein.');
$GLOBALS['TL_LANG']['tl_servitus_step']['tmpTbl']			= array('Temporärer Tabellenname', 'Tragen Sie hier den temporären Tabellennamen ein.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvEncoding']		= array('Zeichensatz','Wählen Sie den Zeichensatz der CSV-Datei.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvDelimiter']		= array('Trennzeichen','Dieses Zeichen trennt die Spalten der CSV.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvEscape']		= array('Escape-Zeichen','Dieses dient zum Maskieren des Delimiters.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvEnclosure']		= array('Textmarkierungszeichen','Dieses Zeichen umschließt ein Feld.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvHeadlines']		= array('Erste Zeile enthält Überschriften','Gibt an, ob die erste Zeile der CSV Überschriften enthält.');
$GLOBALS['TL_LANG']['tl_servitus_step']['csvFile']			= array('CSV-Datei','Wählen Sie die Datei mit den CSV-Daten.');
$GLOBALS['TL_LANG']['tl_servitus_step']['sourceTbl']		= array('Quell-Tabelle', 'Diese Tabelle dient als Datenbasis.');
$GLOBALS['TL_LANG']['tl_servitus_step']['targetTbl']		= array('Ziel-Tabelle', 'In diese Tabellen werden die Daten geschrieben.');
$GLOBALS['TL_LANG']['tl_servitus_step']['useKeyfield']		= array('Schlüsselfeld nutzen', 'Über das Schlüsselfeld werden Datensätze der beiden Tabellen referenziert.');
$GLOBALS['TL_LANG']['tl_servitus_step']['sourceKeyfield']	= array('Schlüsselfeld der Quelltabelle', 'Wählen Sie das Feld der Quelltabelle.');
$GLOBALS['TL_LANG']['tl_servitus_step']['targetKeyfield']	= array('Schlüsselfeld der Zieltabelle', 'Wählen Sie das Feld der Zieltabelle.');
$GLOBALS['TL_LANG']['tl_servitus_step']['deleteObsolete']	= array('Alte Datensätze löschen', 'Entfernt alle Datensätze in der Zieltabelle, welche nicht in der Quelltabelle vorkommen.');
$GLOBALS['TL_LANG']['tl_servitus_step']['updateExisting']	= array('Bestehende Einträge updaten', 'Erneuert die Werte bereits existierender Entitäten.');
$GLOBALS['TL_LANG']['tl_servitus_step']['showNotImported']	= array('Ausgelassene Einträge anzeigen', 'Zeigt alle einträge an, die nicht übernommen wurde. Diese Option ist nur sinnvoll, wenn existierende Einträge nicht upgedated werden.');
$GLOBALS['TL_LANG']['tl_servitus_step']['useValidation']	= array('Zeilen-Validierung', 'Es werden nur Zeilen importiert, welche die Bedingungen erfüllen.');
$GLOBALS['TL_LANG']['tl_servitus_step']['constraints']		= array('Bedingungen', 'Legen Sie hier die Bedingungen fest, die für jede Zeile geprüft werden.');
$GLOBALS['TL_LANG']['tl_servitus_step']['published']		= array('Schritt aktiviert', 'Dieser Schritt ist aktiviert.');

$GLOBALS['TL_LANG']['tl_servitus_step']['field']			= 'Feld';
$GLOBALS['TL_LANG']['tl_servitus_step']['constraint']		= 'Bedingungen';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_servitus_step']['new']			= array('Neuer Schritt', 'Erstellen Sie einen neuen Schritt');
$GLOBALS['TL_LANG']['tl_servitus_step']['edit']			= array('Schritt bearbeiten', 'Schritt ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_servitus_step']['copy']			= array('Schritt kopieren', 'Schritt ID %s kopieren');
$GLOBALS['TL_LANG']['tl_servitus_step']['delete']		= array('Schritt löschen', 'Schritt ID %s löschen');
$GLOBALS['TL_LANG']['tl_servitus_step']['run']			= array('Schritt ausführen', 'Startet den Schritt ID %s');
$GLOBALS['TL_LANG']['tl_servitus_step']['show']			= array('Schrittendetails', 'Details des Schritts ID %s anzeigen');



/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_servitus_step']['type_legend']			= 'Typ';
$GLOBALS['TL_LANG']['tl_servitus_step']['notes_legend']			= 'Notizen';
$GLOBALS['TL_LANG']['tl_servitus_step']['round_legend']			= 'Rundenweises abarbeiten';
$GLOBALS['TL_LANG']['tl_servitus_step']['source_legend']		= 'Quelle';
$GLOBALS['TL_LANG']['tl_servitus_step']['target_legend']		= 'Ziel';
$GLOBALS['TL_LANG']['tl_servitus_step']['config_legend']		= 'Konfiguration';
$GLOBALS['TL_LANG']['tl_servitus_step']['keyfield_legend']		= 'Schlüsselfeld benutzen (update)';
$GLOBALS['TL_LANG']['tl_servitus_step']['published_legend']		= 'Aktivierung';



/**
 * Descriptions
 */
$GLOBALS['TL_LANG']['tl_servitus_step']['typeDesc']['csvImport'] = 'Der CSV-Import Schritt liest eine CSV-Datei in eine temporäre Datenbanktabelle ein. Auf dieser Basis
können in weiteren Schritten transformationen durchgeführt werde. Die Datenbankstruktur wird hierbei dynamisch generiert.
<br><b>Achtung:</b> Falls die temporäre Tabelle existiert wird diese vor dem Import <b>gelöscht</b>!';