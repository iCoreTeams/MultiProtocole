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

class FilterTextPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::FILTER_TEXT_PACKET;

	/** @var string */
	public $text;
	/** @var bool */
	public $fromServer;

	public function decodePayload(){
		$this->text = $this->getString();
		$this->fromServer = $this->getBool();
	}

	public function encodePayload(){
		$this->putString($this->text);
		$this->putBool($this->fromServer);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleFilterText($this);
	}
}
