<div><?PHP 

	/**
	 * Custom template tags for this theme.
	 *
	 * Eventually, some of the functionality here could be replaced by core features
	 *
 * @package genese
 */

 get_header(); ?>
<h2>Tag Archive</h2>
<?php wp_tag_cloud( '' ); ?>
<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'genese)', '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( tag_description() ) : // Show an optional tag description ?>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif; ?>
			</header>
<div>
	<div><?php next_posts_link( '« Older Entries' ); ?></div>
	<div><?php previous_posts_link( 'Newer Entries »' ); ?></div>
</div>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry">
			<?php the_content( 'Read the rest of this entry »' ); ?>
		</div>
	<?php endwhile; ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>