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

class MultiplayerSettingsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::MULTIPLAYER_SETTINGS_PACKET;

	public const MODE_ENABLE = 0;
	public const MODE_DISABLE = 1;
	public const MODE_JOIN_CODE = 2;

	/** @var int */
	public $mode;

	public function decodePayload(){
		$this->mode = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putVarInt($this->mode);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleMultiplayerSettings($this);
	}
}