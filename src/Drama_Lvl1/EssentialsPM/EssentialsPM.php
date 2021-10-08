<?php

namespace Drama_Lvl1\EssentialsPM;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{
    
    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
}
