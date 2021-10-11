<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Drama_Lvl1\EssentialsPM\EssentialsPM;

class ReplyCommand extends Command{
    
    public function __construct(EssentialsPM $plugin)
    {
        parent::__construct("reply", "Reply the last Private Message", "/reply <message>", ["r"]);
        $this->plugin = $plugin;
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
      
    }
}
