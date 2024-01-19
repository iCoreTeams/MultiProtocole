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

namespace pocketmine\network\bedrock\protocol\types\itemStack;

use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\bedrock\protocol\ItemStackRequestPacket;

class SwapStackRequestAction extends TransferStackRequestAction{

	/** @var StackRequestSlotInfo */
	protected $source;
	/** @var StackRequestSlotInfo */
	protected $destination;

	/**
	 * @return StackRequestSlotInfo
	 */
	public function getSource() : StackRequestSlotInfo{
		return $this->source;
	}

	/**
	 * @return StackRequestSlotInfo
	 */
	public function getDestination() : StackRequestSlotInfo{
		return $this->destination;
	}

	public function getActionId() : int{
		return ItemStackRequestPacket::ACTION_SWAP;
	}

	public function decode(DataPacket $stream) : void{
		$this->source = $stream->getStackRequestSlotInfo();
		$this->destination = $stream->getStackRequestSlotInfo();
	}

	public function encode(DataPacket $stream) : void{
		$stream->putStackRequestSlotInfo($this->source);
		$stream->putStackRequestSlotInfo($this->destination);
	}
}