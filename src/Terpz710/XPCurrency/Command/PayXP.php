<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class PayXP extends Command {

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("payxp", "Pay XP to another player");
        $this->setPermission("xpcurrency.payxp");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("xpcurrency.payxp")) {
                if (count($args) === 2) {
                    $targetPlayerName = $args[0];
                    $targetPlayer = $this->plugin->getServer()->getPlayer($targetPlayerName);
                    if ($targetPlayer instanceof Player) {
                        $xpAmount = (int)$args[1];
                        if ($xpAmount > 0) {
                            $xpManager = $this->plugin->getXPManager();
                            if ($xpManager->getPlayerXP($sender) >= $xpAmount) {
                                $xpManager->removePlayerXP($sender, $xpAmount);
                                $xpManager->addPlayerXP($targetPlayer, $xpAmount);
                                $sender->sendMessage("You paid $xpAmount XP to " . $targetPlayerName);
                            } else {
                                $sender->sendMessage("You don't have enough XP to make this payment.");
                            }
                        } else {
                            $sender->sendMessage("Please specify a positive XP amount.");
                        }
                    } else {
                        $sender->sendMessage("Player not found or is not online.");
                    }
                } else {
                    $sender->sendMessage("Usage: /payxp <player> <amount>");
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
