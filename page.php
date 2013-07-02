<?php
get_header(); ?>

    <div class="row">
		<div class="span8">
        <?php if ( have_posts() ) : ?>

          <?php while ( have_posts() ) : the_post(); ?>
              <h1><?php the_title(); ?></h1>
              <p><?php the_content(); ?></p>
          <?php endwhile; ?>

        <?php else: ?>

            <h1>Nothing found</h1>

        <?php endif; ?>
		</div>
		<div class="span4">
			<?php get_sidebar(); ?>	
		</div>
    </div>

<?php
get_footer(); ?>