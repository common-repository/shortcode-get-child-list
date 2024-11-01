=== ShortCode - Get Child List ===
Contributors: ksakai
Tags: list pages, nagivation
Requires at least: 2.9
Tested up to: 3.0.1
Stable tag: trunk

This plugin provide two shortcode. Using the shortcode you can easily generate a childpage list, and also a sitemap.

== Description ==

With this plug-in, you can use shortcodes to output list of children pages or sitemap.
Write following shortcode in your post text.


Generate a sitemap : [get_sitemap]
Generate a list of child and descendant pages: [get_childlist]


You can also customize output with optional arguments:


[get_childlist id="parentID (optional)" add="additional element (optional)" exclude="exclude page by id (optional, e.g. exclude="34,123,35,23")" exclude_by_slug="exclude page by slug (optional, e.g. exclude_by_slug="test,hoge,home")]

== Screenshots ==

1. Using shortcode at editor
2. Example of output using options

== Installation ==

1. Download and unzip to the 'wp-content/plugins/' directory 
1. Activate the plugin.
