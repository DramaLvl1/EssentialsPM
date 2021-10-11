<?php

namespace Drama_Lvl1\EssentialsPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;

class Main extends PluginBase implements Listener{
    
    public function onEnable() : void {
        $this->saveResource("config.yml");
        
        $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getCommandMap()->register("tell", new TellCommand($this));
        $this->getServer()->getCommandMap()->register("reply", new ReplyCommand($this));
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("Prefix");
        if($cfg->get("version") === 1){
            $this->getServer()->getLogger()->info($p . " §aThis config is up to date");
        } else {
            $this->getServer()->getLogger()->alert($p . " This config is outdated.");
            $this->getServer()->getLogger()->alert($p . " Please delete this config to recive the new config version");
            $this->getServer()->getLogger()->alert($p . " And dont forget to copy your messages");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
        $this->getServer()->getLogger()->info($p . " §aEssentialsPM Plugin got enabled successfully");
    }
    
    public function onDisable() : void {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("Prefix");
        $this->getServer()->getLogger()->alert($p . " §cEssentialsPM Plugin got disabled successfully");
    }
}
