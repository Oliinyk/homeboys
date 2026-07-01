<?php
/**
 * "Show All" button.
 *
 * Callers may pass 'total' (total matching posts) and 'per_page' (current
 * limit); the button then renders only when some cards are actually hidden.
 * Without those args it keeps the old behaviour (always shown unless already
 * expanded via ?per_page).
 */
$total    = isset( $args['total'] )    ? (int) $args['total']    : null;
$per_page = isset( $args['per_page'] ) ? (int) $args['per_page'] : null;

// Already expanded via ?per_page — nothing left to reveal.
if ( isset( $_GET['per_page'] ) ) {
    return;
}

// Counts provided: hide the button when nothing is hidden (limit shows all,
// or no limit at all).
if ( null !== $total && null !== $per_page && ( $per_page < 1 || $total <= $per_page ) ) {
    return;
}
?>
<button type="button" class="btn primary-btn show-all-btn">
    Show All
</button>
