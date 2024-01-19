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

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\bedrock\protocol\types\inventory\ItemInstance;
use pocketmine\network\mcpe\NetworkBinaryStream;
use pocketmine\network\bedrock\protocol\InventoryTransactionPacket;

class UseItemOnActorTransactionData extends TransactionData{
	public const ACTION_INTERACT = 0;
	public const ACTION_ATTACK = 1;

	/** @var int */
	private $actorRuntimeId;
	/** @var int */
	private $actionType;
	/** @var int */
	private $hotbarSlot;
	/** @var ItemInstance */
	private $itemInHand;
	/** @var Vector3 */
	private $playerPos;
	/** @var Vector3 */
	private $clickPos;

	/**
	 * @return int
	 */
	public function getActorRuntimeId() : int{
		return $this->actorRuntimeId;
	}

	/**
	 * @return int
	 */
	public function getActionType() : int{
		return $this->actionType;
	}

	/**
	 * @return int
	 */
	public function getHotbarSlot() : int{
		return $this->hotbarSlot;
	}

	/**
	 * @return ItemInstance
	 */
	public function getItemInHand() : ItemInstance{
		return $this->itemInHand;
	}

	/**
	 * @return Vector3
	 */
	public function getPlayerPos() : Vector3{
		return $this->playerPos;
	}

	/**
	 * @return Vector3
	 */
	public function getClickPos() : Vector3{
		return $this->clickPos;
	}

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_USE_ITEM_ON_ACTOR;
	}

	protected function decodeData(DataPacket $stream) : void{
		$this->actorRuntimeId = $stream->getEntityRuntimeId();
		$this->actionType = $stream->getUnsignedVarInt();
		$this->hotbarSlot = $stream->getVarInt();
		$this->itemInHand = $stream->getItemInstance();
		$this->playerPos = $stream->getVector3();
		$this->clickPos = $stream->getVector3();
	}

	protected function encodeData(DataPacket $stream) : void{
		$stream->putEntityRuntimeId($this->actorRuntimeId);
		$stream->putUnsignedVarInt($this->actionType);
		$stream->putVarInt($this->hotbarSlot);
		$stream->putItemInstance($this->itemInHand);
		$stream->putVector3($this->playerPos);
		$stream->putVector3($this->clickPos);
	}

	public static function new(array $actions, int $actorRuntimeId, int $actionType, int $hotbarSlot, Item $itemInHand, Vector3 $playerPos, Vector3 $clickPos) : self{
		$result = new self;
		$result->actions = $actions;
		$result->actorRuntimeId = $actorRuntimeId;
		$result->actionType = $actionType;
		$result->hotbarSlot = $hotbarSlot;
		$result->itemInHand = $itemInHand;
		$result->playerPos = $playerPos;
		$result->clickPos = $clickPos;
		return $result;
	}
}
