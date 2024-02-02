<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\ShulkerBoxInventory;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class ShulkerBox extends Spawnable implements InventoryHolder, Container, Nameable{
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

	/** @var ShulkerBoxInventory */
	protected $inventory;

	/**
	 * ShulkerBox constructor.
	 * @param Level $level
	 * @param CompoundTag $nbt
	 */
	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
		$this->inventory = new ShulkerBoxInventory($this);

        $this->initItems($nbt);
	}

    /**
     * @return int
     */
    public function getSize() : int{
        return 27;
    }

    /**
     * @return ShulkerBoxInventory
     */
    public function getInventory():ShulkerBoxInventory{
        return $this->inventory;
    }

	public function close(){
		if(!$this->closed){
            foreach($this->getInventory()->getViewers() as $player){
                $player->removeWindow($this->getInventory());
            }

			$this->inventory = null;

			parent::close();
		}
	}

    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
        $nbt->setByte("facing", $this->namedtag->getByte("facing", 1));

        $this->addNameSpawnData($nbt, $isBedrock);
    }
}