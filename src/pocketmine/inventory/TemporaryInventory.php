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

namespace pocketmine\inventory;

use pocketmine\Player;

abstract class TemporaryInventory extends ContainerInventory{
	//TODO

	abstract public function getResultSlotIndex();


	public function onClose(Player $who){
		foreach($this->getContents() as $slot => $item){
			if($slot === $this->getResultSlotIndex()){
				//Do not drop the item in the result slot - it is a virtual item and does not actually exist.
				continue;
			}
			$who->dropItem($item);
		}
		$this->clearAll();
	}
}