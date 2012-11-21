<?php

namespace Servitus\Step;

class CopyTable extends \Servitus\Step
{

	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	public function generate()
	{
		return $GLOBALS['TL_LANG']['tl_servitus_step']['tbl'][0].": ".$this->tbl.' → '.$this->copyTo;
	}

	/**
	 * execute the table copy
	 */
	public function run()
	{
		if(!$this->Database->tableExists($this->tbl))
		{
			$this->msg('Table '.$this->tbl.' does not exist!','error');
			return false;
		}

		if($this->Database->tableExists($this->copyTo))
		{
			$this->msg('Table '.$this->tbl.' already exists!','error');
			return false;
		}

		$this->Database->executeUncached('CREATE TABLE '.$this->copyTo.' LIKE '.$this->tbl);
		$this->Database->executeUncached('INSERT INTO '.$this->copyTo.' SELECT * FROM '.$this->tbl);

		$this->msg("Table {$this->tbl} nach {$this->copyTo} kopiert.");
		return true;
	}
}
