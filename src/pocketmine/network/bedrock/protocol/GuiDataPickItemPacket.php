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

class GuiDataPickItemPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::GUI_DATA_PICK_ITEM_PACKET;

	/** @var string */
	public $itemDescription;
	/** @var string */
	public $itemEffects;
	/** @var int */
	public $hotbarSlot;

	public function decodePayload(){
		$this->itemDescription = $this->getString();
		$this->itemEffects = $this->getString();
		$this->hotbarSlot = $this->getLInt();
	}

	public function encodePayload(){
		$this->putString($this->itemDescription);
		$this->putString($this->itemEffects);
		$this->putLInt($this->hotbarSlot);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleGuiDataPickItem($this);
	}
}
