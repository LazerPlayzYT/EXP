<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Terpz710\XPCurrency\Main;

class SetXP extends Command {

    private $xpManager;

    public function __construct(XPManager $xpManager) {
        parent::__construct("setxp", "Set your XP to a specific amount");
        $this->setPermission("xpcurrency.setxp");
        $this->xpManager = $xpManager;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("xpcurrency.setxp")) {
                if (count($args) === 1) {
                    $xpAmount = (int)$args[0];
                    if ($xpAmount >= 0) {
                        $this->xpManager->setPlayerXP($sender, $xpAmount);
                        $sender->sendMessage("Your XP has been set to $xpAmount.");
                    } else {
                        $sender->sendMessage("Please specify a non-negative XP amount.");
                    }
                } else {
                    $sender->sendMessage("Usage: /setxp <amount>");
                }
            } else {
                $sender->sendMessage("You don't have permission to use this command.");
            }
        } else {
            $sender->sendMessage("This command can only be used by a player.");
        }
        return true;
    }
}
