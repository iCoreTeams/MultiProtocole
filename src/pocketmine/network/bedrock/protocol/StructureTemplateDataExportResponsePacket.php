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

class StructureTemplateDataExportResponsePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::STRUCTURE_TEMPLATE_DATA_EXPORT_RESPONSE_PACKET;

	/** @var string */
	public $string;
	/** @var bool */
	public $response;
	/** @var string */
	public $namedtag;

	public function decodePayload(){
		$this->string = $this->getString();
		$this->response = $this->getBool();
		if($this->response){
			$this->namedtag = $this->getRemaining();
		}
	}

	public function encodePayload(){
		$this->putString($this->string);
		$this->putBool($this->response);
		if($this->response){
			$this->put($this->namedtag);
		}
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleStructureTemplateDataExportResponse($this);
	}
}
