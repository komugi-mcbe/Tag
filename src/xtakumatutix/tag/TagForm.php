<?php

namespace xtakumatutix\tag;

use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use xtakumatutix\tag\Main;

Class TagForm implements Form
{
    public function handleResponse(Player $player, $data): void
    {
        // TODO: Implement handleResponse() method.
        if ($data === null){
            return;
        }
        $name = $player->getName();
        $length = mb_strlen($data[0]);
        $mymoney = EconomyAPI::getInstance()->myMoney($player);
        if (!$mymoney < 1500) {
            if (!$length < 12) {
                if ($player->isOp()){
                    $player->sendMessage("称号を " . $data[0]);
                    $player->setDisplayName("[STAFF][".$data[0]."] ".$name);
                    Main::$this->config->set($name, $data[0]);
                    Main::$this->config->save();
                }else{
                $player->sendMessage("称号を " . $data[0]);
                $player->setDisplayName("[".$data[0]."] ".$name);
                Main::$this->config->set($name, $data[0]);
                Main::$this->config->save();
                }
            } else {
                $player->sendMessage("文字があかん");
            }
        }else{
            $player->sendMessage("お金が足りない");
        }
    }

    public function jsonSerialize()
    {
      return[
          'type' => 'custom_form',
          'title' => '称号',
          'content' => [
              [
                  'type' => 'input',
                  'text' => '入力して'
              ]
          ]
      ];
    }
}