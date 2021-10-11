<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Drama_Lvl1\EssentialsPM\EssentialsPM;

class TellCommand extends Command{
  
    public function __construct(EssentialsPM $plugin)
    {
        parent::__construct("tell", "Reply the last Private Message", "/tell <message>", ["msg"]);
        $this->plugin = $plugin;
    }
}
