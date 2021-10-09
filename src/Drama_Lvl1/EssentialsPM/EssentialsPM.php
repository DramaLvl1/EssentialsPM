<?php

namespace Drama_Lvl1\EssentialsPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;

class Main extends PluginBase implements Listener{
    
    public function onEnable() : void {
        $this->saveResource("config.yml");
        Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
}
