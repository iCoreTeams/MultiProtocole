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

namespace pocketmine\inventory;

use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\tile\Chest;

use function count;

class ChestInventory extends ContainerInventory{

	/** @var bool */
	protected $animated = true;

	public function __construct(Chest $tile){
		parent::__construct($tile, InventoryType::get(InventoryType::CHEST));
	}

	/**
	 * @return Chest
	 */
	public function getHolder(){
		return $this->holder;
	}

	/**
	 * @return bool
	 */
	public function isAnimated() : bool{
		return $this->animated;
	}

	/**
	 * @param bool $animated
	 */
	public function setAnimated(bool $animated = true) : void{
		$this->animated = $animated;
	}

	public function onOpen(Player $who){
		parent::onOpen($who);

		if($this->animated and count($this->getViewers()) === 1 and ($level = $this->getHolder()->getLevel()) instanceof Level){
			$this->broadcastBlockEventPacket(BlockEventPacket::TYPE_CHEST, BlockEventPacket::DATA_CHEST_OPEN);
			$level->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_CHEST_OPEN);
		}
	}

	public function onClose(Player $who){
		if($this->animated and count($this->getViewers()) === 1 and ($level = $this->getHolder()->getLevel()) instanceof Level){
			$this->broadcastBlockEventPacket(BlockEventPacket::TYPE_CHEST, BlockEventPacket::DATA_CHEST_CLOSED);
			$level->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
		}
		parent::onClose($who);
	}

	protected function broadcastBlockEventPacket(int $eventType, int $eventData){
		$pk = new BlockEventPacket();
		$pk->x = $this->getHolder()->getX();
		$pk->y = $this->getHolder()->getY();
		$pk->z = $this->getHolder()->getZ();
		$pk->eventType = $eventType;
		$pk->eventData = $eventData;
		$this->getHolder()->getLevel()->addChunkPacket($this->getHolder()->getX() >> 4, $this->getHolder()->getZ() >> 4, $pk);
	}
}
