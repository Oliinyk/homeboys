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
		Array.prototype.forEach.call( root.querySelectorAll( '.decor-image-selector' ), function ( btn ) {
			if ( btn.closest( '.finalrow' ) ) {
				return; // Final Selection clones get their own handler.
			}
			btn.removeAttribute( 'onclick' );
			btn.addEventListener( 'click', function () {
				if ( btn.classList.contains( 'btn-danger' ) ) {
					decorClearSelection( root, decorGallery( btn ) );
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

		// Clone the whole swatch (keeps the donor's spacing/margins) into the
		// Final Selection, turning its button into a working Remove.
		var clone = item.cloneNode( true );
		clone.classList.add( 'final-result-container' );
		clone.setAttribute( 'data-group', gallery );
		clone.setAttribute( 'data-id', id );
		clone.style.opacity = '1';

		var cloneBtn = clone.querySelector( '.decor-image-selector' );
		if ( cloneBtn ) {
			cloneBtn.removeAttribute( 'onclick' );
			cloneBtn.classList.remove( 'btn-info' );
			cloneBtn.classList.add( 'btn-danger' );
			cloneBtn.textContent = 'Remove';
			cloneBtn.addEventListener( 'click', function () {
				decorClearSelection( root, gallery );
			} );
		}
		finalrow.appendChild( clone );
		wireLightbox( clone ); // re-enable zoom on the cloned image

		// Selected swatch: full opacity + Remove. The rest: dimmed + Select.
		Array.prototype.forEach.call( group.querySelectorAll( '.decor-board-image-container' ), function ( c ) {
			var b = c.querySelector( '.decor-image-selector' );
			if ( c === item ) {
				c.style.opacity = '1';
				if ( b ) {
					b.classList.remove( 'btn-info' );
					b.classList.add( 'btn-danger' );
					b.textContent = 'Remove';
				}
			} else {
				c.style.opacity = '0.3';
				if ( b ) {
					b.classList.remove( 'btn-danger' );
					b.classList.add( 'btn-info' );
					b.textContent = 'Select';
				}
			}
		} );
	}

	/** Remove a category's pick: drop the Final Selection clone, reset the swatches. */
	function decorClearSelection( root, gallery ) {
		decorClearFinal( root, gallery );
		var group = root.getElementById( 'tab-decorgroup_' + gallery );
		if ( ! group ) {
			return;
		}
		Array.prototype.forEach.call( group.querySelectorAll( '.decor-board-image-container' ), function ( c ) {
			c.style.opacity = '1';
			var b = c.querySelector( '.decor-image-selector' );
			if ( b ) {
				b.classList.remove( 'btn-danger' );
				b.classList.add( 'btn-info' );
				b.textContent = 'Select';
			}
		} );
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
		var subMenus = root.querySelectorAll( '[id^="sub-menu-"]' );
		var subMenuItems = root.querySelectorAll( '[data-option^="#sub-menu-"]' );

		function closeAllSubMenus() {
			Array.prototype.forEach.call( subMenus, function ( sm ) {
				sm.style.display = 'none';
				sm.setAttribute( 'data-open', '0' );
			} );
			Array.prototype.forEach.call( subMenuItems, function ( it ) {
				it.classList.remove( 'active' );
			} );
		}

		function openSubMenu( subMenu, parentItem ) {
			closeAllSubMenus();
			subMenu.style.display = 'block';
			subMenu.setAttribute( 'data-open', '1' );
			parentItem.classList.add( 'active' );

			// Auto-activate the first panel item inside this sub-menu.
			var firstChild = subMenu.querySelector( '[data-option^="#decor-display-panel-"]' );
			if ( firstChild ) {
				var firstSel = firstChild.getAttribute( 'data-option' ).slice( 1 );
				var firstPanel = root.getElementById( firstSel );
				if ( firstPanel ) {
					activatePanel( firstPanel, firstChild );
				}
			}
		}

		function activatePanel( target, item ) {
			Array.prototype.forEach.call( panels, function ( p ) {
				p.style.display = p === target ? 'block' : 'none';
			} );
			Array.prototype.forEach.call(
				root.querySelectorAll( '[data-option^="#decor-display-panel-"]' ),
				function ( it ) { it.classList.remove( 'active' ); }
			);
			item.classList.add( 'active' );
		}

		// Init: open first sub-menu and activate first panel item.
		if ( panels.length ) {
			Array.prototype.forEach.call( panels, function ( p ) {
				p.style.display = 'none';
			} );
			panels[ 0 ].style.display = 'block';

			var firstId   = panels[ 0 ].id;
			var firstItem = root.querySelector( '[data-option="#' + firstId + '"]' );
			if ( firstItem ) {
				firstItem.classList.add( 'active' );
				var parentItem = firstItem.closest( '[data-option^="#sub-menu-"]' );
				if ( parentItem ) {
					parentItem.classList.add( 'active' );
					var smId = parentItem.getAttribute( 'data-option' ).slice( 1 );
					var sm   = root.getElementById( smId );
					if ( sm ) {
						sm.style.display = 'block';
						sm.setAttribute( 'data-open', '1' );
					}
				}
			}
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
					// Accordion: open this sub-menu, close all others.
					openSubMenu( target, item );
				} else {
					activatePanel( target, item );
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
	function wireLightbox( root, baseUrl ) {
		var triggers = root.querySelectorAll( '[data-image], [data-modal-image], a[data-fancybox]' );

		Array.prototype.forEach.call( triggers, function ( trigger ) {
			trigger.style.cursor = 'pointer';
			trigger.addEventListener( 'click', function ( event ) {
				var url = trigger.getAttribute( 'data-modal-image' )
					|| trigger.getAttribute( 'data-image' )
					|| trigger.getAttribute( 'href' )
					|| '';
				if ( ! url || 0 === url.indexOf( '#' ) ) {
					return;
				}
				// Absolutize relative URLs using the donor site's base.
				if ( baseUrl && 0 !== url.indexOf( 'http' ) && 0 !== url.indexOf( '//' ) ) {
					url = baseUrl.replace( /\/$/, '' ) + '/' + url.replace( /^\//, '' );
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
				if ( panel.dataset.key === 'cavco' ) {
					markup += '<style>.elementor-element-91b50b4{margin-top:0!important}</style>';
				}
				if ( panel.dataset.key === 'goldenwest' ) {
					markup += '<style>'
						+ '.app-container{display:flex!important;align-items:stretch!important;height:auto!important;overflow:visible!important}'
						+ '.main-menu{height:auto!important;overflow:visible!important;flex-shrink:0}'
						+ '.display-area{height:auto!important;overflow:visible!important;flex:1}'
						+ '.display-area>div#decor-display-panel-palisade-shower+p{display:none!important}'
						+ '</style>';
				}
				markup += data.html;

				if ( shadow ) {
					shadow.innerHTML = markup;
					wireShadowTabs( shadow );
					wireDecorBoard( shadow );
					wireOptionMenu( shadow );
					wireLightbox( shadow, data.base_url || '' );
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
