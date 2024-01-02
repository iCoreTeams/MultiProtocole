<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityFallEvent extends EntityEvent implements Cancellable{
    public static $handlerList = null;

    /** @var float */
    protected $fallDistance;

    public function __construct(Entity $entity, float $fallDistance){
        $this->entity = $entity;
        $this->fallDistance = $fallDistance;
    }

    /**
     * @return float
     */
    public function getFallDistance() : float{
        return $this->fallDistance;
    }

    /**
     * @param float $fallDistance
     */
    public function setFallDistance(float $fallDistance) : void{
        $this->fallDistance = $fallDistance;
    }
}