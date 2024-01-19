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

namespace pocketmine\nbt;

use Closure;

class ReaderTracker{

	/** @var int */
	private $maxDepth;
	/** @var int */
	private $currentDepth = 0;

	public function __construct(int $maxDepth){
		$this->maxDepth = $maxDepth;
	}

	/**
	 * @param Closure $execute
	 */
	public function protectDepth(Closure $execute) : void{
		if($this->maxDepth > 0 and ++$this->currentDepth > $this->maxDepth){
			throw new NbtDataException("Nesting level too deep: reached max depth of $this->maxDepth tags");
		}
		try{
			$execute();
		}finally{
			--$this->currentDepth;
		}
	}
}
