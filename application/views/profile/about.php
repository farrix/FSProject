<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/6/11
 * Time: 4:08 PM
 * views/profile/about.php
 *
 * Only used to relay the bio information to the end user / visitor of the site.
 */
 ?>

<div id="global-image"><?=$global_image; ?></div>
<div id="bio-details">
    <div id="bio-section">
		<div id="other-projects">
			<h2>Other Projects</h2>
            <?php
                foreach($projects->result() as $project)
                {
                    echo '<p class="project_on_bio_page">'.anchor('en/project/detail/'.$project->projectId,'<img src="'.base_url().$project->project_image_url.'" alt="'.$project->project_overview.'" />').'</p>';
                }
            ?>

		</div>
		<div id="my-bio">
			<h2>My Bio</h2>
			<p><span><?php echo img($image); ?></span><?php echo $bio;  ?></p>
		</div>
		<div id="contact-me">
			<h2>Contact Me.</h2>
			<ul>
                <?php
                    foreach($related_social_data->result() as $my_social)
                    {
                        foreach($social_media_all->result() as $social)
                        {
                            if ($social->id == $my_social->smnid)
                            {
                                echo '<li class="icon">'.anchor($my_social->url,img($social->icon)).'</li>';
                            }
                        }
                    }
                ?>
            </ul>
		</div>
	</div>
</div>
