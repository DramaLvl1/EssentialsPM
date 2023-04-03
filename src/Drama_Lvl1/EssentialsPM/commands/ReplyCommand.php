<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Drama_Lvl1\EssentialsPM\EssentialsPM;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class ReplyCommand extends Command{

    private $plugin;
    
    public function __construct(EssentialsPM $plugin)
   {
        $this->setPermission("essentialspm.command.reply");
        parent::__construct("reply", "Reply the last Private Message | /reply <message>", "/reply <message>", ["r"]);
        $this->plugin = $plugin;
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");
        if (!$sender instanceof Player) {
            $sender->sendMessage($prefix . " Please use this command ingame");
            return true;
        }
        $sName = $sender->getName();
        if (!isset($this->plugin->msglast[$sender->getName()])) {
            $sender->sendMessage($prefix . " " . $settings->get("no_player_messaged_yet"));
            return true;
        }
        if (empty($args[0])) {
            $sender->sendMessage($prefix . " §cError: No message specified");
            return true;
        }
        $player = $this->plugin->getServer()->getPlayerByPrefix($this->plugin->msglast[$sender->getName()]);
        if(@$this->plugin->msgtoggle[$player->getName()] === true){
            $sender->sendMessage($prefix ." ". $settings->get("message_TurnOFFError"));
            return true;
        }
        $msg = implode(" ", $args);
        $sender->sendMessage($this->convert($settings->get("message_you"), $player, $sName, $msg));
        $player->sendMessage($this->convert($settings->get("message_other"), $player, $sName, $msg));
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
