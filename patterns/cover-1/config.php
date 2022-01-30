<?php 

add_action( 'init', function(){

    $args = [
        'title'       => 'Cover 1',
        'description' => 'The main cover image',
        'categories'  => [ 'bbds', 'text' ],
        'content'     => '',
    ];

    $slug = basename(dirname(__FILE__));
    $path = __DIR__ . '/pattern.php';
    ob_start();
    include_once $path;
    $pattern = ob_get_clean();

    // echo '<pre>';
    // var_dump($pattern); exit;
    // $args['content'] = '<!-- wp:paragraph --><p>A single paragraph block style</p><!-- /wp:paragraph -->';
    $args['content'] = wp_kses_post( $pattern );
    register_block_pattern( 'bbds/' . $slug, $args );

    // var_dump($dd); exit;

});
