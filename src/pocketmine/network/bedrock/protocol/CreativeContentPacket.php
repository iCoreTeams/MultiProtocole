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

use pocketmine\network\bedrock\protocol\types\inventory\CreativeItem;
use pocketmine\network\NetworkSession;
use function count;

class CreativeContentPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CREATIVE_CONTENT_PACKET;

	/** @var CreativeItem[] */
	public $items = [];

	public function decodePayload(){
		for($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; ++$i){
			$this->items[] = $this->getCreativeItem();
		}
	}

	public function encodePayload(){
		$this->putUnsignedVarInt(count($this->items));
		foreach($this->items as $item){
			$this->putCreativeItem($item);
		}
	}

	protected function getCreativeItem() : CreativeItem{
		$creativeItem = new CreativeItem();
		$creativeItem->creativeItemNetworkId = $this->getUnsignedVarInt();
		$creativeItem->item = $this->getItemStackWithoutStackId();
		return $creativeItem;
	}

	protected function putCreativeItem(CreativeItem $creativeItem) : void{
		$this->putUnsignedVarInt($creativeItem->creativeItemNetworkId);
		$this->putItemStackWithoutStackId($creativeItem->item);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleCreativeContent($this);
	}
}