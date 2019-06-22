<?php
# This is web log system without Database

define("USE_Route", false); # If you using routes,you have to changet to true
define("SAVE_DIR", true); # If you want to save dir and file name,hyou have to change true
define("UNIQUE", true); # true¤Ë¤¹¤ë¤ÈUNIQUE_MINUTESÊ¬¤Ë°ìÅÙ¤·¤«µ­Ï¿¤µ¤ì¤Þ¤»¤ó¡£
define("UNIQUE_MINUTES", 10);


$savefile = 'data/'.date('Y_m_d').'.txt';

if (USE_Route) {
	/**
	 * @todo ¤¤¤Ä¤«Route¤ËÂÐ±þ¤µ¤»¤ë¡£
	 * YEahaha
	 */
	// class ClassName extends AnotherClass
	// {

	// 	function __construct(argument)
	// 	{
	// 		# code...
	// 	}
	// }
}else{
	$file = debug_backtrace();
	if (!file_exists($savefile)) {
		touch($savefile);
	}
	$exploded_filename = explode('/', $file[0]["file"]);
		// var_dump($exploded_filename);
		// echo count($exploded_filename);
	$filename = $exploded_filename[count($exploded_filename)-1];
	if (!empty($filename)) {
		if (SAVE_DIR) {
			$filename = $file[0]["file"];
		}
		# Start shokika! (Reset varibles)
		$file = NULL;
		$exploded_filename = NULL;
		if (UNIQUE_MINUTES) {
			$data = file_get_contents($savefile);
			$data .= '{'.time().':'.$_SERVER["REMOTE_ADDR"].':'.$filename;
			file_put_contents($savefile, $data);
		}else{
			$data = file_get_contents($savefile);
			$data .= '{'.time().':'.$_SERVER["REMOTE_ADDR"].':'.$filename;
			file_put_contents($savefile, $data);
		}
	}
}
