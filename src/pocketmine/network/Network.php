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

/**
 * Network-related classes
 */
namespace pocketmine\network;

use pocketmine\network\bedrock\palette\ActorMapping as BedrockActorMapping;
use pocketmine\network\bedrock\palette\BlockPalette as BedrockBlockPalette;
use pocketmine\network\bedrock\palette\ItemPalette as BedrockItemPalette;
use pocketmine\network\bedrock\protocol\PacketPool as BedrockPacketPool;
use pocketmine\network\bedrock\skin\SkinConverter as BedrockSkinConverter;
use pocketmine\network\bedrock\StaticPacketCache;
use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\Server;

use function get_class;
use function spl_object_id;

class Network{

	/** @var Server */
	private $server;

	/** @var NetworkInterface[] */
	private $interfaces = [];

	/** @var AdvancedNetworkInterface[] */
	private $advancedInterfaces = [];

	/** @var int|float */
	private $upload = 0;
	/** @var int|float */
	private $download = 0;

    private string $name = '';

	public function __construct(Server $server){
		PacketPool::init();
		BedrockPacketPool::init();

		BedrockActorMapping::init();
		BedrockBlockPalette::init();
		BedrockItemPalette::init();
		BedrockSkinConverter::init();
		StaticPacketCache::init();

		$this->server = $server;
	}

    /**
     * Sets the server name shown on each interface Query
     *
     * @param string $name
     */
    public function setName(string $name): void{
        $this->name = (string) $name;
        foreach($this->interfaces as $interface){
            $interface->setName($this->name);
        }
    }

    public function getName(): string{
        return $this->name;
    }

    public function updateName(): void{
        foreach($this->interfaces as $interface){
            $interface->setName($this->name);
        }
    }

	public function addStatistics($upload, $download){
		$this->upload += $upload;
		$this->download += $download;
	}

	/**
	 * @return float|int
	 */
	public function getUpload(){
		return $this->upload;
	}

	/**
	 * @return float|int
	 */
	public function getDownload(){
		return $this->download;
	}

	public function resetStatistics(){
		$this->upload = 0;
		$this->download = 0;
	}

	/**
	 * @return NetworkInterface[]
	 */
	public function getInterfaces() : array{
		return $this->interfaces;
	}

	public function processInterfaces(){
		foreach($this->interfaces as $interface){
			$this->processInterface($interface);
		}
	}

	/**
	 * @param NetworkInterface $interface
	 */
	public function processInterface(NetworkInterface $interface) : void{
		try{
			$interface->process();
		}catch(\Throwable $e){
			$logger = $this->server->getLogger();
			if(\pocketmine\DEBUG > 1){
				$logger->logException($e);
			}

			$interface->emergencyShutdown();
			$this->unregisterInterface($interface);
			$logger->critical($this->server->getLanguage()->translateString("pocketmine.server.networkError", [get_class($interface), $e->getMessage()]));
		}
	}

	/**
	 * @param NetworkInterface $interface
	 */
	public function registerInterface(NetworkInterface $interface){
		$interface->start();
		$this->interfaces[$hash = spl_object_id($interface)] = $interface;
		if($interface instanceof AdvancedNetworkInterface){
			$this->advancedInterfaces[$hash] = $interface;
			$interface->setNetwork($this);
		}
	}

	/**
	 * @param NetworkInterface $interface
	 */
	public function unregisterInterface(NetworkInterface $interface){
		unset($this->interfaces[$hash = spl_object_id($interface)],
			$this->advancedInterfaces[$hash]);
	}

	/**
	 * @return Server
	 */
	public function getServer() : Server{
		return $this->server;
	}

	/**
	 * @param string $address
	 * @param int    $port
	 * @param string $payload
	 */
	public function sendPacket(string $address, int $port, string $payload){
		foreach($this->advancedInterfaces as $interface){
			$interface->sendRawPacket($address, $port, $payload);
		}
	}

	/**
	 * Blocks an IP address from the main interface. Setting timeout to -1 will block it forever
	 *
	 * @param string $address
	 * @param int    $timeout
	 */
	public function blockAddress(string $address, int $timeout = 300){
		foreach($this->advancedInterfaces as $interface){
			$interface->blockAddress($address, $timeout);
		}
	}
}
