<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use Drama_Lvl1\EssentialsPM\EssentialsPM;

class TellCommand extends Command{

    private $plugin;
  
    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.command.tell");
        parent::__construct("tell", "Write a message to a player | /tell <player> <message>", "/tell <player> <message>", ["msg"]);
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

        if(!isset($args[0])){
            $sender->sendMessage($prefix . " §cError: No player specified");
            return true;
        }

        $name = strtolower($args[0]);
        if($this->plugin->getServer()->getPlayerByPrefix($name) == null){
            $sender->sendMessage($prefix ." ". $settings->get("no_player"));
            return true;

        } else if(empty($args[1])){
            $sender->sendMessage($prefix . " §cError: No message specified");
            return true;
        }
      

        $player = $this->plugin->getServer()->getPlayerByPrefix($name);
        $sName = $sender->getName();

        if(@$this->plugin->msgtoggle[$player->getName()] === true){
            $sender->sendMessage($prefix ." ". $settings->get("message_TurnOFFError"));
            return true;
        } else {
            unset($args[0]);
            $msg = implode(" ", $args);
            $sender->sendMessage($this->convert($settings->get("message_you"), $player, $sName, $msg));
            $player->sendMessage($this->convert($settings->get("message_other"), $player, $sName, $msg));
            $this->plugin->msglast[$sender->getName()] = $player->getName();
        }
        return true;
    }

    /**
     * @param string $string
     * @param Player $player
     * @param CommandSender $sName
     * @param string $msg
     * @return string
     */
  
    public function convert(string $string, $player, $sName, $msg): string
    {
        $string = str_replace("{sender}", $sName, $string);
        $string = str_replace("{player}", $player->getName(), $string);
        $string = str_replace("{message}", $msg, $string);
        return $string;
    }
}
