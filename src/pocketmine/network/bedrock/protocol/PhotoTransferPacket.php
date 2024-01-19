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

class PhotoTransferPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PHOTO_TRANSFER_PACKET;

	/** @var string */
	public $photoName;
	/** @var string */
	public $photoData;
	/** @var string */
	public $bookId; //photos are stored in a sibling directory to the games folder (screenshots/(some UUID)/bookID/example.png)

	public function decodePayload(){
		$this->photoName = $this->getString();
		$this->photoData = $this->getString();
		$this->bookId = $this->getString();
	}

	public function encodePayload(){
		$this->putString($this->photoName);
		$this->putString($this->photoData);
		$this->putString($this->bookId);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePhotoTransfer($this);
	}
}
