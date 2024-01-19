<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\ShulkerBoxInventory;
use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class ShulkerBox extends Spawnable implements InventoryHolder, Container, Nameable{
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

        if(!$this->namedtag->hasTag("facing", ByteTag::class)){
            $nbt->setByte("facing", 1);
        }
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

    /**
     * @return string
     */
    public function getName() : string{
        return $this->namedtag->getString("CustomName", "Chest");
    }

    /**
     * @return bool
     */
    public function hasName() : bool{
        return $this->namedtag->hasTag("CustomName", StringTag::class);
    }

    /**
     * @param string $str
     */
    public function setName(string $str){
        if($str === ""){
            $this->namedtag->removeTag("CustomName");
            return;
        }

        $this->namedtag->setString("CustomName", $str);
    }

    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
        $nbt->setByte("facing", $this->namedtag->getByte("facing", 1));
        if($this->hasName()){
            $nbt->setString("CustomName", $this->namedtag->getString("CustomName"));
        }
    }
}