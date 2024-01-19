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
use pocketmine\network\mcpe\protocol\types\WindowTypes;

class UpdateTradePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_TRADE_PACKET;

	//TODO: find fields
	public $windowId;
	public $windowType = WindowTypes::TRADING; //Mojang hardcoded this -_-
	public $varint1;
	public $varint2;
	public $isWilling;
	public $traderEid;
	public $playerEid;
	public $displayName;
	public $offers;

	public function decodePayload(){
		$this->windowId = $this->getByte();
		$this->windowType = $this->getByte();
		$this->varint1 = $this->getVarInt();
		$this->varint2 = $this->getVarInt();
		$this->isWilling = $this->getBool();
		$this->traderEid = $this->getEntityUniqueId();
		$this->playerEid = $this->getEntityUniqueId();
		$this->displayName = $this->getString();
		$this->offers = $this->getRemaining();
	}

	public function encodePayload(){
		$this->putByte($this->windowId);
		$this->putByte($this->windowType);
		$this->putVarInt($this->varint1);
		$this->putVarInt($this->varint2);
		$this->putBool($this->isWilling);
		$this->putEntityUniqueId($this->traderEid);
		$this->putEntityUniqueId($this->playerEid);
		$this->putString($this->displayName);
		$this->put($this->offers);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateTrade($this);
	}
}