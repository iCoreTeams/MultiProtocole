<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\inventory\BeaconInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\Player;

class Beacon extends Spawnable implements Nameable, InventoryHolder{
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }

	private BeaconInventory $inventory;
	protected int $currentTick = 0;
	public const POWER_LEVEL_MAX = 4;

	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
        $this->inventory = new BeaconInventory($this);
		$this->scheduleUpdate();
	}

	/**
	 * @return BeaconInventory
	 */
	public function getInventory(): BeaconInventory{
		return $this->inventory;
	}

	/**
	 * @param CompoundTag $nbt
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function updateCompoundTag(CompoundTag $nbt, Player $player) : bool{
		if($nbt->getString("id") !== Tile::BEACON){
			return false;
		}

        $this->namedtag->setInt("primary", $nbt->getInt("primary", 0));
        $this->namedtag->setInt("secondary", $nbt->getInt("secondary", 0));
		return true;
	}

	/**
	 * @return bool
	 */
	public function onUpdate(): bool {
		if($this->closed === true){
			return false;
		}
		if($this->currentTick++ % 100 != 0){
			return true;
		}

		$level = $this->calculatePowerLevel();

		$this->timings->startTiming();

		$id = 0;

		if($level > 0){
            if($this->namedtag->hasTag("secondary", IntTag::class) and $this->namedtag->getInt("primary", 0) != 0){
                $id = $this->namedtag->getInt("primary", 0);
            }elseif($this->namedtag->hasTag("secondary", IntTag::class) and $this->namedtag->getInt("secondary", 0) != 0){
                $id = $this->namedtag->getInt("secondary", 0);
            }
			if($id != 0){
				$range = ($level + 1) * 10;
				$effect = Effect::getEffect($id);
				$effect->setDuration(10 * 30);
				$effect->setAmplifier(0);
				foreach($this->level->getPlayers() as $player){
					if($this->distance($player) <= $range){
						$player->addEffect($effect);
					}
				}
			}
		}

		$this->lastUpdate = microtime(true);

		$this->timings->stopTiming();

		return true;
	}

	/**
	 * @return int
	 */
	protected function calculatePowerLevel(){
		$tileX = $this->getFloorX();
		$tileY = $this->getFloorY();
		$tileZ = $this->getFloorZ();
		for($powerLevel = 1; $powerLevel <= self::POWER_LEVEL_MAX; $powerLevel++){
			$queryY = $tileY - $powerLevel;
			for($queryX = $tileX - $powerLevel; $queryX <= $tileX + $powerLevel; $queryX++){
				for($queryZ = $tileZ - $powerLevel; $queryZ <= $tileZ + $powerLevel; $queryZ++){
					$testBlockId = $this->level->getBlockIdAt($queryX, $queryY, $queryZ);
					if(
						$testBlockId != Block::IRON_BLOCK &&
						$testBlockId != Block::GOLD_BLOCK &&
						$testBlockId != Block::EMERALD_BLOCK &&
						$testBlockId != Block::DIAMOND_BLOCK
					){
						return $powerLevel - 1;
					}
				}
			}
		}
		return self::POWER_LEVEL_MAX;
	}

    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
        $nbt->setInt("primary", $this->namedtag->getInt("primary", 0));
        $nbt->setInt("secondary", $this->namedtag->getInt("secondary", 0));

        $this->addNameSpawnData($nbt, $isBedrock);
    }
}
