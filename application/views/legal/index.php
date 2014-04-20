<div id="global-image"><?=$global_image; ?></div>
    <div id="legal">
	    <div id="content">
		<p><?php
                foreach( $content->result() as $legal)
                {
                    echo $legal->content;
                }
            ?>
        </p>
	</div>
</div>