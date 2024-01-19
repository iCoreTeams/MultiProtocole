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


use pocketmine\network\bedrock\protocol\types\CommandPermissions;
use pocketmine\network\bedrock\protocol\types\UpdateAbilitiesPacketLayer;
use pocketmine\network\NetworkSession;
use pocketmine\network\bedrock\protocol\types\PlayerPermissions;

/**
 * Updates player abilities and permissions, such as command permissions, flying/noclip, fly speed, walk speed etc.
 * Abilities may be layered in order to combine different ability sets into a resulting set.
 */
class UpdateAbilitiesPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_ABILITIES_PACKET;

	/** @var int */
	public $commandPermission = CommandPermissions::NORMAL;
	/** @var int */
	public $playerPermission = PlayerPermissions::MEMBER;
	/** @var int */
	public $targetActorUniqueId; //This is a little-endian long, NOT a var-long. (WTF Mojang)
	/** @var UpdateAbilitiesPacketLayer[]> */
	public $abilityLayers;

	public function decodePayload(){
		$this->targetActorUniqueId = $this->getLLong(); //WHY IS THIS NON-STANDARD?
		$this->playerPermission = $this->getByte();
		$this->commandPermission = $this->getByte();

		$this->abilityLayers = [];
		for($i = 0, $len = $this->getByte(); $i < $len; $i++){
			$this->abilityLayers[] = UpdateAbilitiesPacketLayer::decode($this);
		}
	}

	public function encodePayload(){
		$this->putLLong($this->targetActorUniqueId);
		$this->putByte($this->playerPermission);
		$this->putByte($this->commandPermission);

		$this->putByte(count($this->abilityLayers));
		foreach($this->abilityLayers as $layer){
			$layer->encode($this);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateAbilities($this);
	}
}
