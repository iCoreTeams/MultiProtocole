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

class BlockEntityDataPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::BLOCK_ENTITY_DATA_PACKET;

	public $x;
	public $y;
	public $z;
	public $namedtag;

	public function decodePayload(){
		$this->getBlockPosition($this->x, $this->y, $this->z);
		$this->namedtag = $this->getRemaining();
	}

	public function encodePayload(){
		$this->putBlockPosition($this->x, $this->y, $this->z);
		$this->put($this->namedtag);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleBlockEntityData($this);
	}

}
