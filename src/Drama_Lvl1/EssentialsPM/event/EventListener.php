<?php

namespace Drama_Lvl1\EssentialsPM\event;

use Drama_Lvl1\EssentialsPM\EssentialsPM;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class EventListener implements Listener{

    private $plugin;

    public function __construct(EssentialsPM $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event){
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer();
        $this->plugin->msglast[$player->getName()] = null;
        $this->plugin->msgtoggle[$player->getName()] = false;

        if($settings->get("enabled") === "true"){
            $event->setJoinMessage(str_replace("{player}", $player->getName(), $settings->get("join")));
        } else {
            $event->setJoinMessage("");
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $settings = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer();

        if($settings->get("enabled") === "true"){
            $event->setQuitMessage(str_replace("{player}", $player->getName(), $settings->get("quit")));
        } else {
            $event->setQuitMessage("");
        }
    }
}
