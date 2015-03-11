<?php

if ( !function_exists( 'author_format' ) ) {
    function author_format($author) {
        $author = explode(' ', $author);
        if ( count($author) > 1 ) {
            $last_name = array_pop($author);
            $name = implode(' ', $author);
            $au = ucfirst($last_name) . ', ' . ucfirst($name);
        }
        echo $au ? $au : ucfirst($author[0]);
    }
}

?>
