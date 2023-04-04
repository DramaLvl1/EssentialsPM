<?php

namespace Drama_Lvl1\EssentialsPM;

use Drama_Lvl1\EssentialsPM\event\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use Drama_Lvl1\EssentialsPM\commands\TellCommand;
use Drama_Lvl1\EssentialsPM\commands\ReplyCommand;
use Drama_Lvl1\EssentialsPM\commands\MsgToggleCommand;
use Drama_Lvl1\EssentialsPM\commands\FeedCommand;
use Drama_Lvl1\EssentialsPM\commands\HealCommand;

class EssentialsPM extends PluginBase implements Listener{
    
    public $msgtoggle;
    public $msglast;
    
    public $prefix = [];
    
    private static $instance = null;
    
    const cfg_version = 1;

    public function onLoad(): void
    {
        if ($this->checkConfig() === false){
            $this->getLogger()->info("§cNo config found");
            $this->saveResource("config.yml");
            $this->getLogger()->info("§aA new config has been created");
        } else {
            $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
            $this->prefix = $cfg->get("prefix");
            $this->getServer()->getLogger()->info($this->prefix . " §aEssentialsPM Plugin got enabled successfully");
            $this->updateConfig();
        }
    }

    public function onEnable() : void 
    {
        #$this->updateConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $cmd = $this->getServer()->getCommandMap();
        
        $cmd->unregister($this->getServer()->getCommandMap()->getCommand("tell"));
        $cmd->register("tell", new TellCommand($this));
        $cmd->register("reply", new ReplyCommand($this));
        $cmd->register("msgtoggle", new MsgToggleCommand($this));
        $cmd->register("feed", new FeedCommand($this));
        $cmd->register("heal", new HealCommand($this));

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
    }
    
    private function updateConfig() : void
    {
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $p = $cfg->get("prefix");
        if($cfg->get("version") === self::cfg_version){
            $this->getServer()->getLogger()->info($p . " §aThis config is up to date");
        } else {
            $this->getServer()->getLogger()->alert("§8[§6EssentialsPM§8] §cThis config is outdated.");
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "old_config_" . $cfg->get("version") . ".yml");
            $this->saveResource("config.yml");
        }
    }

    public function checkConfig() : bool {
        if(file_exists($this->getDataFolder() . "config.yml")){
            $this->getLogger()->info("Config exists");
            return true;
        } else {
            $this->getLogger()->info("Config not exists");
            return false;
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
        $p = $cfg->get("prefix");
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
