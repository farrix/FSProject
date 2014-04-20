<?php // admin header ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta name="robots" content="noarchive" />
<meta name="robots" content="nofollow" />
<meta name="robots" content="noindex" />
<meta name="description" content="Portfolio Students Fullsail" />
<meta name="keywords" content="fullsail porfolio alumni wddbs" />
<meta name="author" content="WDDBS Inc, Randall McMillan" />
<meta http-equiv="expires" content="Wed, 26 Feb 2012 08:21:57 GMT" />

    <?php
        /*
         * spot for meta tag data;
         */
        $meta = array(
            array('name'=>'robots', 'content' => 'no-cache' )
        );

        echo meta($meta);
    ?>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php echo link_tag('css/fullsail-site.css'); ?>
    <?php echo link_tag('css/fullsail-admin-site.css'); ?>
    <!--[if IE]>
    <?php echo link_tag('css/ie.css'); ?>
    <![endif]-->
	<?php echo link_tag('css/custom-theme/jquery-ui-1.8.14.custom.css'); ?>
    <link rel="shortcut icon" href="<?=base_url();?>images/favicon.ico" type="image/x-icon" />
	<title>Full Sail Admin</title>
</head>
<body>
	<div id="navbar">
            <ul id="menu">
                <li><?php echo anchor('cms/member/profile','Profile Settings');?></li>
                <li class="menu-div"></li>
                

            <?php
            if ($this->session->userdata('acl') == 'administrator' )
            {
                echo '<li>'.anchor('cms/member/admin','Admin Configuration').'</li>';
                echo '<li class="menu-div"></li>';

            } 
            ?>
            
            <li><?php echo anchor('en/index','Site Home');?></li>
            <li><?='<li class="menu-div"></li>';?></li>
            <li><?php echo anchor('cms/profile/logout','Logout');?></li>
            
            </ul>
		</div>
		<div id="logo-area">
		<?php 
			// setting properties of the logo.
			$image = array(
				'src' => 'images/fullsail_logo.png',
				'alt' => 'FullSail Logo',
				'class' => 'logo'
			);
			echo img($image); ?>
		</div>

       
	