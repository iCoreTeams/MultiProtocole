<?php

declare(strict_types=1);

namespace pocketmine\item;


class NetheriteHelmet extends Sword {
    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::NETHERITE_HELMET, $meta, $count, "Netherite Helmet",self::TIER_NETHERITE);
    }
}