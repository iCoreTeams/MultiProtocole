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
use pocketmine\network\bedrock\protocol\types\CommandOutputMessage;
use function count;

class CommandOutputPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::COMMAND_OUTPUT_PACKET;

	/** @var CommandOriginData */
	public $originData;
	/** @var int */
	public $outputType;
	/** @var int */
	public $successCount;
	/** @var CommandOutputMessage[] */
	public $messages = [];
	/** @var string */
	public $unknownString;

	public function decodePayload(){
		$this->originData = $this->getCommandOriginData();
		$this->outputType = $this->getByte();
		$this->successCount = $this->getUnsignedVarInt();

		for($i = 0, $size = $this->getUnsignedVarInt(); $i < $size; ++$i){
			$this->messages[] = $this->getCommandMessage();
		}

		if($this->outputType === 4){
			$this->unknownString = $this->getString();
		}
	}

	protected function getCommandMessage() : CommandOutputMessage{
		$message = new CommandOutputMessage();

		$message->isInternal = $this->getBool();
		$message->messageId = $this->getString();

		for($i = 0, $size = $this->getUnsignedVarInt(); $i < $size; ++$i){
			$message->parameters[] = $this->getString();
		}

		return $message;
	}

	public function encodePayload(){
		$this->putCommandOriginData($this->originData);
		$this->putByte($this->outputType);
		$this->putUnsignedVarInt($this->successCount);

		$this->putUnsignedVarInt(count($this->messages));
		foreach($this->messages as $message){
			$this->putCommandMessage($message);
		}

		if($this->outputType === 4){
			$this->putString($this->unknownString);
		}
	}

	protected function putCommandMessage(CommandOutputMessage $message) : void{
		$this->putBool($message->isInternal);
		$this->putString($message->messageId);

		$this->putUnsignedVarInt(count($message->parameters));
		foreach($message->parameters as $parameter){
			$this->putString($parameter);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCommandOutput($this);
	}
}
