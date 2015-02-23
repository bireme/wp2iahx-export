<?php

if ( !function_exists( 'author_format' ) ) {
    function author_format($author) {
        $author = explode(' ', $author);
        $last_name = array_pop($author);
        $name = implode(' ', $author);
        echo ucfirst($last_name) . ', ' . ucfirst($name);
    }
}

?>
