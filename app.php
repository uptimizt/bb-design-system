<?php
/*
* Plugin Name: BB Design System
* Description: Block-base design system for WordPress, Gutenberg and Full site editing
* Version: 1.20220205
*/

namespace BBDesignSystem;


add_action('plugins_loaded', function () {
    $n = function ($function) {
        return __NAMESPACE__ . '\\' . $function;
    };

    add_action('wp_enqueue_scripts', $n('add_mods_assets'));
    add_action('enqueue_block_editor_assets', $n('add_mods_assets'));
    add_action('init', $n('load_pattern_configs'), 9); //9 is needed because in the pattern config we use 10 as the default priority

});

function load_pattern_configs()
{
    register_block_pattern_category(
        'bbds',
        ['label' => 'BBDS']
    );

    foreach (get_directories() as $dir_name) {
        $dir_path = sprintf('%s/patterns/%s', __DIR__, $dir_name);
        if (!is_dir($dir_path)) {
            continue;
        }

        $file_path = sprintf('%s/config.php', $dir_path);

        if (!file_exists($file_path)) {
            continue;
        }

        require_once $file_path;
    }
}

function add_mods_assets()
{
    foreach (get_directories('mods') as $dir_name) {

        $dir_path = sprintf('%s/mods/%s', __DIR__, $dir_name);
        if (!is_dir($dir_path)) {
            continue;
        }

        $file_path = sprintf('%s/style.css', $dir_path);

        if (!file_exists($file_path)) {
            continue;
        }
        $file_url = plugins_url('mods/' . $dir_name . '/style.css', __FILE__);
        $file_version = filemtime($file_path);

        wp_enqueue_style($dir_name . '-style', $file_url, [], $file_version);
    }
}


function get_directories($subdir = 'patterns')
{
    $directories = scandir(__DIR__ . '/' . $subdir);
    $directories = array_diff($directories, array('..', '.'));
    return $directories;
}
