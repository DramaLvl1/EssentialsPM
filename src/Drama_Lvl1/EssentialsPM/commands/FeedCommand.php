<?php

namespace Drama_Lvl1\EssentialsPM\commands;

use Drama_Lvl1\EssentialsPM\EssentialsPM;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class FeedCommand extends Command {

    private $plugin;

    public function __construct(EssentialsPM $plugin)
    {
        $this->setPermission("essentialspm.command.feed");
        parent::__construct("feed", "Fill your hunger bar | /feed", "/feed");
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
            if($sender->hasPermission("essentialspm.command.feed.other")){
                $name = strtolower($args[0]);
                $player = $this->plugin->getServer()->getPlayerByPrefix($name);
                $this->fillHunger($player);
                $sender->sendMessage($prefix . " " . str_replace("{player}", $player->getName(), $settings->get("feed_other")));
            } else {
                $this->fillHunger($sender);
            }
        } else {
            $this->fillHunger($sender);
        }
        return true;
    }

    private function fillHunger(Player $player){
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $prefix = $settings->get("prefix");

        $sfood = $player->getHungerManager();
        $sfood->setFood($sfood->getMaxFood());
        $sfood->setSaturation($sfood->getMaxFood());
        $player->sendMessage($prefix . " " . $settings->get("feed_message"));
    }
}