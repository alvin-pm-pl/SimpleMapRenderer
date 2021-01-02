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

namespace alvin0319\SimpleMapRenderer\task;

use alvin0319\SimpleMapRenderer\MapFactory;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Color;

use function file_exists;
use function imagecolorat;
use function imagecreatefrompng;
use function imagedestroy;
use function pathinfo;
use function serialize;
use function unserialize;

use const PATHINFO_EXTENSION;

class MapImageFetchAsyncTask extends AsyncTask{

	protected $files;

	public function __construct(array $files){
		$this->files = serialize($files);
	}

	public function onRun() : void{
		$files = unserialize($this->files);
		$resources = [];
		foreach($files as $id => $file){
			$resources[$id] = $this->convertXY($this->fetch($file));
		}
		$this->setResult($resources);
	}

	public function onCompletion(Server $server) : void{
		$results = $this->getResult();

		foreach($results as $id => $result){
			MapFactory::getInstance()->updateColors($id, $result);
		}
	}

	/**
	 * @param string $png
	 *
	 * @return resource|null
	 */
	private function fetch(string $png){
		if(!file_exists($png)){
			return null;
		}
		if(pathinfo($png, PATHINFO_EXTENSION) !== "png"){
			return null;
		}
		$image = @imagecreatefrompng($png);
		if($image === false){
			return null;
		}
		return $image;
	}

	/**
	 * @param resource $resource
	 *
	 * @return Color[][]
	 */
	private function convertXY($resource){
		$xy = [];
		for($y = 0; $y < 128; $y++){
			for($x = 0; $x < 128; $x++){
				$rgb = imagecolorat($resource, $x, $y);
				$a = (127 - (($rgb >> 24) & 0x7F)) * 2;
				$r = ($rgb >> 16) & 0xff;
				$g = ($rgb >> 8) & 0xff;
				$b = $rgb & 0xff;
				$xy[$y][$x] = new Color((int) $r, (int) $g, (int) $b, (int) $a);
			}
		}
		imagedestroy($resource);
		return $xy;
	}
}