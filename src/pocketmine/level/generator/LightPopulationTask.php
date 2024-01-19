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

use pocketmine\level\format\Chunk;
use pocketmine\level\Level;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class LightPopulationTask extends AsyncTask{

	public $levelId;
	public $chunk;

	public function __construct(Level $level, Chunk $chunk){
		$this->levelId = $level->getId();
		$this->chunk = $chunk->fastSerialize();
	}

	public function onRun(){
		/** @var Chunk $chunk */
		$chunk = Chunk::fastDeserialize($this->chunk);
		if($chunk === null){
			//TODO error
			return;
		}

		$chunk->recalculateHeightMap();
		$chunk->populateSkyLight();
		$chunk->setLightPopulated();

		$this->chunk = $chunk->fastSerialize();
	}

	public function onCompletion(Server $server){
		$level = $server->getLevel($this->levelId);
		if($level !== null){
			/** @var Chunk $chunk */
			$chunk = Chunk::fastDeserialize($this->chunk);
			if($chunk === null){
				//TODO error
				return;
			}
			$level->generateChunkCallback($chunk->getX(), $chunk->getZ(), $chunk);
		}
	}
}
