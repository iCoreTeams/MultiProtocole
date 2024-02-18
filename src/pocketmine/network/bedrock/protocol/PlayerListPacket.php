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


use pocketmine\network\bedrock\protocol\types\PlayerListEntry;
use pocketmine\network\NetworkSession;
use function count;

class PlayerListPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_LIST_PACKET;

	public const TYPE_ADD = 0;
	public const TYPE_REMOVE = 1;

	/** @var PlayerListEntry[] */
	public $entries = [];
	/** @var int */
	public $type;

	public function decodePayload(){
		$this->type = $this->getByte();
		$count = $this->getUnsignedVarInt();
		for($i = 0; $i < $count; ++$i){
			$entry = new PlayerListEntry();

			if($this->type === self::TYPE_ADD){
				$entry->uuid = $this->getUUID();
				$entry->actorUniqueId = $this->getActorUniqueId();
				$entry->username = $this->getString();
				$entry->xboxUserId = $this->getString();
				$entry->platformChatId = $this->getString();
				$entry->buildPlatform = $this->getLInt();
				$entry->skin = $this->getSkin();
				$entry->isTeacher = $this->getBool();
				$entry->isHost = $this->getBool();
                $entry->isSubClient = $this->getBool();
			}else{
				$entry->uuid = $this->getUUID();
			}

			$this->entries[$i] = $entry;
		}
		if($this->type === self::TYPE_ADD){
			for($i = 0; $i < $count; ++$i){
				$verified = $this->getBool();
				$this->entries[$i]->skin->setVerified($verified);
			}
		}
	}

	public function encodePayload(){
		$this->putByte($this->type);
		$this->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			if($this->type === self::TYPE_ADD){
				$this->putUUID($entry->uuid);
				$this->putActorUniqueId($entry->actorUniqueId);
				$this->putString($entry->username);
				$this->putString($entry->xboxUserId);
				$this->putString($entry->platformChatId);
				$this->putLInt($entry->buildPlatform);
				$this->putSkin($entry->skin);
				$this->putBool($entry->isTeacher);
				$this->putBool($entry->isHost);
                $this->putBool($entry->isSubClient);
			}else{
				$this->putUUID($entry->uuid);
			}
		}
		if($this->type === self::TYPE_ADD){
			foreach($this->entries as $entry){
				$this->putBool($entry->skin->isVerified());
			}
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlayerList($this);
	}
}
