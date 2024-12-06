<?php

namespace Icinga\Module\Managementcli\Clicommands;

use Icinga\Cli\Command;
use Icinga\Exception\NotFoundError;
use Icinga\Authentication\User\UserBackend;
use Icinga\Controllers\UserController;
use Icinga\Application\Config;
use Icinga\Util\ConfigAwareFactory;

class UserCommand extends Command
{

	/**
         * Print current configured backends as json
         *
         * Usage: icingacli managementcli user getBackend
         */
	public function getBackendsAction()
	{
		$backends = new UserBackend;
		$index=0;
		foreach ( $backends->getBackendConfigs() as $key => $value )
		{
			if ( $value->backend == "db")
			{
				$data[$index] = array(
					"name"=>$key,
					"resource"=>$value->resource,
					"backend"=> $value->backend,
				);
			} elseif ( $value->backend == "external")
				$data[$index] = array(
                                        "name"=>$key,
                                        "backend"=> $value->backend,
					"strip_username_regexp"=> $value->strip_username_regexp,
                                );
			$index++;
		}
		$bj = json_encode($data);
		print($bj . "\n");

	}

}
