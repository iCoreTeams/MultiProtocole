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

class CorrectPlayerMovePredictionPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CORRECT_PLAYER_MOVE_PREDICTION_PACKET;

	/** @var Vector3 */
	public $position;
	/** @var Vector3 */
	public $delta;
	/** @var bool */
	public $onGround;
	/** @var int */
	public $tick;

	public function decodePayload(){
		$this->position = $this->getVector3();
		$this->delta = $this->getVector3();
		$this->onGround = $this->getBool();
		$this->tick = $this->getUnsignedVarLong();
	}

	public function encodePayload(){
		$this->putVector3($this->position);
		$this->putVector3($this->delta);
		$this->putBool($this->onGround);
		$this->putUnsignedVarLong($this->tick);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCorrectPlayerMovePrediction($this);
	}
}
