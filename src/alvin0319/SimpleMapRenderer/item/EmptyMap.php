<?php

/*
 * MIT License
 *
 * Copyright (c) 2020 - 2021 alvin0319
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

namespace alvin0319\SimpleMapRenderer\item;

use alvin0319\SimpleMapRenderer\data\MapData;
use alvin0319\SimpleMapRenderer\MapFactory;
use alvin0319\SimpleMapRenderer\util\MapUtil;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\Player;

class EmptyMap extends Item{

	public const TYPE_EXPLORER_PLAYER = 2;

	public function __construct(int $meta = 0){
		parent::__construct(self::EMPTY_MAP, $meta, "Empty Map");
	}

	public function onClickAir(Player $player, Vector3 $directionVector) : bool{
		/** @var FilledMap $map */
		$map = ItemFactory::get(ItemIds::FILLED_MAP, 0, 1);
		$map->setDisplayPlayers($this->meta === self::TYPE_EXPLORER_PLAYER);
		$map->setMapId(MapFactory::getInstance()->nextId());

		$colors = [];
		for($x = 0; $x < 128; $x++){
			for($y = 0; $y < 128; $y++){
				$realX = $player->getFloorX() - 64 + $x;
				$realY = $player->getFloorZ() - 64 + $y;
				$maxY = $player->getLevel()->getHighestBlockAt($realX, $realY);
				$block = $player->getLevel()->getBlockAt($realX, $maxY, $realY);
				$color = MapUtil::getMapColorByBlock($block);
				$colors[$y][$x] = $color;
			}
		}

		MapFactory::getInstance()->registerData(new MapData($map->getMapId(), $colors, $map->getDisplayPlayers(), $player->floor()));

		if($player->getInventory()->canAddItem($map)){
			$player->getInventory()->addItem($map);
		}else{
			$player->getLevel()->dropItem($player->floor()->add(0.5, 0.5, 0.5), $map);
		}
		$this->pop();
		return true;
	}
}