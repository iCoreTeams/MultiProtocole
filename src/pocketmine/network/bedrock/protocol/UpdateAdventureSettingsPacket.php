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

/**
 * Updates "adventure settings". In vanilla, these flags apply to the whole world. This differs from abilities, which
 * apply only to the local player itself.
 * In practice, there's no difference between the two for a custom server.
 * This includes flags such as worldImmutable (makes players unable to build), autoJump, showNameTags, noPvM, and noMvP.
 */
class UpdateAdventureSettingsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_ADVENTURE_SETTINGS_PACKET;

	/** @var bool */
	public $noAttackingMobs;
	/** @var bool */
	public $noAttackingPlayers;
	/** @var bool */
	public $worldImmutable;
	/** @var bool */
	public $showNameTags;
	/** @var bool */
	public $autoJump;

	public function decodePayload(){
		$this->noAttackingMobs = $this->getBool();
		$this->noAttackingPlayers = $this->getBool();
		$this->worldImmutable = $this->getBool();
		$this->showNameTags = $this->getBool();
		$this->autoJump = $this->getBool();
	}

	public function encodePayload(){
		$this->putBool($this->noAttackingMobs);
		$this->putBool($this->noAttackingPlayers);
		$this->putBool($this->worldImmutable);
		$this->putBool($this->showNameTags);
		$this->putBool($this->autoJump);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleUpdateAdventureSettings($this);
	}
}
