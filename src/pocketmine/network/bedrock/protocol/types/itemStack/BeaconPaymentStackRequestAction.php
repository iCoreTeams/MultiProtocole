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

class BeaconPaymentStackRequestAction extends StackRequestAction{

	/** @var int */
	protected $primaryEffect;
	/** @var int */
	protected $secondaryEffect;

	/**
	 * @return int
	 */
	public function getPrimaryEffect() : int{
		return $this->primaryEffect;
	}

	/**
	 * @return int
	 */
	public function getSecondaryEffect() : int{
		return $this->secondaryEffect;
	}

	public function getActionId() : int{
		return ItemStackRequestPacket::ACTION_BEACON_PAYMENT;
	}

	public function decode(DataPacket $stream) : void{
		$this->primaryEffect = $stream->getVarInt();
		$this->secondaryEffect = $stream->getVarInt();
	}

	public function encode(DataPacket $stream) : void{
		$stream->putVarInt($this->primaryEffect);
		$stream->putVarInt($this->secondaryEffect);
	}
}