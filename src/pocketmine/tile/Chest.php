<?php

/*
 *
 *                            __  __ _
 *     /\                    |  \/  (_)
 *    /  \   __ _ _   _  __ _| \  / |_ _ __   ___
 *   / /\ \ / _` | | | |/ _` | |\/| | | '_ \ / _ \
 *  / ____ \ (_| | |_| | (_| | |  | | | | | |  __/
 * /_/    \_\__, |\__,_|\__,_|_|  |_|_|_| |_|\___|
 *             | |
 *             |_|
 *
 * This program is private software. No license required.
 * Publication of this program is forbidden and will be punished.
 *
 * @author GreenWix Project
 * @link https://www.greenwix.fun
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\DoubleChestInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;

class Chest extends Spawnable implements InventoryHolder, Container, Nameable{
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
	use ContainerTrait;

	/** @var ChestInventory */
	protected $inventory;
	/** @var DoubleChestInventory */
	protected $doubleInventory = null;

	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
		$this->inventory = new ChestInventory($this);

		$this->initItems($nbt);

        if (!$this->namedtag->hasTag("trapped", ByteTag::class)){
            $blockTile = $this->level->getBlockAt($this->x, $this->y, $this->z);
            if($blockTile->getId() === Block::TRAPPED_CHEST){
                $this->namedtag->setByte("trapped", 1);
            }else{
                $this->namedtag->setByte("trapped", 0);
            }
        }
	}

	public function close(){
		if($this->closed === false){
			foreach($this->getInventory()->getViewers() as $player){
				$player->removeWindow($this->getInventory());
			}

			foreach($this->getInventory()->getViewers() as $player){
				$player->removeWindow($this->getRealInventory());
			}

			$this->inventory = null;
			$this->doubleInventory = null;

			parent::close();
		}
	}

	/**
	 * @return int
	 */
	public function getSize() : int{
		return 27;
	}

	/**
	 * @return ChestInventory|DoubleChestInventory
	 */
	public function getInventory(){
		if($this->isPaired() and $this->doubleInventory === null){
			$this->checkPairing();
		}
		return $this->doubleInventory instanceof DoubleChestInventory ? $this->doubleInventory : $this->inventory;
	}

	/**
	 * @return ChestInventory
	 */
	public function getRealInventory(){
		return $this->inventory;
	}

	protected function checkPairing(){
		if($this->isPaired() and !$this->getLevel()->isChunkLoaded($this->namedtag->getInt("pairx") >> 4, $this->namedtag->getInt("pairz") >> 4)){
			//paired to a tile in an unloaded chunk
			$this->doubleInventory = null;

		}elseif(($pair = $this->getPair()) instanceof Chest){
			if(!$pair->isPaired()){
				$pair->createPair($this);
				$pair->checkPairing();
			}
			if($this->doubleInventory === null){
				if(($pair->x + ($pair->z << 15)) > ($this->x + ($this->z << 15))){ //Order them correctly
					$this->doubleInventory = new DoubleChestInventory($pair, $this);
				}else{
					$this->doubleInventory = new DoubleChestInventory($this, $pair);
				}
			}
		}else{
			$this->doubleInventory = null;
			$this->namedtag->removeTag("pairx", "pairz");
		}
	}

    public function isTrapped(): int{
        return $this->namedtag->getByte("trapped", 0);
    }

	public function isPaired(){
		if(!$this->namedtag->hasTag("pairx", IntTag::class) or !$this->namedtag->hasTag("pairz", IntTag::class)){
			return false;
		}

		return true;
	}

	/**
	 * @return Chest|null
	 */
	public function getPair(){
		if($this->isPaired()){
			$tile = $this->getLevel()->getTileAt($this->namedtag->getInt("pairx"), $this->y, $this->namedtag->getInt("pairz"));
			if($tile instanceof Chest){
				return $tile;
			}
		}

		return null;
	}

	public function pairWith(Chest $tile){
		if($this->isPaired() or $tile->isPaired()){
			return false;
		}

		$this->createPair($tile);

		$this->onChanged();
		$tile->onChanged();
		$this->checkPairing();

		return true;
	}

	private function createPair(Chest $tile){
		$this->namedtag->setInt("pairx", $tile->x);
		$this->namedtag->setInt("pairz", $tile->z);

		$tile->namedtag->setInt("pairx", $this->x);
		$tile->namedtag->setInt("pairz", $this->z);
	}

	public function unpair(){
		if(!$this->isPaired()){
			return false;
		}

		$tile = $this->getPair();
		$this->namedtag->removeTag("pairx", "pairz");

		$this->spawnToAll();

		if($tile instanceof Chest){
			$tile->namedtag->removeTag("pairx", "pairz");
			$tile->checkPairing();
			$tile->spawnToAll();
		}
		$this->checkPairing();

		return true;
	}

	public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
		if($this->isPaired()){
			$nbt->setInt("pairx", $this->namedtag->getInt("pairx"));
			$nbt->setInt("pairz", $this->namedtag->getInt("pairz"));
		}

        $this->addNameSpawnData($nbt, $isBedrock);
	}
}
