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
use pocketmine\resourcepacks\ResourcePack;
use function count;

class ResourcePacksInfoPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACKS_INFO_PACKET;

	/** @var bool */
	public $mustAccept = false; //if true, forces client to choose between accepting packs or being disconnected
    /** @var bool */
	public $hasScripts = false; //if true, causes disconnect for any platform that doesn't support scripts yet
    /** @var bool */
	public $forceServerPacks = false;
	/** @var ResourcePack[] */
	public $behaviorPackEntries = [];
	/** @var ResourcePack[] */
	public $resourcePackEntries = [];
	public $cdnUrls = [];

	public function decodePayload(){
		$this->mustAccept = $this->getBool();
		$this->hasScripts = $this->getBool();
        $this->forceServerPacks = $this->getBool();
        $behaviorPackCount = $this->getLShort();
		while($behaviorPackCount-- > 0){
			$this->getString();
			$this->getString();
			$this->getLLong();
			$this->getString();
			$this->getString();
			$this->getString();
			$this->getBool();
		}

		$resourcePackCount = $this->getLShort();
		while($resourcePackCount-- > 0){
			$this->getString();
			$this->getString();
			$this->getLLong();
			$this->getString();
			$this->getString();
			$this->getString();
			$this->getBool();
			$this->getBool();
		}

		$this->cdnUrls = [];

        for ($i = 0, $count = $this->getUnsignedVarInt(); $i < $count; $i++) {
            $packId = $this->getString();
            $cdnUrl = $this->getString();
            $this->cdnUrls[$packId] = $cdnUrl;
        }
	}

	public function encodePayload(){
		$this->putBool($this->mustAccept);
		$this->putBool($this->hasScripts);
        $this->putBool($this->forceServerPacks);
        $this->putLShort(count($this->behaviorPackEntries));
		foreach($this->behaviorPackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getPackVersion());
			$this->putLLong($entry->getPackSize());
			$this->putString(""); //TODO: encryption key
			$this->putString(""); //TODO: subpack name
			$this->putString(""); //TODO: content identity
			$this->putBool(false); //TODO: has scripts (?)
		}
		$this->putLShort(count($this->resourcePackEntries));
		foreach($this->resourcePackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getPackVersion());
			$this->putLLong($entry->getPackSize());
			$this->putString(""); //TODO: encryption key
			$this->putString(""); //TODO: subpack name
			$this->putString(""); //TODO: content identity
			$this->putBool(false); //TODO: seems useless for resource packs
			$this->putBool(false); //TODO: supports RTX
		}
		$this->putUnsignedVarInt(count($this->cdnUrls));
        foreach ($this->cdnUrls as $packId => $cdnUrl) {
            $this->putString($packId);
            $this->putString($cdnUrl);
        }
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleResourcePacksInfo($this);
	}
}
