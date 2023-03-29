<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use Drama_Lvl1\EssentialsPM\EssentialsPM;

class TellCommand extends Command{
  
    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.tell.command");
        parent::__construct("tell", "Write a message to a player", "/tell <player> <message>", ["msg"]);
        $this->plugin = $plugin;
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        if(!$sender instanceof Player){
            $sender->sendMessage("Please use this command ingame");
            return true;
        }
      
        if(empty($args[0])){
            $sender->sendMessage("§cError: No player specified. Usage: /tell <player> <message>");
            return true;
          
        } else if(empty($args[1])){
            $sender->sendMessage("§cError: No message specified. Usage: /tell <player> <message>");
            return true;
        }
      
        $name = strtolower($args[0]);
        
        if($this->plugin->getServer()->getPlayer($name) == null){
            $sender->sendMessage("§cError: Player not found");
            return true;
        }
    }
}
