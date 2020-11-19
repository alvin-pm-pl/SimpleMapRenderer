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

use alvin0319\SimpleMapRenderer\task\MapImageFetchAsyncTask;
use alvin0319\SimpleMapRenderer\util\ImageUtil;
use pocketmine\utils\Color;
use RecursiveDirectoryIterator;

use function file_exists;
use function is_numeric;
use function microtime;
use function pathinfo;

use function round;

use const PATHINFO_FILENAME;

final class MapFactory{
	/** @var MapFactory|null */
	private static $instance = null;
	/** @var int */
	protected $id = 0;

	/** @var Color[][][] */
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
	}

	public function save() : void{
		SimpleMapRenderer::getInstance()->getLogger()->notice("Saving images, It takes few seconds.");
		$start = microtime(true);
		foreach($this->mapData as $id => $data){
			if(!file_exists($file = SimpleMapRenderer::getInstance()->getDataFolder() . "images/{$id}.png")){
				ImageUtil::toPNG($file, $data);
			}
		}
		$end = microtime(true);
		SimpleMapRenderer::getInstance()->getLogger()->notice("Image save successful (took " . round($end - $start, 2) . " ms)");
	}

	public function registerData(int $mapId, array $data) : void{
		$this->mapData[$mapId] = $data;
	}

	public function nextId() : int{
		return ++$this->id;
	}
}