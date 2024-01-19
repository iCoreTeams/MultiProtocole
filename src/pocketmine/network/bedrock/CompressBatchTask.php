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

namespace pocketmine\network\bedrock;

use pocketmine\network\CompressBatchPromise;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class CompressBatchTask extends AsyncTask{

	/** @var string */
	protected $data;
	/** @var int */
	protected $level = 7;

	public function __construct(string $data, int $compressionLevel, CompressBatchPromise $promise){
		$this->data = $data;
		$this->level = $compressionLevel;

		parent::__construct($promise);
	}

	public function onRun(){
		$this->setResult(NetworkCompression::compress($this->data, $this->level), false);
	}

	public function onCompletion(Server $server){
		$promise = $this->fetchLocal();

		if($promise instanceof CompressBatchPromise){
			$promise->resolve($this->getResult());
		}
	}
}
