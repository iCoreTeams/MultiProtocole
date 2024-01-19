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

namespace pocketmine\inventory;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;
use pocketmine\network\bedrock\protocol\ContainerClosePacket as BedrockContainerClose;
use pocketmine\Player;
use pocketmine\BedrockPlayer;

abstract class ContainerInventory extends BaseInventory{

	public function onOpen(Player $who){
		parent::onOpen($who);

		$pk = new ContainerOpenPacket();
		$pk->windowId = $who->getWindowId($this);
		$pk->type = $this->getType()->getNetworkType();
		$holder = $this->getHolder();
		if($holder instanceof Vector3){
			$pk->x = $holder->getX();
			$pk->y = $holder->getY();
			$pk->z = $holder->getZ();
		}else{
			$pk->x = $pk->y = $pk->z = 0;
		}

		$who->sendDataPacket($pk);

		$this->sendContents($who);
	}

	public function onClose(Player $who){
		if($who instanceof BedrockPlayer){
			$pk = new BedrockContainerClose();
			$pk->windowId = $who->getWindowId($this);
			$pk->server = $who->getClientClosingWindowId() !== $pk->windowId;
			$who->sendDataPacket($pk);
		}else{
			$pk = new ContainerClosePacket();
			$pk->windowId = $who->getWindowId($this);
			$who->sendDataPacket($pk);
		}

		parent::onClose($who);
	}
}