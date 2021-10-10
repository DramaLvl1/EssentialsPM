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
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("Prefix");
        if($cfg->get("version") === 1){
            $this->getServer()->getLogger()->notice($p . " §aThis config is up to date");
        } else {
            $this->getServer()->getLogger()->alert($p . " This config is outdated.");
            $this->getServer()->getLogger()->alert($p . " Please delete this config to recive the new config version");
            $this->getServer()->getLogger()->alert($p . " And dont forget to copy your messages");
        }
    }
}
