<?php
/************************************************
 * FileTools
 * Created by Liyang on 2016-03-31
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

class FileTools {
	
	function __construct() {

	}

	public function getPhpFile($fileName) {
		return trim(substr(file_get_contents($fileName), 15));
	}

	public function setPhpFile($fileName, $contents) {
		$fp = fopen($fileName, "w");
		fwrite($fp, "<?php exit();?>$contents");
		fclose($fp);
	}
}
?>
