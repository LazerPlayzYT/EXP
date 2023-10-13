<?php

namespace Terpz710\XPCurrency\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use Terpz710\XPCurrency\Main;

class XPBottleCommand extends Command implements Listener {

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("xpbottle", "Create an experience bottle with specified XP");
        $this->setPermission("xpcurrency.xpbottle");
        $this->plugin = $plugin;
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("xpcurrency.xpbottle")) {
                if (count($args) === 1) {
                    $amount = (int)$args[0];
                    if ($amount > 0) {
                        
                        $currentXP = $sender->getXpManager()->getXpLevel();
                        if ($currentXP >= $amount) {
                            
                            $bottle = VanillaItems::EXPERIENCE_BOTTLE()->setXp($amount);

                            $sender->getInventory()->addTypeItem($bottle);
                            $sender->getXpManager()->subtractXpLevels($amount);
                            $sender->sendMessage("You created an XP bottle with $amount XP.");
                        } else {
                            $sender->sendMessage("You don't have enough XP to create the bottle.");
                        }
                    } else {
                        $sender->sendMessage("Please specify a positive XP amount.");
                    }
                } else {
                    $sender->sendMessage("Usage: /xpbottle <amount>");
                }
            } else {
                $sender->sendMessage("You don't have permission to use this command.");
            }
        } else {
            $sender->sendMessage("This command can only be used by a player.");
        }
        return true;
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK)
            if ($item->getId() === VanillaItems::EXPERIENCE_BOTTLE) {
                $xp = $item->getXp();
            
                $currentXP = $player->getXpManager()->getXpLevel()();
                if ($currentXP >= $xp) {
                    $xpManager = $this->plugin->getXPManager();
                    $xpManager->earnExperienceCurrency($player, $xp);
                    $player->getInventory()->removeItem($item);
                    $player->sendMessage("You used the XP bottle and gained $xp XP.");
                } else {
                    $player->sendMessage("You don't have enough XP to use the bottle.");
                }
            }
        }
    }
