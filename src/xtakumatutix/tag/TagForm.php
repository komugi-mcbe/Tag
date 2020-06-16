<?php

namespace xtakumatutix\tag;

use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\Config;
use xtakumatutix\tag\Main;

class TagForm implements Form
{
    public function __construct(Main $Main)
    {
        $this->Main = $Main;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
        if (isset($data[0])) {
            $name = $player->getName();
            $length = mb_strlen($data[0]);
            $section = mb_substr_count($data[0], "§");
            $count = $length - $section * 2;
            if ($count < 16) {
                if ($player->isOP()) {
                    $player->sendMessage("§a >> §r称号を「" . $data[0] . "§r」にしました");
                    $player->setDisplayName("§6[§eSTAFF§6]§b[§r" . $data[0] . "§r§b]§r " . $name);
                    $this->Main->config->set($name, $data[0]);
                    $this->Main->config->save();
                } else {
                    $player->sendMessage("§a >> §r称号を「" . $data[0] . "§r」にしました");
                    $player->setDisplayName("§b[§r" . $data[0] . "§r§b]§r " . $name);
                    $this->Main->config->set($name, $data[0]);
                    $this->Main->config->save();
                }
            } else {
                $player->sendMessage("§c >> §f文字は15字以内です");
            }
        } else {
            $player->sendMessage("§c >> §f文字を入力してください");
            return;
        }
    }

    public
    function jsonSerialize()
    {
        return [
            'type' => 'custom_form',
            'title' => '称号',
            'content' => [
                [
                    'type' => 'input',
                    'text' => "称号を設定できます。\n文字は15字以内でのみ可能です\n※不適切な単語などが見つかった場合\n処置を取らせていただきます",
                    'placeholder' => '「§」のみ含まれません。'
                ]
            ]
        ];
    }
}