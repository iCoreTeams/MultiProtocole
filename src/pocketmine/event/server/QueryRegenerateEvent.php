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

namespace pocketmine\event\server;

use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\Binary;

use function chr;
use function count;
use function str_replace;
use function substr;

class QueryRegenerateEvent extends ServerEvent{
	public static $handlerList = null;

	public const GAME_ID = "MINECRAFTPE";

	/** @var int */
	private $timeout;
	/** @var string */
	private $motd;
	/** @var string */
	private $subMotd;
	/** @var bool */
	private $listPlugins;
	/** @var Plugin[] */
	private $plugins;
	/** @var Player[] */
	private $players;

	/** @var string */
	private $gametype;
	/** @var string */
	private $version;
	/** @var string */
	private $server_engine;
	/** @var string */
	private $map;
	/** @var int */
	private $numPlayers;
	/** @var int */
	private $maxPlayers;
	/** @var string */
	private $whitelist;
	/** @var int */
	private $port;
	/** @var string */
	private $ip;
	/** @var bool */
	private $visiblePlayersNicknames = false;
	/** @var string */
	private string $customServerName = "";

	/** @var array */
	private $extraData = [];


	/**
	 * @param Server $server
	 * @param int    $timeout
	 */
	public function __construct(Server $server, int $timeout = 5){
		$this->timeout = $timeout;
		$this->customServerName = $server->getAdvancedProperty("query.server-name", "iCore Server");
		$this->motd = $server->getMotd();
		$this->subMotd = $server->getName() . " v" . $server->getPocketMineVersion();
		$this->listPlugins = $server->getAdvancedProperty("query.visible-plugins", false);
		$this->visiblePlayersNicknames = $server->getAdvancedProperty("query.visible-players-nicknames", false);
		$this->plugins = $server->getPluginManager()->getPlugins();
		$this->players = [];
		$onlinePlayers = $server->getOnlinePlayers();
		if ($server->getAdvancedProperty("query.visible-players", false)) {
			foreach ($onlinePlayers as $player) {
				if ($player->isOnline()) {
					$this->players[] = $player;
				}
			}
		}

		$this->gametype = ($server->getGamemode() & 0x01) === 0 ? "SMP" : "CMP";
		$this->version = $server->getVersion() . ' - ' . $server->getBedrockVersion();
		$this->server_engine = $this->subMotd;
		$this->map = $server->getAdvancedProperty("query.visible-map", false) ? $server->getDefaultLevel() === null ? "unknown" : $server->getDefaultLevel()->getName() : "world";
		$this->numPlayers = count($onlinePlayers);
		$this->maxPlayers = $server->getMaxPlayers();
		$this->whitelist = $server->hasWhitelist() ? "on" : "off";
		$this->port = $server->getPort();
		$this->ip = $server->getIp();
	}

	/**
	 * Gets the min. timeout for Query Regeneration
	 *
	 * @return int
	 */
	public function getTimeout() : int{
		return $this->timeout;
	}

	/**
	 * @param int $timeout
	 */
	public function setTimeout(int $timeout){
		$this->timeout = $timeout;
	}

	/**
	 * @deprecated
	 *
	 * @return string
	 */
	public function getServerName() : string{
		return $this->motd;
	}

	/**
	 * @deprecated
	 *
	 * @param string $motd
	 */
	public function setServerName(string $motd){
		$this->motd = $motd;
	}

	/**
	 * @return string
	 */
	public function getMotd() : string{
		return $this->motd;
	}

	/**
	 * @param string $motd
	 */
	public function setMotd(string $motd){
		$this->motd = $motd;
	}

	/**
	 * @return string
	 */
	public function getSubMotd() : string{
		return $this->subMotd;
	}

	/**
	 * @param string $subMotd
	 */
	public function setSubMotd(string $subMotd) : void{
		$this->subMotd = $subMotd;
	}

	/**
	 * @return bool
	 */
	public function canListPlugins() : bool{
		return $this->listPlugins;
	}

	/**
	 * @param bool $value
	 */
	public function setListPlugins(bool $value){
		$this->listPlugins = $value;
	}

	/**
	 * @return Plugin[]
	 */
	public function getPlugins() : array{
		return $this->plugins;
	}

	/**
	 * @param Plugin[] $plugins
	 */
	public function setPlugins(array $plugins){
		$this->plugins = $plugins;
	}

	/**
	 * @return Player[]
	 */
	public function getPlayerList() : array{
		return $this->players;
	}

	/**
	 * @param Player[] $players
	 */
	public function setPlayerList(array $players){
		$this->players = $players;
	}

	/**
	 * @return int
	 */
	public function getPlayerCount() : int{
		return $this->numPlayers;
	}

	/**
	 * @param int $count
	 */
	public function setPlayerCount(int $count){
		$this->numPlayers = $count;
	}

	/**
	 * @return int
	 */
	public function getMaxPlayerCount() : int{
		return $this->maxPlayers;
	}

	/**
	 * @param int $count
	 */
	public function setMaxPlayerCount(int $count){
		$this->maxPlayers = $count;
	}

	/**
	 * @return string
	 */
	public function getWorld() : string{
		return $this->map;
	}

	/**
	 * @param string $world
	 */
	public function setWorld(string $world){
		$this->map = $world;
	}

	/**
	 * Returns the extra Query data in key => value form
	 *
	 * @return array
	 */
	public function getExtraData() : array{
		return $this->extraData;
	}

	/**
	 * @param array $extraData
	 */
	public function setExtraData(array $extraData){
		$this->extraData = $extraData;
	}

	/**
	 * @return string
	 */
	public function getLongQuery() : string{
		$query = "";

		$plist = $this->server_engine;
		if(count($this->plugins) > 0 and $this->listPlugins){
			$plist .= ":";
			foreach($this->plugins as $p){
				$d = $p->getDescription();
				$plist .= " " . str_replace([";", ":", " "], ["", "", "_"], $d->getName()) . " " . str_replace([";", ":", " "], ["", "", "_"], $d->getVersion()) . ";";
			}
			$plist = substr($plist, 0, -1);
		}

		$KVdata = [
			"splitnum" => chr(128),
			"hostname" => $this->customServerName,
			"gametype" => $this->gametype,
			"game_id" => self::GAME_ID,
			"version" => $this->version,
			"server_engine" => $this->server_engine,
			"plugins" => $plist,
			"map" => $this->map,
			"numplayers" => $this->numPlayers,
			"maxplayers" => $this->maxPlayers,
			"whitelist" => $this->whitelist,
			"hostip" => $this->ip,
			"hostport" => $this->port
		];

		foreach($KVdata as $key => $value){
			$query .= $key . "\x00" . $value . "\x00";
		}

		foreach($this->extraData as $key => $value){
			$query .= $key . "\x00" . $value . "\x00";
		}

		$query .= "\x00\x01player_\x00\x00";
		$i = 0;
		foreach($this->players as $player) {
			$identifier = "player" . $i++;
			if ($this->visiblePlayersNicknames) $identifier = $player->getName();
			$query .= $identifier. "\x00";
		}
		$query .= "\x00";

		return $query;
	}

	/**
	 * @return string
	 */
	public function getShortQuery() : string{
		return $this->motd . "\x00" . $this->gametype . "\x00" . $this->map . "\x00" . $this->numPlayers . "\x00" . $this->maxPlayers . "\x00" . Binary::writeLShort($this->port) . $this->ip . "\x00";
	}

}
