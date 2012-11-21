<?php


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['type']				= array('Type', 'Wählen Sie die durchzuführende Operation.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sourceField']		= array('Feld der Quelltabelle', 'Wählen Sie das Feld der Datenbasis.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sourceFields']		= array('Felder der Quelltabelle', 'Wählen Sie mindestens ein Feld der Quelltabelle.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['targetField']		= array('Feld der Zieltabelle', 'Wählen Sie das Feld der Zieltabelle.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterData']			= array('Feldwert verändern', 'Der Feldwert wird vor dem Schreiben in die Zieltabelle verändert.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['dateFormat']			= array('Datumsformat', 'Tragen Sie hier das Format des Darums ein im Quellfeld ein.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['path']				= array('Pfad der Quelldateien', 'Wählen Sie den Pfad der Quelldateien.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['avoidDuplicates']	= array('Duplikate vermeiden', 'Prüft ob der Wert/Datei bereits vorhanden ist und referenziert ggf. diese.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['value']				= array('Wert', 'Tragen Sie hier den Wert ein, der in das Feld geschrieben werden soll.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sqlquery']			= array('SQL-Query', 'Das Query wird <i>nach</i> jedem import einer Zeile aufgerufen. Sie können mit {{sourceID}} und {{insertID}} die jeweiligen Datensätze referenzieren.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['queryToField']		= array('Ergebnis in ein Feld schreiben', 'Mit dieser Option kann das Ergebnis des Querys in ein Feld der Zieltabelle geschrieben werden. Achten Sie darauf, dass Ihr Query nur eine Ergebnis nur aus einer Zeller besteht!');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['transformMatrix']	= array('Übersetzungsmatrix', 'Die entsprechung der linken Spalte wird in den Wert der rechten Spalte transformiert.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['childTbl']			= array('Kindtabelle', 'Wählen Sie die zu befüllende Kindtabelle.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['childTblFld']		= array('Zielfeld', 'In dieses Feld der Kindtabelle wird der Wert geschrieben.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['foreignTbl']			= array('Fremndtabelle', 'Diese Tabelle wird nach dem Wert durchsucht, dessen ID referenziert wird.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['foreignField']		= array('Fremndtabelle-Feld', 'Dieses Feld wird nach dem Wert durchsucht, dessen ID referenziert wird.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['hashAlgo']			= array('Hash-Algorithmus', 'Wählen Sie den Algorithmus zum berechnen des Hashwerts.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValues']		= array('Feldwerte splitten', 'Trennt die Werte des Feldes anhand des gewählten Zeichens.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['position']			= array('Position', 'Wählen Sie die Position des Werts.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['onlyIfNotExists']	= array('Nur einfügen wenn noch nicht vorhanden', 'Der Wert wird nur eingefügt, sofern er noch nicht existiert.');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['published']			= array('Feldzuweiseung aktiviert', 'Dieser Feldzuweiseung ist aktiviert.');


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['new']			= array('Neue Feldzuweiseung', 'Erstellen Sie eine neue Feldzuweiseung');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['edit']			= array('Feldzuweiseung bearbeiten', 'Feldzuweiseung ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['copy']			= array('Feldzuweiseung kopieren', 'Feldzuweiseung ID %s kopieren');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['delete']			= array('Feldzuweiseung löschen', 'Feldzuweiseung ID %s löschen');
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['show']			= array('Feldzuweiseungendetails', 'Details des Feldzuweiseungs ID %s anzeigen');



/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['type_legend']			= 'Typ';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alter_legend']			= 'Feldwert-Änderung';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['config_legend']			= 'Konfiguration';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['published_legend']		= 'Aktivierung';


/**
 * alterData Reference
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['toTstamp'] 			= 'Datum Unix-Timestamp wandeln';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['refImage'] 			= 'Bild referenzieren';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['transform'] 			= 'Transformations-Matrix';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['refForeignTable'] 	= 'Fremndtabelle referenzieren';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['hash'] 				= 'Hash berechnen';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef']['prefixSuffix'] 		= 'Wert voranstellen/anhängen';


/**
 * splitValues Reference
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValuesRef']['deserialize']		= 'PHP deserialize()';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValuesRef']['comma']			= 'Kommata';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValuesRef']['semikolon']		= 'Semikolon';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValuesRef']['space']			= 'Leerzeichen';


/**
 * position Reference
 */
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['positionRef']['prefix']		= 'voranstellen';
$GLOBALS['TL_LANG']['tl_servitus_fldmap']['positionRef']['suffix']		= 'anhängen';
