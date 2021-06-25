<?php

namespace Matthoto\SolaSoup;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\level\sound\PopSound;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    private $cooldown = [];

    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($event->isCancelled()) return;
            if ($player->getInventory()->getItemInHand()->getId() === Item::COOKED_CHICKEN) {
                $lastPlayerTime = $this->cooldown[$player->getName()] ?? 0;
                $timeNow = time();
                if($timeNow - $lastPlayerTime >= 0) {
                    if ($player->getHealth() >= 20) {
                        $player->sendMessage("§4Tu as déjà toute ta vie !");
                    } else {
                        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK or $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
                            $player->setHealth($player->getHealth() + "2" * 2);
                            $player->sendMessage("§4Vous vous êtes bien heal !");
                            $player->getLevel()->addSound(new PopSound($player));
                            $player->getInventory()->removeItem($item->setCount(1));
                            $this->cooldown[$player->getName()] = $timeNow;
                        }
                    }
                }else{
                    $player->sendMessage("§4Attend un peu avant de reprendre une soup !");
                }
            }
    }
}