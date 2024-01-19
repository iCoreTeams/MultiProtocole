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

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>


use pocketmine\network\NetworkSession;

class AddPaintingPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_PAINTING_PACKET;

	/** @var int|null */
	public $entityUniqueId = null; //TODO
	/** @var int */
	public $entityRuntimeId;
	public $x;
	public $y;
	public $z;
	public $direction;
	public $title;

	public function decodePayload(){
		$this->entityUniqueId = $this->getEntityUniqueId();
		$this->entityRuntimeId = $this->getEntityRuntimeId();
		$this->getBlockPosition($this->x, $this->y, $this->z);
		$this->direction = $this->getVarInt();
		$this->title = $this->getString();
	}

	public function encodePayload(){
		$this->putEntityUniqueId($this->entityUniqueId ?? $this->entityRuntimeId);
		$this->putEntityRuntimeId($this->entityRuntimeId);
		$this->putBlockPosition($this->x, $this->y, $this->z);
		$this->putVarInt($this->direction);
		$this->putString($this->title);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleAddPainting($this);
	}

}
