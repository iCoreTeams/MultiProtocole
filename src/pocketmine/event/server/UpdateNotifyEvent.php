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

namespace pocketmine\event\server;

use pocketmine\updater\AutoUpdater;

/**
 * Called when the AutoUpdater receives notification of an available PocketMine-MP update.
 * Plugins may use this event to perform actions when an update notification is received.
 */
class UpdateNotifyEvent extends ServerEvent{
	public static $handlerList = null;

	/** @var AutoUpdater */
	private $updater;

	public function __construct(AutoUpdater $updater){
		$this->updater = $updater;
	}

	public function getUpdater() : AutoUpdater{
		return $this->updater;
	}
}