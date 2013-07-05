 
    </div> <!-- /container -->
	
	<?php
	//only show second navbar on front-page.php
	if (is_front_page()) { ?>
    <div class="navbar navbar-fixed-bottom">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">Filter</a>
	  <ul class="nav">
<li><a href="#">Kao</a></li>
<li><a href="#">uni</a></li>
<li><a href="#">filter</a></li>
</ul>
    </div>
  </div>
</div>
<?php } ?>
    <?php wp_footer(); ?>

  </body>
</html>