<?php
namespace Servitus;

abstract class Step extends \Controller
{
	/**
	 * Current record
	 * @var array
	 */
	protected $arrData = array();

	/**
	 * @var \Contao\Database
	 */
	protected $Database = null;

	/**
	 * Wheter the step as more rounds to go
	 * @var bool
	 */
	protected $hasMoreRounds = true;

	/**
	 * Some data to save/restore over the rounds
	 * @var array
	 */
	protected $roundData = array('counter'=>0);

	/**
	 * Initialize the object
	 * restore the roundData from the session
	 *
	 * @param object
	 */
	public function __construct($arrStepData)
	{
		$this->arrData = $arrStepData;
		parent::__construct();
		$this->Database = \Database::getInstance();

		// restore counter
		if($this->useRounds && isset($_SESSION['Servitus']['stepData'.$this->id]))
		{
			$this->roundData = $_SESSION['Servitus']['stepData'.$this->id];
		}
	}


	/**
	 * Destruct the object
	 * save the roundData in the session
	 */
	public function __destruct()
	{
		// save counter
		if($this->useRounds && $this->hasMoreRounds())
		{
			$_SESSION['Servitus']['stepData'.$this->id] = $this->roundData;
		}
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
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	abstract public function generate();


	/**
	 * execute the step
	 */
	abstract public function run();


	/**
	 * Factory method to instantiiate a step with a given ID
	 *
	 * @param $id
	 * @throws \Exception
	 * @return Step
	 */
	public static function findById($id)
	{
		$objStep = \Database::getInstance()->prepare('SELECT * FROM tl_servitus_step WHERE id=?')->execute($id);
		if(!$objStep->numRows) throw new \Exception('Step ID: '.$id.' not found!');

		$stepClass = '\Servitus\Step\\'.$GLOBALS['Servitus_Step'][$objStep->type]['class'];
		return new $stepClass($objStep->row());
	}


	/**
	 * Handle INFO/WARNING/ERROR/DEBUG messages
	 *
	 * @param $text
	 * @param string $severity
	 */
	public function msg($text,$severity='info')
	{
		$severity = strtolower($severity);

		if($this->logger == 'echo')
		{
			if($severity == 'warning') $severity = 'gerror';
			echo '<p class="tl_'.$severity.'">'.$text.'</p>';
		}
	}


	/**
	 * Reset rounds to start from beginning
	 */
	public function roundsReset()
	{
		$this->roundData = array('counter'=>0);
	}


	/**
	 * true if there are more rounds to execute
	 *
	 * @return bool
	 */
	public function hasMoreRounds()
	{
		return ($this->useRounds && $this->hasMoreRounds);
	}


	/**
	 * true if its the first round
	 *
	 * @return bool
	 */
	protected function isFirstRound()
	{
		return (!$this->useRounds || $this->getRoundData('counter')==0);
	}

	/**
	 * Save data to restore on next round
	 *
	 * @param $key
	 * @param $value
	 */
	protected function setRoundData($key,$value)
	{
		$this->roundData[$key] = $value;
	}


	/**
	 * Restore data from last round
	 *
	 * @param $key
	 * @return mixed
	 */
	protected function getRoundData($key)
	{
		return $this->roundData[$key];
	}


	/**
	 * Set to "all done" and reset round-data
	 */
	protected function setRoundsDone()
	{
		$this->hasMoreRounds = false;
		$this->roundsReset();
	}
}

