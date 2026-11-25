<?php
/**
 * Dashboard: "What are you building?" personas and the setup checklist.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_personas  = \CozyAddons\Admin\Dashboard::personas();
$cozy_dashboard_checklist = \CozyAddons\Admin\Dashboard::get_checklist();
$cozy_dashboard_total     = count( $cozy_dashboard_checklist );
$cozy_dashboard_done      = count( array_filter( wp_list_pluck( $cozy_dashboard_checklist, 'done' ) ) );
$cozy_dashboard_ring      = 2 * M_PI * 17;
?>
<section class="cbd-card cbd-onboarding">
	<h2 class="cbd-card__title"><?php esc_html_e( 'What are you building?', 'cozy-addons' ); ?></h2>
	<p class="cbd-card__lead"><?php esc_html_e( 'We will tailor your next steps.', 'cozy-addons' ); ?></p>

	<div class="cbd-personas" role="radiogroup" aria-label="<?php esc_attr_e( 'What are you building?', 'cozy-addons' ); ?>">
		<?php foreach ( $cozy_dashboard_personas as $cozy_dashboard_key => $cozy_dashboard_persona ) : ?>
			<?php $cozy_dashboard_selected = $cozy_dashboard_key === $cozy_dashboard_state['persona']; ?>
			<button type="button" class="cbd-persona<?php echo $cozy_dashboard_selected ? ' is-selected' : ''; ?>" role="radio" aria-checked="<?php echo $cozy_dashboard_selected ? 'true' : 'false'; ?>" data-persona="<?php echo esc_attr( $cozy_dashboard_key ); ?>">
				<span class="cbd-tile-icon"><?php cozy_addons_dashboard_the_icon( 'users' ); ?></span>
				<strong><?php echo esc_html( $cozy_dashboard_persona['title'] ); ?></strong>
				<span><?php echo esc_html( $cozy_dashboard_persona['subtitle'] ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>

	<div class="cbd-tip" aria-live="polite">
		<span class="cbd-tip__icon"><?php cozy_addons_dashboard_the_icon( 'bulb', 14 ); ?></span>
		<?php foreach ( $cozy_dashboard_personas as $cozy_dashboard_key => $cozy_dashboard_persona ) : ?>
			<p data-persona-tip="<?php echo esc_attr( $cozy_dashboard_key ); ?>"<?php echo $cozy_dashboard_key === $cozy_dashboard_state['persona'] ? '' : ' hidden'; ?>>
				<?php echo esc_html( $cozy_dashboard_persona['tip'] ); ?>
			</p>
		<?php endforeach; ?>
	</div>

	<div class="cbd-checklist" data-total="<?php echo esc_attr( $cozy_dashboard_total ); ?>">
		<div class="cbd-checklist__head">
			<span class="cbd-ring">
				<svg width="44" height="44" viewBox="0 0 44 44" aria-hidden="true" focusable="false">
					<circle cx="22" cy="22" r="17" class="cbd-ring__track" />
					<circle cx="22" cy="22" r="17" class="cbd-ring__value" stroke-dasharray="<?php echo esc_attr( round( $cozy_dashboard_ring, 2 ) ); ?>" stroke-dashoffset="<?php echo esc_attr( round( $cozy_dashboard_ring * ( 1 - $cozy_dashboard_done / $cozy_dashboard_total ), 2 ) ); ?>" />
				</svg>
				<span class="cbd-ring__label"><span data-checklist-count><?php echo esc_html( $cozy_dashboard_done ); ?></span>/<?php echo esc_html( $cozy_dashboard_total ); ?></span>
			</span>
			<div>
				<h3><?php esc_html_e( 'Your setup checklist', 'cozy-addons' ); ?></h3>
				<p>
					<?php
					printf(
						/* translators: 1: number of finished steps, 2: total steps. */
						esc_html__( '%1$s of %2$s complete. Most people finish in under 15 minutes.', 'cozy-addons' ),
						'<span data-checklist-count>' . esc_html( $cozy_dashboard_done ) . '</span>',
						esc_html( $cozy_dashboard_total )
					);
					?>
				</p>
			</div>
		</div>

		<ul class="cbd-checklist__items">
			<?php foreach ( $cozy_dashboard_checklist as $cozy_dashboard_key => $cozy_dashboard_item ) : ?>
				<?php $cozy_dashboard_locked = $cozy_dashboard_item['auto'] || ! $cozy_dashboard_item['manual']; ?>
				<li class="cbd-task<?php echo $cozy_dashboard_item['done'] ? ' is-done' : ''; ?>" data-item="<?php echo esc_attr( $cozy_dashboard_key ); ?>">
					<button
						type="button"
						class="cbd-task__status"
						aria-pressed="<?php echo $cozy_dashboard_item['done'] ? 'true' : 'false'; ?>"
						<?php
						if ( $cozy_dashboard_locked ) {
							echo 'disabled';
						}
						?>
						title="<?php echo esc_attr( $cozy_dashboard_locked ? __( 'Detected automatically', 'cozy-addons' ) : __( 'Mark as done', 'cozy-addons' ) ); ?>"
					>
						<?php cozy_addons_dashboard_the_icon( 'check', 14 ); ?>
						<span class="screen-reader-text">
							<?php
							/* translators: %s: checklist step title. */
							printf( esc_html__( 'Mark "%s" as done', 'cozy-addons' ), esc_html( $cozy_dashboard_item['title'] ) );
							?>
						</span>
					</button>
					<div class="cbd-task__body">
						<h4><?php echo esc_html( $cozy_dashboard_item['title'] ); ?></h4>
						<p><?php echo esc_html( $cozy_dashboard_item['description'] ); ?></p>
					</div>
					<a class="cbd-btn cbd-btn--small" href="<?php echo esc_url( $cozy_dashboard_item['url'] ); ?>"><?php echo esc_html( $cozy_dashboard_item['action'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
