<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/6/11
 * Time: 2:46 PM
 * To change this template use File | Settings | File Templates.
 */

    
?>


	<div id="global-image"><?php echo img(@$image); ?></div>
<!--<section id="project_details">-->
    <div id="detail-section">
		<div id="bio-profile">
			<h2>Producer Profile</h2>
			<p><?php if (@$bio_image) { echo anchor('en/profile/'.@$userid, img(@$bio_image)); } else { echo '<img src="'.base_url().'./images/no-profile-pic.jpg" alt="No Profile Available"';} ?></p>
            <p>Please click on above image to read information about the producer of this work.</p>
            <h3>Additional Info</h3>
			<p><?php echo @$additional; ?></p>
		</div>
		<div id="project-overview">
			<h2>Project Overview</h2>

			<p><?php echo $overview;  ?></p>
		</div>
		<div id="tools-used">
			<h2>Tools Used</h2>
			<p><?php foreach($image_stack as $key => $path)
                    {
                        $image_properties = array(
                            'src' => $path['path'],
                            'alt' => 'Application Tool Icon',
                            'title' => $path['name']
                        );
                        echo img($image_properties);
                    }
            ?></p>
		</div>
	</div>
