# SimpleMapRenderer
Simple Map Plugin for PocketMine-MP

# How to use
Just put the plugin on plugins folder and enjoy it!

![](https://raw.githubusercontent.com/alvin0319/SimpleMapRenderer/master/map_info.png)

# API

##### Get MapFactory instance
```php
$factory = \alvin0319\SimpleMapRenderer\MapFactory::getInstance();
```

##### Get `MapData` object

```php
$mapId = your_map_id;
$mapData = $factory->getMapData($mapId);
```

##### Register Map info
```php
$mapId = your_custom_map_id; 
$colors = [];
$center = new Vector3(0, 0, 0);
for($y = 0; $y < 128; $y++){
    for($x = 0; $x < 128; $x++){
        $colors[] = new \pocketmine\utils\Color(mt_rand(0, 128), mt_rand(0, 128), mt_rand(0, 128));
    }
}
$mapData = new \alvin0319\SimpleMapRenderer\data\MapData($mapId, $colors, false, $center);

$factory->registerData($mapData);
```
##### Get block color
```php
$block = Level->getBlock($x, $y, $z);
$color = \alvin0319\SimpleMapRenderer\util\MapUtil::getMapColorByBlock($block);
```

##### Save image file

```php
$filePath = path_to_your_png_file;
$colors = [];
for($y = 0; $y < 128; $y++){
    for($x = 0; $x < 128; $x++){
        $colors[] = new \pocketmine\utils\Color(mt_rand(0, 128), mt_rand(0, 128), mt_rand(0, 128));
    }
}
\alvin0319\SimpleMapRenderer\util\ImageUtil::toPNG($filePath, $colors);
```

#### Note
 * `$mapId` cannot overlap with an existing ID.
 * The `$color` must be a two-dimensional array from 0 to 128. (ex: `[y][x] = Color`)
 
# To-Do
* Implement MapDecoration (tracking player, mob, etc...)