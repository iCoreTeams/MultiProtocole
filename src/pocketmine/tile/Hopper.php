<?php

/*
 *
 *  _____   _____   __   _   _   _____  __    __  _____
 * /  ___| | ____| |  \ | | | | /  ___/ \ \  / / /  ___/
 * | |     | |__   |   \| | | | | |___   \ \/ /  | |___
 * | |  _  |  __|  | |\   | | | \___  \   \  /   \___  \
 * | |_| | | |___  | | \  | | |  ___| |   / /     ___| |
 * \_____/ |_____| |_|  \_| |_| /_____/  /_/     /_____/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTX Technologies
 * @link https://itxtech.org
 *
 */

namespace pocketmine\tile;

use pocketmine\block\Hopper as HopperBlock;
use pocketmine\entity\object\Item as DroppedItem;
use pocketmine\inventory\HopperInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\ShulkerBoxInventory;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class Hopper extends Spawnable implements InventoryHolder, Container, Nameable{
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

	/** @var HopperInventory */
	protected $inventory;

	/** @var bool */
	protected $isPowered = false;

	/**
	 * Hopper constructor.
	 *
	 * @param Level $level
	 * @param CompoundTag $nbt
	 */
	public function __construct(Level $level, CompoundTag $nbt){
        if(!$nbt->hasTag("TransferCooldown", IntTag::class)){
            $nbt->setInt("TransferCooldown", 0);
        }

		parent::__construct($level, $nbt);
		$this->inventory = new HopperInventory($this);

        $this->initItems($nbt);

		$this->scheduleUpdate();
	}

    public function getDefaultName(): string
    {
        return "Hopper";
    }

	public function close(){
		if($this->closed === false){
            foreach($this->getInventory()->getViewers() as $player){
                $player->removeWindow($this->getInventory());
            }
			$this->inventory = null;

			parent::close();
		}
	}

	public function activate(): void{
		$this->isPowered = true;
	}

	public function deactivate(): void{
		$this->isPowered = false;
	}

	/**
	 * @return bool
	 */
	public function canUpdate(){
		return $this->namedtag->getInt("TransferCooldown") === 0 and !$this->isPowered;
	}

	public function resetCooldownTicks(){
        $this->namedtag->setInt("TransferCooldown", 8);
	}

	/**
	 * @return bool
	 */
	public function onUpdate(): bool{
		if(!($this->getBlock() instanceof HopperBlock)){
			return false;
		}
		//Pickup dropped items
		//This can happen at any time regardless of cooldown
		$area = clone $this->getBlock()->getBoundingBox(); //Area above hopper to draw items from
		$area->maxY = ceil($area->maxY) + 1; //Account for full block above, not just 1 + 5/8
		foreach($this->getLevel()->getChunkEntities((int)$this->getBlock()->x >> 4, (int)$this->getBlock()->z >> 4) as $entity){
			if(!($entity instanceof DroppedItem) or !$entity->isAlive()){
				continue;
			}
			if(!$entity->boundingBox->intersectsWith($area)){
				continue;
			}

			$item = $entity->getItem();
			if(!$item instanceof Item){
				continue;
			}
			if($item->getCount() < 1){
				$entity->close();
				continue;
			}

			if($this->inventory->canAddItem($item)){
				$this->inventory->addItem($item);
				$entity->close();
			}
		}

		if(!$this->canUpdate()){ //Hoppers only update CONTENTS every 8th tick
            $this->namedtag->setInt("TransferCooldown", $this->namedtag->getInt("TransferCooldown") - 1);
			return true;
		}

		//Suck items from above tile inventories
		$source = $this->getLevel()->getTile($this->getBlock()->getSide(Vector3::SIDE_UP));
		if($source instanceof Tile and $source instanceof InventoryHolder){
			$inventory = $source->getInventory();
			$item = clone $inventory->getItem($inventory->firstOccupied());
			$item->setCount(1);
			if($this->inventory->canAddItem($item)){
				$this->inventory->addItem($item);
				$inventory->removeItem($item);
				$source->getInventory()->getHolder()->saveNBT();
				$this->resetCooldownTicks();
				if($source instanceof Hopper){
					$source->resetCooldownTicks();
				}
			}
		}

		//Feed item into target inventory
		//Do not do this if there's a hopper underneath this hopper, to follow vanilla behaviour
		if(!($this->getLevel()->getTile($this->getBlock()->getSide(Vector3::SIDE_DOWN)) instanceof Hopper)){
			$target = $this->getLevel()->getTile($this->getBlock()->getSide($this->getBlock()->getDamage()));
			if($target instanceof Tile and $target instanceof InventoryHolder){
				$inv = $target->getInventory();
				foreach($this->inventory->getContents() as $item){
					if($item->getId() === Item::AIR or $item->getCount() < 1){
						continue;
					}

					$targetItem = clone $item;
					$targetItem->setCount(1);

					if($item->getId() === 218 and $inv instanceof ShulkerBoxInventory){
						return false;
					}

					if($inv->canAddItem($targetItem)){
						$this->inventory->removeItem($targetItem);
						$inv->addItem($targetItem);
						$target->getInventory()->getHolder()->saveNBT();
						$this->resetCooldownTicks();
						if($target instanceof Hopper){
							$target->resetCooldownTicks();
						}
						break;
					}

				}
			}
		}

		return true;
	}

	/**
	 * @return HopperInventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

	/**
	 * @return int
	 */
	public function getSize(): int{
		return 5;
	}

	/**
	 * @return bool
	 */
    public function hasLock() : bool{
        return $this->namedtag->hasTag("Lock", StringTag::class);
    }

	/**
	 * @param string $itemName
	 */
    public function setLock(string $itemName): void{
        if($itemName === ""){
            $this->namedtag->removeTag("Lock");
            return;
        }

        $this->namedtag->setString("Lock", $itemName);
    }

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function checkLock(string $key): bool{
		return $this->namedtag->getString("Lock", "") === $key;
	}

    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
        if($this->hasLock()){
            $nbt->setString("Lock", $this->namedtag->getString("Lock"));
        }
        $this->addNameSpawnData($nbt, $isBedrock);
    }
}
