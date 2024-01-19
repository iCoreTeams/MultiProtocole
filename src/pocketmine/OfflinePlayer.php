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

namespace pocketmine;

use pocketmine\metadata\Metadatable;
use pocketmine\metadata\MetadataValue;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\Plugin;

use function file_exists;
use function strtolower;

class OfflinePlayer implements IPlayer, Metadatable{

	/** @var string */
	private $name;
	/** @var Server */
	private $server;
	/** @var CompoundTag|null */
	private $namedtag;

	/**
	 * @param Server $server
	 * @param string $name
	 */
	public function __construct(Server $server, string $name){
		$this->server = $server;
		$this->name = $name;
		if(file_exists($this->server->getDataPath() . "players/" . strtolower($this->getName()) . ".dat")){
			$this->namedtag = $this->server->getOfflinePlayerData($this->name);
		}else{
			$this->namedtag = null;
		}
	}

	public function isOnline() : bool{
		return $this->getPlayer() !== null;
	}

	public function getName(){
		return $this->name;
	}

	public function getServer(){
		return $this->server;
	}

	public function isOp() : bool{
		return $this->server->isOp(strtolower($this->getName()));
	}

	public function setOp(bool $value){
		if($value === $this->isOp()){
			return;
		}

		if($value === true){
			$this->server->addOp(strtolower($this->getName()));
		}else{
			$this->server->removeOp(strtolower($this->getName()));
		}
	}

	public function isBanned() : bool{
		return $this->server->getNameBans()->isBanned(strtolower($this->getName()));
	}

	public function setBanned(bool $value){
		if($value === true){
			$this->server->getNameBans()->addBan($this->getName(), null, null, null);
		}else{
			$this->server->getNameBans()->remove($this->getName());
		}
	}

	public function isWhitelisted() : bool{
		return $this->server->isWhitelisted(strtolower($this->getName()));
	}

	public function setWhitelisted(bool $value){
		if($value === true){
			$this->server->addWhitelist(strtolower($this->getName()));
		}else{
			$this->server->removeWhitelist(strtolower($this->getName()));
		}
	}

	public function getPlayer(){
		return $this->server->getPlayerExact($this->getName());
	}

	public function getFirstPlayed(){
		return $this->namedtag instanceof CompoundTag ? $this->namedtag->getLong("firstPlayed") : null;
	}

	public function getLastPlayed(){
		return $this->namedtag instanceof CompoundTag ? $this->namedtag->getLong("lastPlayed") : null;
	}

	public function hasPlayedBefore() : bool{
		return $this->namedtag instanceof CompoundTag;
	}

	public function setMetadata(string $metadataKey, MetadataValue $newMetadataValue){
		$this->server->getPlayerMetadata()->setMetadata($this, $metadataKey, $newMetadataValue);
	}

	public function getMetadata(string $metadataKey){
		return $this->server->getPlayerMetadata()->getMetadata($this, $metadataKey);
	}

	public function hasMetadata(string $metadataKey) : bool{
		return $this->server->getPlayerMetadata()->hasMetadata($this, $metadataKey);
	}

	public function removeMetadata(string $metadataKey, Plugin $owningPlugin){
		$this->server->getPlayerMetadata()->removeMetadata($this, $metadataKey, $owningPlugin);
	}


}
