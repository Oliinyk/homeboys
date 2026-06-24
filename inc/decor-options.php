<?php
/**
 * Decor Options.
 *
 * Pulls the content zone of partner manufacturer decor pages, caches it,
 * refreshes once a day via WP-Cron, and exposes it over REST so the
 * Decor Options template can render each one isolated inside a Shadow DOM
 * (manufacturer's own styles, full width, no iframe).
 *
 * @package Home_Boys_2
 */

defined( 'ABSPATH' ) || exit;

const HB2_DECOR_CACHE_PREFIX = 'hb2_decor_cache_';
const HB2_DECOR_CRON_HOOK    = 'hb2_decor_daily_refresh';

/**
 * Manufacturers shown as Decor Options tabs.
 *
 * `ready` gates whether we actually proxy the site yet; non-ready tabs show a
 * "coming soon" placeholder. `selector` is an XPath to the content zone; null
 * falls back to heuristics in hb2_decor_extract().
 *
 * @return array<string,array>
 */
function hb2_decor_manufacturers() {
	return array(
		'goldenwest' => array(
			'name'     => 'Golden West Homes',
			'url'      => 'https://decor.goldenwestalbany.com/',
			'selector' => '//div[contains(concat(" ", normalize-space(@class), " "), " app-container ")]',
			'ready'    => true,
		),
		'marlette'   => array(
			'name'     => 'Marlette Homes',
			'url'      => 'https://claytonhermiston.com/decor/',
			'selector' => '//main[@id="main"]',
			'ready'    => true,
		),
		'cavco'      => array(
			'name'     => 'Cavco Nampa / Fleetwood Homes of Idaho',
			'url'      => 'https://www.cavcoidaho.com/manufactured-home-decor/',
			'selector' => '//div[@data-elementor-type="wp-page"]',
			'ready'    => true,
		),
	);
}

/**
 * Return the cached payload for a manufacturer, fetching on first access.
 *
 * @param string $key Manufacturer key.
 * @return array{html:string,styles:string[],fetched:int,error:string}|null
 */
function hb2_decor_get( $key ) {
	$manufacturers = hb2_decor_manufacturers();
	if ( ! isset( $manufacturers[ $key ] ) ) {
		return null;
	}

	$cached = get_option( HB2_DECOR_CACHE_PREFIX . $key );
	if ( is_array( $cached ) && ! empty( $cached['html'] ) ) {
		return $cached;
	}

	return hb2_decor_refresh_one( $key );
}

/**
 * Fetch, extract and cache a single manufacturer.
 *
 * On failure (or empty extraction) the last good cache is preserved so the
 * page never goes blank because the partner changed their markup.
 *
 * @param string $key Manufacturer key.
 * @return array|null
 */
function hb2_decor_refresh_one( $key ) {
	$manufacturers = hb2_decor_manufacturers();
	if ( ! isset( $manufacturers[ $key ] ) ) {
		return null;
	}

	$m   = $manufacturers[ $key ];
	$old = get_option( HB2_DECOR_CACHE_PREFIX . $key );

	$response = wp_remote_get(
		$m['url'],
		array(
			'timeout'    => 30,
			'user-agent' => 'Mozilla/5.0 (compatible; HomeBoysDecorBot/1.0; +https://thehomeboys.com)',
		)
	);

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( is_wp_error( $response ) || 200 !== $code ) {
		$error = is_wp_error( $response ) ? $response->get_error_message() : 'HTTP ' . $code;
		return hb2_decor_keep_old( $key, $old, $error );
	}

	$now     = time();
	$payload = hb2_decor_extract( wp_remote_retrieve_body( $response ), $m['url'], $m['selector'] );

	// Never overwrite a good cache with empty content.
	if ( '' === $payload['html'] ) {
		return hb2_decor_keep_old( $key, $old, 'content zone not found' );
	}

	$new_hash = md5( $payload['html'] );

	// Daily check: content identical to the donor's last snapshot — record the
	// check time and keep the cached copy (no write of html/styles).
	if ( is_array( $old ) && isset( $old['hash'] ) && $old['hash'] === $new_hash ) {
		$old['checked'] = $now;
		$old['error']   = '';
		update_option( HB2_DECOR_CACHE_PREFIX . $key, $old, false );
		return $old;
	}

	// Changed (or first fetch): store the new snapshot.
	$payload['hash']    = $new_hash;
	$payload['fetched'] = $now;
	$payload['checked'] = $now;
	$payload['changed'] = $now;
	$payload['error']   = '';

	update_option( HB2_DECOR_CACHE_PREFIX . $key, $payload, false );

	return $payload;
}

/**
 * Persist an error against the previous cache (or an empty payload) and return it.
 *
 * @param string     $key   Manufacturer key.
 * @param array|null $old   Previous cache.
 * @param string     $error Error message.
 * @return array
 */
function hb2_decor_keep_old( $key, $old, $error ) {
	if ( is_array( $old ) ) {
		$old['error'] = $error;
		update_option( HB2_DECOR_CACHE_PREFIX . $key, $old, false );
		return $old;
	}

	return array(
		'html'    => '',
		'styles'  => array(),
		'fetched' => 0,
		'error'   => $error,
	);
}

/**
 * Refresh every manufacturer. Hooked to the daily cron event.
 */
function hb2_decor_refresh_all() {
	foreach ( array_keys( hb2_decor_manufacturers() ) as $key ) {
		$m = hb2_decor_manufacturers()[ $key ];
		if ( empty( $m['ready'] ) ) {
			continue;
		}
		hb2_decor_refresh_one( $key );
	}
}
add_action( HB2_DECOR_CRON_HOOK, 'hb2_decor_refresh_all' );

/**
 * Schedule the daily refresh once.
 */
add_action( 'init', function () {
	if ( ! wp_next_scheduled( HB2_DECOR_CRON_HOOK ) ) {
		wp_schedule_event( time() + MINUTE_IN_SECONDS, 'daily', HB2_DECOR_CRON_HOOK );
	}
} );

/**
 * Admin-only manual refresh: /any-page/?hb2_decor_refresh=all (or a key).
 */
add_action( 'init', function () {
	if ( empty( $_GET['hb2_decor_refresh'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$target = sanitize_key( wp_unslash( $_GET['hb2_decor_refresh'] ) );
	if ( 'all' === $target ) {
		hb2_decor_refresh_all();
	} else {
		hb2_decor_refresh_one( $target );
	}
}, 20 );

/**
 * REST: GET /wp-json/hb2/v1/decor/{key} -> { html, styles, fetched, error }.
 */
add_action( 'rest_api_init', function () {
	register_rest_route(
		'hb2/v1',
		'/decor/(?P<key>[a-z0-9_-]+)',
		array(
			'methods'             => 'GET',
			'permission_callback' => '__return_true',
			'callback'            => function ( $request ) {
				$payload = hb2_decor_get( $request['key'] );
				if ( null === $payload ) {
					return new WP_Error( 'hb2_decor_unknown', 'Unknown manufacturer', array( 'status' => 404 ) );
				}
				return rest_ensure_response(
					array(
						'html'    => $payload['html'],
						'styles'  => $payload['styles'],
						'fetched' => isset( $payload['fetched'] ) ? $payload['fetched'] : 0,
						'checked' => isset( $payload['checked'] ) ? $payload['checked'] : 0,
						'changed' => isset( $payload['changed'] ) ? $payload['changed'] : 0,
						'error'   => $payload['error'],
					)
				);
			},
		)
	);
} );

/**
 * Extract the content zone and stylesheet URLs from a manufacturer document.
 *
 * Strips scripts/forms/iframes/header/footer, absolutizes inline URLs. CSS that
 * references images via url() resolves against the partner's CSS files, so those
 * are left to the browser.
 *
 * @param string      $html     Raw HTML.
 * @param string      $base_url  Document URL (for resolving relative links).
 * @param string|null $selector  XPath to the content node, or null for heuristics.
 * @return array{html:string,styles:string[]}
 */
function hb2_decor_extract( $html, $base_url, $selector = null ) {
	$styles = array();
	if ( '' === trim( (string) $html ) ) {
		return array( 'html' => '', 'styles' => $styles );
	}

	// Strip scripts/comments from the raw markup first: libxml's HTML parser
	// can terminate an inline <script> early at a "</" inside a JS string and
	// leak the remainder as visible text nodes. Removing them up front avoids
	// that and drops the partner's (non-functional here) configurator JS.
	$html = preg_replace( '#<script\b[^>]*>.*?</script>#is', '', $html );
	$html = preg_replace( '#<noscript\b[^>]*>.*?</noscript>#is', '', $html );
	$html = preg_replace( '#<!--.*?-->#s', '', $html );

	$prev = libxml_use_internal_errors( true );
	$doc  = new DOMDocument();
	$doc->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );

	$xpath = new DOMXPath( $doc );

	// Stylesheet links.
	foreach ( $xpath->query( '//link[@rel="stylesheet"][@href]' ) as $link ) {
		$href = hb2_decor_abs_url( $link->getAttribute( 'href' ), $base_url );
		if ( '' !== $href ) {
			$styles[] = $href;
		}
	}

	// Inline <style> (Elementor critical CSS etc.).
	$inline_css = '';
	foreach ( $xpath->query( '//head//style' ) as $style ) {
		$inline_css .= $style->textContent . "\n";
	}

	// Content node.
	$node = null;
	$queries = array();
	if ( $selector ) {
		$queries[] = $selector;
	}
	$queries = array_merge(
		$queries,
		array(
			'//div[@data-elementor-type="wp-page"]',
			'//main',
			'//*[@id="content"]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " site-main ")]',
			'//article',
			'//body',
		)
	);
	foreach ( $queries as $q ) {
		$found = $xpath->query( $q );
		if ( $found && $found->length ) {
			$node = $found->item( 0 );
			break;
		}
	}
	if ( ! $node ) {
		return array( 'html' => '', 'styles' => array_values( array_unique( $styles ) ) );
	}

	// Drop unwanted descendants.
	$drop = array();
	$drop_query = './/script | .//noscript | .//iframe | .//form'
		. ' | .//*[contains(@class,"elementor-location-header")]'
		. ' | .//*[contains(@class,"elementor-location-footer")]';
	foreach ( $xpath->query( $drop_query, $node ) as $el ) {
		$drop[] = $el;
	}
	foreach ( $drop as $el ) {
		if ( $el->parentNode ) {
			$el->parentNode->removeChild( $el );
		}
	}

	hb2_decor_absolutize_node( $node, $base_url );

	$content_html = $doc->saveHTML( $node );
	if ( '' !== trim( $inline_css ) ) {
		$content_html = '<style>' . $inline_css . '</style>' . $content_html;
	}

	return array(
		'html'   => $content_html,
		'styles' => array_values( array_unique( $styles ) ),
	);
}

/**
 * Absolutize every URL-bearing attribute inside a node (and the node itself).
 *
 * @param DOMNode $node Content node.
 * @param string  $base Base URL.
 */
function hb2_decor_absolutize_node( $node, $base ) {
	$xpath    = new DOMXPath( $node->ownerDocument );
	$url_attrs = array( 'src', 'href', 'poster', 'data-src', 'data-lazy-src', 'data-bg' );

	$elements = array( $node );
	foreach ( $xpath->query( './/*', $node ) as $el ) {
		$elements[] = $el;
	}

	foreach ( $elements as $el ) {
		if ( ! $el instanceof DOMElement ) {
			continue;
		}
		foreach ( $url_attrs as $attr ) {
			if ( $el->hasAttribute( $attr ) ) {
				$el->setAttribute( $attr, hb2_decor_abs_url( $el->getAttribute( $attr ), $base ) );
			}
		}
		if ( $el->hasAttribute( 'srcset' ) ) {
			$el->setAttribute( 'srcset', hb2_decor_abs_srcset( $el->getAttribute( 'srcset' ), $base ) );
		}
		if ( $el->hasAttribute( 'style' ) ) {
			$el->setAttribute( 'style', hb2_decor_abs_style( $el->getAttribute( 'style' ), $base ) );
		}
	}
}

/**
 * Resolve a possibly-relative URL against a base, forcing https.
 *
 * @param string $url  URL.
 * @param string $base Base URL.
 * @return string
 */
function hb2_decor_abs_url( $url, $base ) {
	$url = trim( $url );
	if ( '' === $url || 0 === strpos( $url, 'data:' ) || 0 === strpos( $url, '#' ) ) {
		return $url;
	}
	// Protocol-relative.
	if ( 0 === strpos( $url, '//' ) ) {
		return 'https:' . $url;
	}
	// Absolute.
	if ( preg_match( '#^https?://#i', $url ) ) {
		return preg_replace( '#^http://#i', 'https://', $url );
	}

	$parts = wp_parse_url( $base );
	if ( empty( $parts['host'] ) ) {
		return $url;
	}
	$origin = 'https://' . $parts['host'];
	$path   = isset( $parts['path'] ) ? $parts['path'] : '/';

	if ( 0 === strpos( $url, '/' ) ) {
		return $origin . $url;
	}

	$dir = preg_replace( '#/[^/]*$#', '/', $path );
	return $origin . $dir . $url;
}

/**
 * Absolutize each candidate in a srcset attribute.
 *
 * @param string $srcset srcset value.
 * @param string $base   Base URL.
 * @return string
 */
function hb2_decor_abs_srcset( $srcset, $base ) {
	$out = array();
	foreach ( explode( ',', $srcset ) as $candidate ) {
		$candidate = trim( $candidate );
		if ( '' === $candidate ) {
			continue;
		}
		$bits = preg_split( '#\s+#', $candidate, 2 );
		$url  = hb2_decor_abs_url( $bits[0], $base );
		$out[] = isset( $bits[1] ) ? $url . ' ' . $bits[1] : $url;
	}
	return implode( ', ', $out );
}

/**
 * Absolutize url(...) references inside an inline style attribute.
 *
 * @param string $style style value.
 * @param string $base  Base URL.
 * @return string
 */
function hb2_decor_abs_style( $style, $base ) {
	return preg_replace_callback(
		'#url\(\s*([\'"]?)([^\'")]+)\1\s*\)#i',
		function ( $m ) use ( $base ) {
			return 'url(' . $m[1] . hb2_decor_abs_url( $m[2], $base ) . $m[1] . ')';
		},
		$style
	);
}

/**
 * Enqueue tab assets only on the Decor Options template.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_page_template( 'decor-options-template.php' ) ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/decor-options.css';
	$js_path  = get_template_directory() . '/assets/js/decor-options.js';

	wp_enqueue_style( 'hb2-decor-options', get_template_directory_uri() . '/assets/css/decor-options.css', array(), file_exists( $css_path ) ? filemtime( $css_path ) : _S_VERSION );
	wp_enqueue_script( 'hb2-decor-options', get_template_directory_uri() . '/assets/js/decor-options.js', array(), file_exists( $js_path ) ? filemtime( $js_path ) : _S_VERSION, true );
	wp_localize_script(
		'hb2-decor-options',
		'HB2_DECOR',
		array(
			'rest' => esc_url_raw( rest_url( 'hb2/v1/decor/' ) ),
		)
	);
} );
