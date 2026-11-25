/**
 * Advanced Mega Menu (Cozy Blocks): frontend behaviour. No dependencies.
 * Progressive enhancement: links and panels exist in the server HTML; this adds
 * open/close state, aria-expanded, hover, keyboard handling, panel positioning and the mobile drawer.
 */
( function () {
	'use strict';

	/**
	 * Horizontal offset (px) of a panel relative to its reference element.
	 * full  : panel starts at the viewport's left edge.
	 * others: aligned start/center/end to the reference, then clamped inside the viewport.
	 */
	function computeShift( o ) {
		var m = o.margin == null ? 12 : o.margin;
		if ( o.mode === 'full' ) { return -Math.round( o.refLeft ); }
		var shift = 0;
		if ( o.align === 'center' ) { shift = ( o.refWidth - o.panelWidth ) / 2; }
		else if ( o.align === 'end' ) { shift = o.refWidth - o.panelWidth; }
		var left = o.refLeft + shift;
		var overflow = left + o.panelWidth - ( o.viewport - m );
		if ( overflow > 0 ) { shift -= overflow; }
		left = o.refLeft + shift;
		if ( left < m ) { shift += m - left; }
		return Math.round( shift );
	}

	function qsa( sel, ctx ) { return Array.prototype.slice.call( ( ctx || document ).querySelectorAll( sel ) ); }

	var FOCUSABLE = 'a[href],button:not([disabled]),input:not([disabled]),select:not([disabled]),textarea:not([disabled]),[tabindex]:not([tabindex="-1"])';


	/**
	 * Mega menu overlay: a translucent, blurred layer between the page and the menu.
	 *
	 * A plugin cannot assume the theme's z-index values (the CozyThemesUI reference has header z=50 and
	 * scrim z=40). So the layer is placed at runtime:
	 *   1. find the header-level element A and the outermost stacking context C around the open panel;
	 *   2. insert the layer just before A, one z-index level below C, so page content is covered but the
	 *      header, active item and panel stay above it and sharp;
	 *   3. start the layer at the panel's top edge, so the header is never dimmed even when it has no z-index;
	 *   4. compensate for ancestors that turn position:fixed into position:absolute (transform, filter...).
	 * One shared layer serves every menu; it never takes pointer events and causes no layout shift.
	 *
	 * Inserting the layer before A makes A lose :first-child, so sibling-based spacing such as WordPress's
	 * `.wp-site-blocks > :first-child { margin-block-start: 0 }` would push the header down by the block gap.
	 * A's top margin is measured before the insert and kept until the layer is removed.
	 */
	var Overlay = {
		el: null, owner: null, panel: null, raf: 0, hideT: 0, bound: false, held: null,

		/** Insert the layer before A without moving A. */
		insert: function ( el, A ) {
			this.release();
			var before = getComputedStyle( A ).marginTop;
			A.parentNode.insertBefore( el, A );
			if ( getComputedStyle( A ).marginTop !== before ) {
				this.held = { node: A, inline: A.style.marginTop, priority: A.style.getPropertyPriority( 'margin-top' ) };
				A.style.setProperty( 'margin-top', before, 'important' );
			}
		},

		/** Give A back its own top margin (when the layer is removed or moved). */
		release: function () {
			var h = this.held;
			if ( ! h ) { return; }
			this.held = null;
			if ( h.inline ) { h.node.style.setProperty( 'margin-top', h.inline, h.priority ); } else { h.node.style.removeProperty( 'margin-top' ); }
			if ( h.node.getAttribute( 'style' ) === '' ) { h.node.removeAttribute( 'style' ); }
		},

		createsContext: function ( cs, parentCs ) {
			var z = cs.zIndex;
			if ( cs.position === 'fixed' || cs.position === 'sticky' ) { return true; }
			if ( ( cs.position === 'absolute' || cs.position === 'relative' ) && z !== 'auto' ) { return true; }
			if ( parentCs && /flex|grid/.test( parentCs.display ) && z !== 'auto' ) { return true; }
			if ( parseFloat( cs.opacity ) < 1 ) { return true; }
			if ( cs.transform !== 'none' || cs.filter !== 'none' || ( cs.perspective && cs.perspective !== 'none' ) ) { return true; }
			var bf = cs.backdropFilter || cs.webkitBackdropFilter;
			if ( bf && bf !== 'none' ) { return true; }
			if ( ( cs.clipPath && cs.clipPath !== 'none' ) || ( cs.maskImage && cs.maskImage !== 'none' ) ) { return true; }
			if ( cs.isolation === 'isolate' || ( cs.mixBlendMode && cs.mixBlendMode !== 'normal' ) ) { return true; }
			if ( /paint|layout|strict|content/.test( cs.contain || '' ) ) { return true; }
			if ( /transform|opacity|filter|perspective|backdrop-filter/.test( cs.willChange || '' ) ) { return true; }
			return false;
		},

		/**
		 * A  = the header-level element: the first ancestor whose siblings include tall page content.
		 *      The layer is inserted right before it, so it shares a stacking level with the content.
		 * C  = the outermost element, from the menu up to A, that creates a stacking context. The open panel
		 *      lives inside C, so the layer must sit one level below C.
		 */
		locate: function ( nav ) {
			var A = null, p, i;
			for ( p = nav.parentElement; p && p !== document.body && p !== document.documentElement; p = p.parentElement ) {
				var par = p.parentElement;
				if ( ! par ) { break; }
				for ( i = 0; i < par.children.length; i++ ) {
					var c = par.children[ i ];
					if ( c !== p && ! c.classList.contains( 'cozy-addons-menu-overlay' ) && c.offsetHeight >= 120 ) { A = p; break; }
				}
				if ( A ) { break; }
			}
			if ( ! A ) { // No obvious page content next to the header: use the outermost ancestor under <body>.
				A = nav;
				for ( p = nav.parentElement; p && p !== document.body && p !== document.documentElement; p = p.parentElement ) { A = p; }
			}
			var C = null;
			for ( var n = nav; n && n !== document.body && n !== document.documentElement; n = n.parentElement ) {
				if ( this.createsContext( getComputedStyle( n ), n.parentElement ? getComputedStyle( n.parentElement ) : null ) ) { C = n; }
				if ( n === A ) { break; }
			}
			return { A: A, C: C };
		},

		show: function ( menu, panel ) {
			clearTimeout( this.hideT );
			var el = this.el || ( this.el = document.createElement( 'div' ) );
			el.className = 'cozy-addons-menu-overlay';
			el.setAttribute( 'aria-hidden', 'true' );

			var rootCs = getComputedStyle( menu.root );
			[ '--cozy-addons-menu-ov-color', '--cozy-addons-menu-ov-blur', '--cozy-addons-menu-ov-dur' ].forEach( function ( v ) {
				var val = rootCs.getPropertyValue( v ).trim();
				if ( val ) { el.style.setProperty( v, val ); }
			} );

			var loc = this.locate( menu.root );
			var host = loc.A.parentNode;
			if ( el.parentNode !== host || el.nextSibling !== loc.A ) { this.insert( el, loc.A ); }
			var z;
			if ( loc.C ) {
				var zi = parseInt( getComputedStyle( loc.C ).zIndex, 10 );
				z = isNaN( zi ) ? 0 : Math.max( 0, zi - 1 );
			} else {
				z = ( parseInt( rootCs.getPropertyValue( '--cozy-addons-menu-z' ), 10 ) || 9990 ) - 1;
			}
			el.style.zIndex = String( z );

			this.owner = menu; this.panel = panel;
			this.place();
			if ( ! this.bound ) {
				this.bound = true;
				var self = this, tick = function () { cancelAnimationFrame( self.raf ); self.raf = requestAnimationFrame( function () { self.place(); } ); };
				window.addEventListener( 'scroll', tick, { passive: true } );
				window.addEventListener( 'resize', tick );
			}
			requestAnimationFrame( function () { el.classList.add( 'is-on' ); } );
		},

		place: function () {
			var el = this.el;
			if ( ! el || ! this.panel || ! el.parentNode ) { return; }
			el.style.left = '0px'; el.style.top = '0px'; el.style.width = '0px'; el.style.height = '0px';
			var origin = el.getBoundingClientRect();           // non-zero only if an ancestor re-parents fixed positioning
			// The panel animates in with a small translateY; use its resting position, not the mid-animation one.
			var ty = 0, tf = getComputedStyle( this.panel ).transform;
			if ( tf && tf !== 'none' && window.DOMMatrix ) { try { ty = new DOMMatrix( tf ).m42; } catch ( e ) { ty = 0; } }
			var top = Math.max( 0, this.panel.getBoundingClientRect().top - ty );
			el.style.left = ( -origin.left ) + 'px';
			el.style.top = ( top - origin.top ) + 'px';
			el.style.width = document.documentElement.clientWidth + 'px';
			el.style.height = Math.max( 0, window.innerHeight - top ) + 'px';
		},

		hide: function ( menu ) {
			if ( ! this.el || this.owner !== menu ) { return; }
			var el = this.el, ms = parseFloat( el.style.getPropertyValue( '--cozy-addons-menu-ov-dur' ) ) || 250, self = this;
			el.classList.remove( 'is-on' );
			this.owner = null; this.panel = null;
			clearTimeout( this.hideT );
			this.hideT = setTimeout( function () { if ( ! self.owner && el.parentNode ) { el.parentNode.removeChild( el ); self.release(); } }, ms + 60 );
		}
	};

	function Menu( root ) {
		this.root = root;
		this.scopes = [ root ];   // the root, plus a portal when the off-canvas panel is moved to <body>
		this.oc = null;           // set by offcanvas.js
		this.bp = parseInt( root.getAttribute( 'data-breakpoint' ), 10 ) || 900;
		this.defaultOpen = root.getAttribute( 'data-open-on' ) || 'hover';
		this.toggle = root.querySelector( '[data-cozy-addons-menu-toggle]' );
		this.drawer = root.querySelector( '[data-cozy-addons-menu-drawer]' );
		this.mqMobile = window.matchMedia( '(max-width:' + this.bp + 'px)' );
		this.mqHover = window.matchMedia( '(hover:hover) and (pointer:fine)' );
		this.items = qsa( '[data-cozy-addons-menu-sub]', root );
		this.drawerOpen = false;
		this.overlayOn = root.getAttribute( 'data-overlay' ) === '1';
		this.bind();
		root.setAttribute( 'data-cozy-addons-menu-ready', '' );
	}

	Menu.prototype = {
		isMobile: function () { return this.mqMobile.matches; },

		/** Panels behave as click-to-open accordions on mobile AND inside the desktop off-canvas panel. */
		accordion: function () { return this.isMobile() || !! this.oc; },

		/** Queries that must also see content moved into the off-canvas portal. */
		qa: function ( sel ) { var out = []; this.scopes.forEach( function ( sc ) { out = out.concat( qsa( sel, sc ) ); } ); return out; },
		q1: function ( sel ) { return this.qa( sel )[ 0 ] || null; },
		contains: function ( node ) { return this.scopes.some( function ( sc ) { return sc.contains( node ); } ); },
		setOpenClass: function ( on ) { this.scopes.forEach( function ( sc ) { sc.classList.toggle( 'is-open', on ); } ); },

		openOn: function ( li ) {
			var v = li.getAttribute( 'data-open-on' );
			return v && v !== 'inherit' ? v : this.defaultOpen;
		},

		trigger: function ( li ) { return li.querySelector( ':scope > .cozy-addons-menu-row [data-cozy-addons-menu-trigger]' ); },

		panel: function ( li ) { return li.querySelector( ':scope > .cozy-addons-menu-sub, :scope > .cozy-addons-menu-mega' ); },

		setState: function ( li, open ) {
			li.classList.toggle( 'is-open', open );
			var t = this.trigger( li );
			if ( t ) { t.setAttribute( 'aria-expanded', open ? 'true' : 'false' ); }
			this.syncOverlay();
		},

		/** Overlay is on only while a mega panel is open on a desktop-style layout. */
		syncOverlay: function () {
			if ( ! this.overlayOn ) { return; }
			var open = this.q1( '.cozy-addons-menu-has-mega.is-open' );
			if ( open && ! this.accordion() ) { Overlay.show( this, this.panel( open ) ); } else { Overlay.hide( this ); }
		},

		openSub: function ( li ) {
			if ( li.classList.contains( 'is-open' ) ) { return; }
			var parent = li.parentElement, self = this;
			Array.prototype.forEach.call( parent.children, function ( sib ) {
				if ( sib !== li && sib.hasAttribute( 'data-cozy-addons-menu-sub' ) ) { self.closeSub( sib ); }
			} );
			this.setState( li, true );
			this.position( li );
		},

		closeSub: function ( li ) {
			var self = this;
			clearTimeout( li._cozyAddonsMenuT );
			this.setState( li, false );
			qsa( '[data-cozy-addons-menu-sub].is-open', li ).forEach( function ( d ) { self.setState( d, false ); } );
		},

		closeAllSubs: function () {
			var self = this;
			this.items.forEach( function ( li ) { if ( li.classList.contains( 'is-open' ) ) { self.setState( li, false ); } } );
		},

		toggleSub: function ( li ) {
			if ( li.classList.contains( 'is-open' ) ) { this.closeSub( li ); } else { this.openSub( li ); }
		},

		/** Keep panels inside the viewport and size full-width mega panels. */
		position: function ( li ) {
			if ( this.accordion() ) { return; }
			var panel = this.panel( li );
			if ( ! panel ) { return; }
			var vw = document.documentElement.clientWidth;
			var isMega = li.classList.contains( 'cozy-addons-menu-has-mega' );
			var topLevel = li.parentElement.classList.contains( 'cozy-addons-menu-list' );

			if ( isMega ) {
				var mode = li.getAttribute( 'data-width-mode' ) || 'content';
				var ref = this.root.getBoundingClientRect();
				if ( mode === 'full' ) { panel.style.setProperty( '--cozy-addons-menu-mw', vw + 'px' ); }
				panel.style.setProperty( '--cozy-addons-menu-shift', computeShift( {
					mode: mode, align: li.getAttribute( 'data-align' ) || 'start',
					refLeft: ref.left, refWidth: ref.width, panelWidth: panel.offsetWidth, viewport: vw
				} ) + 'px' );
			} else if ( topLevel ) {
				var r = li.getBoundingClientRect();
				panel.style.setProperty( '--cozy-addons-menu-shift', computeShift( {
					mode: 'custom', align: li.getAttribute( 'data-align' ) || 'start',
					refLeft: r.left, refWidth: r.width, panelWidth: panel.offsetWidth, viewport: vw
				} ) + 'px' );
			} else {
				li.classList.remove( 'is-flip' );
				if ( panel.getBoundingClientRect().right > vw - 12 ) { li.classList.add( 'is-flip' ); }
			}
		},

		/* ---- mobile drawer ---- */
		focusables: function () {
			return qsa( FOCUSABLE, this.drawer ).filter( function ( el ) { return el.getClientRects().length > 0; } );
		},

		openDrawer: function () {
			if ( this.drawerOpen ) { return; }
			this.drawerOpen = true;
			this.setOpenClass( true );
			if ( this.toggle ) { this.toggle.setAttribute( 'aria-expanded', 'true' ); }
			document.documentElement.classList.add( 'cozy-addons-menu-lock' );
			var f = this.focusables();
			if ( f.length ) { f[ 0 ].focus(); }
		},

		closeDrawer: function ( returnFocus ) {
			if ( ! this.drawerOpen ) { return; }
			this.drawerOpen = false;
			this.setOpenClass( false );
			if ( this.toggle ) { this.toggle.setAttribute( 'aria-expanded', 'false' ); }
			document.documentElement.classList.remove( 'cozy-addons-menu-lock' );
			this.closeAllSubs();
			if ( returnFocus !== false && this.toggle ) { this.toggle.focus(); }
		},

		/* ---- events ---- */
		bind: function () {
			var self = this;

			this.items.forEach( function ( li ) {
				var t = self.trigger( li );
				if ( t ) {
					t.addEventListener( 'click', function () { self.toggleSub( li ); } );
					t.addEventListener( 'keydown', function ( e ) {
						if ( e.key === 'ArrowDown' && ! self.accordion() ) {
							e.preventDefault();
							self.openSub( li );
							var first = self.panel( li ) && qsa( FOCUSABLE, self.panel( li ) )[ 0 ];
							if ( first ) { first.focus(); }
						}
					} );
				}
				li.addEventListener( 'mouseenter', function () {
					if ( self.accordion() || ! self.mqHover.matches || self.openOn( li ) !== 'hover' ) { return; }
					clearTimeout( li._cozyAddonsMenuT );
					li._cozyAddonsMenuT = setTimeout( function () { self.openSub( li ); }, 40 );
				} );
				li.addEventListener( 'mouseleave', function () {
					if ( self.accordion() || ! self.mqHover.matches || self.openOn( li ) !== 'hover' ) { return; }
					clearTimeout( li._cozyAddonsMenuT );
					li._cozyAddonsMenuT = setTimeout( function () { self.closeSub( li ); }, 180 );
				} );
				li.addEventListener( 'focusout', function ( e ) {
					// Mobile accordions must not collapse on focus change: the layout would shift under the
					// finger before the click lands and the tap would hit the wrong item. Siblings close in openSub().
					if ( self.accordion() ) { return; }
					// relatedTarget is null when clicking non-focusable content: keep open, outside-click handles it.
					if ( e.relatedTarget && ! li.contains( e.relatedTarget ) ) { self.closeSub( li ); }
				} );
			} );

			document.addEventListener( 'click', function ( e ) {
				if ( ! self.contains( e.target ) || ! e.target.closest( '[data-cozy-addons-menu-sub]' ) ) { self.closeAllSubs(); }
			} );

			document.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' ) {
					if ( self.oc && self.oc.isOpen() ) { self.oc.close( true ); return; }
					var open = self.qa( '[data-cozy-addons-menu-sub].is-open' );
					if ( open.length ) {
						var li = open[ open.length - 1 ], t = self.trigger( li );
						self.closeSub( li );
						if ( t ) { t.focus(); }
					} else if ( self.drawerOpen ) {
						self.closeDrawer( true );
					}
				} else if ( e.key === 'Tab' && self.drawerOpen ) {
					var f = self.focusables();
					if ( ! f.length ) { return; }
					var first = f[ 0 ], last = f[ f.length - 1 ];
					if ( e.shiftKey && document.activeElement === first ) { e.preventDefault(); last.focus(); }
					else if ( ! e.shiftKey && document.activeElement === last ) { e.preventDefault(); first.focus(); }
				}
			} );

			if ( this.toggle ) {
				this.toggle.addEventListener( 'click', function () {
					if ( self.drawerOpen ) { self.closeDrawer( true ); } else { self.openDrawer(); }
				} );
			}
			var close = this.root.querySelector( '[data-cozy-addons-menu-close]' );
			if ( close ) { close.addEventListener( 'click', function () { self.closeDrawer( true ); } ); }
			var back = this.root.querySelector( '[data-cozy-addons-menu-backdrop]' );
			if ( back ) { back.addEventListener( 'click', function () { self.closeDrawer( true ); } ); }

			var onMq = function () { self.closeDrawer( false ); self.closeAllSubs(); };
			if ( this.mqMobile.addEventListener ) { this.mqMobile.addEventListener( 'change', onMq ); } else { this.mqMobile.addListener( onMq ); }

			var raf;
			window.addEventListener( 'resize', function () {
				cancelAnimationFrame( raf );
				raf = requestAnimationFrame( function () {
					self.qa( '[data-cozy-addons-menu-sub].is-open' ).forEach( function ( li ) { self.position( li ); } );
				} );
			} );
		}
	};

	function init() { qsa( '[data-cozy-addons-menu]' ).forEach( function ( el ) { if ( ! el._cozyAddonsMenu ) { el._cozyAddonsMenu = new Menu( el ); } } ); }

	if ( typeof module === 'object' && module.exports ) {
		module.exports = { computeShift: computeShift };
	} else {
		window.CozyAddonsMenu = { computeShift: computeShift, init: init, Menu: Menu, locate: function ( nav ) { return Overlay.locate( nav ); } };
		if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', init ); } else { init(); }
	}
}() );
