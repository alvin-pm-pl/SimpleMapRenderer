<?php

/*
 * MIT License
 *
 * Copyright (c) 2020 alvin0319
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace alvin0319\SimpleMapRenderer;

use alvin0319\SimpleMapRenderer\data\MapData;
use alvin0319\SimpleMapRenderer\item\FilledMap;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundMapItemDataPacket;
use pocketmine\network\mcpe\protocol\MapInfoRequestPacket;
use pocketmine\network\mcpe\protocol\types\MapDecoration;
use pocketmine\Player;
use pocketmine\utils\Color;

use function count;

class EventListener implements Listener{

	public function onDataPacketReceived(DataPacketReceiveEvent $event) : void{
		$packet = $event->getPacket();
		$player = $event->getPlayer();
		if($packet instanceof MapInfoRequestPacket){
			$mapId = $packet->mapId;
			if(($mapData = MapFactory::getInstance()->getMapData($mapId)) !== null){
				$event->setCancelled();
				$this->sendMapInfo($player, $mapId, $mapData);
			}
		}
	}

	public function sendMapInfo(Player $player, int $mapId, MapData $mapData, array $includePlayers = []) : void{
		$pk = new ClientboundMapItemDataPacket();
		$pk->mapId = $mapId;
		$pk->colors = $mapData->getColors();
		if(count($includePlayers) > 0){
			if($mapData->getDisplayPlayers()){
				/**
				 * @var int     $playerId
				 */
				foreach($includePlayers as $playerId){
					/** @var Player $target */
					$target = $player->getServer()->findEntity($playerId);
					$pk->decorations[] = $this->getMapDecoration($mapData, $target);
				}
			}
		}
		$pk->type = ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE;
		$pk->width = $pk->height = 128;
		$pk->scale = 1;
		$player->sendDataPacket($pk);
	}

	public function onPlayerItemHeld(PlayerItemHeldEvent $event) : void{
		$item = $event->getItem();
		$player = $event->getPlayer();
		if($item instanceof FilledMap){
			$mapData = MapFactory::getInstance()->getMapData($item->getMapId());
			if($mapData instanceof MapData){
				$this->sendMapInfo($player, $mapData->getMapId(), $mapData);
			}
		}
	}

	private function getMapDecoration(MapData $data, Player $player) : MapDecoration{
		$rotation = $player->getYaw();

		$i = 1 << 0;
		$f = ($player->getFloorX() - $data->getCenter()->getX()) / $i;
		$f1 = ($player->getFloorZ() - $data->getCenter()->getZ()) / $i;
		$b0 = (int) (($f * 2.0) + 0.5);
		$b1 = (int) (($f1 * 2.0) + 0.5);
		$j = 63;

		$rotation = $rotation + ($rotation < 0.0 ? -8.0 : 8.0);
		$b2 = ((int) ($rotation * 16.0 / 360.0));

		if($f <= -$j){
			$b0 = (int) (($j * 2) + 2.5);
		}

		if($f1 <= -$j){
			$b1 = (int) (($j * 2) + 2.5);
		}

		if($f >= $j){
			$b0 = (int) ($j * 2 + 1);
		}
		if($f1 >= $j){
			$b1 = (int) ($j * 2 + 1);
		}
		return new MapDecoration(0, $b2, $b0, $b1, $player->getName(), $color ?? new Color(255, 255, 255));
	}
}