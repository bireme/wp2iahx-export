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

if ( $_GET['tax'] && $_GET['term'] ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => $_GET['tax'],
            'field'    => $_GET['field'] ? $_GET['field'] : 'slug',
            'terms'    => $_GET['term']
        )
    );
}

$posts = get_posts($args);

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

if ($_GET['ct'] && file_exists(dirname(__FILE__).'/custom/'.$_GET['ct'].'.php'))
    include_once(dirname(__FILE__).'/custom/'.$_GET['ct'].'.php');
else {
?>
<add>
    <language><?php bloginfo_rss( 'language' ); ?></language>
    <?php foreach ( $posts as $post ) : setup_postdata( $post ); $meta = get_post_meta( $post->ID ); ?>
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
            <?php foreach ( $meta as $key => $value ) : ?>
                <?php if ( $key != 'wpdecs_terms' ) { ?>
                    <?php $name = str_replace('-', '_', $key); ?>
                    <field name="<?php echo $name; ?>"><![CDATA[<?php echo $value[0]; ?>]]></field>
                <?php } ?>
            <?php endforeach; ?>
            <?php
                if (array_key_exists('wpdecs_terms', $meta)) {
                    $wpdecs_terms = unserialize($meta['wpdecs_terms'][0]);
                    foreach ( $wpdecs_terms as $decs ) :
                        if ($decs['qid']) {
                            foreach ( $decs['qid'] as $id ) :
                                ?>
                                <field name="mh"><![CDATA[<?php echo '^d' . $decs['mfn'] . '^s' . $id; ?>]]></field>
                                <?php
                            endforeach;
                        } else {
                            ?>
                            <field name="mh"><![CDATA[<?php echo '^d' . $decs['mfn']; ?>]]></field>
                            <?php
                        }
                    endforeach;
                }
            ?>
            <?php $cat = get_taxonomies(); $tax = wp_get_post_terms( $post->ID, $cat ); ?>
            <?php if ($tax) { ?>
                <?php foreach ( $tax as $t ) : ?>
                    <?php $name = str_replace('-', '_', $t->taxonomy); ?>
                    <field name="<?php echo $name; ?>"><![CDATA[<?php echo $t->name; ?>]]></field>
                <?php endforeach; ?>
            <?php } ?>
            <?php
                rss_enclosure();
                do_action('rss2_item');
            ?>
        </doc>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
</add>
<?php } ?>
