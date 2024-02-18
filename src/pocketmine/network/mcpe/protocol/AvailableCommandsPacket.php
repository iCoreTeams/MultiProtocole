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

use InvalidArgumentException;
use pocketmine\network\NetworkSession;
use function gettype;
use function is_array;

class AvailableCommandsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::AVAILABLE_COMMANDS_PACKET;

	/** @var array */
	public $commandData;
	/** @var string */
	public $unknown = "";

	public function decodePayload(){
		$this->commandData = $this->getJson();
		if(!is_array($this->commandData)){
			throw new InvalidArgumentException("Commands expected to be array, got " . gettype($this->commands));
		}
		$this->unknown = $this->getString();
	}

	public function encodePayload(){
		$this->putJson($this->commandData);
		$this->putString($this->unknown);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAvailableCommands($this);
	}

}