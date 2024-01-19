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

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\mcpe\NetworkBinaryStream;
use pocketmine\network\bedrock\protocol\InventoryTransactionPacket;
use function count;

class MismatchTransactionData extends TransactionData{

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_MISMATCH;
	}

	protected function decodeData(DataPacket $stream) : void{
		if(!empty($this->actions)){
			throw new \UnexpectedValueException("Mismatch transaction type should not have any actions associated with it, but got " . count($this->actions));
		}
	}

	protected function encodeData(DataPacket $stream) : void{

	}

	public static function new() : self{
		return new self; //no arguments
	}
}
