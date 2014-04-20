<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/11/11
 * Time: 1:22 AM
 * To change this template use File | Settings | File Templates.
 */
 
?>

 <?=validation_errors('<div id="error">','</div>'); ?>



    <ul id="search-results">
        <li><h2>Search Results</h2></li>
    <?php
    if (@$first_search)
    {
        foreach($first_search->result() as $search_results)
        {
            foreach($pages->result() as $page)
            {
                if ($page->id == $search_results->place_on_page)
                {
                    $url = $page->url;
                }
            }
            //echo '<ul>';
            echo '<li>'.anchor($url,$search_results->header).'</li>';
            echo '<li>'.$url.'</li>';
            //echo '</ul>';
        }
    }

    if (@$second_search)
    {
        foreach($second_search->result() as $search_results)
        {
            //echo '<ul>';
            echo '<li>'.anchor('en/profile/'.$search_results->userid, word_limiter($search_results->bio, 10)).'</li>';
            echo '<li>en/profile/'.$search_results->userid.'</li>';
            //echo '</ul>';
        }
    }

    if (@$third_search)
    {
        foreach($third_search->result() as $search_results)
        {
            // project search
            //echo '<ul>';
            echo '<li><p>'.anchor('en/project/detail/'.$search_results->projectId,$search_results->project_overview).'</p></li>';
            echo '<li>en/project/detail/'.$search_results->projectId.'</li>';
            //echo '</ul>';
        }
    }

//    if ( (count($first_search) > 1 ) || (count($second_search) > 1 ) || (count($third_search) > 1 ) )
//    {
//
//    } else {
//
//        echo '<ul><li>No Results found, please try again.</li></ul>';
//    }
    ?>

        </ul>

