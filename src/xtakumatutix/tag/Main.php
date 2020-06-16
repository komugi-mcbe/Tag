<?php

namespace xtakumatutix\tag;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->getLogger()->notice("読み込み完了 - ver." . $this->getDescription()->getVersion());
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->config = new Config($this->getDataFolder() . "Tag.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!($sender instanceof Player)) {
            return true;
        }
        $sender->sendForm(new TagForm($this));
        return true;
    }
}