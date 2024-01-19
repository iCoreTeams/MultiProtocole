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


use pocketmine\item\Item;
use pocketmine\network\NetworkSession;

class DropItemPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::DROP_ITEM_PACKET;

	public $type;
	/** @var Item */
	public $item;

	public function decodePayload(){
		$this->type = $this->getByte();
		$this->item = $this->getSlot();
	}

	public function encodePayload(){
		$this->putByte($this->type);
		$this->putSlot($this->item);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleDropItem($this);
	}

}
