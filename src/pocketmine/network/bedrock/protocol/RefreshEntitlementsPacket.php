<?php

/** 
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

use pocketmine\network\NetworkSession;

class RefreshEntitlementsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::REFRESH_ENTITLEMENTS_PACKET;

	public function decodePayload() : void{
		//NOOP
	}

	public function encodePayload() : void{
		//NOOP
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleRefreshEntitlements($this);
	}
}