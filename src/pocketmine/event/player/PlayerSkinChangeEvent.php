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

namespace pocketmine\event\player;

use pocketmine\entity\Skin;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerSkinChangeEvent extends PlayerEvent implements Cancellable{
	public static $handlerList;

	/** @var Skin */
	protected $oldSkin;
	/** @var Skin */
	protected $newSkin;

	public function __construct(Player $player, Skin $oldSkin, Skin $newSkin){
		$this->player = $player;
		$this->oldSkin = $oldSkin;
		$this->newSkin = $newSkin;
	}

	/**
	 * @return Skin
	 */
	public function getOldSkin() : Skin{
		return $this->oldSkin;
	}

	/**
	 * @return Skin
	 */
	public function getNewSkin() : Skin{
		return $this->newSkin;
	}

	/**
	 * @param Skin $newSkin
	 */
	public function setNewSkin(Skin $newSkin) : void{
		$this->newSkin = $newSkin;
	}
}