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

use pocketmine\item\Item;
use pocketmine\network\bedrock\protocol\types\inventory\ItemInstance;
use pocketmine\network\NetworkSession;
use pocketmine\utils\UUID;
use function count;

class CraftingEventPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CRAFTING_EVENT_PACKET;

	/** @var int */
	public $windowId;
	/** @var int */
	public $type;
	/** @var UUID */
	public $id;
	/** @var ItemInstance[] */
	public $input = [];
	/** @var ItemInstance[] */
	public $output = [];

	public function decodePayload(){
		$this->windowId = $this->getByte();
		$this->type = $this->getVarInt();
		$this->id = $this->getUUID();

		$size = $this->getUnsignedVarInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			$this->input[] = $this->getItemInstance();
		}

		$size = $this->getUnsignedVarInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			$this->output[] = $this->getItemInstance();
		}
	}

	public function encodePayload(){
		$this->putByte($this->windowId);
		$this->putVarInt($this->type);
		$this->putUUID($this->id);

		$this->putUnsignedVarInt(count($this->input));
		foreach($this->input as $item){
			$this->putItemInstance($item);
		}

		$this->putUnsignedVarInt(count($this->output));
		foreach($this->output as $item){
			$this->putItemInstance($item);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCraftingEvent($this);
	}
}
