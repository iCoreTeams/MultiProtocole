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

class BlockPickRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::BLOCK_PICK_REQUEST_PACKET;

	public $tileX;
	public $tileY;
	public $tileZ;
	public $hotbarSlot;

	public function decodePayload(){
		$this->getSignedBlockPosition($this->tileX, $this->tileY, $this->tileZ);
		$this->hotbarSlot = $this->getByte();
	}

	public function encodePayload(){
		$this->putSignedBlockPosition($this->tileX, $this->tileY, $this->tileZ);
		$this->putByte($this->hotbarSlot);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleBlockPickRequest($this);
	}
}