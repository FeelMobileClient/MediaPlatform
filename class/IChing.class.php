<?php
/************************************************
 * IChing
 * Created by Liyang on 2016-04-03
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

class IChing {

	public $hexagramArr = array();
	public  $hexagramCount = 0;

	function __construct() {
		$hexagramArr['000000'] = '乾';
		$hexagramArr['111111'] = '坤';
		$hexagramArr['011101'] = '屯';
		$hexagramArr['101110'] = '蒙';
		$hexagramArr['000101'] = '需';
		$hexagramArr['101000'] = '讼';
		$hexagramArr['101111'] = '师';
		$hexagramArr['111101'] = '比';
		$hexagramArr['001100'] = '小';
		$hexagramArr['001000'] = '履';
		$hexagramArr['000111'] = '泰';
		$hexagramArr['111000'] = '否';
		$hexagramArr['010000'] = '同';
		$hexagramArr['000010'] = '大';
		$hexagramArr['110111'] = '谦';
		$hexagramArr['111011'] = '豫';
		$hexagramArr['011001'] = '随';
		$hexagramArr['100110'] = '蛊';
		$hexagramArr['001111'] = '临';
		$hexagramArr['111100'] = '观';
		$hexagramArr['011010'] = '噬嗑';
		$hexagramArr['010110'] = '贲';
		$hexagramArr['111110'] = '剥';
		$hexagramArr['011111'] = '复';
		$hexagramArr['011000'] = '无妄';
		$hexagramArr['000110'] = '大畜';
		$hexagramArr['011110'] = '颐';
		$hexagramArr['100001'] = '大过';
		$hexagramArr['101101'] = '坎';
		$hexagramArr['010010'] = '离';

		$hexagramArr['110001'] = '咸';
		$hexagramArr['100011'] = '恒';
		$hexagramArr['110000'] = '遁';
		$hexagramArr['000011'] = '大壮';
		$hexagramArr['111010'] = '晋';
		$hexagramArr['010000'] = '明夷';
		$hexagramArr['010100'] = '家人';
		$hexagramArr['001010'] = '';
	}


	private function divine() {
		$hexagramNo = null;

		for($index = 0; $index < 6; $index++) {
			$randNo = rand(0, 1);
			$hexagramNo .= $randNo;
		}
		return $hexagramNo;
	}
	

	public function getHexagram() {
		$hexagram = $this->hexagramArr[$this->divine()];
		return "伏羲六十四卦之".$this->divine();
		return "伏羲六十四卦之".$hexagram;
	}
}
?>
