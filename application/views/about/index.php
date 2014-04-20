<div id="about-us">
	<div id="global-image">
        <?=$global_image; ?>
    </div>
	<div id="about-us-section">
		<div id="students-learn">
		    <h2><?php echo @$content[0]->header; ?></h2>
			<p><?php echo @$content[0]->content; ?></p>
		</div>
		<div id="produced">
			<h2><?php echo @$content[1]->header; ?></h2>
			<p><?php echo @$content[1]->content; ?></p>
		</div>
		<div id="skills">
			<h2><?php echo @$content[2]->header; ?></h2>
			<p><?php echo @$content[2]->content; ?></p>
		</div>
	</div>
</div>