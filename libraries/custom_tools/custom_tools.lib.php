<?php

if (! defined('PHPMYADMIN')) {
	exit;
}

// require_once './libraries/custom_tools/custom_tools.lib.php';

function getMenuCustomTabList(){
    // all list
	return array(
		'index'       => __('CustomTool'),
		'debug'       => __('DebugTool'),
		'game'        => __('GameTool'),
		'player'      => __('PlayerTool'),
        'coupon'      => __('CouponTool'),
        'history'      => __('History'),
	);
}

function getCustomToolTabs()
{
    $tabs = array();
    $cfgRelation = PMA_getRelationsParam();
    if($cfgRelation['custom_toolswork']) {
        $tabs['index']['text'] = __('Tools');
        $tabs['index']['icon'] = 'normalize.png';
        $tabs['index']['link'] = 'custom_tools.php';
        $tabs['index']['args'] = array('custom_tool' => 'index');
        $tabs['index']['active'] = (isset($GLOBALS['custom_tool']) && $GLOBALS['custom_tool'] != 'index')?false:true;

        // TODO get data from DB, by user
        $cutsom_tools = array();
        $cutsom_tools[] = array('code' => 'index', 'title' => 'CustomTool');
        $cutsom_tools[] = array('code' => 'debug', 'title' => 'DebugTool');
        $cutsom_tools[] = array('code' => 'player', 'title' => 'PlayerTool');
        $cutsom_tools[] = array('code' => 'game', 'title' => 'GameTool');
        $cutsom_tools[] = array('code' => 'coupon', 'title' => 'CouponTool');
        $cutsom_tools[] = array('code' => 'history', 'title' => 'History');
        if (! empty($cutsom_tools)) {
            foreach($cutsom_tools as $tools) {
                $tab = array();
                $code = $tools['code'];
                $tab['text'] = __($tools['title']);
                // $tabs[$code]['icon'] = $tools['icon'];
                $tab['link'] = 'custom_tools.php';
                $tab['args'] = array('custom_tool' => $code);
                $tab['active'] = false;
                if(isset($GLOBALS['custom_tool']) && $GLOBALS['custom_tool'] == $code)
                    $tab['active'] = true;
                $tabs[$code] = $tab;
            }
        }
    }
    return $tabs;
}
