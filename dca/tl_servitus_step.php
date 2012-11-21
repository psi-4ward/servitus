<?php



/**
 * Table tl_servitus_step
 */
$GLOBALS['TL_DCA']['tl_servitus_step'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'ptable'					  => 'tl_servitus_job',
		'ctables'					  => 'tl_servitus_fldmap',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => array('name'),
			'child_record_callback'   => array('tl_servitus_step', 'generateRow')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'editFldmap' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['editFldmap'],
				'href'                => 'table=tl_servitus_fldmap',
				'icon'                => 'system/modules/servitus/assets/fldmap.png',
				'button_callback'	  => array('tl_servitus_step','generateEditFldmapButton')
			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('DCAHelper', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'run' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_step']['run'],
				'href'                => 'key=runStep',
				'icon'                => 'system/modules/servitus/assets/run.png',
				'attributes'          => 'onclick="return confirm(\'Dieser Schritt wird jetzt ausgeführt!\');"',
			)
		),
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                	=> array('type', 'useRounds','useKeyfield','useValidation'),
		'default'                     	=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{published_legend},published',
		'truncateTable'               	=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{config_legend},tbl;{published_legend},published',
		'renameTable'               	=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{config_legend},tbl,renameTo;{published_legend},published',
		'copyTable'               		=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{config_legend},tbl,copyTo;{published_legend},published',
		'deleteTable'               	=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{config_legend},tbl;{published_legend},published',
		'csvImport'               		=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{round_legend:hide},useRounds;{config_legend},tmpTbl,csvEncoding,csvDelimiter,csvEnclosure,csvEscape,csvHeadlines,csvFile;{validation_legend},useValidation;{published_legend},published',
		'fillTable'                   	=> '{type_legend},type,typeDesc;{notes_legend:hide},name,description;{round_legend:hide},useRounds;{config_legend},sourceTbl,targetTbl;{keyfield_legend},useKeyfield;{published_legend},published',
	),

	// Subpalettes
	'subpalettes' => array
	(
		'useRounds'					=> 'perRound',
		'useKeyfield'				=> 'sourceKeyfield,targetKeyfield,deleteObsolete,updateExisting,showNotImported',
		'useValidation'				=> 'constraints'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['type'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_step', 'getStepTypes'),
			'reference'               => &$GLOBALS['TL_LANG']['Servitus_Steps'],
			'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'typeDesc' => array
		(
			'input_field_callback'		=> array('tl_servitus_step', 'getTypeDescription')
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['name'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['description'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'style'=>'height:40px'),
			'sql'                     => "text NULL"
		),
		'useRounds' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['useRounds'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'perRound' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['perRound'],
			'inputType'               => 'text',
			'default'				  => '1000',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit'),
			'sql'                     => "int(6) NOT NULL default '1000'"
		),
		'tbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['tbl'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('\Servitus\Helper', 'getTables'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'sourceTbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['sourceTbl'],
			'inputType'               => 'select',
			'options_callback'        => array('\Servitus\Helper', 'getTables'),
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'targetTbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['targetTbl'],
			'inputType'               => 'select',
			'options_callback'        => array('\Servitus\Helper', 'getTables'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'renameTo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['renameTo'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'copyTo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['copyTo'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'tmpTbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['tmpTbl'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'csvEncoding' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvEncoding'],
			'inputType'               => 'select',
			'default'				  => 'UTF-8',
			'options'       		  => array('UTF-8', 'ASCII', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1252', 'CP1256'),
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default 'UTF-8'"
		),
		'csvDelimiter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvDelimiter'],
			'inputType'               => 'select',
			'options'       		  => array(',',';'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'csvEnclosure' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvEnclosure'],
			'inputType'               => 'text',
			'default'				  => '"',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'maxlength'=>1, 'decodeEntities'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'csvEscape' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvEscape'],
			'inputType'               => 'text',
			'default'				  => '\\',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'maxlength'=>1, 'decodeEntities'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'csvHeadlines' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvHeadlines'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'csvFile' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['csvFile'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'files'=>true, 'extensions'=>'csv,txt', 'tl_class'=>'clr', 'mandatory'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'useKeyfield' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['useKeyfield'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'sourceKeyfield' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['sourceKeyfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_step', 'getSourceTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'targetKeyfield' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['targetKeyfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_step', 'getTargetTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'deleteObsolete' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['deleteObsolete'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'updateExisting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['updateExisting'],
			'inputType'               => 'checkbox',
			'default'				  => '1',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'showNotImported' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['showNotImported'],
			'inputType'               => 'checkbox',
			'default'				  => '1',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'useValidation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['useValidation'],
			'inputType'               => 'checkbox',
			'default'				  => '1',
			'eval'                    => array('tl_class'=>'', 'submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'constraints' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['constraints'],
			'inputType'               => 'multiColumnWizard',
			'eval'                    => array
			(
				'columnFields' => array
				(
					'fld' => array
					(
						'label'       => &$GLOBALS['TL_LANG']['tl_servitus_step']['field'],
						'inputType'   => 'select',
						'options_callback' => array('tl_servitus_step','getCsvRowtitles'),
						'eval'		  => array('mandatory'=>true, 'style'=>'width:280px', 'isAssociative'=>true)
					),
					'constraint' => array
					(
						'label'       => &$GLOBALS['TL_LANG']['tl_servitus_step']['constraint'],
						'inputType'   => 'select',
						'options'	  => array('notEmpty','digit','alpha','alnum','extnd','date','time','datim','friendly','email','emails','url','alias','folderalias','phone','prcnt','locale','language'),
						'eval'		  => array('mandatory'=>true, 'style'=>'width:280px')
					),
				)
			),
			'sql'                     => "blob NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_step']['published'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);

/**
 * Helper class for DCA
 */
class tl_servitus_step extends System
{

	/**
	 * @var \Contao\Database
	 */
	protected $Database;

	public function __construct()
	{
		parent::__construct();
		$this->Database = \Database::getInstance();
	}

	
	/**
	 * Return the headlines of the csv
	 * these are equivalent wit the rows of the temp-table
	 */
	public function getCsvRowtitles($dc)
	{
		if(!$dc->activeRecord) return array();
		$objCsvImport = new \Servitus\Step\CsvImport($dc->activeRecord->row());
		return $objCsvImport->getHeadlines();
	}
	
	
	/**
	 * Return the editFieldMap-Button if theres type=fillTable
	 * used in button_callback
	 *
	 * @param $row
	 * @param $href
	 * @param $label
	 * @param $title
	 * @param $icon
	 * @param $attributes
	 * @return string
	 */
	public function generateEditFldmapButton($row, $href, $label, $title, $icon, $attributes)
	{
		if($row['type'] != 'fillTable') return '';

		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}



	public function getTargetTblFields($dc)
	{
		if(!$dc->activeRecord->targetTbl) return array();
		$arrFlds = $this->Database->listFields($dc->activeRecord->targetTbl);
		$erg = array();
		foreach($arrFlds as $fld)
		{
			if($fld['type'] == 'index') continue;
			$erg[] = $fld['name'];
		}
		return $erg;
	}
	public function getSourceTblFields($dc)
	{
		if(!$dc->activeRecord->sourceTbl) return array();
		$arrFlds = $this->Database->listFields($dc->activeRecord->sourceTbl);
		$erg = array();
		foreach($arrFlds as $fld)
		{
			if($fld['type'] == 'index') continue;
			$erg[] = $fld['name'];
		}
		return $erg;
	}


	/**
	 * Return all step-types
	 *
	 * @return array
	 */
	public function getStepTypes()
	{
		return array_keys($GLOBALS['Servitus_Step']);
	}


	/**
	 * Generate a row
	 *
	 * @param $arrRow
	 * @return string
	 */
	public function generateRow($arrRow)
	{
		$stepClass = '\Servitus\Step\\'.$GLOBALS['Servitus_Step'][$arrRow['type']]['class'];
		if(!class_exists($stepClass))
		{
			return '<p class="tl_error">Class '.$stepClass.' does not exist!</p>';
		}

		$objStep = new $stepClass($arrRow);
		$ret = '<p><span style="font-weight:bold">'.$GLOBALS['TL_LANG']['Servitus_Steps'][$arrRow['type']].'</span><br>'.$arrRow['name'].'</p>'.$objStep->generate();
		return $ret;
	}


	public function getTypeDescription($dc)
	{
		$type = ($dc->activeRecord->type);

		if(!isset($GLOBALS['TL_LANG']['tl_servitus_step']['typeDesc'][$type])) return '';

		return '<div class="clr">
  					<h3 style="margin-bottom:5px;">Type-Beschreibung</h3>
  					<div>'.$GLOBALS['TL_LANG']['tl_servitus_step']['typeDesc'][$type].'</div>
				</div>';
	}
}