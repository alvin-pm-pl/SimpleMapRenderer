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

use pocketmine\item\Item;

class FilledMap extends Item{

	public const TAG_MAP_IS_SCALING = "map_is_scaling"; // TAG_Byte
	public const TAG_MAP_SCALE = "map_scale"; // TAG_Byte
	public const TAG_MAP_UUID = "map_uuid"; // TAG_Long
	public const TAG_MAP_DISPLAY_PLAYERS = "map_display_players"; // TAG_Byte
	public const TAG_MAP_NAME_INDEX = "map_name_index"; // TAG_Int
	public const TAG_MAP_IS_INIT = "map_is_init"; // TAG_Byte

	public function __construct(int $meta = 0){
		parent::__construct(self::FILLED_MAP, $meta, "Filled Map");
	}

	public function setDisplayPlayers(bool $displayPlayers) : void{
		$this->getNamedTag()->setByte(self::TAG_MAP_DISPLAY_PLAYERS, (int) $displayPlayers);
	}

	public function setIsScaling(bool $isScaling) : void{
		$this->getNamedTag()->setByte(self::TAG_MAP_IS_SCALING, (int) $isScaling);
	}

	public function setMapId(int $id) : void{
		$this->getNamedTag()->setLong(self::TAG_MAP_UUID, $id);
	}

	public function getMapId() : int{
		return $this->getNamedTag()->getLong(self::TAG_MAP_UUID);
	}

	public function getDisplayPlayers() : bool{
		return (bool) $this->getNamedTag()->getByte(self::TAG_MAP_DISPLAY_PLAYERS);
	}

	public function getIsScaling() : bool{
		return (bool) $this->getNamedTag()->getByte(self::TAG_MAP_IS_SCALING);
	}
}