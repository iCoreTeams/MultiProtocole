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

use pocketmine\network\bedrock\protocol\types\StructureSettings;
use pocketmine\network\NetworkSession;

class StructureTemplateDataExportRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::STRUCTURE_TEMPLATE_DATA_EXPORT_REQUEST_PACKET;

	/** @var string */
	public $string;
	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var StructureSettings */
	public $structureSettings;
	/** @var int */
	public $byte;

	public function decodePayload(){
		$this->string = $this->getString();
		$this->getBlockPosition($this->x, $this->y, $this->z);
		$this->structureSettings = $this->getStructureSettings();
		$this->byte = $this->getByte();
	}

	public function encodePayload(){
		$this->putString($this->string);
		$this->putBlockPosition($this->x, $this->y, $this->z);
		$this->putStructureSettings($this->structureSettings);
		$this->putByte($this->byte);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleStructureTemplateDataExportRequest($this);
	}
}
