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

namespace pocketmine\level\generator\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\biome\Biome;
use pocketmine\utils\Random;

use function count;
use function min;
use function ord;

class GroundCover extends Populator{

	public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random){
		$chunk = $level->getChunk($chunkX, $chunkZ);
		for($x = 0; $x < 16; ++$x){
			for($z = 0; $z < 16; ++$z){
				$biome = Biome::getBiome($chunk->getBiomeId($x, $z));
				$cover = $biome->getGroundCover();
				if(count($cover) > 0){
					$diffY = 0;
					if(!$cover[0]->isSolid()){
						$diffY = 1;
					}

					$column = $chunk->getBlockIdColumn($x, $z);
					for($y = 127; $y > 0; --$y){
						if($column[$y] !== "\x00" and !Block::get(ord($column[$y]))->isTransparent()){
							break;
						}
					}
					$startY = min(127, $y + $diffY);
					$endY = $startY - count($cover);
					for($y = $startY; $y > $endY and $y >= 0; --$y){
						$b = $cover[$startY - $y];
						if($column[$y] === "\x00" and $b->isSolid()){
							break;
						}
						if($b->getDamage() === 0){
							$chunk->setBlockId($x, $y, $z, $b->getId());
						}else{
							$chunk->setBlock($x, $y, $z, $b->getId(), $b->getDamage());
						}
					}
				}
			}
		}
	}
}