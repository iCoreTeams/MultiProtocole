<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\object\EnderCrystal as Crystal;
use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\Player;

class EnderCrystal extends Item{

	/**
	 * EyeOfEnder constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::END_CRYSTAL, 0, $count, 'Ender Crystal');
	}

	/**
	 * @param Level $level
     * @param Player $player
     * @param Block $block
     * @param Block $target
     * @param int $face
     * @param float $fx
     * @param float $fy
     * @param float $fz
     *
	 * @return bool
	 */
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
        $id = $target->getId();
		if($id !== BlockIds::OBSIDIAN and $id !== BlockIds::BEDROCK){
			return false;
		}

		$level = $player->getLevel();
		assert($level !== null);

		if(!$level->getBlock($target->asVector3()->add(0, 1, 0))->getId() != 0){
			$pos = $target;
			$entities = $level->getNearbyEntities(new AxisAlignedBB($pos->getX(), $pos->getY(), $pos->getZ(), $pos->getX() + 1, $pos->getY() + 2, $pos->getZ() + 1));
			if(count($entities) === 0 && $level->getBlock($pos->getSide(Vector3::SIDE_UP)) instanceof Air && $level->getBlock($pos->getSide(Vector3::SIDE_UP, 2)) instanceof Air){
				$npc = new Crystal($player->level, EntityDataHelper::createBaseNBT($target->add(0.5, 1, 0.5), null, $player->getYaw(), $player->getPitch()));
				$npc->spawnToAll();

                $this->pop();

				return true;
			}
		}

		return false;
	}
}