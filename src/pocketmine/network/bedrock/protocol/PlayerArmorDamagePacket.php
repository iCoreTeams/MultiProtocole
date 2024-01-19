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

class PlayerArmorDamagePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_ARMOR_DAMAGE_PACKET;

	public const FLAG_HELMET = 0b0001;
	public const FLAG_CHESTPLATE = 0b0010;
	public const FLAG_LEGGINGS = 0b0100;
	public const FLAG_BOOTS = 0b1000;

	/** @var int */
	public $helmetDamage = 0;
	/** @var int */
	public $chestplateDamage = 0;
	/** @var int */
	public $leggingsDamage = 0;
	/** @var int */
	public $bootsDamage = 0;

	public function decodePayload(){
		$flags = $this->getByte();

		if($flags & self::FLAG_HELMET > 0){
			$this->helmetDamage = $this->getVarInt();
		}
		if($flags & self::FLAG_CHESTPLATE > 0){
			$this->chestplateDamage = $this->getVarInt();
		}
		if($flags & self::FLAG_LEGGINGS > 0){
			$this->leggingsDamage = $this->getVarInt();
		}
		if($flags & self::FLAG_BOOTS > 0){
			$this->bootsDamage = $this->getVarInt();
		}
	}

	public function encodePayload(){
		$flags = 0;

		if($this->helmetDamage !== 0){
			$flags |= self::FLAG_HELMET;
		}
		if($this->chestplateDamage !== 0){
			$flags |= self::FLAG_CHESTPLATE;
		}
		if($this->leggingsDamage !== 0){
			$flags |= self::FLAG_LEGGINGS;
		}
		if($this->bootsDamage !== 0){
			$flags |= self::FLAG_BOOTS;
		}

		$this->putByte($flags);

		if($this->helmetDamage !== 0){
			$this->putVarInt($this->helmetDamage);
		}
		if($this->chestplateDamage !== 0){
			$this->putVarInt($this->chestplateDamage);
		}
		if($this->leggingsDamage !== 0){
			$this->putVarInt($this->leggingsDamage);
		}
		if($this->bootsDamage !== 0){
			$this->putVarInt($this->bootsDamage);
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlayerArmorDamage($this);
	}
}