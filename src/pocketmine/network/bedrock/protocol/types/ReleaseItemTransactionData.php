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

class ReleaseItemTransactionData extends TransactionData{
	public const ACTION_RELEASE = 0; //bow shoot
	public const ACTION_CONSUME = 1; //eat food, drink potion

	/** @var int */
	private $actionType;
	/** @var int */
	private $hotbarSlot;
	/** @var ItemInstance */
	private $itemInHand;
	/** @var Vector3 */
	private $headPos;

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
	public function getHeadPos() : Vector3{
		return $this->headPos;
	}

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_RELEASE_ITEM;
	}

	protected function decodeData(DataPacket $stream) : void{
		$this->actionType = $stream->getUnsignedVarInt();
		$this->hotbarSlot = $stream->getVarInt();
		$this->itemInHand = $stream->getItemInstance();
		$this->headPos = $stream->getVector3();
	}

	protected function encodeData(DataPacket $stream) : void{
		$stream->putUnsignedVarInt($this->actionType);
		$stream->putVarInt($this->hotbarSlot);
		$stream->putItemInstance($this->itemInHand);
		$stream->putVector3($this->headPos);
	}

	public static function new(array $actions, int $actionType, int $hotbarSlot, Item $itemInHand, Vector3 $headPos) : self{
		$result = new self;
		$result->actions = $actions;
		$result->actionType = $actionType;
		$result->hotbarSlot = $hotbarSlot;
		$result->itemInHand = $itemInHand;
		$result->headPos = $headPos;
		return $result;
	}
}
