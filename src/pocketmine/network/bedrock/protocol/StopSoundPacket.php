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

class StopSoundPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::STOP_SOUND_PACKET;

	/** @var string */
	public $soundName;
	/** @var bool */
	public $stopAll;

	public function decodePayload(){
		$this->soundName = $this->getString();
		$this->stopAll = $this->getBool();
	}

	public function encodePayload(){
		$this->putString($this->soundName);
		$this->putBool($this->stopAll);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleStopSound($this);
	}
}
