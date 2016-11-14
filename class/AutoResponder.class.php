<?php
/************************************************
 * AutoResponder
 * Created by Liyang on 2016-03-29
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

class AutoResponder {

	public $phraseArr = array();
	public  $phraseCount = 0;

	function __construct() {

		array_push($this->phraseArr, "应无所住，而生其心！");

		array_push($this->phraseArr, "昔年种柳，依依汉南。今看摇落，凄怆江潭。树犹如此，人何以堪！--庾信《枯树赋》");

		array_push($this->phraseArr, "我不会讨人喜欢，我从小就不会讨人喜欢，后来我知道了如何讨人喜欢，我决定就不讨人喜欢。--崔永元");

		array_push($this->phraseArr, "每一个不曾起舞的日子，都是对生命的辜负。--尼采");
		array_push($this->phraseArr, "一个人有两个我，一个在黑暗中醒着，一个在光明中睡着。--纪伯伦");
		array_push($this->phraseArr, "若我会见到你，事隔经年。我如何向你招呼，以眼泪，以沉默。--拜伦");

		array_push($this->phraseArr, "我所担心的是我配不上我所遭受的苦难。--陀思妥耶夫斯基");

		array_push($this->phraseArr, "心脏是一座有两间卧室的房子，一间住着痛苦，另一间住着欢乐，人不能笑得太响。否则笑声会吵醒隔壁房间的痛苦。--卡夫卡");
		array_push($this->phraseArr, "最大的悲剧不是坏人的嚣张，而是好人的过度沉默。--马丁·路德·金");
		array_push($this->phraseArr, "到头来，我们记住的，不是敌人的攻击，而是朋友的沉默。--马丁·路德·金");
		array_push($this->phraseArr, "人生是个含泪的微笑。--欧·亨利");

		array_push($this->phraseArr, "也许是天生懦弱的关系,我对所有的喜悦都掺杂着不祥的预感。--三岛由纪夫");
		array_push($this->phraseArr, "发挥才智，则锋芒毕露；凭借感情，则流于世俗；坚持己见，则孤独无友；总之，人世难居。--《草枕》夏目漱石");

		// 反鸡汤
		array_push($this->phraseArr, "这个世界没有错，谁让你长的不好看又没钱。--网络");
		array_push($this->phraseArr, "有一种病叫看过听过励志演讲励志电影励志籍励志歌曲仿佛就已经奋斗努力过了。--网络");
		array_push($this->phraseArr, "又一天过去了，过得怎么样？梦想是不是更远了？--网络");
		array_push($this->phraseArr, "你以为只要长得帅就有女生喜欢？你以为只要有钱就能过的开心？你以为只有学霸才能找到好工作？我告诉你，这些都是真的！--网络");
		array_push($this->phraseArr, "你以为只要长得帅就有女生喜欢？你以为只要有钱就能过的开心？你以为只有学霸才能找到好工作？我告诉你，这些都是真的！--网络");
		array_push($this->phraseArr, "你只有努力过了才知道，智商上的巨大差距是不可逾越的。--网络");
		array_push($this->phraseArr, "人生就是这样，有欢笑也有泪水。一部分人主要负责欢笑，另外一部分人主要负责泪水。--网络");
		array_push($this->phraseArr, "你只需要看别人精彩，老天对你另有安排。--网络");
		array_push($this->phraseArr, "大部分人的成功靠的不是厚积薄发的努力，也不是戏剧化的机遇，而是早就定好的天赋与出身。
--网络");
		array_push($this->phraseArr, "懒是一个很好的托辞，说的好像只要勤快了就能干成什么大事一样。--网络");
		array_push($this->phraseArr, "生活会让你苦上一阵子，等你适应了，再让你苦上一辈子。--网络");
		array_push($this->phraseArr, "很多人每天都精神抖擞地去奋斗，仿佛全世界都在等着看他成功似的。--网络");
		array_push($this->phraseArr, "假如生活欺骗了你，不要悲伤，不要难过，他明天还会继续欺骗你。--网络");
		array_push($this->phraseArr, "所有抱怨社会不公和制度的人翻译过来只有一句话：给我金钱、女人和社会地位。
--网络");
		array_push($this->phraseArr, "你我都渴望成功，哪怕要付出很多，但我们连早点起床都做不到。--网络");
		array_push($this->phraseArr, "人是如此的容易放弃；有时整个世界好像都在反对你做的事情。那么，忘掉世界上还有其他的人吧。世上没有天才，总有一天你也能像你心中的”天才们“一样成为天才。--网络");

		$this->phraseCount = count($this->phraseArr);
	}


	private function getRandNo() {
		$randNo = rand(0, $this->phraseCount - 1);
		return $randNo;
	}
	

	public function getResponse() {
		$responseText = $this->phraseArr[$this->getRandNo()];
		return $responseText;
	}
}
?>
