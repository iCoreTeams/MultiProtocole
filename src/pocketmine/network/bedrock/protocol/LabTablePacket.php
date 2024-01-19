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

class LabTablePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::LAB_TABLE_PACKET;

	/** @var int */
	public $uselessByte; //0 for client -> server, 1 for server -> client. Seems useless.

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;

	/** @var int */
	public $reactionType;

	public function decodePayload(){
		$this->uselessByte = $this->getByte();
		$this->getSignedBlockPosition($this->x, $this->y, $this->z);
		$this->reactionType = $this->getByte();
	}

	public function encodePayload(){
		$this->putByte($this->uselessByte);
		$this->putSignedBlockPosition($this->x, $this->y, $this->z);
		$this->putByte($this->reactionType);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleLabTable($this);
	}
}
