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
use pocketmine\network\bedrock\protocol\types\actor\PropertySyncData;
use pocketmine\network\bedrock\protocol\types\inventory\ItemInstance;
use pocketmine\network\NetworkSession;
use pocketmine\network\bedrock\protocol\types\actor\ActorLink;
use pocketmine\Player;
use pocketmine\utils\UUID;
use function count;

class AddPlayerPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_PLAYER_PACKET;

	/** @var UUID */
	public $uuid;
	/** @var string */
	public $username;
	/** @var int */
	public $actorRuntimeId;
	/** @var string */
	public $platformChatId = "";
	/** @var Vector3 */
	public $position;
	/** @var Vector3|null */
	public $motion;
	/** @var float */
	public $pitch = 0.0;
	/** @var float */
	public $yaw = 0.0;
	/** @var float|null */
	public $headYaw = null; //TODO
	/** @var ItemInstance */
	public $item;
	/** @var int */
	public $gameMode = Player::SURVIVAL;
	/** @var array */
	public $metadata = [];
	/** @var PropertySyncData|null */
	public $syncedProperties;

	/** @var UpdateAbilitiesPacket|null */
	public $abilitiesPacket;

	/** @var ActorLink[] */
	public $links = [];

	/** @var string */
	public $deviceId = ""; //TODO: fill player's device ID (???)
	/** @var int */
	public $deviceOS = -1; //TODO: fill player's device OS

	public function decodePayload(){
		$this->uuid = $this->getUUID();
		$this->username = $this->getString();
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->platformChatId = $this->getString();
		$this->position = $this->getVector3();
		$this->motion = $this->getVector3();
		$this->pitch = $this->getLFloat();
		$this->yaw = $this->getLFloat();
		$this->headYaw = $this->getLFloat();
		$this->item = $this->getItemInstance();
		$this->gameMode = $this->getVarInt();
		$this->metadata = $this->getActorMetadata();
		$this->syncedProperties = PropertySyncData::read($this);

		if($this->abilitiesPacket === null){
			$this->abilitiesPacket = new UpdateAbilitiesPacket($this->buffer, $this->offset);
		}else{
			$this->abilitiesPacket->setBuffer($this->buffer, $this->offset);
		}
		$this->abilitiesPacket->decodePayload();

		$linkCount = $this->getUnsignedVarInt();
		for($i = 0; $i < $linkCount; ++$i){
			$this->links[$i] = $this->getActorLink();
		}

		$this->deviceId = $this->getString();
		$this->deviceOS = $this->getLInt();
	}

	public function encodePayload(){
		$this->putUUID($this->uuid);
		$this->putString($this->username);
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putString($this->platformChatId);
		$this->putVector3($this->position);
		$this->putVector3Nullable($this->motion);
		$this->putLFloat($this->pitch);
		$this->putLFloat($this->yaw);
		$this->putLFloat($this->headYaw ?? $this->yaw);
		$this->putItemInstance($this->item);
		$this->putVarInt($this->gameMode);
		$this->putActorMetadata($this->metadata);
		($this->syncedProperties ?? new PropertySyncData())->write($this);

		if($this->abilitiesPacket === null){
			$this->abilitiesPacket = new UpdateAbilitiesPacket();
			$this->abilitiesPacket->targetActorUniqueId = $this->actorRuntimeId;
			$this->abilitiesPacket->abilityLayers = [];
		}else{
			$this->abilitiesPacket->reset();
		}
		$this->abilitiesPacket->encodePayload();
		$this->put($this->abilitiesPacket->getBuffer());

		$this->putUnsignedVarInt(count($this->links));
		foreach($this->links as $link){
			$this->putActorLink($link);
		}

		$this->putString($this->deviceId);
		$this->putLInt($this->deviceOS);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAddPlayer($this);
	}
}
