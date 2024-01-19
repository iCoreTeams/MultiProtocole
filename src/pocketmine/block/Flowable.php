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

namespace pocketmine\block;

abstract class Flowable extends Transparent{

	public function canBeFlowedInto(){
		return true;
	}

	public function getHardness(){
		return 0;
	}

	public function getBlastResistance() : float{
		return 0;
	}

	public function isSolid(){
		return false;
	}

	protected function recalculateBoundingBox(){
		return null;
	}
}