<?php
namespace Servitus;

class Job extends \Controller
{
	/**
	 * Current record
	 * @var array
	 */
	protected $arrData = array();


	/**
	 * Initialize the object
	 * @param object
	 */
	public function __construct($arrStepData)
	{
		$this->arrData = $arrStepData;
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
	 * Factory method to instantiiate a job with a given ID
	 *
	 * @param $id int
	 * @throws \Exception
	 * @return Step
	 */
	public static function findById($id)
	{
		$objJob = \Database::getInstance()->prepare('SELECT * FROM tl_servitus_job WHERE id=?')->execute($id);
		if(!$objJob->numRows) throw new \Exception('Job ID: '.$id.' not found!');

		return new Job($objJob->row());
	}


	/**
	 * Factory method to instantiiate a job with a given TOKEN
	 *
	 * @param $token str
	 * @throws \Exception
	 * @return Step
	 */
	public static function findByToken($token)
	{
		$objJob = \Database::getInstance()->prepare('SELECT * FROM tl_servitus_job WHERE token=?')->execute($token);
		if(!$objJob->numRows) throw new \Exception('Job with given token not found!');

		return new Job($objJob->row());
	}


}