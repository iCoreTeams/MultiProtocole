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

class NpcRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::NPC_REQUEST_PACKET;

    public const REQUEST_SET_ACTIONS = 0;
    public const REQUEST_EXECUTE_ACTION = 1;
    public const REQUEST_EXECUTE_CLOSING_COMMANDS = 2;
    public const REQUEST_SET_NAME = 3;
    public const REQUEST_SET_SKIN = 4;
    public const REQUEST_SET_INTERACTION_TEXT = 5;
    public const REQUEST_EXECUTE_OPENING_COMMANDS = 6; // v448+

	/** @var int */
	public $actorRuntimeId;
	/** @var int */
	public $requestType;
	/** @var string */
	public $commandString;
	/** @var int */
	public $actionType;
    /** @var string */
    public $sceneName;

	public function decodePayload(){
		$this->actorRuntimeId = $this->getActorRuntimeId();
		$this->requestType = $this->getByte();
		$this->commandString = $this->getString();
		$this->actionType = $this->getByte();
        $this->sceneName = $this->getString();
    }

	public function encodePayload(){
		$this->putActorRuntimeId($this->actorRuntimeId);
		$this->putByte($this->requestType);
		$this->putString($this->commandString);
		$this->putByte($this->actionType);
        $this->putString($this->sceneName);
    }

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleNpcRequest($this);
	}
}
