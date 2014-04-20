<!-- <p><br />Page rendered in {elapsed_time} seconds</p>  -->
<div id="footer">
    <div id="footer-content">
        <ul id="links">
            <li><?php echo anchor('en/index','Home');?></li>
            <li><?php echo anchor('en/about','About Us');?></li>
            <li><?php echo anchor('en/contact','Contact Us');?></li>
            <li><?php echo anchor('en/legal','Disclaimer');?></li>
            <li><?php echo anchor('sitemap/index','SiteMap');?></li>
        </ul>

        <p id="copyright">&copy; 2011 Full Sail University, Developed by WDDBS Inc.</p>
        <p id="createdwith">Software used to create this website and all of its deliverables are: Photoshop, Illustrator, Coda, Phpstorm2.1, Sequel Pro, Git, GitTower, CodeIgniter, Php, Mamp, Jquery</p>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.position.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin.js"></script>
    <!-- testing 2 below lines -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/nicedit/nicEdit.js"></script>
<!--<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>-->
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<!-- Google Analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25158525-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- networks -->
    <div id="social_media_pick">
        <p><label>Profile URL: </label><input type="text" name="url" id="url"/></p>
        <p>Please make sure that this url is correct, this can not be modified.</p>
    </div>

    <div id="delete">
        <p>Are you sure you want to delete this?</p>
    </div>
</body>
</html>