/**
 * Decor Options tabs.
 *
 * Switches tabs and lazily loads each ready manufacturer's proxied decor content
 * (fetched from the hb2/v1/decor REST route) into an isolated Shadow DOM so the
 * partner's own styles apply full width without leaking into the theme.
 */
( function () {
	'use strict';

	if ( typeof window.HB2_DECOR === 'undefined' ) {
		return;
	}

	var tabs   = Array.prototype.slice.call( document.querySelectorAll( '.decor-tab' ) );
	var panels = Array.prototype.slice.call( document.querySelectorAll( '.decor-panel' ) );

	if ( ! tabs.length ) {
		return;
	}

	/**
	 * Re-implement Bootstrap-style nav-tab switching inside a shadow root.
	 *
	 * The partner configurators ship their interactivity as page-level JS we
	 * strip on the way in (and inline scripts don't run inside a shadow root
	 * anyway). The markup is standard Bootstrap tabs — anchors with
	 * data-toggle="tab" pointing at #tab-pane ids — so we wire the show/hide
	 * ourselves. Sites without that pattern simply get no handlers.
	 *
	 * @param {ShadowRoot} root Shadow root holding the injected content.
	 */
	function wireShadowTabs( root ) {
		var links = root.querySelectorAll( '[data-toggle="tab"], [data-bs-toggle="tab"], .nav-tabs a[href^="#"]' );

		Array.prototype.forEach.call( links, function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				// Bootstrap 4 uses href="#id"; Bootstrap 5 uses data-bs-target.
				var sel = link.getAttribute( 'data-bs-target' )
					|| link.getAttribute( 'data-target' )
					|| link.getAttribute( 'href' )
					|| ( link.getAttribute( 'aria-controls' ) ? '#' + link.getAttribute( 'aria-controls' ) : '' );
				if ( ! sel || '#' !== sel.charAt( 0 ) || sel.length < 2 ) {
					return;
				}
				event.preventDefault();

				var pane = root.getElementById( sel.slice( 1 ) );
				if ( ! pane ) {
					return;
				}

				var nav = link.closest( '.nav' ) || link.closest( 'ul' );
				if ( nav ) {
					Array.prototype.forEach.call( nav.querySelectorAll( '.active' ), function ( el ) {
						el.classList.remove( 'active' );
					} );
				}
				link.classList.add( 'active' );
				var li = link.closest( 'li' );
				if ( li ) {
					li.classList.add( 'active' );
				}

				var content = pane.parentNode;
				if ( content ) {
					Array.prototype.forEach.call( content.children, function ( sibling ) {
						sibling.classList.remove( 'active', 'show', 'in' );
					} );
				}
				pane.classList.add( 'active', 'show', 'in' );
			} );
		} );
	}

	/**
	 * Re-implement the partner decor board's "Select / Final Selection" behaviour
	 * inside a shadow root.
	 *
	 * The board ships this as page-level jQuery (inline onclick handlers calling
	 * global selectDecorItem/removeDecorItem) which we strip. The markup is
	 * stable: each swatch is a .decor-board-image-container inside a category
	 * group (#tab-decorgroup_<gallery>) with a .decor-image-selector button; the
	 * chosen swatch is cloned into the single .finalrow under the Final Selection
	 * tab, one selection per category.
	 *
	 * @param {ShadowRoot} root Shadow root holding the injected content.
	 */
	function wireDecorBoard( root ) {
		var buttons = root.querySelectorAll( '.decor-image-selector' );

		Array.prototype.forEach.call( buttons, function ( btn ) {
			btn.removeAttribute( 'onclick' );
			btn.addEventListener( 'click', function () {
				if ( btn.classList.contains( 'btn-danger' ) ) {
					decorDeselect( root, btn );
				} else {
					decorSelect( root, btn );
				}
			} );
		} );
	}

	/** Resolve the category key from the enclosing #tab-decorgroup_<gallery>. */
	function decorGallery( btn ) {
		var group = btn.closest( '[id^="tab-decorgroup_"]' );
		return group ? group.id.replace( 'tab-decorgroup_', '' ) : '';
	}

	/** Drop any existing selection cloned into .finalrow for a category. */
	function decorClearFinal( root, gallery ) {
		var finalrow = root.querySelector( '.finalrow' );
		if ( ! finalrow ) {
			return;
		}
		Array.prototype.forEach.call(
			finalrow.querySelectorAll( '.final-result-container' ),
			function ( c ) {
				if ( c.getAttribute( 'data-group' ) === gallery ) {
					c.parentNode.removeChild( c );
				}
			}
		);
	}

	function decorSelect( root, btn ) {
		var item = btn.closest( '.decor-board-image-container' );
		var group = btn.closest( '[id^="tab-decorgroup_"]' );
		var finalrow = root.querySelector( '.finalrow' );
		if ( ! item || ! group || ! finalrow ) {
			return;
		}

		var gallery = decorGallery( btn );
		var id = item.getAttribute( 'data-id' ) || btn.getAttribute( 'data-id' ) || '';

		// One selection per category.
		decorClearFinal( root, gallery );

		var container = document.createElement( 'div' );
		container.className = 'final-result-container';
		container.setAttribute( 'data-group', gallery );
		container.setAttribute( 'data-id', id );
		var inner = item.querySelector( '.decor-board-inner-image-container' );
		if ( inner ) {
			container.appendChild( inner.cloneNode( true ) );
		}
		finalrow.appendChild( container );

		// This swatch becomes "Remove"; the rest of the category resets to "Select".
		Array.prototype.forEach.call( group.querySelectorAll( '.decor-image-selector' ), function ( b ) {
			if ( b === btn ) {
				b.classList.remove( 'btn-info' );
				b.classList.add( 'btn-danger' );
				b.textContent = 'Remove';
			} else {
				b.classList.remove( 'btn-danger' );
				b.classList.add( 'btn-info' );
				b.textContent = 'Select';
			}
		} );
	}

	function decorDeselect( root, btn ) {
		decorClearFinal( root, decorGallery( btn ) );
		btn.classList.remove( 'btn-danger' );
		btn.classList.add( 'btn-info' );
		btn.textContent = 'Select';
	}

	/**
	 * Re-implement the Golden West left-menu navigation inside a shadow root.
	 *
	 * Golden West uses `<li data-option="#target">` items: a target of
	 * `#sub-menu-N` expands/collapses a submenu, a target of
	 * `#decor-display-panel-…` shows that panel and hides the others. Their JS
	 * (app.js) is stripped, so we wire it ourselves. Sites without [data-option]
	 * get no handlers.
	 *
	 * @param {ShadowRoot} root Shadow root holding the injected content.
	 */
	function wireOptionMenu( root ) {
		var items = root.querySelectorAll( '[data-option]' );
		if ( ! items.length ) {
			return;
		}

		var panels = root.querySelectorAll( '[id^="decor-display-panel-"]' );

		function showPanel( target ) {
			Array.prototype.forEach.call( panels, function ( p ) {
				p.style.display = p === target ? 'block' : 'none';
			} );
			Array.prototype.forEach.call( items, function ( it ) {
				it.classList.remove( 'active' );
			} );
		}

		// Start with only the first panel visible.
		if ( panels.length ) {
			showPanel( panels[ 0 ] );
		}

		Array.prototype.forEach.call( items, function ( item ) {
			item.addEventListener( 'click', function ( event ) {
				event.stopPropagation();
				var sel = item.getAttribute( 'data-option' ) || '';
				if ( '#' !== sel.charAt( 0 ) || sel.length < 2 ) {
					return;
				}
				var target = root.getElementById( sel.slice( 1 ) );
				if ( ! target ) {
					return;
				}

				if ( 0 === sel.indexOf( '#sub-menu' ) ) {
					// Toggle a submenu open/closed via inline display.
					var open = '1' === target.getAttribute( 'data-open' );
					target.style.display = open ? 'none' : 'block';
					target.setAttribute( 'data-open', open ? '0' : '1' );
				} else {
					showPanel( target );
					item.classList.add( 'active' );
				}
			} );
		} );
	}

	/**
	 * Re-create the donors' image lightbox.
	 *
	 * Each donor opens a larger photo on click via its own (stripped) JS:
	 * Golden West uses `[data-image]`, Marlette a Bootstrap modal trigger
	 * `[data-modal-image]`, Cavco a fancybox link `a[data-fancybox]` (href is the
	 * full image). We attach our own handler that opens a shared overlay.
	 *
	 * @param {ShadowRoot} root Shadow root holding the injected content.
	 */
	function wireLightbox( root ) {
		var triggers = root.querySelectorAll( '[data-image], [data-modal-image], a[data-fancybox]' );

		Array.prototype.forEach.call( triggers, function ( trigger ) {
			trigger.style.cursor = 'zoom-in';
			trigger.addEventListener( 'click', function ( event ) {
				var url = trigger.getAttribute( 'data-modal-image' )
					|| trigger.getAttribute( 'data-image' )
					|| trigger.getAttribute( 'href' )
					|| '';
				if ( ! url || 0 === url.indexOf( '#' ) ) {
					return;
				}
				event.preventDefault();
				event.stopPropagation();
				openLightbox( url, trigger.getAttribute( 'title' ) || '' );
			} );
		} );
	}

	var lightbox = null;

	/** Open (creating once) the shared full-screen image overlay. */
	function openLightbox( url, caption ) {
		if ( ! lightbox ) {
			lightbox = document.createElement( 'div' );
			lightbox.className = 'decor-lightbox';
			lightbox.setAttribute( 'hidden', '' );
			lightbox.innerHTML =
				'<button type="button" class="decor-lightbox-close" aria-label="Close">&times;</button>'
				+ '<figure class="decor-lightbox-figure">'
				+ '<img class="decor-lightbox-img" alt="">'
				+ '<figcaption class="decor-lightbox-caption"></figcaption>'
				+ '</figure>';
			document.body.appendChild( lightbox );

			lightbox.addEventListener( 'click', function ( event ) {
				if ( event.target === lightbox || event.target.classList.contains( 'decor-lightbox-close' ) ) {
					closeLightbox();
				}
			} );
			document.addEventListener( 'keydown', function ( event ) {
				if ( 'Escape' === event.key ) {
					closeLightbox();
				}
			} );
		}

		lightbox.querySelector( '.decor-lightbox-img' ).setAttribute( 'src', url );
		var cap = lightbox.querySelector( '.decor-lightbox-caption' );
		cap.textContent = caption;
		cap.style.display = caption ? '' : 'none';
		lightbox.removeAttribute( 'hidden' );
	}

	function closeLightbox() {
		if ( lightbox ) {
			lightbox.setAttribute( 'hidden', '' );
			lightbox.querySelector( '.decor-lightbox-img' ).setAttribute( 'src', '' );
		}
	}

	function panelFor( key ) {
		return panels.filter( function ( p ) {
			return p.dataset.key === key;
		} )[ 0 ];
	}

	function loadPanel( panel ) {
		if ( ! panel || panel.dataset.loaded === '1' || panel.dataset.ready !== '1' ) {
			return;
		}
		panel.dataset.loaded = '1';

		fetch( window.HB2_DECOR.rest + encodeURIComponent( panel.dataset.key ) )
			.then( function ( res ) {
				return res.json();
			} )
			.then( function ( data ) {
				if ( ! data || ! data.html ) {
					throw new Error( ( data && data.error ) || 'No content' );
				}

				var host   = document.createElement( 'div' );
				host.className = 'decor-shadow-host';
				var shadow = host.attachShadow ? host.attachShadow( { mode: 'open' } ) : null;

				var markup = '';
				( data.styles || [] ).forEach( function ( href ) {
					markup += '<link rel="stylesheet" href="' + href + '">';
				} );
				markup += data.html;

				if ( shadow ) {
					shadow.innerHTML = markup;
					wireShadowTabs( shadow );
					wireDecorBoard( shadow );
					wireOptionMenu( shadow );
					wireLightbox( shadow );
				} else {
					// Very old browsers: fall back to inline (styles may leak).
					host.innerHTML = markup;
				}

				panel.innerHTML = '';
				panel.appendChild( host );
			} )
			.catch( function () {
				panel.dataset.loaded = '';
				panel.innerHTML = '<div class="decor-error container">Could not load these decor options right now.</div>';
			} );
	}

	function activate( key ) {
		tabs.forEach( function ( tab ) {
			var on = tab.dataset.key === key;
			tab.classList.toggle( 'active', on );
			tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
		} );
		panels.forEach( function ( panel ) {
			var on = panel.dataset.key === key;
			panel.classList.toggle( 'active', on );
			if ( on ) {
				panel.removeAttribute( 'hidden' );
				loadPanel( panel );
			} else {
				panel.setAttribute( 'hidden', '' );
			}
		} );
	}

	tabs.forEach( function ( tab ) {
		tab.addEventListener( 'click', function () {
			activate( tab.dataset.key );
		} );
	} );

	// Load whichever tab is active on first paint.
	var initial = tabs.filter( function ( t ) {
		return t.classList.contains( 'active' );
	} )[ 0 ] || tabs[ 0 ];
	loadPanel( panelFor( initial.dataset.key ) );
} )();
