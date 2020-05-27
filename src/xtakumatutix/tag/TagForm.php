<?php

namespace xtakumatutix\tag;

use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use xtakumatutix\tag\Main;

Class TagForm implements Form
{
    public function __construct(Main $Main)
    { 
        $this->Main = $Main;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null){
            return;
        }
        $name = $player->getName();
        $length = mb_strlen($data[0]);
        $mymoney = EconomyAPI::getInstance()->myMoney($player);
        if (!$mymoney < 1500) {
            if (!$length < 12) {
                if ($player->isOp()){
                    $player->sendMessage("称号を「".$data[0]."」にしました");
                    $player->setDisplayName("[STAFF][".$data[0]."] ".$name);
                    $this->Main->config->set($name, $data[0]);
                    $this->Main->config->save();
                }else{
                $player->sendMessage("称号を " . $data[0]);
                $player->setDisplayName("[".$data[0]."] ".$name);
                $this->Main->config->set($name, $data[0]);
                $this->Main->config->save();
                }
            } else {
                $player->sendMessage("文字があかん");
                return;
            }
        }else{
            $player->sendMessage("お金が足りない");
            return;
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
                  'text' => '称号を設定できます。
                  文字は12字以内でのみ可能です
                  ※不適切な単語などが見つかった場合処置を取らせていただきます'
              ]
          ]
      ];
    }
}