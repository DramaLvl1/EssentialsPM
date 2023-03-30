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
    
    private static $instance = null;
    
    const cfg_version = 1;
    
    public function onEnable() : void 
    {
        $this->updateConfig();
        
        $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getCommandMap()->register("tell", new TellCommand($this));
        $this->getServer()->getCommandMap()->register("reply", new ReplyCommand($this));
        
       
        # $this->getServer()->getCommandMap()->register("msgtoggle", new MsgToggleCommand($this));
        # $this->getServer()->getCommandMap()->register("feed", new FeedCommand($this));
        # $this->getServer()->getCommandMap()->register("heal", new HealCommand($this));
        # $this->getServer()->getCommandMap()->register("tpo", new TpoCommand($this));
        # $this->getServer()->getCommandMap()->register("tpohere", new TpohereCommand($this));
        # $this->getServer()->getCommandMap()->register("tpall", new TpallCommand($this));
        # $this->getServer()->getCommandMap()->register("sudo", new SudoCommand($this));
        # $this->getServer()->getCommandMap()->register("nick", new NickCommand($this));
        # $this->getServer()->getCommandMap()->register("realname", new RealNameCommand($this));
        # $this->getServer()->getCommandMap()->register("resetnick", new ResetNickCommand($this));
        # $this->getServer()->getCommandMap()->register("day", new DayCommand($this));
        # $this->getServer()->getCommandMap()->register("night", new NightCommand($this));
        # $this->getServer()->getCommandMap()->register("item", new ItemCommand($this));
        
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
    
     /**
     * @return EssentialsPM
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }
}
