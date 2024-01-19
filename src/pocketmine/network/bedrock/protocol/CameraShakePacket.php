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

class CameraShakePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CAMERA_SHAKE_PACKET;

	public const TYPE_POSITIONAL = 0;
	public const TYPE_ROTATIONAL = 1;

	public const ACTION_ADD = 0;
	public const ACTION_STOP = 1;

	/** @var float */
	public $intensity;
	/** @var float */
	public $duration;
	/** @var int */
	public $shakeType;
	/** @var int */
	public $shakeAction;

	public function decodePayload(){
		$this->intensity = $this->getLFloat();
		$this->duration = $this->getLFloat();
		$this->shakeType = $this->getByte();
		$this->shakeAction = $this->getByte();
	}

	public function encodePayload(){
		$this->putLFloat($this->intensity);
		$this->putLFloat($this->duration);
		$this->putByte($this->shakeType);
		$this->putByte($this->shakeAction);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCameraShake($this);
	}
}
