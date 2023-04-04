<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use Drama_Lvl1\EssentialsPM\EssentialsPM;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class HealCommand extends Command {

    private $plugin;

    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.command.heal");
        parent::__construct("heal", "heal yourself | /heal", "/heal");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");
        if (!$sender instanceof Player) {
            $sender->sendMessage($prefix . " Please use this command ingame");
            return true;
        }
        if(isset($args[0])){
            if($sender->hasPermission("essentialspm.command.heal.other")){
                $name = strtolower($args[0]);
                $player = $this->plugin->getServer()->getPlayerByPrefix($name);
                $this->healPlayer($player);
                $sender->sendMessage($prefix . " " . str_replace("{player}", $player->getName(), $settings->get("heal_other")));
            } else {
                $this->healPlayer($sender);
            }
        } else {
            $this->healPlayer($sender);
        }
        return true;
    }

    private function healPlayer(Player $player){
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");

        $player->setHealth($player->getMaxHealth());
        $player->sendMessage($prefix . " " . $settings->get("heal_message"));
    }
}