<?php

declare(strict_types=1);

namespace pocketmine\block;

class Slime extends Solid{

    protected $id = self::SLIME_BLOCK;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function hasEntityCollision() : bool{
        return true;
    }

    public function getHardness() : float{
        return 0;
    }

    public function getName() : string{
        return "Slime Block";
    }

    public function getBounceMotionMultiplier() : float{
        return 1.0;
    }

    public function getBounceFallDistanceMultiplier() : float{
        return 0.0;
    }
}