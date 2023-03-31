<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use pocketmine\Server;

use Drama_Lvl1\EssentialsPM\EssentialsPM;

class TellCommand extends Command{
  
    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.command.tell");
        parent::__construct("tell", "Write a message to a player", "/tell <player> <message>", ["msg"]);
        $this->plugin = $plugin;
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");
        if(!$sender instanceof Player){
            $sender->sendMessage($prefix . " Please use this command ingame");
            return true;
        }
      
        if(empty($args[0])){
            $sender->sendMessage($prefix . " §cError: No player specified. Usage: /tell <player> <message>");
            return true;
          
        } else if(empty($args[1])){
            $sender->sendMessage($prefix . "§cError: No message specified. Usage: /tell <player> <message>");
            return true;
        }
      
        $name = strtolower($args[0]);
        $player = Server::getInstance()->getPlayerByPrefix($name);
        
        if($this->plugin->getServer()->getPlayerByPrefix($name) == null){
            $sender->sendMessage($settings->get("no_player"));
            return true;
        } else {
            if(@$this->plugin->msgtoggle[$player] === true){
                $sender->sendMessage($settings->get("message_TurnOFFError"));
                return true;
            } else {
                unset($args[0]);
                $msg = implode(" ", $args);
                $sender->sendMessage($this->convert($settings->get("message_you"), $player, $sName, $msg));
                Server::getInstance()->getPlayerByPrefix($name)->sendMessage($this->convert($settings->get("message_other"), $player, $sName, $msg));
                $this->plugin->msglast[$sender->getName()] = Server::getInstance()->getPlayerByPrefix($name);
                $this->plugin->msglast[Server::getInstance()->getPlayerByPrefix($name)] = $sender->getName();
            }
        }
    }
  
     /**
     * @param string $string
     * @param $player Player
     * @param $sName CommandSender
     * @param $msg String
     */
  
    public function convert(string $string, $player, $sName, $msg): string
    {
        $string = str_replace("{sender}", $sName, $string);
        $string = str_replace("{player}", $player, $string);
        $string = str_replace("{message}", $msg, $string);
        return $string;
    }
}
