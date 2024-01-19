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

class CreateStackRequestAction extends StackRequestAction{

	/** @var int */
	protected $resultsSlot;

	/**
	 * @return int
	 */
	public function getResultsSlot() : int{
		return $this->resultsSlot;
	}

	public function getActionId() : int{
		return ItemStackRequestPacket::ACTION_CREATE;
	}

	public function decode(DataPacket $stream) : void{
		$this->resultsSlot = $stream->getByte();
	}

	public function encode(DataPacket $stream) : void{
		$stream->putByte($this->resultsSlot);
	}
}