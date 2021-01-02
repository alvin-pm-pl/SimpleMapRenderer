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

namespace alvin0319\SimpleMapRenderer\util;

use pocketmine\block\Block;
use pocketmine\block\Planks;
use pocketmine\block\Prismarine;
use pocketmine\block\Stone;
use pocketmine\block\StoneSlab;
use pocketmine\block\Wood;
use pocketmine\block\Wood2;
use pocketmine\utils\Color;

final class MapUtil{

	public const COLOR_BLOCK_WHITE = 0;
	public const COLOR_BLOCK_ORANGE = 1;
	public const COLOR_BLOCK_MAGENTA = 2;
	public const COLOR_BLOCK_LIGHT_BLUE = 3;
	public const COLOR_BLOCK_YELLOW = 4;
	public const COLOR_BLOCK_LIME = 5;
	public const COLOR_BLOCK_PINK = 6;
	public const COLOR_BLOCK_GRAY = 7;
	public const COLOR_BLOCK_LIGHT_GRAY = 8;
	public const COLOR_BLOCK_CYAN = 9;
	public const COLOR_BLOCK_PURPLE = 10;
	public const COLOR_BLOCK_BLUE = 11;
	public const COLOR_BLOCK_BROWN = 12;
	public const COLOR_BLOCK_GREEN = 13;
	public const COLOR_BLOCK_RED = 14;
	public const COLOR_BLOCK_BLACK = 15;

	/**
	 * Credits from Altay
	 *
	 * @param Block $block
	 *
	 * @return Color
	 * @link https://github.com/TuranicTeam/Altay/blob/stable/src/pocketmine/maps/renderer/VanillaMapRenderer.php#L172#L274
	 */
	public static function getMapColorByBlock(Block $block) : Color{
		$meta = $block->getDamage();
		$id = $block->getId();
		if($id === Block::AIR){
			return new Color(0, 0, 0);
		}elseif($id === Block::GRASS or $id === Block::SLIME_BLOCK){
			return new Color(127, 178, 56);
		}elseif($id === Block::SAND or $id === Block::SANDSTONE or $id === Block::SANDSTONE_STAIRS or ($id === Block::STONE_SLAB and ($meta & 0x07) == StoneSlab::SANDSTONE) or ($id === Block::DOUBLE_STONE_SLAB and $meta == StoneSlab::SANDSTONE) or $id === Block::GLOWSTONE or $id === Block::END_STONE or ($id === Block::PLANKS and $meta == Planks::BIRCH) or ($id === Block::LOG and ($meta & 0x03) == Wood::BIRCH) or $id === Block::BIRCH_FENCE_GATE or ($id === Block::FENCE and $meta = Planks::BIRCH) or $id === Block::BIRCH_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::BIRCH) or $id === Block::BONE_BLOCK or $id === Block::END_BRICKS){
			return new Color(247, 233, 163);
		}elseif($id === Block::BED_BLOCK or $id === Block::COBWEB){
			return new Color(199, 199, 199);
		}elseif($id === Block::LAVA or $id === Block::STILL_LAVA or $id === Block::FLOWING_LAVA or $id === Block::TNT or $id === Block::FIRE or $id === Block::REDSTONE_BLOCK){
			return new Color(255, 0, 0);
		}elseif($id === Block::ICE or $id === Block::PACKED_ICE or $id === Block::FROSTED_ICE){
			return new Color(160, 160, 255);
		}elseif($id === Block::IRON_BLOCK or $id === Block::IRON_DOOR_BLOCK or $id === Block::IRON_TRAPDOOR or $id === Block::IRON_BARS or $id === Block::BREWING_STAND_BLOCK or $id === Block::ANVIL or $id === Block::HEAVY_WEIGHTED_PRESSURE_PLATE){
			return new Color(167, 167, 167);
		}elseif($id === Block::SAPLING or $id === Block::LEAVES or $id === Block::LEAVES2 or $id === Block::TALL_GRASS or $id === Block::DEAD_BUSH or $id === Block::RED_FLOWER or $id === Block::DOUBLE_PLANT or $id === Block::BROWN_MUSHROOM or $id === Block::RED_MUSHROOM or $id === Block::WHEAT_BLOCK or $id === Block::CARROT_BLOCK or $id === Block::POTATO_BLOCK or $id === Block::BEETROOT_BLOCK or $id === Block::CACTUS or $id === Block::SUGARCANE_BLOCK or $id === Block::PUMPKIN_STEM or $id === Block::MELON_STEM or $id === Block::VINE or $id === Block::LILY_PAD){
			return new Color(0, 124, 0);
		}elseif(($id === Block::WOOL and $meta == self::COLOR_BLOCK_WHITE) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_WHITE) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_WHITE) or $id === Block::SNOW_LAYER or $id === Block::SNOW_BLOCK){
			return new Color(255, 255, 255);
		}elseif($id === Block::CLAY_BLOCK or $id === Block::MONSTER_EGG){
			return new Color(164, 168, 184);
		}elseif($id === Block::DIRT or $id === Block::FARMLAND or ($id === Block::STONE and $meta == Stone::GRANITE) or ($id === Block::STONE and $meta == Stone::POLISHED_GRANITE) or ($id === Block::SAND and $meta == 1) or $id === Block::RED_SANDSTONE or $id === Block::RED_SANDSTONE_STAIRS or ($id === Block::STONE_SLAB2 and ($meta & 0x07) == StoneSlab::RED_SANDSTONE) or ($id === Block::LOG and ($meta & 0x03) == Wood::JUNGLE) or ($id === Block::PLANKS and $meta == Planks::JUNGLE) or $id === Block::JUNGLE_FENCE_GATE or ($id === Block::FENCE and $meta == Planks::JUNGLE) or $id === Block::JUNGLE_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::JUNGLE)){
			return new Color(151, 109, 77);
		}elseif($id === Block::STONE or ($id === Block::STONE_SLAB and ($meta & 0x07) == StoneSlab::STONE) or $id === Block::COBBLESTONE or $id === Block::COBBLESTONE_STAIRS or ($id === Block::STONE_SLAB and ($meta & 0x07) == StoneSlab::COBBLESTONE) or $id === Block::COBBLESTONE_WALL or $id === Block::MOSS_STONE or ($id === Block::STONE and $meta == Stone::ANDESITE) or ($id === Block::STONE and $meta == Stone::POLISHED_ANDESITE) or $id === Block::BEDROCK or $id === Block::GOLD_ORE or $id === Block::IRON_ORE or $id === Block::COAL_ORE or $id === Block::LAPIS_ORE or $id === Block::DISPENSER or $id === Block::DROPPER or $id === Block::STICKY_PISTON or $id === Block::PISTON or $id === Block::PISTON_ARM_COLLISION or $id === Block::MOVINGBLOCK or $id === Block::MONSTER_SPAWNER or $id === Block::DIAMOND_ORE or $id === Block::FURNACE or $id === Block::STONE_PRESSURE_PLATE or $id === Block::REDSTONE_ORE or $id === Block::STONE_BRICK or $id === Block::STONE_BRICK_STAIRS or ($id === Block::STONE_SLAB and ($meta & 0x07) == StoneSlab::STONE_BRICK) or $id === Block::ENDER_CHEST or $id === Block::HOPPER_BLOCK or $id === Block::GRAVEL or $id === Block::OBSERVER){
			return new Color(112, 112, 112);
		}elseif($id === Block::WATER or $id === Block::STILL_WATER or $id === Block::FLOWING_WATER){
			return new Color(64, 64, 255);
		}elseif(($id === Block::WOOD and ($meta & 0x03) == Wood::OAK) or ($id === Block::PLANKS and $meta == Planks::OAK) or ($id === Block::FENCE and $meta == Planks::OAK) or $id === Block::OAK_FENCE_GATE or $id === Block::OAK_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::OAK) or $id === Block::NOTEBLOCK or $id === Block::BOOKSHELF or $id === Block::CHEST or $id === Block::TRAPPED_CHEST or $id === Block::CRAFTING_TABLE or $id === Block::WOODEN_DOOR_BLOCK or $id === Block::BIRCH_DOOR_BLOCK or $id === Block::SPRUCE_DOOR_BLOCK or $id === Block::JUNGLE_DOOR_BLOCK or $id === Block::ACACIA_DOOR_BLOCK or $id === Block::DARK_OAK_DOOR_BLOCK or $id === Block::SIGN_POST or $id === Block::WALL_SIGN or $id === Block::WOODEN_PRESSURE_PLATE or $id === Block::JUKEBOX or $id === Block::WOODEN_TRAPDOOR or $id === Block::BROWN_MUSHROOM_BLOCK or $id === Block::STANDING_BANNER or $id === Block::WALL_BANNER or $id === Block::DAYLIGHT_SENSOR or $id === Block::DAYLIGHT_SENSOR_INVERTED){
			return new Color(143, 119, 72);
		}elseif($id === Block::QUARTZ_BLOCK or ($id === Block::STONE_SLAB and ($meta & 0x07) == 6) or $id === Block::QUARTZ_STAIRS or ($id === Block::STONE and $meta == Stone::DIORITE) or ($id === Block::STONE and $meta == Stone::POLISHED_DIORITE) or $id === Block::SEA_LANTERN){
			return new Color(255, 252, 245);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_ORANGE) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_ORANGE) or $id === Block::ORANGE_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_ORANGE) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_ORANGE) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_ORANGE) or $id === Block::PUMPKIN or $id === Block::JACK_O_LANTERN or $id === Block::HARDENED_CLAY or ($id === Block::WOOD2 and ($meta & 0x03) == Wood2::ACACIA) or ($id === Block::PLANKS and $meta == Planks::ACACIA) or ($id === Block::FENCE and $meta == Planks::ACACIA) or $id === Block::ACACIA_FENCE_GATE or $id === Block::ACACIA_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::ACACIA)){
			return new Color(216, 127, 51);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_MAGENTA) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_MAGENTA) or $id === Block::MAGENTA_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_MAGENTA) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_MAGENTA) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_MAGENTA) or $id === Block::PURPUR_BLOCK or $id === Block::PURPUR_STAIRS or ($id === Block::STONE_SLAB2 and ($meta & 0x07) == Stone::PURPUR_BLOCK)){
			return new Color(178, 76, 216);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_LIGHT_BLUE) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_LIGHT_BLUE) or $id === Block::LIGHT_BLUE_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_LIGHT_BLUE) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_LIGHT_BLUE) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_LIGHT_BLUE)){
			return new Color(102, 153, 216);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_YELLOW) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_YELLOW) or $id === Block::YELLOW_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_YELLOW) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_YELLOW) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_YELLOW) or $id === Block::HAY_BALE or $id === Block::SPONGE){
			return new Color(229, 229, 51);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_LIME) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_LIME) or $id === Block::LIME_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_LIME) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_LIME) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_LIME) or $id === Block::MELON_BLOCK){
			return new Color(229, 229, 51);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_PINK) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_PINK) or $id === Block::PINK_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_PINK) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_PINK) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_PINK)){
			return new Color(242, 127, 165);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_GRAY) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_GRAY) or $id === Block::GRAY_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_GRAY) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_GRAY) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_GRAY) or $id === Block::CAULDRON_BLOCK){
			return new Color(76, 76, 76);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_LIGHT_GRAY) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_LIGHT_GRAY) or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_LIGHT_GRAY) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_LIGHT_GRAY) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_LIGHT_GRAY) or $id === Block::STRUCTURE_BLOCK){
			return new Color(153, 153, 153);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_CYAN) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_CYAN) or $id === Block::CYAN_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_CYAN) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_CYAN) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_CYAN) or ($id === Block::PRISMARINE and $meta == Prismarine::NORMAL)){
			return new Color(76, 127, 153);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_PURPLE) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_PURPLE) or $id === Block::PURPLE_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_PURPLE) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_PURPLE) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_PURPLE) or $id === Block::MYCELIUM or $id === Block::REPEATING_COMMAND_BLOCK or $id === Block::CHORUS_PLANT or $id === Block::CHORUS_FLOWER){
			return new Color(127, 63, 178);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_BLUE) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_BLUE) or $id === Block::BLUE_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_BLUE) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_BLUE) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_BLUE)){
			return new Color(51, 76, 178);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_BROWN) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_BROWN) or $id === Block::BROWN_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_BROWN) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_BROWN) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_BROWN) or $id === Block::SOUL_SAND or ($id === Block::WOOD2 and ($meta & 0x03) == Wood2::DARK_OAK) or ($id === Block::PLANKS and $meta == Planks::DARK_OAK) or ($id === Block::FENCE and $meta == Planks::DARK_OAK) or $id === Block::DARK_OAK_FENCE_GATE or $id === Block::DARK_OAK_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::DARK_OAK) or $id === Block::COMMAND_BLOCK){
			return new Color(102, 76, 51);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_GREEN) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_GREEN) or $id === Block::GREEN_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_GREEN) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_GREEN) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_GREEN) or $id === Block::END_PORTAL_FRAME or $id === Block::CHAIN_COMMAND_BLOCK){
			return new Color(102, 127, 51);
		}elseif(($id === Block::CONCRETE and $meta == self::COLOR_BLOCK_RED) or ($id === Block::CONCRETE_POWDER and $meta == self::COLOR_BLOCK_RED) or $id === Block::RED_GLAZED_TERRACOTTA or ($id === Block::WOOL and $meta == self::COLOR_BLOCK_RED) or ($id === Block::CARPET and $meta == self::COLOR_BLOCK_RED) or ($id === Block::STAINED_HARDENED_CLAY and $meta == self::COLOR_BLOCK_RED) or $id === Block::RED_MUSHROOM_BLOCK or $id === Block::BRICK_BLOCK or ($id === Block::STONE_SLAB and ($meta & 0x07) == 4) or $id === Block::BRICK_STAIRS or $id === Block::ENCHANTING_TABLE or $id === Block::NETHER_WART_BLOCK or $id === Block::NETHER_WART_PLANT){
			return new Color(153, 51, 51);
		}elseif(($id === Block::WOOL and $meta == 0) or ($id === Block::CARPET and $meta == 0) or ($id === Block::STAINED_HARDENED_CLAY and $meta == 0) or $id === Block::DRAGON_EGG or $id === Block::COAL_BLOCK or $id === Block::OBSIDIAN or $id === Block::END_PORTAL){
			return new Color(25, 25, 25);
		}elseif($id === Block::GOLD_BLOCK or $id === Block::LIGHT_WEIGHTED_PRESSURE_PLATE){
			return new Color(250, 238, 77);
		}elseif($id === Block::DIAMOND_BLOCK or ($id === Block::PRISMARINE and $meta == Prismarine::DARK) or ($id === Block::PRISMARINE and $meta == Prismarine::BRICKS) or $id === Block::BEACON){
			return new Color(92, 219, 213);
		}elseif($id === Block::LAPIS_BLOCK){
			return new Color(74, 128, 255);
		}elseif($id === Block::EMERALD_BLOCK){
			return new Color(0, 217, 58);
		}elseif($id === Block::PODZOL or ($id === Block::WOOD and ($meta & 0x03) == Wood::SPRUCE) or ($id === Block::PLANKS and $meta == Planks::SPRUCE) or ($id === Block::FENCE and $meta == Planks::SPRUCE) or $id === Block::SPRUCE_FENCE_GATE or $id === Block::SPRUCE_STAIRS or ($id === Block::WOODEN_SLAB and ($meta & 0x07) == Planks::SPRUCE)){
			return new Color(129, 86, 49);
		}elseif($id === Block::NETHERRACK or $id === Block::NETHER_QUARTZ_ORE or $id === Block::NETHER_BRICK_FENCE or $id === Block::NETHER_BRICK_BLOCK or $id === Block::MAGMA or $id === Block::NETHER_BRICK_STAIRS or ($id === Block::STONE_SLAB and ($meta & 0x07) == 7)){
			return new Color(112, 2, 0);
		}else{
			return new Color(0, 0, 0, 0);
		}
	}
}