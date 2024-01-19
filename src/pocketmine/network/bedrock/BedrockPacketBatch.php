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

namespace pocketmine\network\bedrock;

use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\bedrock\protocol\PacketPool;
use pocketmine\network\mcpe\NetworkBinaryStream;
use pocketmine\utils\BinaryDataException;

class BedrockPacketBatch extends NetworkBinaryStream{

	public function putPacket(DataPacket $packet) : void{
		if(!$packet->isEncoded){
			$packet->encode();
		}
		$this->putString($packet->getBuffer());
	}

	/**
	 * @return DataPacket
	 * @throws BinaryDataException
	 */
	public function getPacket() : DataPacket{
		return PacketPool::getPacket($this->getString());
	}

	/**
	 * Constructs a packet batch from the given list of packets.
	 *
	 * @param DataPacket ...$packets
	 *
	 * @return BedrockPacketBatch
	 */
	public static function fromPackets(DataPacket ...$packets) : BedrockPacketBatch{
		$result = new BedrockPacketBatch();
		foreach($packets as $packet){
			$result->putPacket($packet);
		}
		return $result;
	}
}
