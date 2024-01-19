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

namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\bedrock\protocol\types\inventory\ItemInstance;
use pocketmine\network\NetworkSession;

class AddItemActorPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_ITEM_ACTOR_PACKET;

	/** @var int|null */
	public $actorUniqueId = null; //TODO
	/** @var int */
	public $actorRuntimeId;
	/** @var ItemInstance */
	public $item;
	/** @var Vector3 */
	public $position;
	/** @var Vector3|null */
	public $motion;
	/** @var array */
	public $metadata = [];
	/** @var bool */
	public $isFromFishing = false;

	public function decodePayload(){
		$this->actorUniqueId = $this->getActorUniqueId();
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->item = $this->getItemInstance();
		$this->position = $this->getVector3();
		$this->motion = $this->getVector3();
		$this->metadata = $this->getActorMetadata();
		$this->isFromFishing = $this->getBool();
	}

	public function encodePayload(){
		$this->putActorUniqueId($this->actorUniqueId ?? $this->actorRuntimeId);
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putItemInstance($this->item);
		$this->putVector3($this->position);
		$this->putVector3Nullable($this->motion);
		$this->putActorMetadata($this->metadata);
		$this->putBool($this->isFromFishing);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAddItemActor($this);
	}
}
