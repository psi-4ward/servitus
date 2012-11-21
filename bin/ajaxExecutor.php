<?php
/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

namespace Servitus;

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once '../../../initialize.php';


class AjaxRunner
{

	public function __construct()
	{

		if(!\Environment::get('isAjaxRequest'))
		{
			header('HTTP/1.0 400 Bad Request');
			die('Run this script through Servitus AJAX Executor');
		}

		$token = \Input::get('token');
		if(!$token)
		{
			header('HTTP/1.0 400 Bad Request');
			die('Missing job-token');
		}
		try
		{
			$objJob = Job::findByToken($token);
		}
		catch(\Exception $e)
		{
			header('HTTP/1.0 400 Bad Request');
			die($e->getMessage());
		}

		// run a specific job
		if(\Input::get('sid'))
		{
			try
			{
				$objStep = Step::findById(\Input::get('sid'));
			}
			catch(\Exception $e)
			{
				header('HTTP/1.0 400 Bad Request');
				die($e->getMessage());
			}
			if($objStep->pid != $objJob->id)
			{
				header('HTTP/1.0 400 Bad Request');
				die('Wrong token');
			}

			$objStep->logger = 'echo';
			ob_start();
			$objStep->run();
			$content = ob_get_clean();

			echo json_encode(array
			(
				'content' => $content,
				'runAgain' => $objStep->hasMoreRounds()
			));


		}
	}
}
$x = new AjaxRunner();

