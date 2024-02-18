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

use pocketmine\item\Item;


/**
 * Air block
 */
class Air extends Transparent{

	protected $id = self::AIR;
	protected $meta = 0;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Air";
	}

	public function isBreakable(Item $item){
		return false;
	}

	public function canBeFlowedInto(){
		return true;
	}

	public function canBeReplaced(){
		return true;
	}

	public function canBePlaced(){
		return false;
	}

	public function isSolid(){
		return false;
	}

	public function getBoundingBox(){
		return null;
	}

	public function getCollisionBoxes() : array{
		return [];
	}

    protected function recalculateCollisionBoxes() : array{
        return [];
    }

	public function getHardness(){
		return -1;
	}

	public function getBlastResistance() : float{
		return 0;
	}

}