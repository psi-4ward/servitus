<?php

namespace Servitus\Step;

class DeleteTable extends \Servitus\Step
{

	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	public function generate()
	{
		return $GLOBALS['TL_LANG']['tl_servitus_step']['tbl'][0].": ".$this->tbl;
	}


	/**
	 * execute the deletion
	 */
	public function run()
	{
		if(!$this->Database->tableExists($this->tbl))
		{
			$this->msg('Table '.$this->tbl.' does not exist!','error');
			return false;
		}

		$this->Database->executeUncached('DROP TABLE '.$this->tbl);

		$this->msg("Table {$this->tbl} gelöscht!");
		return true;
	}
}
