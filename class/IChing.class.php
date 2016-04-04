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
		$this->hexagramArr['000000'] = '乾';
		$this->hexagramArr['111111'] = '坤';
		$this->hexagramArr['011101'] = '屯';
		$this->hexagramArr['101110'] = '蒙';
		$this->hexagramArr['000101'] = '需';
		$this->hexagramArr['101000'] = '讼';
		$this->hexagramArr['101111'] = '师';
		$this->hexagramArr['111101'] = '比';
		$this->hexagramArr['001100'] = '小';
		$this->hexagramArr['001000'] = '履';
		$this->hexagramArr['000111'] = '泰';
		$this->hexagramArr['111000'] = '否';
		$this->hexagramArr['010000'] = '同';
		$this->hexagramArr['000010'] = '大';
		$this->hexagramArr['110111'] = '谦';
		$this->hexagramArr['111011'] = '豫';
		$this->hexagramArr['011001'] = '随';
		$this->hexagramArr['100110'] = '蛊';
		$this->hexagramArr['001111'] = '临';
		$this->hexagramArr['111100'] = '观';
		$this->hexagramArr['011010'] = '噬嗑';
		$this->hexagramArr['010110'] = '贲';
		$this->hexagramArr['111110'] = '剥';
		$this->hexagramArr['011111'] = '复';
		$this->hexagramArr['011000'] = '无妄';
		$this->hexagramArr['000110'] = '大畜';
		$this->hexagramArr['011110'] = '颐';
		$this->hexagramArr['100001'] = '大过';
		$this->hexagramArr['101101'] = '坎';
		$this->hexagramArr['010010'] = '离';

		$this->hexagramArr['110001'] = '咸';
		$this->hexagramArr['100011'] = '恒';
		$this->hexagramArr['110000'] = '遁';
		$this->hexagramArr['000011'] = '大壮';
		$this->hexagramArr['111010'] = '晋';
		$this->hexagramArr['010000'] = '明夷';
		$this->hexagramArr['010100'] = '家人';
		$this->hexagramArr['001010'] = '睽';
		$this->hexagramArr['110101'] = '蹇';
		$this->hexagramArr['101011'] = '解';
		$this->hexagramArr['001110'] = '损';
		$this->hexagramArr['011100'] = '益';
		$this->hexagramArr['000001'] = '夬';
		$this->hexagramArr['100000'] = '姤';
		$this->hexagramArr['111001'] = '萃';
		$this->hexagramArr['100111'] = '升';
		$this->hexagramArr['101001'] = '困';
		$this->hexagramArr['100101'] = '井';
		$this->hexagramArr['010001'] = '革';
		$this->hexagramArr['100010'] = '鼎';
		$this->hexagramArr['011011'] = '震';
		$this->hexagramArr['110110'] = '艮';
		$this->hexagramArr['110100'] = '渐';
		$this->hexagramArr['001011'] = '归';
		$this->hexagramArr['010011'] = '丰';
		$this->hexagramArr['110010'] = '旅';
		$this->hexagramArr['100100'] = '巽';
		$this->hexagramArr['001001'] = '兑';
		$this->hexagramArr['101100'] = '涣';
		$this->hexagramArr['001101'] = '节';
		$this->hexagramArr['001100'] = '中孚';
		$this->hexagramArr['110011'] = '小过';
		$this->hexagramArr['010101'] = '即济';
		$this->hexagramArr['101010'] = '未济';
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
		return "伏羲六十四卦之".$hexagram;
	}
}
?>
