<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Servitus\Helper'   				=> 'system/modules/servitus/classes/Helper.php',
	'Servitus\Job'   					=> 'system/modules/servitus/classes/Job.php',
	'Servitus\Step'   					=> 'system/modules/servitus/classes/Step.php',
	'Servitus\Fldsrc'   				=> 'system/modules/servitus/classes/Fldsrc.php',
	'Servitus\AlterData'   				=> 'system/modules/servitus/classes/AlterData.php',
	'Servitus\Step\CopyTable'  			=> 'system/modules/servitus/steps/CopyTable.php',
	'Servitus\Step\TruncateTable'  		=> 'system/modules/servitus/steps/TruncateTable.php',
	'Servitus\Step\DeleteTable'  		=> 'system/modules/servitus/steps/DeleteTable.php',
	'Servitus\Step\RenameTable'  		=> 'system/modules/servitus/steps/RenameTable.php',
	'Servitus\Step\CsvImport'  			=> 'system/modules/servitus/steps/CsvImport.php',
	'Servitus\Step\FillTable'  			=> 'system/modules/servitus/steps/FillTable.php',
	'Servitus\Fldsrc\TableField'  		=> 'system/modules/servitus/fldsrc/TableField.php',
	'Servitus\Fldsrc\ToChildTable' 		=> 'system/modules/servitus/fldsrc/ToChildTable.php',
	'Servitus\Fldsrc\Fixed' 			=> 'system/modules/servitus/fldsrc/Fixed.php',
	'Servitus\Fldsrc\Query' 			=> 'system/modules/servitus/fldsrc/Query.php',
	'Servitus\Fldsrc\Tstamp' 			=> 'system/modules/servitus/fldsrc/Tstamp.php',
	'Servitus\AlterData\PrefixSuffix'	=> 'system/modules/servitus/alterData/PrefixSuffix.php',
	'Servitus\AlterData\Transform'		=> 'system/modules/servitus/alterData/Transform.php',
	'Servitus\AlterData\ToTstamp'		=> 'system/modules/servitus/alterData/ToTstamp.php',
	'Servitus\AlterData\ReferenceForeignTable' => 'system/modules/servitus/alterData/ReferenceForeignTable.php',
	'Servitus\AlterData\GenerateHash' 	=> 'system/modules/servitus/alterData/GenerateHash.php',
	'Servitus\AlterData\ReferenceImage' => 'system/modules/servitus/alterData/ReferenceImage.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
//	'be_tabimporter'         => 'system/modules/tabimporter/templates',
));
