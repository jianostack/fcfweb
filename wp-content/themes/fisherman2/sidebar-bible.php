<h5 class="dailyVerses"><?php echo get_cat_name(13); ?></h5>
<?php
if (ICL_LANGUAGE_CODE=='en'){
    $args = array('category__in' => array( 13 ), 'posts_per_page' => 1);
    $query = new WP_Query($args);
    if( $query->have_posts() ):
        while ( $query->have_posts() ) : $query->the_post();
            $book = get_field('book');
            $chapter = get_field('chapter');
            $start_verse = get_field('start_verse');
            $end_verse = get_field('end_verse');
        endwhile;
    endif;
    wp_reset_postdata();

    $token = 'IsXpwbBhyqHcV3TBoZrdXR863L3RWEb5gqzToSrG';
    $url = 'https://bibles.org/v2/chapters/eng-ESV:'.$book.'.'.$chapter.'/verses.xml?start='.$start_verse.'&end='.$end_verse;
    //$url = 'https://bibles.org/v2/chapters/eng-ESV:Gen.1/verses.xml?start=1&end=1';
    //$url='http://api.preachingcentral.com/bible.php?passage=John3:16-17&version=chinese-ncv-simplifi';
    //http://www.4-14.org.uk/xml-bible-web-service-api

    // Set up cURL
    $ch = curl_init();
    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // don't verify SSL certificate
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // Return the contents of the response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Follow redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    // Set up authentication
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$token:X");

    // Do the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode == 404) {
        curl_close($ch);
        echo 'error';
    } else {
        curl_close($ch);
        // Parse the XML into a SimpleXML object
        $xml = new SimpleXMLElement($response);

        $i=0;
        do {
            print($xml->verses->verse[$i]->text);
            $i++;
        }while(isset($xml->verses->verse[$i]->text));
    }


    $args = array('category__in' => array( 13 ), 'posts_per_page' => 1);
    $query = new WP_Query($args);
    if( $query->have_posts() ):
        while ( $query->have_posts() ) : $query->the_post();
            print'<div style="text-align:right;font-weight:bold"><em>';
            the_title();
            print'</em></div>';
        endwhile;
    endif;
    wp_reset_postdata();
} else if (ICL_LANGUAGE_CODE=='zh-hans'){
    //zh-hans post category loop
    $args = array('category__in' => array( 14 ), 'posts_per_page' => 1);
    $query = new WP_Query($args);
    if( $query->have_posts() ):
        while ( $query->have_posts() ) : $query->the_post();
            the_content();
            print'<div style="text-align:right;font-weight:bold"><em>';
            the_title();
            print'</em></div>';
        endwhile;
    endif;
    wp_reset_postdata();
}
?>


