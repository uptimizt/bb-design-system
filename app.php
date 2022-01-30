<?php
/*
* Plugin Name: BB Design System
* Description: Block-base design system for WordPress, Gutenberg and Full site editing
* Version: 1.20220130.3
*/


namespace BBDesignSystem\Init;


add_action('init', function () {

    if (isset($_GET['dd'])) {

        exit;
    }

    register_block_pattern_category(
        'bbds',
        ['label' => 'BBDS']
    );

    load_pattern_configs();

}, 9);




add_action('plugins_loaded', function () {
    $n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

    // add_action( 'init', __NAMESPACE__ . '\add_categories'  );
    // add_action( 'init', $n( 'add_categories' ) );
    // add_action( 'init', __NAMESPACE__ . '\load_pattern_configs' );
    // add_action( 'init', $n( 'load_pattern_configs' ) );

});

function load_pattern_configs()
{
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


// function backend()
// {

//     foreach (self::get_directories() as $dir_name) {
//         $dir_path = sprintf('%s/lazyblock/%s', __DIR__, $dir_name);
//         if (!is_dir($dir_path)) {
//             continue;
//         }

//         $css_file_path = sprintf('%s/block.css', $dir_path);

//         if (!file_exists($css_file_path)) {
//             continue;
//         }
//         $block_css_url = plugins_url(sprintf('lazyblock/%s/block.css', $dir_name), __FILE__);
//         $block_css_version = filemtime($css_file_path);;

//         wp_enqueue_style($dir_name . '-style', $block_css_url, ['wp-edit-blocks'], $block_css_version);
//     }
// }


// function commone_style()
// {
//     $path = 'lazyblock/style.css';
//     $url = plugins_url($path, __FILE__);
//     $path = __DIR__ . '/' . $path;
//     if (file_exists($path)) {
//         wp_enqueue_style(
//             'style-lbu7',
//             $url,
//             $dep = [],
//             $var = filemtime($path)
//         );
//     }
// }



function get_directories()
{
    $directories = scandir(__DIR__ . '/patterns');
    $directories = array_diff($directories, array('..', '.'));
    return $directories;
}
