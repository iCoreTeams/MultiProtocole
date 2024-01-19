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

class PlaySoundPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAY_SOUND_PACKET;

	/** @var string */
	public $soundName;
	/** @var float */
	public $x;
	/** @var float */
	public $y;
	/** @var float */
	public $z;
	/** @var float */
	public $volume;
	/** @var float */
	public $pitch;

	public function decodePayload(){
		$this->soundName = $this->getString();
		$this->getBlockPosition($this->x, $this->y, $this->z);
		$this->x /= 8;
		$this->y /= 8;
		$this->z /= 8;
		$this->volume = $this->getLFloat();
		$this->pitch = $this->getLFloat();
	}

	public function encodePayload(){
		$this->putString($this->soundName);
		$this->putBlockPosition((int) ($this->x * 8), (int) ($this->y * 8), (int) ($this->z * 8));
		$this->putLFloat($this->volume);
		$this->putLFloat($this->pitch);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlaySound($this);
	}
}
