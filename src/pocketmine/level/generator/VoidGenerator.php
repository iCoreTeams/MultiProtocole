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

namespace pocketmine\level\generator;

use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

use function count;
use function explode;
use function preg_match_all;
use function str_replace;

class VoidGenerator extends Generator{
	/** @var ChunkManager */
	private $level;
	/** @var ?Chunk */
	private $chunk;

	public function getSettings() : array{
		return [];
	}

	public function getName() : string{
		return "void";
	}

	public function __construct(array $options = []){

	}

	public function init(ChunkManager $level, Random $random){
		$this->level = $level;
	}

	public function generateChunk(int $chunkX, int $chunkZ){
		if($this->chunk === null){
			$this->chunk = new Chunk($chunkX, $chunkZ);
			$this->chunk->setGenerated();
		}
		$chunk = clone $this->chunk;
		$chunk->setX($chunkX);
		$chunk->setZ($chunkZ);
		$this->level->setChunk($chunkX, $chunkZ, $chunk);
	}

	public function populateChunk(int $chunkX, int $chunkZ){

	}

	public function getSpawn() : Vector3{
		return new Vector3(0, 128, 0);
	}
}