<?php
/*
Plugin Name: ShortCode - Get Child List
Plugin URI: http://wordpress.org/extend/plugins/shortcode-get-child-list/
Description: This plugin consists of two short-code. Generate a sitemap [get_sitemap]. Generate a list of child pages [get_childlist id="parentID(can be omitted)" add="additional element(can be omitted)" exclude="exclude page by id(can be omitted)(e.g. exclude="34,123,35,23")" exclude_by_slug="exclude page by slug(can be omitted)(e.g. exclude_by_slug="test,hoge,home")"]
Author: ksakai
Version: 0.4
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

class sc_child_list {
	function get_childlist ($atts, $content=null) {
		global $post;
		extract(shortcode_atts(array(
			'id' => $post->ID,
			'exclude' => '',
			'exclude_by_slug' => '',
			'add' => ''
		), $atts));
		$exc_query = '';
		if ( $exclude!='' ) {
			$exc_array = explode( ',', $exclude );
			for ( $i=0; $i<count($exc_array); $i++ ) {
				if ( preg_match('/^[0-9]+$/', $exc_array[$i]) ) {
					$exc_query .= $exc_array[$i] . ',';
				}
			}
		}
		if ( $exclude_by_slug!='' ) {
			$exc_bs_array = explode( ',', $exclude_by_slug );
			$temp_html = wp_list_pages('title_li=&sort_column=menu_order&child_of='.$post->ID.'&echo=0');
			$page_array = array();
			preg_match_all('/<a(?:.*?)>(.*?)<\/a>/ui', $temp_html, $page_array, PREG_SET_ORDER);
			for ( $i=0; $i<count($page_array); $i++ ) {
				$page_obj = get_page_by_title($page_array[$i][1]);
				if ( in_array( $page_obj->post_name, $exc_bs_array ) ) {
					$exc_query .= $page_obj->ID . ',';
				}
			}
		}
		rtrim($exc_query,',');
		if(wp_list_pages("title_li=&child_of=$id&echo=0" )) {
			$html = '<ul>';
			$html .= wp_list_pages('title_li=&sort_column=menu_order&child_of='.$id.'&echo=0&exclude=' . $exc_query);
			if ($add!="") {
				$html .= "<li class='page-item'>".$add."</li>";
			}
			$html .= "</ul>";
		} else {
			return FALSE;
		}
		return $html;
	}
	
	function get_sitemap () {
		$id = 0;
		/* Group Resctiction */
		if(class_exists("userGroups")){
			$pagesToExclude = userGroups::getPagesToExclude();
		}
		$html = "<div id='sitemap'>";
		if ( wp_list_pages("title_li=&child_of=$id&echo=0" ) ) {
			$html .= '<ul>' . wp_list_pages('title_li=&sort_column=menu_order&child_of='.$id.'&echo=0&exclude='.$pagesToExclude ) . '</ul>';
		}
		$html .= '</div>';
		return $html;
	}
}

add_shortcode('get_childlist', array('sc_child_list', 'get_childlist'));
add_shortcode('get_sitemap', array('sc_child_list', 'get_sitemap'));
?>
