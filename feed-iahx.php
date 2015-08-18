<?php
/**
 * Custom XML feed generator template.
 */

$args = array(
    'posts_per_page'   => $_GET['count'] ? $_GET['count'] : -1,
    'offset'           => $_GET['offset'] ? $_GET['offset'] : 0,
    'category'         => '',
    'category_name'    => $_GET['cat_name'] ? $_GET['cat_name'] : '',
    'orderby'          => 'post_date',
    'order'            => $_GET['order'] ? $_GET['order'] : 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => $_GET['post_type'] ? $_GET['post_type'] : 'any',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'post_status'      => $_GET['status'] ? $_GET['status'] : 'publish',
    'suppress_filters' => true
);
$posts = get_posts($args);

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

if ($_GET['ct'] && file_exists(dirname(__FILE__).'/custom/'.$_GET['ct'].'.php'))
    include_once(dirname(__FILE__).'/custom/'.$_GET['ct'].'.php');
else {
?>
<add>
    <language><?php bloginfo_rss( 'language' ); ?></language>
    <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
        <doc>
            <field name="id"><?php echo $post->post_type . '-' . $post->ID; ?></field>
            <field name="da"><?php echo mysql2date('Ymd', get_post_time('Y-m-d', true), true); ?></field>
            <field name="type"><?php echo $_GET['type'] ? $_GET['type'] : ''; ?></field>
            <field name="ti"><?php the_title_rss(); ?></field>
            <field name="db"><?php echo $_GET['db'] ? $_GET['db'] : ''; ?></field>
            <field name="ab"><?php $content = get_the_content_feed('rss2'); ?><![CDATA[<?php echo $content; ?>]]></field>
            <field name="ur"><?php the_permalink_rss(); ?></field>
            <field name="au"><?php $author = get_the_author(); ?><![CDATA[<?php author_format($author); ?>]]></field>
            <field name="la"><?php echo $_GET['la'] ? $_GET['la'] : ''; ?></field>
            <?php rss_enclosure(); ?>
            <?php do_action('rss2_item'); ?>
        </doc>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
</add>
<?php } ?>
