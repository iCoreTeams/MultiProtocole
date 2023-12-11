<?php

declare(strict_types=1);

namespace pocketmine\item;


class NetheriteChestplate extends Sword {
    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::NETHERITE_CHESTPLATE, $meta, $count, "Netherite Chestplate",self::TIER_NETHERITE);
    }
}