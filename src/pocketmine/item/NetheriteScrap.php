<?php

declare(strict_types=1);

namespace pocketmine\item;


class NetheriteScrap extends Sword {
    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::NETHERITE_SCRAP, $meta, $count, "Netherite Scrap",self::TIER_NETHERITE);
    }
}