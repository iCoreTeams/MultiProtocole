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

namespace pocketmine\scheduler;

use pocketmine\utils\Internet;

/**
 * Executes a consecutive list of cURL operations.
 *
 * The result of this AsyncTask is an array of arrays (returned from {@link Internet::simpleCurl}) or RuntimeException objects.
 *
 * @package pocketmine\scheduler
 */
use function igbinary_serialize;
use function igbinary_unserialize;

class BulkCurlTask extends AsyncTask{
	private $operations;

	/**
	 * BulkCurlTask constructor.
	 *
	 * $operations accepts an array of arrays. Each member array must contain a string mapped to "page", and optionally,
	 * "timeout", "extraHeaders" and "extraOpts". Documentation of these options are same as those in
	 * {@link Internet::simpleCurl}.
	 *
	 * @param array      $operations
	 * @param mixed|null $complexData
	 */
	public function __construct(array $operations, $complexData = null){
		parent::__construct($complexData);
		$this->operations = igbinary_serialize($operations);
	}

	public function onRun(){
		$operations = igbinary_unserialize($this->operations);
		$results = [];
		foreach($operations as $op){
			try{
				$results[] = Internet::simpleCurl($op["page"], $op["timeout"] ?? 10, $op["extraHeaders"] ?? [], $op["extraOpts"] ?? []);
			}catch(\RuntimeException $e){
				$results[] = $e;
			}
		}
		$this->setResult($results);
	}
}
