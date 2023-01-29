<?php

namespace Drama_Lvl1\EssentialsPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\Config;
use Drama_Lvl1\EssentialsPM\commands\TellCommand;
use Drama_Lvl1\EssentialsPM\commands\ReplyCommand;

class EssentialsPM extends PluginBase implements Listener{
    
    public $last;
    public $prefix = [];
    
    const cfg_version = 1;
    
    public function onEnable() : void 
    {
        $this->saveResource("config.yml");
        
        $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getCommandMap()->register("tell", new TellCommand($this));
        $this->getServer()->getCommandMap()->register("reply", new ReplyCommand($this));
        
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->prefix = $cfg->get("Prefix");
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info($this->prefix . " §aEssentialsPM Plugin got enabled successfully");
    }
    
    private function updateConfig() : void
    {
        $this->saveResource("config.yml");
        
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("Prefix");
        if($cfg->get("version") === self::cfg_version){
            $this->getServer()->getLogger()->info($p . " §aThis config is up to date");
        } else {
            $this->getServer()->getLogger()->alert($p . " This config is outdated.");
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "old_config_" . $cfg->get("version") . ".yml");
            $this->saveResource("config.yml");
            $this->reloadConfig();
            # $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }
    
    public function reloadConfig() : void
    {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $cfg->save();
        $cfg->reload();
    }
    
    public function onDisable() : void 
    {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("Prefix");
        $this->getServer()->getLogger()->alert($p . " §cEssentialsPM Plugin got disabled successfully");
    }
}
