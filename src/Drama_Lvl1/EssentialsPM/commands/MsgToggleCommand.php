<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use Drama_Lvl1\EssentialsPM\EssentialsPM;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\utils\Config;


class MsgToggleCommand extends Command{

    private $plugin;

    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.command.msgtoggle");
        parent::__construct("msgtoggle", "enable/disable private messages | /msgtoggle", "/msgtoggle");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");

        if(!$sender instanceof Player){
            $sender->sendMessage($prefix . " Please use this command ingame");
            return true;
        }

        if(@$this->plugin->msgtoggle[$sender->getName()] === false){
            $this->plugin->msgtoggle[$sender->getName()] = true;
            $sender->sendMessage($prefix." ". $settings->get("msgtoggle_turn_off"));
        } else {
            $this->plugin->msgtoggle[$sender->getName()] = false;
            $sender->sendMessage($prefix ." ". $settings->get("msgtoggle_turn_on"));
        }
        return true;
    }
}