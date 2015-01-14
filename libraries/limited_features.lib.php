<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functions for limited feature by user
 * @package PhpMyAdmin
 */
if (!defined('PHPMYADMIN')) {
    exit;
}
//require_once './libraries/limited_features.lib.php';

function isAvailableFeature($item_type, $action = null)
{
    // elseif($item_type == "database" and $action == "") // ??? list??
    //  return (getLimitedFeatureAuth("database", "") == "W");
    if($item_type == "console") {
        return $GLOBALS['cfg']['ShowConsole'];
    } elseif($item_type == "table" and $action == "create") {
        return (getLimitedFeatureAuth("table", "create") == "W");
    } elseif($item_type == "directQuery") {
        return (getLimitedFeatureAuth("directQuery", "") == "W");
    } elseif($item_type == "bookmark" and $action == "form") {
        $auth = getLimitedFeatureAuth("bookmark", "form");
        return ($auth == "R" or $auth == "W");
    } else {
        error_log("isAvailableFeature unhandled type item_type: {$item_type} action: {$action}" );
    }
    return true;
}

function getLimitedFeatureAuth($item_type, $item_name, $database = null)
{
    $cfgRelation = PMA_getRelationsParam();
    $item_type = PMA_Util::sqlAddSlashes($item_type);
    $item_name = PMA_Util::sqlAddSlashes($item_name);
    if ($cfgRelation['limited_featureswork']) {
        $featureTable = PMA_Util::backquote($cfgRelation['db'])
            . "." . PMA_Util::backquote($cfgRelation['limited_features']);
        $userTable = PMA_Util::backquote($GLOBALS['cfg']['Server']['pmadb'])
            . "." . PMA_Util::backquote($GLOBALS['cfg']['Server']['users']);
        $sqlQuery = "SELECT auth FROM " . $featureTable
            . " WHERE `item_type` = '" . $item_type . "'"
            . " AND `usergroup` = (SELECT usergroup FROM "
            . $userTable . " WHERE `username` = '"
            . PMA_Util::sqlAddSlashes($cfgRelation['user']) . "')" // $GLOBALS['cfg']['Server']['user']
            . " AND `item_name` = '" . PMA_Util::sqlAddSlashes($item_name) . "'";
        if($database){
            $sqlQuery .= " AND `db_name` = '" . PMA_Util::sqlAddSlashes($database) . "'";
        }
        $result = PMA_queryAsControlUser($sqlQuery, false);
        if ($result) {
            $row = $GLOBALS['dbi']->fetchAssoc($result);
            $GLOBALS['dbi']->freeResult($result);
            return $row['auth'];
        }
    }
    return NULL;
}

function GetLimitedFeatureItems($item_type, $database, $is_allowed) {
    $featurePrivileges = array();
    $cfgRelation = PMA_getRelationsParam();
    $item_type = PMA_Util::sqlAddSlashes($item_type);
    if ($cfgRelation['limited_featureswork']) {
        $featureTable = PMA_Util::backquote($cfgRelation['db'])
            . "." . PMA_Util::backquote($cfgRelation['limited_features']);
        $userTable = PMA_Util::backquote($GLOBALS['cfg']['Server']['pmadb'])
            . "." . PMA_Util::backquote($GLOBALS['cfg']['Server']['users']);
        $sqlQuery = "SELECT `item_name`, `display_name` FROM " . $featureTable
            . " WHERE `item_type` = '" . $item_type . "'"
            . " AND `usergroup` = (SELECT usergroup FROM "
            . $userTable . " WHERE `username` = '"
            . PMA_Util::sqlAddSlashes($cfgRelation['user']) . "')"; // $GLOBALS['cfg']['Server']['user']
        if($database) {
            $sqlQuery .= " AND `db_name` = '" . PMA_Util::sqlAddSlashes($database) . "'";
        }
        if($is_allowed) {
            $sqlQuery .= " AND `auth` != 'N'";
        } else {
            $sqlQuery .= " AND `auth` = 'N'";
        }
        $result = PMA_queryAsControlUser($sqlQuery, false);
        if ($result) {
            while ($row = $GLOBALS['dbi']->fetchAssoc($result)) {
                $featurePrivileges[] = $row['item_name'];
            }
        }
        $GLOBALS['dbi']->freeResult($result);
    }
    return $featurePrivileges;
}

function FilterItems($items, $item_type, $database)
{
    if($GLOBALS['cfg']['limited_feature_policy'] == "deny") {
        $allowedItems = GetLimitedFeatureItems($item_type, $database, true);
        foreach ($items as $key => $item) {
            if (! in_array($item, $allowedItems)) {
                unset($items[$key]);
            }
        }
    } else {
        $deniedItems = GetLimitedFeatureItems($item_type, $database, false);
        foreach ($items as $key => $item) {
            if (in_array($item, $deniedItems)) {
                unset($items[$key]);
            }
        }
    }
    return $items;
}


function GetTablePrivilege($database, $is_allowed)
{
    return GetLimitedFeatureItems("table", $database, $is_allowed);
}

function GetDatabasePrivilege($is_allowed)
{
    return GetLimitedFeatureItems("database", NULL, $is_allowed);
}

function FilterDatabase($databases)
{
    return FilterItems($databases, "database", NULL);
}

function FilterTables($tables, $database)
{
    return FilterItems($tables, "table", $database);
}

?>