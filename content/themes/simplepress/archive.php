<?php

/**
 * @author Manuel Zarat
 * @date 05.01.2018
 * @license http://opensource.org/licenses/MIT
 * 
 * @todo search
 * 
 */

echo "<div class='sp-content'>\n";

while( $archive->have_posts() ) {

    $item = $archive->the_post( $strip_tags=true, $content_length=200 );
    
    echo "<div class='sp-content-item'>\n";
    echo "<div class='sp-content-item-head'><a href='../?type=$item[type]&id=$item[id]'>" . $item['title'] . "</a></div>\n";
    echo "<div class='sp-content-item-body'>" . $item['content'] . "</div>\n";
    echo "</div>\n";
    
}

$archive->pagination();

echo "</div>\n\n";

?>