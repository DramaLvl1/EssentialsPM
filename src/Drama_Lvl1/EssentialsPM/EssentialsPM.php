<?php

namespace Drama_Lvl1\EssentialsPM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\Config;
use Drama_Lvl1\EssentialsPM\commands\TellCommand;
use Drama_Lvl1\EssentialsPM\commands\ReplyCommand;

class EssentialsPM extends PluginBase implements Listener{
    
    public $msgtoggle;
    public $msglast;
    
    public $prefix = [];
    
    private static $instance = null;
    
    const cfg_version = 1;
    
    public function onEnable() : void 
    {
        $this->updateConfig();
        
        $cmd = $this->getServer()->getCommandMap();
        
        $cmd->unregister($this->getServer()->getCommandMap()->getCommand("tell"));
        $cmd->register("tell", new TellCommand($this));
        $cmd->register("reply", new ReplyCommand($this));
        
       
        # $cmd->register("msgtoggle", new MsgToggleCommand($this));
        # $cmd->register("feed", new FeedCommand($this));
        # $cmd->register("heal", new HealCommand($this));
        # $cmd->register("tpo", new TpoCommand($this));
        # $cmd->register("tpohere", new TpohereCommand($this));
        # $cmd->register("tpall", new TpallCommand($this));
        # $cmd->register("sudo", new SudoCommand($this));
        # $cmd->register("nick", new NickCommand($this));
        # $cmd->register("realname", new RealNameCommand($this));
        # $cmd->register("resetnick", new ResetNickCommand($this));
        # $cmd->register("day", new DayCommand($this));
        # $cmd->register("night", new NightCommand($this));
        # $cmd->register("item", new ItemCommand($this));
        
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
