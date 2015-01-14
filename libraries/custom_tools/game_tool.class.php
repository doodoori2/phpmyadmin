<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *
 *
 * @package
 */

if (! defined('PHPMYADMIN')) {
	exit;
}

class game_tool
{
	public function entry()
	{
		$response = PMA_Response::getInstance();
		$header = $response->getHeader();
		$scripts = $header->getScripts();
		$relationsPara = PMA_getRelationsParam();
		$response->addHTML('<div>');
		//$response->addHTML($GLOBALS['custom_tool']);
		//$response->addHTML(json_encode($GLOBALS['cfg']['Server']['user']));

		$retval = '<ul id="topmenu2">';
		$items = array();
		$items[] = array("url" => "/tools.php", "name" => "aaa");
		$items[] = array("url" => "/tools.php", "name" => "bbb");
		$items[] = array("url" => "/tools.php", "name" => "ccc");
		$items[] = array("url" => "/tools.php", "name" => "ddd");
		$selfUrl = "/";
		foreach ($items as $item) {
			$class = '';
			if ($item['url'] === $selfUrl) {
				$class = ' class="tabactive"';
			}
			$retval .= '<li>';
			$retval .= '<a' . $class;
			$retval .= ' href="' . $item['url'] . '">';
			$retval .= $item['name'];
			$retval .= '</a>';
			$retval .= '</li>';
		}
		$retval .= '</ul>';
		$retval .= '<div class="clearfloat"></div>';
		$response->addHTML($retval);
		$response->addHTML('</div>');
		$n = 30;
		$this->echo_apache_logs($response, $n);
	}

	private function echo_apache_logs($response, $n)
	{
		$log_filenames = $this->get_log_filenames();
		foreach ($log_filenames as $log_filename) {
			$response->addHTML('<div>');
			$response->addHTML('<p>'.$log_filename.'</p>');
			$response->addHTML('<xmp>');
			$content = $this->get_file_latest_lines($log_filename, $n);
			foreach($content as $line) {
				$response->addHTML($line);
			}
			$response->addHTML('</xmp>');
			$response->addHTML('</div>');
		}
	}

	private function get_log_filenames(){
		$log_filenames = array();
		switch ($_SERVER['HTTP_HOST']) {
			case "lpma.local":
				$path = "D:\\APM_Setup\\Server\\Apache\\logs";
				$log_filenames[] = $path . "\\lpma.error.log";
				$log_filenames[] = $path . "\\lpma.access.log";
				break;
		}
		return $log_filenames;
	}


	private function get_file_latest_lines($filename, $n)
	{
		if(!file_exists($filename))
			return array();
		$content = file_get_contents($filename);
		if(!$content)
			return array();
		$lines = explode("\n", $content);
		return array_slice($lines, -$n);
	}

	private function get_db_latest_rows($tablename, $field, $n)
	{
		$query = "SELECT * FROM `$tablename`";
		// $result = mysqli_query($handle, $query);
		$result = array();
		$row_num = 0;
		$rows = array();
		for ($i = 0; $i < $row_num; ++$i) {
			// $row = mysqli_fetch_assoc($result);
			$row = array();
			$rows[] = $row;
		}
		return $rows;
	}
}