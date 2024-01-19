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

use pocketmine\network\NetworkSession;

class SetDisplayObjectivePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SET_DISPLAY_OBJECTIVE_PACKET;

	/** @var string */
	public $displaySlot;
	/** @var string */
	public $objectiveName;
	/** @var string */
	public $displayName;
	/** @var string */
	public $criteriaName;
	/** @var int */
	public $sortOrder;

	public function decodePayload(){
		$this->displaySlot = $this->getString();
		$this->objectiveName = $this->getString();
		$this->displayName = $this->getString();
		$this->criteriaName = $this->getString();
		$this->sortOrder = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putString($this->displaySlot);
		$this->putString($this->objectiveName);
		$this->putString($this->displayName);
		$this->putString($this->criteriaName);
		$this->putVarInt($this->sortOrder);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSetDisplayObjective($this);
	}
}
