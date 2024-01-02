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

use InvalidArgumentException;
use pocketmine\network\NetworkSession;
use function gettype;
use function is_bool;
use function is_float;

class RequestAbilityPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::REQUEST_ABILITY_PACKET;

	private const VALUE_TYPE_BOOL = 1;
	private const VALUE_TYPE_FLOAT = 2;

	public const ABILITY_FLYING = 9;
	public const ABILITY_NOCLIP = 17;

	/** @var int */
	public $abilityId;
	/** @var float|bool */
	public $abilityValue;

	public function decodePayload(){
		$this->abilityId = $this->getVarInt();

		$valueType = $this->getByte();

		//what is the point of having a type ID if you just write all the types anyway ??? mojang ...
		//only one of these values is ever used; the other(s) are discarded
		$boolValue = $this->getBool();
		$floatValue = $this->getLFloat();

		if($valueType === self::VALUE_TYPE_BOOL){
			$this->abilityValue = $boolValue;
		}elseif($valueType === self::VALUE_TYPE_FLOAT){
			$this->abilityValue = $floatValue;
		}else{
			throw new InvalidArgumentException("Unknown ability value type $valueType");
		}
	}

	public function encodePayload(){
		$this->putVarInt($this->abilityId);

		if(is_bool($this->abilityValue)){
			$valueType = self::VALUE_TYPE_BOOL;
			$boolValue = $this->abilityValue;
			$floatValue = 0.0;
		}elseif(is_float($this->abilityValue)){
			$valueType = self::VALUE_TYPE_FLOAT;
			$boolValue = false;
			$floatValue = $this->abilityValue;
		}else{
			throw new InvalidArgumentException("Unknown ability value type " . gettype($this->abilityValue));
		}

		$this->putByte($valueType);
		$this->putBool($boolValue);
		$this->putLFloat($floatValue);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleRequestAbility($this);
	}
}
