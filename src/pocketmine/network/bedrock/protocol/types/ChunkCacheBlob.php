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

namespace pocketmine\network\bedrock\protocol\types;

class ChunkCacheBlob{
	/** @var int */
	public $hash;
	/** @var string */
	public $payload;

	/**
	 * ChunkCacheBlob constructor.
	 *
	 * @param int    $hash
	 * @param string $payload
	 */
	public function __construct(int $hash, string $payload){
		$this->hash = $hash;
		$this->payload = $payload;
	}
}