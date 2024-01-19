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

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;

class MountainsBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$trees = new Tree();
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(1);

		$this->addPopulator($tallGrass);

		//TODO: add emerald

		$this->setElevation(63, 127);

		$this->temperature = 0.4;
		$this->rainfall = 0.5;
	}

	public function getName() : string{
		return "Mountains";
	}
}