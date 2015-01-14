<?php

if (! defined('PHPMYADMIN')) {
	exit;
}

require_once 'libraries/custom_tools/debug_tool.class.php';

class index_tool
{
    public function entry()
    {
        $response = PMA_Response::getInstance();
//        $header = $response->getHeader();
//        $scripts = $header->getScripts();
//        $relationsPara = PMA_getRelationsParam();
        $response->addHTML('<div>');
        $response->addHTML('<h2>Limited PMA </h2>');
        $response->addHTML($this->get_display());
        $response->addHTML('</div>');
    }

    private function get_display(){
        $output = "";
        $ret = '<span class="dbItemControls">'
            . '<a href="custom_tools.php'
            . PMA_URL_getCommon()
            . '" class="showUnhide ajax" >Test'
            . '</a></span>';
        $output = $ret;

//        $response->addHTML(
//            '<form method="post" action="db_structure.php" '
//            . 'name="tablesForm" id="tablesForm">'
//        );
//
//        $response->addHTML(PMA_URL_getHiddenInputs($db));
//
//        $response->addHTML(
//            PMA_tableHeader(
//                $db_is_system_schema, $GLOBALS['replication_info']['slave']['status']
//            )
//        );

        //        $html .= '    <th' . $colspan . '>'
//            . '<a href="server_databases.php'
//            . PMA_URL_getCommon($_url_params) . '">' . "\n"
//            . '            ' . $stat['disp_name'] . "\n"
//            . ($sort_by == $stat_name
//                ? '            ' . PMA_Util::getImage(
//                    's_' . $sort_order . '.png',
//                    ($sort_order == 'asc' ? __('Ascending') : __('Descending'))
//                ) . "\n"
//                : ''
//            )
//            . '        </a></th>' . "\n";
//
//        $output .= PMA_Util::getListNavigator(
//            $databases_count, $pos, $_url_params, 'server_databases.php',
//            'frame_content', $GLOBALS['cfg']['MaxDbList']
//        );
       return $output;
    }
}