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

use pocketmine\network\bedrock\protocol\types\itemStack\ItemStackRequest;
use pocketmine\network\NetworkSession;
use function count;

class ItemStackRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ITEM_STACK_REQUEST_PACKET;

	/** @var ItemStackRequest[] */
	public $requests;

	public function decodePayload(){
		for($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; ++$i){
			$request = new ItemStackRequest();
			$request->read($this);
			$this->requests[] = $request;
		}
	}

	public function encodePayload(){
		$this->putUnsignedVarInt(count($this->requests));
		foreach($this->requests as $request){
			$request->write($this);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleItemStackRequest($this);
	}
}