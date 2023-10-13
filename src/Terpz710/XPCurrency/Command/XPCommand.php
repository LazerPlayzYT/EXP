<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class XPCommand extends Command {

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("xp", "Check your XP balance");
        $this->setPermission("xpcurrency.xp");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("xpcurrency.xp")) {
                $xpManager = $this->plugin->getXPManager();
                $xp = $xpManager->getPlayerXP($sender);
                $sender->sendMessage("Your XP balance: $xp");
            } else {
                $sender->sendMessage("You don't have permission to use this command.");
            }
        } else {
            $sender->sendMessage("This command can only be used by a player.");
        }
        return true;
    }
}
