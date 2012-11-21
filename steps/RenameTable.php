<?php

namespace Servitus\Step;

class RenameTable extends \Servitus\Step
{

	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	public function generate()
	{
		return $GLOBALS['TL_LANG']['tl_servitus_step']['tbl'][0].": ".$this->tbl.' → '.$this->renameTo;
	}


	/**
	 * execute the renaming
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

		$this->Database->executeUncached('RENAME TABLE '.$this->tbl.' TO '.$this->renameTo);

		$this->msg("Table {$this->tbl} in {$this->renameTo} umbenannt.");
		return true;
	}
}
