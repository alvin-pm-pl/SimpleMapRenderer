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
use alvin0319\SimpleMapRenderer\task\MapImageFetchAsyncTask;
use alvin0319\SimpleMapRenderer\util\ImageUtil;
use pocketmine\math\Vector3;
use RecursiveDirectoryIterator;

use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_numeric;
use function json_decode;
use function json_encode;
use function microtime;
use function pathinfo;
use function round;

use const PATHINFO_FILENAME;

final class MapFactory{
	/** @var MapFactory|null */
	private static $instance = null;
	/** @var int */
	protected $id = 0;

	/** @var MapData[] */
	protected $mapData = [];

	public static function getInstance() : MapFactory{
		return self::$instance;
	}

	public function __construct(){
		self::$instance = $this;
		$this->fetchAsyncTask();
	}

	public function fetchAsyncTask() : void{
		$files = new RecursiveDirectoryIterator($dir = SimpleMapRenderer::getInstance()->getDataFolder() . "images/", RecursiveDirectoryIterator::SKIP_DOTS);
		$res = [];
		foreach($files as $file){
			if($file->isFile()){
				$fileName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
				if(is_numeric($fileName)){
					$res[(int) $fileName] = $dir . $file->getFilename();
				}
			}
		}
		SimpleMapRenderer::getInstance()->getServer()->getAsyncPool()->submitTask(new MapImageFetchAsyncTask($res));
		$files = new RecursiveDirectoryIterator($dir = SimpleMapRenderer::getInstance()->getDataFolder() . "data/", RecursiveDirectoryIterator::SKIP_DOTS);
		foreach($files as $file){
			if($file->isFile()){
				$fileData = pathinfo($file->getFilename());
				if($fileData["extension"] === "json" && is_numeric($fileData["filename"])){
					$data = json_decode(file_get_contents($dir . $fileData["filename"] . ".json"), true);
					[$x, $y, $z] = explode(":", $data["center"]);
					$mapData = new MapData($data["id"], [], $data["displayPlayers"], new Vector3((float) $x, (float) $y, (float) $z));
					$this->mapData[$mapData->getMapId()] = $mapData;
				}
			}
		}
		$this->id = SimpleMapRenderer::getInstance()->getConfig()->get("mapId", $this->id);
	}

	public function save() : void{
		SimpleMapRenderer::getInstance()->getConfig()->set("mapId", $this->id);
		SimpleMapRenderer::getInstance()->getLogger()->notice("Saving images, It takes few seconds.");
		$start = microtime(true);
		foreach($this->mapData as $id => $data){
			if(!file_exists($file = SimpleMapRenderer::getInstance()->getDataFolder() . "images/{$id}.png")){
				ImageUtil::toPNG($file, $data->getColors());
			}
			if(!file_exists($file = SimpleMapRenderer::getInstance()->getDataFolder() . "data/{$id}.json")){
				file_put_contents($file, json_encode($data->jsonSerialize()));
			}
		}
		$end = microtime(true);
		SimpleMapRenderer::getInstance()->getLogger()->notice("Image save successful (took " . round($end - $start, 2) . " ms)");
	}

	public function registerData(MapData $data) : void{
		$this->mapData[$data->getMapId()] = $data;
	}

	public function updateColors(int $id, array $colors) : void{
		if(!isset($this->mapData[$id])){
			return;
		}
		$data = $this->mapData[$id];
		$data->setColors($colors);
	}

	public function getMapData(int $mapId) : ?MapData{
		return $this->mapData[$mapId] ?? null;
	}

	public function nextId() : int{
		$this->id += 1;
		return $this->id;
	}
}