<?php

namespace xtakumatutix\tag;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;

class EventListener implements Listener
{
    private $Main;

    public function __construct(Main $Main)
    {
        $this->Main = $Main;
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $config = $this->Main->config;
        if ($config->exists($name)) {
            $tag = $config->get($name);
            if ($player->isOp()) {
                $player->setDisplayName("§6[§eSTAFF§6]§b[§r" . $tag . "§b] §r" . $name);
            } else {
                $player->setDisplayName("§b[§r" . $tag . "§b] §r" . $name);
            }
        } else {
            $player->setDisplayName("§b[§r初入店§b] §r" . $name);
        }
    }
}