<?php



/**
 * Table tl_servitus_fldmap
 */
$GLOBALS['TL_DCA']['tl_servitus_fldmap'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'ptable'					  => 'tl_servitus_step',
		'onload_callback'			  => array(array('tl_servitus_fldmap','constructPalettes')),
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
			'headerFields'            => array('type','sourceTbl','targetTbl','useKeyfield','sourceKeyfield','targetKeyfield','deleteObsolete'),
			'child_record_callback'   => array('tl_servitus_fldmap', 'generateRow')
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
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['copy'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('DCAHelper', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		),
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                	=> array('type','alterData', 'queryToField'),
		'default'                     	=> '{type_legend},type,typeDesc;{published_legend},published',
		'tableField'					=> '{type_legend},type,typeDesc;{config_legend},sourceField,targetField;{alter_legend},alterData;{published_legend},published',
		'fixed'							=> '{type_legend},type,typeDesc;{config_legend},targetField,value;{published_legend},published',
		'tstamp'						=> '{type_legend},type,typeDesc;{config_legend},targetField;{published_legend},published',
		'query'							=> '{type_legend},type,typeDesc;{config_legend},sqlquery,queryToField;{published_legend},published',
		'toChildTable'                  => '{type_legend},type,typeDesc;{config_legend},sourceFields,childTbl,childTblFld,avoidDuplicates,splitValues;{alter_legend},alterData;{published_legend},published',
	),

	// Subpalettes
	'subpalettes' => array
	(
		'queryToField' 					=> 'targetField',
	),

	// alterData Palettes
	'alterDataPalettes' => array
	(
		'toTstamp'						=> 'dateFormat',
		'refImage'						=> 'path',
		'transform'						=> 'transformMatrix',
		'refForeignTable'				=> 'foreignTbl,foreignField',
		'hash'							=> 'hashAlgo',
		'prefixSuffix'					=> 'value,position,onlyIfNotExists'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['type'],
			'filter'                  => true,
			'inputType'               => 'select',
			'default'				  => 'tableField',
			'options_callback'        => array('tl_servitus_fldmap', 'getFldSrcTypes'),
			'reference'               => &$GLOBALS['TL_LANG']['Servitus_FldSrcTypes'],
			'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'sourceField' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sourceField'],
			'search'				  => 'true',
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_fldmap', 'getSourceTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'sourceFields' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sourceFields'],
			'search'				  => 'true',
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_fldmap', 'getSourceTblFields'),
			'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'', 'decodeEntities'=>true),
			'sql'                     => "blob NULL"
		),
		'targetField' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['targetField'],
			'search'				  => 'true',
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_fldmap', 'getTargetTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alterData' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterData'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'		  => array('tl_servitus_fldmap','getAlterDataTypes'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef'],
			'eval'                    => array('submitOnChange'=>true, 'includeBlankOption'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'dateFormat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['dateFormat'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'path' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['path'],
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files' => false, 'mandatory'=>true),
			'sql'                     => "varchar(9) NOT NULL default ''"
		),
		'avoidDuplicates' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['avoidDuplicates'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'value' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['value'],
			'inputType'               => 'textarea',
			'eval'                    => array('style'=>'height:200px', 'decodeEntities'=>true,'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		),
		'sqlquery' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['sqlquery'],
			'inputType'               => 'textarea',
			'eval'                    => array('style'=>'height:200px', 'decodeEntities'=>true, 'tl_class'=>'clr', 'rte'=>'codeMirror|sql'),
			'sql'                     => "text NULL"
		),
		'queryToField' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['queryToField'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'transformMatrix' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['transformMatrix'],
			'inputType'               => 'multiColumnWizard',
			'eval'                    => array
			(
				'columnFields' => array
				(
					'src' => array
					(
						'label'       => ' ',
						'inputType'   => 'text',
						'eval'		  => array('mandatory'=>true, 'style'=>'width:280px')
					),
					'val' => array
					(
						'label'       => ' ',
						'inputType'   => 'text',
						'eval'		  => array('mandatory'=>true, 'style'=>'width:280px')
					),
				)
			),
			'sql'                     => "blob NULL"
		),
		'childTbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['childTbl'],
			'inputType'               => 'select',
			'options_callback'        => array('\Servitus\Helper', 'getTables'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'childTblFld' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['childTblFld'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_fldmap', 'getChildTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'foreignTbl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['foreignTbl'],
			'inputType'               => 'select',
			'options_callback'        => array('\Servitus\Helper', 'getTables'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true, 'submitOnChange'=>true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'foreignField' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['foreignField'],
			'search'				  => 'true',
			'inputType'               => 'select',
			'options_callback'        => array('tl_servitus_fldmap', 'getForeignTblFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'hashAlgo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['hashAlgo'],
			'inputType'               => 'select',
			'options'        		  => array('md5', 'sha1','contao-password'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'splitValues' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValues'],
			'inputType'               => 'select',
			'options'        		  => array('deserialize', 'comma','semikolon','space'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['splitValuesRef'],
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'position' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['position'],
			'inputType'               => 'select',
			'options'        		  => array('prefix', 'suffix'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['positionRef'],
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'decodeEntities'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'onlyIfNotExists' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['onlyIfNotExists'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_servitus_fldmap']['published'],
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
class tl_servitus_fldmap extends System
{

	/**
	 * @var \Contao\Database
	 */
	protected $Database;

	protected static $arrStep;


	/**
	 * Construct the class
	 * and fill arrStep with steps data
	 */
	public function __construct()
	{
		parent::__construct();
		$this->Database = \Database::getInstance();

		if(empty(self::$arrStep))
		{
			if(in_array(\Input::get('act'),array('edit','cut','paste','show','create')))
			{
				self::$arrStep = $this->Database->prepare('
							SELECT s.* FROM tl_servitus_fldmap AS m
							LEFT JOIN tl_servitus_step AS s ON (m.pid=s.id)
							WHERE m.id=?')->execute(\Input::get('id'))->row();
			}
			else
			{
				self::$arrStep = $this->Database->prepare('
							SELECT * FROM tl_servitus_step
							WHERE id=?')->execute(\Input::get('id'))->row();
			}
		}

	}


	/**
	 * construct palettes from the configuration
	 */
	public function constructPalettes()
	{
		// foreach fldmap-type having alterData
		foreach($GLOBALS['TL_DCA']['tl_servitus_fldmap']['palettes'] as $type => $data)
		{
			if(!is_array($GLOBALS['Servitus_FldSrc'][$type]['alterDataTypes'])) continue;

			// generate a palette foreach alterDataType
			foreach($GLOBALS['Servitus_FldSrc'][$type]['alterDataTypes'] as $alterDataType)
			{
				$GLOBALS['TL_DCA']['tl_servitus_fldmap']['palettes'][$type.$alterDataType] = str_replace
				(
					'alterData',
					'alterData,'.$GLOBALS['TL_DCA']['tl_servitus_fldmap']['alterDataPalettes'][$alterDataType],
					$data
				);
			}
		}
	}


	public function getForeignTblFields($dc)
	{
		if(!$dc->activeRecord->foreignTbl) return array();
		$arrFlds = $this->Database->listFields($dc->activeRecord->foreignTbl);
		$erg = array();
		foreach($arrFlds as $fld)
		{
			if($fld['type'] == 'index') continue;
			$erg[] = $fld['name'];
		}
		return $erg;
	}
	public function getChildTblFields($dc)
	{
		if(!$dc->activeRecord->childTbl) return array();
		$arrFlds = $this->Database->listFields($dc->activeRecord->childTbl);
		$erg = array();
		foreach($arrFlds as $fld)
		{
			if($fld['type'] == 'index') continue;
			$erg[] = $fld['name'];
		}
		return $erg;
	}
	public function getTargetTblFields($dc)
	{
		$arrFlds = $this->Database->listFields(self::$arrStep['targetTbl']);
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
		$arrFlds = $this->Database->listFields(self::$arrStep['sourceTbl']);
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
	public function getFldSrcTypes()
	{
		return array_keys($GLOBALS['Servitus_FldSrc']);
	}


	/**
	 * Return all alterData-types
	 *
	 * @param $dc DataContainer
	 * @return array
	 */
	public function getAlterDataTypes($dc)
	{
		return $GLOBALS['Servitus_FldSrc'][$dc->activeRecord->type]['alterDataTypes'];
	}


	/**
	 * Generate a row
	 *
	 * @param $arrRow
	 * @return string
	 */
	public function generateRow($arrRow)
	{
		$stepClass = '\Servitus\Fldsrc\\'.$GLOBALS['Servitus_FldSrc'][$arrRow['type']]['class'];
		if(!class_exists($stepClass))
		{
			return '<p class="tl_error">Class '.$stepClass.' does not exist!</p>';
		}

		$objStep = new $stepClass($arrRow);
		$ret = '<p><span style="font-weight:bold">'.$GLOBALS['TL_LANG']['Servitus_FldSrc'][$arrRow['type']].'</span><br>'.$arrRow['name'].'</p>'.$objStep->generate();
		return $ret;
	}

}