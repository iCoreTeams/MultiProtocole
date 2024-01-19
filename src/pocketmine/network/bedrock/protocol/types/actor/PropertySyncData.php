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

namespace pocketmine\network\bedrock\protocol\types\actor;

use pocketmine\network\bedrock\protocol\DataPacket;

class PropertySyncData{

	/** @var int */
	public $intProperties = [];
	/** @var float */
	public $floatProperties = [];

	public function __construct(array $intProperties = [], array $floatProperties = []){
		$this->intProperties = $intProperties;
		$this->floatProperties = $floatProperties;
	}

	public static function read(DataPacket $pk) : self{
		$result = new self;
		for($i = 0, $count = $pk->getUnsignedVarInt(); $i < $count; ++$i){
			$result->intProperties[$pk->getUnsignedVarInt()] = $pk->getVarInt();
		}
		for($i = 0, $count = $pk->getUnsignedVarInt(); $i < $count; ++$i){
			$result->floatProperties[$pk->getUnsignedVarInt()] = $pk->getLFloat();
		}
		return $result;
	}

	public function write(DataPacket $pk) : void{
		$pk->putUnsignedVarInt(count($this->intProperties));
		foreach($this->intProperties as $key => $value){
			$pk->putUnsignedVarInt($key);
			$pk->putVarInt($value);
		}
		$pk->putUnsignedVarInt(count($this->floatProperties));
		foreach($this->floatProperties as $key => $value){
			$pk->putUnsignedVarInt($key);
			$pk->putLFloat($value);
		}
	}
}