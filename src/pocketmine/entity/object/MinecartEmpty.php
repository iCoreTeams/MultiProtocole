<?php

declare(strict_types=1);

namespace pocketmine\entity\object;

use pocketmine\math\Vector3;
use pocketmine\entity\feature\Interactive;
use pocketmine\entity\Rideable;
use pocketmine\Player;

class MinecartEmpty extends MinecartAbstract implements Interactive, Rideable
{

    public const NETWORK_ID = self::MINECART;

    public function getSeatPosition(): Vector3 { return new Vector3(0, 1, 0); }

    public function getInteractButtonText(Player $player): ?string { return "action.interact.ride.minecart"; }

    public function isRideable() :bool{
        return true;
    }

    public function getName(): string
	{
		return "Minecart";
	}

    public function getType(): int
	{
		return self::TYPE_NORMAL;
	}

}