<?php

namespace Icinga\Module\Managementcli\Clicommands;

use Icinga\Cli\Command;
use Icinga\Application\MigrationManager;
use Icinga\Exception\NotFoundError;
use Icinga\Application\Logger;

class MigrationCommand extends Command
{
    /**
       * 
       * Check if module has currently 
       * pending migrations. 
       * 
       * Returns "exit 0" if pending, else "1"
       *
       * icingacli managementcli migration getpending --name <module>
       *
       * 
       */
    public function getpendingAction()
    {
        $name = $this->params->get('name');
        $mm = MigrationManager::instance();
        try {
            if ($mm->getMigration($name)->count() > 0) {
                exit(0);
            } else {
                exit(1);
            }
        } catch (NotFoundError $e) {
            if ($this->isVerbose) {
              Logger::error("The module wasn't found, check your spelling\n");
              print($e);
            }
            exit(1);
        }
    }
    /**
       * 
       * Run migrations for module <name> 
       * 
       * Returns "exit 0" if runned, else "0"
       *
       * USAGE
       *
       * icingacli managementcli migration applypending --name <module>
       *
       * 
       */
    public function applypendingAction(): void
    {
        $name = $this->params->get('name');
        $mm = MigrationManager::instance();
        try { 
            if($mm->getMigration($name)->run()){
                exit(0);
            } else {
                exit(1);
            }
        } catch (NotFoundError $e) {
            Logger::error("The module wasn't found, check your spelling\n");
            print($e);
            exit(1);
        }
    }
}
