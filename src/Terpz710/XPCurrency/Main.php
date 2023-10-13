<?php

namespace Terpz710\XPCurrency;

use pocketmine\plugin\PluginBase;
use Terpz710\XPCurrency\XPManager;
use Terpz710\XPCurrency\XPCommand;
use Terpz710\XPCurrency\PayXP;
use Terpz710\XPCurrency\SetXP;
use Terpz710\XPCurrency\XPBottleCommand;

class Main extends PluginBase {

    private $xpManager;

    public function onEnable() {
        $this->xpManager = new XPManager($this);
        $this->getServer()->getCommandMap()->register("xpcurrency", new XPCommand($this));
        $this->getServer()->getCommandMap()->register("payxp", new PayXP($this));
        $this->getServer()->getCommandMap()->register("setxp", new SetXP($this, $this->xpManager));
        $this->getServer()->getCommandMap()->register("xpbottle", new XPBottleCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new XPBottleCommand($this), $this);
    }

    public function getXPManager() {
        return $this->xpManager;
    }
}
