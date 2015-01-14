<?php

if (! defined('PHPMYADMIN')) {
	exit;
}

require_once 'libraries/custom_tools/debug_tool.class.php';

class history_tool
{
    public function entry()
    {
        $response = PMA_Response::getInstance();
//        $header = $response->getHeader();
//        $scripts = $header->getScripts();
//        $relationsPara = PMA_getRelationsParam();
        $response->addHTML('<div>');
        $response->addHTML('<h2>Use History</h2>');
        $response->addHTML('<h3>Login info: '.$GLOBALS['cfg']['Server']['user'].' ('.$_SERVER['REMOTE_ADDR'].')</h3>');
        $response->addHTML($this->get_display());
        $response->addHTML('</div>');
    }

    private function get_display(){
        $_sql_history = PMA_getHistory($GLOBALS['cfg']['Server']['user']);
        $output = "";
        if ($_sql_history) {
            $output .= "<table>";
            $output .= "<thead><tr><th>table</th><th>timevalue</th><th>query</th></tr>";
            foreach ($_sql_history as $record) {
                $output .= '<tr><td>'
                    . htmlspecialchars($record['db'])
                    . '.'
                    . htmlspecialchars($record['table'])
                    . '</td><td>'
                    . htmlspecialchars($record['timevalue'])
                    . '</td><td>'
                    . htmlspecialchars($record['sqlquery'])
                    . '</td></tr>';
            }
            $output .= "</table>";
        }
        return $output;
    }
}