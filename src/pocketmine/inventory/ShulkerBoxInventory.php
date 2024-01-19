<?php

/*
 *  ___                                 _____                        
 * (  _`\                              (_   _)                       
 * | (_(_)_ __   _    ____    __    ___  | |   __     _ _   ___ ___  
 * |  _) ( '__)/'_`\ (_  ,) /'__`\/' _ `\| | /'__`\ /'_` )/' _ ` _ `\
 * | |   | |  ( (_) ) /'/_ (  ___/| ( ) || |(  ___/( (_| || ( ) ( ) |
 * (_)   (_)  `\___/'(____)`\____)(_) (_)(_)`\____)`\__,_)(_) (_) (_)
 *
 *
 * @link https://vk.com/frozencore_team
 *
 *
*/

namespace pocketmine\inventory;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\tile\ShulkerBox;

class ShulkerBoxInventory extends ContainerInventory{
	protected $holder;

	/**
	 * ShulkerBoxInventory constructor.
	 * @param ShulkerBox $tile
	 */
	public function __construct(ShulkerBox $tile){
		parent::__construct($tile, InventoryType::get(InventoryType::SHULKER_BOX));
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Shulker Box";
	}

	/**
	 * @return int
	 */
	public function getSize() : int{
		return 27;
	}

	/**
	 * @return ShulkerBox
	 */
	public function getHolder(){
		return $this->holder;
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function canAddItem(Item $item): bool
    {
		if($item->getId() === Block::SHULKER_BOX){
			return false;
		}
		return parent::canAddItem($item);
	}

	public function onOpen(Player $who){
		parent::onOpen($who);
		if(count($this->getViewers()) === 1){
			$pk = new BlockEventPacket();
			$pk->x = $this->getHolder()->getFloorX();
			$pk->y = $this->getHolder()->getFloorY();
			$pk->z = $this->getHolder()->getFloorZ();
			$pk->eventType = 1;
			$pk->eventData = 2;
			if(($level = $this->getHolder()->getLevel()) instanceof Level){
				$level->broadcastLevelSoundEvent($this->getHolder(), LevelSoundEventPacket::SOUND_SHULKERBOX_OPEN);
				$level->addChunkPacket($this->getHolder()->getFloorX() >> 4, $this->getHolder()->getFloorZ() >> 4, $pk);
			}
		}
	}

	public function onClose(Player $who){
		if(count($this->getViewers()) === 1){
			$pk = new BlockEventPacket();
			$pk->x = $this->getHolder()->getFloorX();
			$pk->y = $this->getHolder()->getFloorY();
			$pk->z = $this->getHolder()->getFloorZ();
			$pk->eventType = 1;
			$pk->eventData = 0;
			if(($level = $this->getHolder()->getLevel()) instanceof Level){
				$level->broadcastLevelSoundEvent($this->getHolder(), LevelSoundEventPacket::SOUND_SHULKERBOX_CLOSED);
				$level->addChunkPacket($this->getHolder()->getFloorX() >> 4, $this->getHolder()->getFloorZ() >> 4, $pk);
			}
		}
		$this->getHolder()->saveNBT();
		parent::onClose($who);
	}
}