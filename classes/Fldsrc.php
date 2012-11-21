<?php
namespace Servitus;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
abstract class Fldsrc extends \Controller
{
	/**
	 * Current record
	 * @var array
	 */
	protected $arrData = array();

	/**
	 * Current step record
	 * @var array
	 */
	protected $arrStepData = array();

	/**
	 * Source table row data
	 * @var array
	 */
	protected $arrSourceData = array();

	/**
	 * @var \Contao\Database
	 */
	protected $Database = null;


	/**
	 * Initialize the object
	 * @param array
	 * @param array
	 */
	public function __construct($arrFldsrcData, $arrStepData=null)
	{
		$this->arrData = $arrFldsrcData;

		$this->Database = \Database::getInstance();

		// load step data if necessary
		if(!$arrStepData)
		{
			$arrStepData = $this->Database->prepare('SELECT * FROM tl_servitus_step WHERE id=?')->execute($arrFldsrcData['id'])->row();
		}
		$this->arrSetpData = $arrStepData;

		parent::__construct();
	}


	/**
	 * Set an object property
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		$this->arrData[$strKey] = $varValue;
	}


	/**
	 * Return an object property
	 * @param string
	 * @return mixed
	 */
	public function __get($strKey)
	{
		if (isset($this->arrData[$strKey]))
		{
			return $this->arrData[$strKey];
		}

		return parent::__get($strKey);
	}


	/**
	 * Check whether a property is set
	 * @param string
	 * @return boolean
	 */
	public function __isset($strKey)
	{
		return isset($this->arrData[$strKey]);
	}


	/**
	 * Return an step attribute
	 *
	 * @param $key
	 * @return mixed
	 */
	public function getStepValue($key)
	{
		return $this->arrSetpData[$key];
	}


	/**
	 * Return an source table attribute
	 *
	 * @param $key
	 * @return mixed
	 */
	public function getSourceValue($key)
	{
		return $this->arrSourceData[$key];
	}


	/**
	 * Set the source table attributes
	 *
	 * @param $arrData array
	 */
	public function setSourceData($arrData)
	{
		$this->arrSourceData = $arrData;
	}


	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	abstract public function generate();


	/**
	 * Return the field of the target-table
	 * return value of NULL means theres no target field
	 *
	 * @return string
	 */
	abstract public function getField();


	/**
	 * Return the field of the target-table
	 *
	 * @param array|null $arrTarget The data of the inserted row, only available if the Fldsrc is not related to a targetTbl.field (self::getField() == null)
	 * @param bool $isUpdated true if ithe target-record and not a new one
	 * @return string
	 */
	abstract public function getValue($arrTarget = null, $isUpdated = false);

}
