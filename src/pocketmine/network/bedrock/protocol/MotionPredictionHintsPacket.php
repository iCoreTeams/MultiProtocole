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


use pocketmine\math\Vector3;
use pocketmine\network\NetworkSession;

class MotionPredictionHintsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MOTION_PREDICTION_HINTS_PACKET;

	/** @var int */
	public $actorRuntimeId;
	/** @var Vector3 */
	public $motion;
	/** @var bool */
	public $onGround;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->motion = $this->getVector3();
		$this->onGround = $this->getBool();
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putVector3($this->motion);
		$this->putBool($this->onGround);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCameraShake($this);
	}
}
