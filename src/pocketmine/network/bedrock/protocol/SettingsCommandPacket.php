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

class SettingsCommandPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SETTINGS_COMMAND_PACKET;

	/** @var string */
	public $commandString;
	/** @var bool */
	public $supressOutput;

	public function decodePayload(){
		$this->commandString = $this->getString();
		$this->supressOutput = $this->getBool();
	}

	public function encodePayload(){
		$this->putString($this->commandString);
		$this->putBool($this->supressOutput);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSettingsCommand($this);
	}
}