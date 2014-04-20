<div id="content-information">
    <div id="image-rotate-area">
        <p><a href='#' class="next"></a></p>
        <p><a href='#' class="prev"></a></p>
        <ul id="rotating-banner">
        <?php
            foreach($rotate_banner->result() as $image)
            {
                /* this will list the images on the page */
                echo '<li>'.anchor('en/project/detail/'.$image->projectId,img($image->project_image_url)).'</li>';
            }
        ?>
        </ul>

    </div>
<?php
        if ($this->session->flashdata('success'))
        {
            echo '<article id="success">'.$this->session->flashdata('success').'</article>';
        }

        if ($this->session->flashdata('error'))
        {
            echo '<article id="error">'.$this->session->flashdata('error').'.</article>';
        }
    ?>

	<div id="about-fullsail">
		<h2><?php echo @$content[0]->header; ?></h2>
		<p><?php echo @$content[0]->content; ?></p>
	</div>
	<div id="recent-work">
		<h2>Recent Work</h2>
            <ul>


    <?php
        foreach( $last_projects->result() as $p_last)
        {
            $image_properties = array(
                'alt' => 'Project Image',
                'src' => $p_last->project_image_url
            );
            echo '<li class="recent-work-image">'.anchor('en/project/detail/'.$p_last->projectId,img($image_properties)).'</li>';
        }
        ?>
            </ul>
	</div>
	<div id="latest-producer">
		<h2>Latest Producer</h2>
		<?php
                if (@$latest_bio)
                {
                    foreach ($latest_bio->result() as $bio)
                    {
                        echo word_limiter($bio->bio, 100);
                    }

                } else { echo 'No content'; }
            ?>
        
    </div>
</div>