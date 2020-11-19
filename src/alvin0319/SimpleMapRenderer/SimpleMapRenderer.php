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

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use function is_dir;
use function mkdir;

class SimpleMapRenderer extends PluginBase{
	/** @var SimpleMapRenderer|null */
	private static $instance = null;
	/** @var MapFactory */
	protected $mapFactory;
	/** @var Config */
	protected $config;

	public function onLoad() : void{
		self::$instance = $this;
	}

	public static function getInstance() : SimpleMapRenderer{
		return self::$instance;
	}

	public function onEnable() : void{
		if(!is_dir($dir = $this->getDataFolder() . "images/")){
			mkdir($dir);
		}
		$this->saveResource("config.json");
		$this->config = new Config($this->getDataFolder() . "config.json", Config::JSON);
		$this->mapFactory = new MapFactory();
	}

	public function onDisable() : void{
		$this->mapFactory->save();
		$this->getConfig()->save();
	}
}