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

class ShowCreditsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SHOW_CREDITS_PACKET;

	public const STATUS_START_CREDITS = 0;
	public const STATUS_END_CREDITS = 1;

	public $playerEid;
	public $status;

	public function decodePayload(){
		$this->playerEid = $this->getEntityRuntimeId();
		$this->status = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putEntityRuntimeId($this->playerEid);
		$this->putVarInt($this->status);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleShowCredits($this);
	}
}