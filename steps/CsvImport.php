<?php
namespace Servitus\Step;

class CsvImport extends \Servitus\Step
{

	protected $handle = null;


	public function __construct($arrStepData)
	{
		parent::__construct($arrStepData);

		$this->constraints = deserialize($this->constraints, true);

		// open CSV-File
		$objFile = $this->Database->prepare('SELECT * FROM tl_files WHERE id=?')->execute($this->csvFile);

		if(!$objFile || !is_file(TL_ROOT.'/'.$objFile->path))
		{
			$this->msg('CSV-File not found','error');
			return false;
		}
		$this->handle = @fopen(TL_ROOT.'/'.$objFile->path, "r");
		if(!$this->handle)
		{
			$this->msg('Could not open CSV-File for reading','error');
			return false;
		}
	}


	public function __destruct()
	{
		if($this->handle) fclose($this->handle);
		parent::__destruct();
	}


	/**
	 * Generate the html for the step-listing
	 *
	 * @return string
	 */
	public function generate()
	{
		$ret = $GLOBALS['TL_LANG']['tl_servitus_step']['tmpTbl'][0].": ".$this->tmpTbl.'<br>';
		$objFile = \FilesModel::findByPk($this->csvFile);
		if(!$objFile || !is_file(TL_ROOT.'/'.$objFile->path))
		{
			$ret = '<p class="tl_error">CSV-File not found!</p>';
		}
		else
		{
			$ret .= $GLOBALS['TL_LANG']['tl_servitus_step']['csvFile'][0].": ".$objFile->path;
		}

		return $ret;
	}


	/**
	 * execute the CSV-Import
	 */
	public function run()
	{
		if(!$this->handle) return false;

		if($this->isFirstRound())
		{
			$this->setRoundData('csvLine',0);

			// read first line and generate temp table
			$arrFirstline = $this->readLine();
			if(!is_array($arrFirstline) || empty($arrFirstline[0]))
			{
				$this->msg('No rows in CSV found! Wrong delimiter?','error');
				return false;
			}
			$this->generateTmpTable($arrFirstline);

			// import the first line if its a headline
			if(!$this->csvHeadlines)
			{
				$this->importRow($arrFirstline);
			}
		}

		if(!$this->useRounds)
		{
			// import the whole csv
			while($data = $this->readLine()) $this->importRow($data);
			$this->msg((int)$this->getRoundData('counter').' rows imported.','confirm');
			return true;
		}
		else
		{
			if(!$this->isFirstRound())
			{
				// set the values from the last round
				fseek($this->handle, $this->getRoundData('filepointerOffset'));
				$this->msg('Continue import at '.$this->getRoundData('counter'));
			}

			// continue importing the csv
			$i = 0;
			while(($data = $this->readLine()))
			{
				$this->importRow($data);

				if($i >= $this->perRound) break;
				$i++;
			}

			if(feof($this->handle))
			{
				// end of file, import is done
				$this->msg((int)$this->getRoundData('counter').' rows imported.','confirm');
				$this->setRoundsDone();
				return true;
			}
			else
			{
				// save round data
				$this->setRoundData('filepointerOffset',ftell($this->handle));
				return true;
			}
		}


	}


	/**
	 * Generate the headline-names
	 *
	 * @param array|null $arrHeadline
	 * @return array|bool|null
	 */
	public function getHeadlines($arrHeadline = null)
	{
		if(!$arrHeadline) $arrHeadline = $this->readLine();

		// generate row-names
		if($this->csvHeadlines)
		{
			// standardize row-names
			foreach($arrHeadline as $k=>$v)
			{
				$arrHeadline[$k] = standardize($v,true);
			}
		}
		else
		{
			// generate row[0..n] names
			$cnt = count($arrHeadline);
			$arrHeadline = array();
			for($i=0;$i<$cnt;$i++)
			{
				$arrHeadline[$i] = 'row'.$i;
			}
		}

		return $arrHeadline;
	}
	

	/**
	 * Write a row into the temp table
	 *
	 * @param $arrData
	 * @return bool
	 */
	protected function importRow($arrData)
	{
		$this->setRoundData('csvLine', $this->getRoundData('csvLine')+1);

		// validation
		if($this->useValidation)
		{
			foreach($this->constraints as $constraint)
			{
				$fld = $constraint['fld'];
				$constraint = $constraint['constraint'];
				if($constraint == 'notEmpty' && !strlen($arrData[$fld]))
				{
					$this->msg("Line:".($this->getRoundData('csvLine')+1)." Col:".$fld.' does not match constraint '.$constraint, 'warning');
					return false;
				}
				else
				{
					if(!$this->valditaor($constraint,$arrData[$fld]))
					{
						$this->msg("Line:".($this->getRoundData('csvLine')+1)." Col:".$fld.' does not match constraint '.$constraint, 'warning');
						return false;
					}
				}
			}
		}

		$str = substr(str_repeat('?,',count($arrData)),0,-1);
		$this->Database->prepare('INSERT INTO '.$this->tmpTbl.' VALUES (NULL,'.$str.')')->executeUncached($arrData);
		$this->setRoundData('counter', $this->getRoundData('counter')+1);

		return true;
	}


	/**
	 * Create a temporary table and try to use the headlines for row-names
	 *
	 * @param array $firstLine
	 */
	protected function generateTmpTable($firstLine)
	{
		$arrHeadline = $this->getHeadlines($firstLine);

		// Drop existing temp table
		if($this->Database->tableExists($this->tmpTbl))
		{
			$this->Database->executeUncached('DROP TABLE '.$this->tmpTbl);
			$this->msg('Table '.$this->tmpTbl.' dropped.','info');
		}

		// generate temp table
		$strQry = 'CREATE TABLE `'.$this->tmpTbl.'` (';
  		$strQry .= '`id` int(10) unsigned NOT NULL auto_increment,';
		foreach($arrHeadline as $row)
		{
			$strQry .= '`'.$row.'` text NULL,';
		}

		$strQry .= 'PRIMARY KEY (`id`)';
		$strQry .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8;';

		$this->Database->executeUncached($strQry);
		$this->msg('Table '.$this->tmpTbl.' created.','info');
	}


	/**
	 * Read a line from the CSV-file
	 *
	 * @return array|bool
	 */
	protected function readLine()
	{
		if(!$this->handle) return false;
		$strLine = fgets($this->handle);
		if($strLine === false) return false;

		// reencode characters
		if($this->csvEncoding != 'UTF-8')
		{
			$strLine = iconv($this->csvEncoding, 'UTF-8', $strLine);
		}

		return str_getcsv($strLine,$this->csvDelimiter,$this->csvEnclosure,$this->csvEscape);
	}


	/**
	 * Call contaos Validator
	 *
	 * @param $rgxp
	 * @param $varInput
	 * @param $row
	 * @return bool
	 */
	protected function valditaor($rgxp, $varInput)
	{
	switch ($rgxp)
	{
		// Special validation rule for style sheets
		case (strncmp($rgxp, 'digit_', 6) === 0):
			$textual = explode('_', $rgxp);
			array_shift($textual);

			if (in_array($varInput, $textual) || strncmp($varInput, '$', 1) === 0)
			{
				break;
			}
			// DO NOT ADD A break; STATEMENT HERE

		// Numeric characters (including full stop [.] minus [-] and space [ ])
		case 'digit':
			if (!\Validator::isNumeric($varInput))
			{
				return false;
			}
			break;

		// Alphabetic characters (including full stop [.] minus [-] and space [ ])
		case 'alpha':
			if (!\Validator::isAlphabetic($varInput))
			{
				return false;
			}
			break;

		// Alphanumeric characters (including full stop [.] minus [-], underscore [_] and space [ ])
		case 'alnum':
			if (!\Validator::isAlphanumeric($varInput))
			{
				return false;
			}
			break;

		// Do not allow any characters that are usually encoded by class Input [=<>()#/])
		case 'extnd':
			if (!\Validator::isExtendedAlphanumeric(html_entity_decode($varInput)))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid date format
		case 'date':
			if (!\Validator::isDate($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid time format
		case 'time':
			if (!\Validator::isTime($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid date and time format
		case 'datim':
			if (!\Validator::isDatim($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid friendly name e-mail address
		case 'friendly':
			list ($strName, $varInput) = \String::splitFriendlyEmail($varInput);
			// no break;

		// Check whether the current value is a valid e-mail address
		case 'email':
			if (!\Validator::isEmail($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is list of valid e-mail addresses
		case 'emails':
			$arrEmails = trimsplit(',', $varInput);

			foreach ($arrEmails as $strEmail)
			{
				$strEmail = \Idna::encodeEmail($strEmail);

				if (!\Validator::isEmail($strEmail))
				{
					return false;
					break;
				}
			}
			break;

		// Check whether the current value is a valid URL
		case 'url':
			if (!\Validator::isUrl($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid alias
		case 'alias':
			if (!\Validator::isAlias($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a valid folder URL alias
		case 'folderalias':
			if (!\Validator::isFolderAlias($varInput))
			{
				return false;
			}
			break;

		// Phone numbers (numeric characters, space [ ], plus [+], minus [-], parentheses [()] and slash [/])
		case 'phone':
			if (!\Validator::isPhone(html_entity_decode($varInput)))
			{
				return false;
			}
			break;

		// Check whether the current value is a percent value
		case 'prcnt':
			if (!\Validator::isPercent($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a locale
		case 'locale':
			if (!\Validator::isLocale($varInput))
			{
				return false;
			}
			break;

		// Check whether the current value is a language code
		case 'language':
			if (!\Validator::isLanguage($varInput))
			{
				return false;
			}
			break;
		}

		return true;

	}
}
