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

class UpdateSoftEnumPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_SOFT_ENUM_PACKET;

	public const TYPE_ADD = 0;
	public const TYPE_REMOVE = 1;
	public const TYPE_SET = 2;

	/** @var string */
	public $enumName;
	/** @var string[] */
	public $values = [];
	/** @var int */
	public $type;

	public function decodePayload(){
		$this->enumName = $this->getString();
		for($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; ++$i){
			$this->values[] = $this->getString();
		}
		$this->type = $this->getByte();
	}

	public function encodePayload(){
		$this->putString($this->enumName);
		$this->putUnsignedVarInt(count($this->values));
		foreach($this->values as $v){
			$this->putString($v);
		}
		$this->putByte($this->type);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateSoftEnum($this);
	}
}
