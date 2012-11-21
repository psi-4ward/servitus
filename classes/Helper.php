<?php
namespace Servitus;

class Helper extends \Controller
{

	/**
	 * Construct the class
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Return a array with database tables
	 *
	 * @return array
	 */
	public function getTables()
	{
		return \Database::getInstance()->listTables();
	}


	/**
	 * Execute a job-step
	 * and return its result for displaying in the Contao backend
	 *
	 * @param \Contao\DataContainer $dc
	 * @return string
	 */
	public function runStepFromDCA(\DataContainer $dc)
	{
		$objStep = Step::findById($dc->id);
		$objJob = Job::findById($objStep->pid);

		// be sure to start from scratch
		$objStep->roundsReset();

		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/servitus/assets/Servitus.js';

		$ret = '<div id="tl_buttons"><a href="'.$this->getReferer(true).'" class="header_back" title="" accesskey="b" onclick="Backend.getScrollOffset()">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a></div>';
		$ret .= '<h2 class="sub_headline">Ausführung Schritt ID '.$dc->id.'</h2>';
		$ret .= '<div style="padding:20px;" id="ServitusStatus"></div>';
		$ret .= '<script>window.addEvent("domready",function(){var s = new Servitus(); s.runStep("'.$objJob->token.'","'.$dc->id.'");});</script>';
		$ret .= '<div class="tl_formbody_submit"><div class="tl_submit_container"> <input type="submit" name="" class="tl_submit" value="OK" onclick="document.location.href=\''.$this->getReferer(true).'\';return false;"></div></div>';
		return $ret;
	}
}

