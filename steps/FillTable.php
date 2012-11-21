<?php

namespace Servitus\Step;

class FillTable extends \Servitus\Step
{

	/**
	 * Instances of Fldsrc classes
	 * @var array
	 */
	protected $fldsrc = array();

	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	public function generate()
	{
		$ret = '';
		$ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['sourceTbl'][0].': <span style="font-family:monospace;">'.$this->sourceTbl.'</span><br>';
		$ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['targetTbl'][0].': <span style="font-family:monospace;">'.$this->targetTbl.'</span><br>';
		if($this->useKeyfield)
		{
			$ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['useKeyfield'][0].': <span style="font-family:monospace;">'.$this->sourceTbl.'.'.$this->sourceKeyfield.' &#8644; '. $this->targetTbl.'.'.$this->targetKeyfield.'</span><br>';
			if($this->deleteObsolete) $ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['deleteObsolete'][0].'<br>';
			if($this->updateExisting) $ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['updateExisting'][0].'<br>';
		}
		return $ret;
	}


	/**
	 * execute the table filling
	 */
	public function run()
	{
		/* some validation */
		if(!$this->Database->tableExists($this->sourceTbl))
		{
			$this->msg('Source table '.$this->sourceTbl.' does not exist!','error');
			return false;
		}
		if(!$this->Database->tableExists($this->targetTbl))
		{
			$this->msg('Source table '.$this->targetTbl.' does not exist!','error');
			return false;
		}
		if($this->useKeyfield)
		{
			if(!$this->Database->fieldExists($this->sourceKeyfield,$this->sourceTbl))
			{
				$this->msg('Source keyfield '.$this->sourceKeyfield.' does not exist!','error');
				return false;
			}
			if(!$this->Database->fieldExists($this->targetKeyfield,$this->targetTbl))
			{
				$this->msg('Target keyfield '.$this->targetKeyfield.' does not exist!','error');
				return false;
			}
		}


		/* delete obsolete rows */
		if($this->isFirstRound() && $this->useKeyfield && $this->deleteObsolete)
		{
			$objDel = $this->Database->executeUncached("DELETE FROM {$this->targetTbl}
											  WHERE NOT EXISTS (
											  	SELECT * FROM {$this->sourceTbl}
											  	WHERE {$this->sourceTbl}.{$this->sourceKeyfield} = {$this->targetTbl}.{$this->targetKeyfield}
											  )");
			$this->msg('Deleted '.$objDel->affectedRows.' obsolete rows in '.$this->targetTbl);
		}


		/* preload the fieldsources */
		$objFldsrc = $this->Database->prepare('SELECT * FROM tl_servitus_fldmap WHERE pid=? AND published="1"')->execute($this->id);
		while($objFldsrc->next())
		{
			$class = '\Servitus\Fldsrc\\'.$GLOBALS['Servitus_FldSrc'][$objFldsrc->type]['class'];
			$this->fldsrc[] = new $class($objFldsrc->row(),$this->arrData);
		}
		if(empty($this->fldsrc))
		{
			$this->msg('No active fieldmappings found.','error');
			return false;
		}


		/* run the importing foreach row in sourceTable */
		$objSource = $this->Database->prepare('SELECT * FROM '.$this->sourceTbl.' ORDER BY id');
		$overallRowcount = $objSource->execute()->numRows;
		if($this->useRounds)
		{
			$objSource = $objSource->limit($this->perRound,$this->roundData['counter']);
		}
		$objSource = $objSource->execute();

		if(!$this->isFirstRound())
		{
			$this->msg('Continue filltable at '.(int)$this->getRoundData('counter'));
		}


		while($objSource->next())
		{
			$this->importRow($objSource);
			$this->roundData['counter']++;
		}

		/* finish */
		if($this->getRoundData('counter') >= $overallRowcount)
		{
			$this->msg((int)$this->getRoundData('insertCounter').' rows inserted');
			$this->msg((int)$this->getRoundData('updateCounter').' rows updated');
			$this->setRoundsDone();
		}

		return true;
	}


	/**
	 * Import a row into target table
	 *
	 * @param \Database\Result $objSrc
	 */
	protected function importRow(\Database\Result $objSrc)
	{
		/* Search for existing target row if theres a keyfield */
		$arrTarget = null;
		if($this->useKeyfield)
		{
			// search for existing record
			// use executeUncached to hold the memory usage low (is this a good idea?)
			$objTarget = $this->Database->prepare('SELECT * FROM '.$this->targetTbl.' WHERE '.$this->targetKeyfield.'=?')
										->executeUncached($objSrc->{$this->sourceKeyfield});
			if($objTarget->numRows && !$this->updateExisting)
			{
				if($this->showNotImported)
				{
					$this->msg('Omitted existing row with '.$this->sourceKeyfield.'="'.$objSrc->{$this->sourceKeyfield}.'"');
				}

				// nothing to do becaus we dont want to update existing records
				return;
			}

			if($objTarget->numRows)
			{
				$arrTarget = $objTarget->row();
			}
		}


		/* generate all values which are related to a targetTbl.field */
		$arrSet = array();
		/** @var $objFldsrc \Servitus\Fldsrc */
		foreach($this->fldsrc as $objFldsrc)
		{
			$objFldsrc->setSourceData($objSrc->row());
			$targetFld = $objFldsrc->getField();
			if($targetFld != null)
			{
				$arrSet[$targetFld] = $objFldsrc->getValue();
			}
		}


		/* UPDATE or INSERT target row */
		if($this->useKeyfield && $arrTarget && $this->updateExisting)
		{
			// update existing row
			$objUpdate = $this->Database->prepare('UPDATE '.$this->targetTbl.' %s WHERE id=?')
						   ->set($arrSet)
						   ->executeUncached($arrTarget['id']);

			if($objUpdate->affectedRows)
			{
				$this->roundData['updateCounter']++;
			}

			// renew $arrTarget with new values
			$arrTarget = array_merge($arrTarget,$arrSet);
		}
		else
		{
			// insert new row
			$objInsert = $this->Database->prepare('INSERT INTO '.$this->targetTbl.' %s')
						   ->set($arrSet)
						   ->executeUncached();
			$this->roundData['insertCounter']++;
			$arrTarget = $arrSet;
			$arrTarget['id'] = $objInsert->insertId;
		}


		/* generate all values which are NOT related to a targetTbl.field */
		foreach($this->fldsrc as $objFldsrc)
		{
			$objFldsrc->setSourceData($objSrc->row());
			$targetFld = $objFldsrc->getField();
			if($targetFld == null)
			{
				$objFldsrc->getValue($arrTarget);
			}
		}
	}
}
