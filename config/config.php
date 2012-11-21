<?php

/**
 * Add back end modules
 */
$GLOBALS['BE_MOD']['system']['servitus'] = array
(
	'tables' 	=> array('tl_servitus_job', 'tl_servitus_step', 'tl_servitus_fldmap'),
	'icon'   	=> 'system/modules/servitus/assets/icon_jobs.png',
	'runStep'	=> array('\Servitus\Helper','runStepFromDCA')
);


/**
 * Servitus Step-Types
 */
$GLOBALS['Servitus_Step']['copyTable'] 				= array('class' => 'CopyTable');
$GLOBALS['Servitus_Step']['deleteTable'] 			= array('class' => 'DeleteTable');
$GLOBALS['Servitus_Step']['renameTable'] 			= array('class' => 'RenameTable');
$GLOBALS['Servitus_Step']['truncateTable'] 			= array('class' => 'TruncateTable');
$GLOBALS['Servitus_Step']['csvImport'] 				= array('class' => 'CsvImport');
$GLOBALS['Servitus_Step']['fillTable'] 				= array('class' => 'FillTable');


/**
 * Servitus MergeTable-Types
 */
$GLOBALS['Servitus_FldSrc']['tableField'] 			= array('class' => 'TableField', 'alterDataTypes'=>array('toTstamp','refImage','transform','refForeignTable','hash','prefixSuffix'));
$GLOBALS['Servitus_FldSrc']['tstamp'] 				= array('class' => 'Tstamp');
$GLOBALS['Servitus_FldSrc']['fixed'] 				= array('class' => 'Fixed');
$GLOBALS['Servitus_FldSrc']['query'] 				= array('class' => 'Query');
$GLOBALS['Servitus_FldSrc']['toChildTable'] 		= array('class' => 'ToChildTable', 'alterDataTypes'=>array('toTstamp','transform','refForeignTable','hash','prefixSuffix'));


/**
 * Servitus AlterData-Types
 */
$GLOBALS['Servitus_AlterData']['toTstamp'] 			= array('class' => 'ToTstamp');
$GLOBALS['Servitus_AlterData']['refImage'] 			= array('class' => 'ReferenceImage');
$GLOBALS['Servitus_AlterData']['transform'] 		= array('class' => 'Transform');
$GLOBALS['Servitus_AlterData']['prefixSuffix'] 		= array('class' => 'PrefixSuffix');
$GLOBALS['Servitus_AlterData']['refForeignTable'] 	= array('class' => 'ReferenceForeignTable');
$GLOBALS['Servitus_AlterData']['hash'] 				= array('class' => 'GenerateHash');
