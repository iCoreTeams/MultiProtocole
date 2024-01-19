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

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>


use pocketmine\network\NetworkSession;

class MovePlayerPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MOVE_PLAYER_PACKET;

	public const MODE_NORMAL = 0;
	public const MODE_RESET = 1;
	public const MODE_TELEPORT = 2;
	public const MODE_PITCH = 3; //facepalm Mojang

	public $entityRuntimeId;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $bodyYaw;
	public $pitch;
	public $mode = self::MODE_NORMAL;
	public $onGround = false; //TODO
	public $ridingEid = 0;
	public $int1 = 0;
	public $int2 = 0;

	public function decodePayload(){
		$this->entityRuntimeId = $this->getEntityRuntimeId();
		$this->getVector3f($this->x, $this->y, $this->z);
		$this->pitch = $this->getLFloat();
		$this->yaw = $this->getLFloat();
		$this->bodyYaw = $this->getLFloat();
		$this->mode = $this->getByte();
		$this->onGround = $this->getBool();
		$this->ridingEid = $this->getEntityRuntimeId();
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$this->int1 = $this->getLInt();
			$this->int2 = $this->getLInt();
		}
	}

	public function encodePayload(){
		$this->putEntityRuntimeId($this->entityRuntimeId);
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putLFloat($this->pitch);
		$this->putLFloat($this->yaw);
		$this->putLFloat($this->bodyYaw); //TODO
		$this->putByte($this->mode);
		$this->putBool($this->onGround);
		$this->putEntityRuntimeId($this->ridingEid);
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$this->putLInt($this->int1);
			$this->putLInt($this->int2);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMovePlayer($this);
	}

}
