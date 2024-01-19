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

class InteractPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::INTERACT_PACKET;

	public const ACTION_LEAVE_VEHICLE = 3;
	public const ACTION_MOUSEOVER = 4;

	public const ACTION_OPEN_INVENTORY = 6;

	/** @var int */
	public $action;
	/** @var int */
	public $actorRuntimeId;

	/** @var float */
	public $x;
	/** @var float */
	public $y;
	/** @var float */
	public $z;

	public function decodePayload(){
		$this->action = $this->getByte();
		$this->actorRuntimeId = $this->getActorRuntimeId();

		if($this->action === self::ACTION_MOUSEOVER){
			//TODO: should this be a vector3?
			$this->x = $this->getLFloat();
			$this->y = $this->getLFloat();
			$this->z = $this->getLFloat();
		}
	}

	public function encodePayload(){
		$this->putByte($this->action);
		$this->putActorRuntimeId($this->actorRuntimeId);

		if($this->action === self::ACTION_MOUSEOVER){
			$this->putLFloat($this->x);
			$this->putLFloat($this->y);
			$this->putLFloat($this->z);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleInteract($this);
	}
}
