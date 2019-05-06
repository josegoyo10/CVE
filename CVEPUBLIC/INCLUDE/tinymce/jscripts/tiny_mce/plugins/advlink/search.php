<?php
/**
* @version $Id: search.php,v 1.11 2005/02/16 10:43:04 akede Exp $
* @package Mambo
* @subpackage Search
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

//Modified for TinyMCE-EXP Advanced Link Search feature - 20/02/2005 Ryan Demmer

/** ensure this file is being included by a parent file */
define( '_VALID_MOS', 1 );

//require_once( $mainframe->getPath( 'front_html' ) );
        $base_path = "../../../../../../../";
        global $option;

        include_once ($base_path."globals.php");
        require_once ($base_path."configuration.php");
        require_once ($mosConfig_absolute_path."/includes/mambo.php");
        //require_once ($mosConfig_absolute_path."/includes/sef.php");
        require_once ("search.html.php");
        require_once ("searchbot.php");
        include ($base_path."mambots/editors/tinymce_exp/jscripts/tiny_mce/exp_config.php");

        $_MAMBOTS = new mosMambotHandler();

        include "$mosConfig_absolute_path/language/$mosConfig_lang.php";
        include ("langs/$editor_lang.php");

        $database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
        $mainframe = new mosMainframe ($database, $option, $base_path);

        $my = $mainframe->getUser();

        $gid = $my->gid;

        //These two functions are required to maintain compatability with Mambo 4.5.1
        function SmartSubstr($text, $length=200, $searchword) {
                 $wordpos = strpos(strtolower($text), strtolower($searchword));
                 $halfside = intval($wordpos - $length/2 - strlen($searchword));
                 if ($wordpos && $halfside > 0) {
                     return '...' . substr($text, $halfside, $length);
                 } else {
                     return substr( $text, 0, $length);
                 }
       }

        function PrepareSearchContent( $text, $length=200, $searchword ) {
                 // strips tags won't remove the actual jscript
                 $text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
                 $text = preg_replace( '/{.+?}/', '', $text);
                 //$text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2', $text );
                 return SmartSubstr( strip_tags( $text ), $length, $searchword );
        }

        // Adds parameter handling

        if( $Itemid > 0 ) {
                $menu =& new mosMenu( $database );
                $menu->load( $Itemid );
                $params =& new mosParameters( $menu->params );
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', $menu->name, _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        } else {
                $params =& new mosParameters('');
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        }

        // html output
        //search_html::openhtml( $params );

        $searchword = mosGetParam( $_REQUEST, 'searchword', '' );
        $searchword = $database->getEscaped( trim( $searchword ) );

        $search_ignore = array();
        @include "$mosConfig_absolute_path/language/$mosConfig_lang.ignore.php";

        $orders = array();
        $orders[] = mosHTML::makeOption( 'newest', _SEARCH_NEWEST );
        $orders[] = mosHTML::makeOption( 'oldest', _SEARCH_OLDEST );
        $orders[] = mosHTML::makeOption( 'popular', _SEARCH_POPULAR );
        $orders[] = mosHTML::makeOption( 'alpha', _SEARCH_ALPHABETICAL );
        $orders[] = mosHTML::makeOption( 'category', _SEARCH_CATEGORY );
        $ordering = mosGetParam( $_REQUEST, 'ordering', 'newest');
        $lists = array();
        $lists['ordering'] = mosHTML::selectList( $orders, 'ordering', 'class="inputbox"', 'value', 'text', $ordering );

        $searchphrase = mosGetParam( $_REQUEST, 'searchphrase', 'any' );
        $searchphrases = array();

        $phrase = new stdClass();
        $phrase->value = 'any';
        $phrase->text = _SEARCH_ANYWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'all';
        $phrase->text = _SEARCH_ALLWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'exact';
        $phrase->text = _SEARCH_PHRASE;
        $searchphrases[] = $phrase;

        $lists['searchphrase']= mosHTML::radioList( $searchphrases, 'searchphrase', '', $searchphrase );

        // html output
        search_html::searchbox( htmlspecialchars( $searchword ), $lists, $params );

        if (!$searchword) {
                if ( count( $_POST ) ) {
                        // html output
                        // no matches found
                        search_html::message( _NOKEYWORD, $params );
                }
        } else if ( in_array( $searchword, $search_ignore ) ) {
                // html output
                search_html::message( _IGNOREKEYWORD, $params );
        } else {
                // html output
                search_html::searchintro( htmlspecialchars( $searchword ), $params );

                //mosLogSearch( $searchword );
                $phrase         = mosGetParam( $_REQUEST, 'searchphrase', '' );
                $ordering         = mosGetParam( $_REQUEST, 'ordering', '' );

                //$_MAMBOTS->loadBotGroup( 'search' );
                $results         = array(botSearch( $searchword, $phrase, $ordering ));
                $totalRows         = 0;

                $rows = array();
                for ($i = 0, $n = count( $results); $i < $n; $i++) {
                        $rows = array_merge( $rows, $results[$i] );
                }

                $totalRows = count( $rows );

                for ($i=0; $i < $totalRows; $i++) {
                        $row = &$rows[$i]->text;
                        if ($phrase == 'exact') {
        $searchwords = array($searchword);
        $needle = $searchword;
      } else {
        $searchwords = explode(' ', $searchword);
        $needle = $searchwords[0];
      }

                $row = PrepareSearchContent( $row, 200, $needle );

      foreach ($searchwords as $hlword) {
                         $row = eregi_replace( $hlword, "<span style=\"background-color:#B6BDD2\">\\0</span>", $row);
                        }

                        if (!eregi( '^http', $rows[$i]->href )) {
                                // determines Itemid for Content items
                                if ( strstr( $rows[$i]->href, 'view' ) ) {
                                        // tests to see if itemid has already been included - this occurs for typed content items
                                        if ( !strstr( $rows[$i]->href, 'Itemid' ) ) {
                                                $temp = explode( 'id=', $rows[$i]->href );

                                                $itemid = $mainframe->getItemid($temp[1]);
                                                if ($itemid == ""){
                                                    $itemid = "0";
                                                }
                                                $rows[$i]->href = $rows[$i]->href. '&amp;Itemid='. $itemid;
                                        }
                                }
                        }
                }

                //$mainframe->setPageTitle( _SEARCH_TITLE );

                if ( $n ) {
                // html output
                        search_html::display( $rows, $params );
                } else {
                // html output
                        search_html::displaynoresult();
                }
        }
?>
