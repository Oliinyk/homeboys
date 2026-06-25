<?php
/**
 * Template name: Decor Options
 *
 * Lives under the Process section. Renders one tab per partner manufacturer;
 * each tab loads that manufacturer's decor content zone (proxied + cached in
 * inc/decor-options.php) into an isolated Shadow DOM, full width.
 */

$manufacturers = hb2_decor_manufacturers();
$keys          = array_keys( $manufacturers );

get_header();

// Overlay.
get_template_part( 'template-parts/modules/nav_overlay', null );
?>

<section class="hero-section decor-hero">
	<div class="container">
		<ul class="breadcrumbs">
			<li class="crumb-item">
				<a href="#">PROCESS</a>
			</li>
			<li class="crumb-item">
				<span><?php echo esc_html( get_the_title() ); ?></span>
			</li>
		</ul>

		<h4 class="subtitle-section">Our</h4>
		<h1 class="title-section">Decor Options</h1>

		<div class="location-list decor-tabs" role="tablist">
			<?php
			$i = 0;
			foreach ( $manufacturers as $key => $m ) :
				$is_active = ( 0 === $i );
				?>
				<div
					class="location-list-item decor-tab<?php echo $is_active ? ' active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
					aria-controls="decor-panel-<?php echo esc_attr( $key ); ?>"
					data-key="<?php echo esc_attr( $key ); ?>"
				>
					<h4 class="location-title"><?php echo esc_html( $m['name'] ); ?></h4>
					<p class="location-subtitle">Decor Options</p>
			</div>
				<?php
				$i++;
			endforeach;
			?>
		</div>
	</div>
</section>

<section class="decor-panels">
	<div class="container">
		<?php
		$i = 0;
		foreach ( $manufacturers as $key => $m ) :
			$is_active = ( 0 === $i );
			?>
			<div
				id="decor-panel-<?php echo esc_attr( $key ); ?>"
				class="decor-panel<?php echo $is_active ? ' active' : ''; ?>"
				role="tabpanel"
				data-key="<?php echo esc_attr( $key ); ?>"
				data-ready="<?php echo ! empty( $m['ready'] ) ? '1' : '0'; ?>"
				<?php echo $is_active ? '' : 'hidden'; ?>
			>
				<?php if ( empty( $m['ready'] ) ) : ?>
					<div class="decor-placeholder container">
						<p><?php echo esc_html( $m['name'] ); ?> decor options are coming soon.</p>
					</div>
				<?php else : ?>
					<div class="decor-loading container">Loading <?php echo esc_html( $m['name'] ); ?> decor options&hellip;</div>
				<?php endif; ?>
			</div>
			<?php
			$i++;
		endforeach;
		?>
	</div>
</section>

<?php
// Contact section.
get_template_part( 'template-parts/modules/section', 'contact' );

// Find Home section.
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();
