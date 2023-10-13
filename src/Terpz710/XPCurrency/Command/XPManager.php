<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\player\Player;
use pocketmine\Server;
use Terpz710\XPCurrency\Main;

class XPManager {

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function setPlayerXP(Player $player, int $xpAmount) {
        $player->getXpManager()->setXpLevel($xpAmount);
    }

    public function getPlayerXP(Player $player) {
        return $player->getXpManager()->getXpLevel();
    }

    public function addPlayerXP(Player $player, int $xpToAdd) {
        $currentXP = $this->getXpManager()->getPlayerXP($player);
        $this->getXpManager()->setPlayerXP($player, $currentXP + $xpToAdd);
    }

    public function removePlayerXP(Player $player, int $xpToRemove) {
        $currentXP = $this->getPlayerXP($player);
        $newXP = max(0, $currentXP - $xpToRemove);
        $this->setPlayerXP($player, $newXP);
    }
}
