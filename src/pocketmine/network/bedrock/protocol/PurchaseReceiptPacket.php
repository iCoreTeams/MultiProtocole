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
use function count;

class PurchaseReceiptPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PURCHASE_RECEIPT_PACKET;

	/** @var string[] */
	public $entries = [];

	public function decodePayload(){
		$count = $this->getUnsignedVarInt();
		for($i = 0; $i < $count; ++$i){
			$this->entries[] = $this->getString();
		}
	}

	public function encodePayload(){
		$this->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$this->putString($entry);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePurchaseReceipt($this);
	}
}
