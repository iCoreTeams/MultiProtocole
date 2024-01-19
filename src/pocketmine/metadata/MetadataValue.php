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

namespace pocketmine\metadata;

use pocketmine\plugin\Plugin;

abstract class MetadataValue{
	/** @var Plugin */
	private $owningPlugin;

	protected function __construct(Plugin $owningPlugin){
		$this->owningPlugin = $owningPlugin;
	}

	/**
	 * @return Plugin
	 */
	public function getOwningPlugin(){
		return $this->owningPlugin;
	}

	/**
	 * Fetches the value of this metadata item.
	 *
	 * @return mixed
	 */
	abstract public function value();

	/**
	 * Invalidates this metadata item, forcing it to recompute when next
	 * accessed.
	 */
	abstract public function invalidate();
}