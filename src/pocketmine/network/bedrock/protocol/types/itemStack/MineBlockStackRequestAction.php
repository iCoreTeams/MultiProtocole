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

class MineBlockStackRequestAction extends StackRequestAction{

	/** @var int */
	protected $unknown1;
	/** @var int */
	protected $predictedDurability;
	/** @var int */
	protected $stackId;

	/**
	 * @return int
	 */
	public function getUnknown1() : int{
		return $this->unknown1;
	}

	/**
	 * @return int
	 */
	public function getPredictedDurability() : int{
		return $this->predictedDurability;
	}

	/**
	 * @return int
	 */
	public function getStackId() : int{
		return $this->stackId;
	}

	public function getActionId() : int{
		return ItemStackRequestPacket::ACTION_MINE_BLOCK;
	}

	public function decode(DataPacket $stream) : void{
		$this->unknown1 = $stream->getVarInt();
		$this->predictedDurability = $stream->getVarInt();
		$this->stackId = $stream->getVarInt();
	}

	public function encode(DataPacket $stream) : void{
		$stream->putVarInt($this->unknown1);
		$stream->putVarInt($this->predictedDurability);
		$stream->putVarInt($this->stackId);
	}
}