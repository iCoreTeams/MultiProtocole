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

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\bedrock\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\NetworkBinaryStream;
use function count;

abstract class TransactionData{

	public const MAX_ACTION_COUNT = 128;

	/** @var NetworkInventoryAction[] */
	protected $actions = [];

	/**
	 * @return NetworkInventoryAction[]
	 */
	final public function getActions() : array{
		return $this->actions;
	}

	/**
	 * @return int
	 */
	abstract public function getTypeId() : int;

	/**
	 * @param InventoryTransactionPacket $packet
	 *
	 * @throws \OutOfBoundsException
	 * @throws \UnexpectedValueException
	 */
	public function decode(InventoryTransactionPacket $packet) : void{
		$actionCount = $packet->getUnsignedVarInt();
		if($actionCount > self::MAX_ACTION_COUNT){
			throw new \UnexpectedValueException("Too big action count: $actionCount");
		}
		for($i = 0; $i < $actionCount; ++$i){
			$this->actions[] = (new NetworkInventoryAction())->read($packet);
		}
		$this->decodeData($packet);
	}

	/**
	 * @param DataPacket $stream
	 *
	 * @throws \OutOfBoundsException
	 * @throws \UnexpectedValueException
	 */
	abstract protected function decodeData(DataPacket $stream) : void;

	public function encode(InventoryTransactionPacket $packet) : void{
		$packet->putUnsignedVarInt(count($this->actions));
		foreach($this->actions as $action){
			$action->write($packet);
		}
		$this->encodeData($packet);
	}

	abstract protected function encodeData(DataPacket $stream) : void;
}
