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
use pocketmine\network\bedrock\protocol\types\CommandOriginData;

class CommandRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::COMMAND_REQUEST_PACKET;

	/** @var string */
	public $command;
	/** @var CommandOriginData */
	public $originData;
	/** @var bool */
	public $isInternal;
	/** @var int */
	public $version;

	public function decodePayload(){
		$this->command = $this->getString();
		$this->originData = $this->getCommandOriginData();
		$this->isInternal = $this->getBool();
		$this->version = $this->getVarInt();
	}

	public function encodePayload(){
		$this->putString($this->command);
		$this->putCommandOriginData($this->originData);
		$this->putBool($this->isInternal);
		$this->putVarInt($this->version);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCommandRequest($this);
	}
}
