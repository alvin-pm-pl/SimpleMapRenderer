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

namespace alvin0319\SimpleMapRenderer\util;

use pocketmine\utils\Color;

use function file_exists;
use function imagecolorallocate;
use function imagecreatefrompng;
use function imagecreatetruecolor;
use function imagedestroy;
use function imagefill;
use function imagepng;
use function imagesavealpha;
use function pathinfo;

use const PATHINFO_EXTENSION;

class ImageUtil{

	/**
	 * Returns the resource of create image, need to do imagedestroy()
	 *
	 * @param string $png
	 *
	 * @return resource|null
	 * @see imagedestroy()
	 */
	public static function fromPNG(string $png){
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
	 * @param string $png
	 * @param array  $data
	 */
	public static function toPNG(string $png, array $data) : void{
		$image = imagecreatetruecolor(128, 128);
		imagefill($image, 0, 0, imagecolorallocate($image, 0, 0, 0));
		imagesavealpha($image, true);
		for($y = 0; $y < 128; $y++){
			for($x = 0; $x < 128; $x++){
				//$color = new Color($data[$y][$x]["red"], $data[$y][$x]["green"], $data[$y][$x]["blue"]);
				/** @var Color $color */
				$color = $data[$y][$x];
				imagefill($image, $x, $y, $color->toRGBA());
			}
		}
		imagepng($image, $png);
		imagedestroy($image);
	}
}