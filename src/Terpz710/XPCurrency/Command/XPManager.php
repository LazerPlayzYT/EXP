<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\player\Player;
use pocketmine\Server;

class XPManager {

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function setPlayerXP(Player $player, int $xpAmount) {
        $player->setXpLevel($xpAmount);
    }

    public function getPlayerXP(Player $player) {
        return $player->getXpLevel();
    }

    public function addPlayerXP(Player $player, int $xpToAdd) {
        $currentXP = $this->getPlayerXP($player);
        $this->setPlayerXP($player, $currentXP + $xpToAdd);
    }

    public function removePlayerXP(Player $player, int $xpToRemove) {
        $currentXP = $this->getPlayerXP($player);
        $newXP = max(0, $currentXP - $xpToRemove);
        $this->setPlayerXP($player, $newXP);
    }
}
