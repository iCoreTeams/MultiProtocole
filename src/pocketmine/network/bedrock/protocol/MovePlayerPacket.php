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

class MovePlayerPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MOVE_PLAYER_PACKET;

	public const MODE_NORMAL = 0;
	public const MODE_RESET = 1;
	public const MODE_TELEPORT = 2;
	public const MODE_PITCH = 3; //facepalm Mojang

	/** @var int */
	public $actorRuntimeId;
	/** @var Vector3 */
	public $position;
	/** @var float */
	public $pitch;
	/** @var float */
	public $yaw;
	/** @var float */
	public $headYaw;
	/** @var int */
	public $mode = self::MODE_NORMAL;
	/** @var bool */
	public $onGround = false; //TODO
	/** @var int */
	public $ridingEid = 0;
	/** @var int */
	public $teleportCause = 0;
	/** @var int */
	public $teleportItem = 0;
	/** @var int */
	public $tick = 0;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->position = $this->getVector3();
		$this->pitch = $this->getLFloat();
		$this->yaw = $this->getLFloat();
		$this->headYaw = $this->getLFloat();
		$this->mode = $this->getByte();
		$this->onGround = $this->getBool();
		$this->ridingEid = $this->getActorRuntimeId();
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$this->teleportCause = $this->getLInt();
			$this->teleportItem = $this->getLInt();
		}
		$this->tick = $this->getUnsignedVarLong();
	}

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putVector3($this->position);
		$this->putLFloat($this->pitch);
		$this->putLFloat($this->yaw);
		$this->putLFloat($this->headYaw); //TODO
		$this->putByte($this->mode);
		$this->putBool($this->onGround);
		$this->putActorRuntimeId($this->ridingEid);
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$this->putLInt($this->teleportCause);
			$this->putLInt($this->teleportItem);
		}
		$this->putUnsignedVarLong($this->tick);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMovePlayer($this);
	}
}
