<?php

declare(strict_types=1);

namespace pocketmine\item;


class NetheriteLeggins extends Sword {
    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::NETHERITE_LEGGINS, $meta, $count, "Netherite Leggins",self::TIER_NETHERITE);
    }

    public function getItemPocket(): Item
    {
        $item = Item::get(self::DIAMOND_LEGGINGS, $this->getDamage(), $this->getCount());
        $item->setCustomName($this->getName());
        return $item;
    }
}