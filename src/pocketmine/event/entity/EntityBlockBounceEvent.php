<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityBlockBounceEvent extends EntityEvent implements Cancellable{
    public static $handlerList = null;

    /** @var Block */
    protected $block;
    /** @var float */
    protected $motionMultiplier;
    /** @var float */
    protected $fallDistanceMultiplier;

    public function __construct(Entity $entity, Block $block, float $motionMultiplier, float $fallDistanceMultiplier){
        $this->entity = $entity;
        $this->block = $block;
        $this->motionMultiplier = $motionMultiplier;
        $this->fallDistanceMultiplier = $fallDistanceMultiplier;
    }

    /**
     * @return Block
     */
    public function getBlock() : Block{
        return $this->block;
    }

    /**
     * @return float
     */
    public function getMotionMultiplier() : float{
        return $this->motionMultiplier;
    }

    /**
     * @param float $motionMultiplier
     */
    public function setMotionMultiplier(float $motionMultiplier) : void{
        $this->motionMultiplier = $motionMultiplier;
    }

    /**
     * @return float
     */
    public function getFallDistanceMultiplier() : float{
        return $this->fallDistanceMultiplier;
    }

    /**
     * @param float $fallDistanceMultiplier
     */
    public function setFallDistanceMultiplier(float $fallDistanceMultiplier) : void{
        $this->fallDistanceMultiplier = $fallDistanceMultiplier;
    }
}