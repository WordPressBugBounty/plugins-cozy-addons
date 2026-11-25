/**
 * Desktop off-canvas panels: Side Drawer, Fullscreen Overlay, Push Sidebar.
 * Loaded only on pages that render an off-canvas menu or trigger. Builds on view.js (the menu controller):
 *  - the panel is moved to <body> (a "portal") so a theme's transformed, z-indexed or overflow:hidden header can never break it;
 *  - modal layouts get dialog semantics, a focus trap and inert page content; push is non-modal navigation;
 *  - push shifts page sections with the CSS `translate` property (it composes with a theme's own transforms)
 *    and removes every trace of itself when the panel closes.
 */
( function () {
	'use strict';
	var CMB = window.CozyAddonsMenu;
	if ( ! CMB ) { return; }

	var html = document.documentElement;
	var SELECTOR_OK = /^[A-Za-z0-9_\-#.\[\]=\s>,*~+^$|:]+$/;
	var FOCUSABLE = 'a[href],button:not([disabled]),input:not([disabled]),select:not([disabled]),textarea:not([disabled]),summary,[tabindex]:not([tabindex="-1"])';
	var SKIP_TAGS = /^(SCRIPT|STYLE|LINK|NOSCRIPT|TEMPLATE|META)$/;

	var registry = [];
	var current = null;
	var locks = 0;

	function qsa( sel, ctx ) { return Array.prototype.slice.call( ( ctx || document ).querySelectorAll( sel ) ); }
	function mq( q ) { return window.matchMedia( q ).matches; }

	function lockScroll() {
		if ( locks++ === 0 ) {
			// Reserve the scrollbar's width so hiding it cannot shift the page sideways.
			html.style.setProperty( '--cozy-addons-menu-sbw', Math.max( 0, window.innerWidth - html.clientWidth ) + 'px' );
			html.classList.add( 'cozy-addons-menu-lock' );
		}
	}
	function unlockScroll() {
		if ( locks > 0 && --locks === 0 ) {
			html.classList.remove( 'cozy-addons-menu-lock' );
			html.style.removeProperty( '--cozy-addons-menu-sbw' );
		}
	}

	/* ------------------------------------------------------------------ Panel */

	function Panel( menu ) {
		var root = menu.root;
		this.menu = menu;
		this.root = root;
		this.id = root.id || '';
		this.layout = root.getAttribute( 'data-oc-layout' ) || 'drawer';
		this.side = root.getAttribute( 'data-oc-side' ) || 'right';
		this.modal = root.getAttribute( 'data-oc-modal' ) === '1';
		this.lock = root.getAttribute( 'data-oc-lock' ) === '1';
		this.bdClose = root.getAttribute( 'data-oc-bdclose' ) === '1';
		this.offsetAuto = root.getAttribute( 'data-oc-offset' ) === 'auto';
		this.pushMode = root.getAttribute( 'data-oc-push-mode' ) || 'auto';
		this.pushSel = root.getAttribute( 'data-oc-push-selector' ) || '';
		this.pushParts = root.getAttribute( 'data-oc-push-parts' ) || '';
		this.show = root.getAttribute( 'data-oc-show' ) || '';
		this.tablet = parseInt( root.getAttribute( 'data-oc-tablet' ), 10 ) || 1024;
		this.label = root.getAttribute( 'data-oc-label' ) || 'Menu';
		this.extSel = root.getAttribute( 'data-oc-selector' ) || '';
		this.reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		this.state = false;
		this.lastTrigger = null;
		this.inerted = [];
		this.pushTargets = [];
		this.pushTimer = 0;
		this.triggers = [];
		this.ok = this.buildPortal();
		if ( ! this.ok ) { return; }
		menu.oc = this;
		menu.scopes.push( this.portal );
		this.bind();
	}

	/** Move the backdrop and the panel into a body-level copy of the menu's root classes, so every existing selector still matches. */
	Panel.prototype.buildPortal = function () {
		var backdrop = this.root.querySelector( '[data-cozy-addons-menu-backdrop]' ), drawer = this.root.querySelector( '[data-cozy-addons-menu-drawer]' );
		if ( ! backdrop || ! drawer ) { return false; }
		var keep = ( this.root.className || '' ).split( /\s+/ ).filter( function ( c ) { return /^cozy-addons-menu/.test( c ); } );
		var portal = document.createElement( 'div' );
		portal.className = keep.join( ' ' ) + ' cozy-addons-menu-oc-portal';
		portal.setAttribute( 'data-cozy-addons-menu-portal', '' );
		portal.appendChild( backdrop );
		portal.appendChild( drawer );
		document.body.appendChild( portal );
		this.portal = portal; this.backdrop = backdrop; this.drawer = drawer;
		this.closeBtn = drawer.querySelector( '[data-cozy-addons-menu-close]' );
		return true;
	};

	Panel.prototype.bind = function () {
		var self = this;
		var own = this.root.querySelector( '[data-cozy-addons-menu-oc-trigger]' );
		if ( own ) { this.addTrigger( own, true ); }
		if ( this.extSel && this.extSel.length <= 150 && SELECTOR_OK.test( this.extSel ) ) {
			var found = [];
			try { found = qsa( this.extSel ); } catch ( e ) { found = []; }
			found.slice( 0, 20 ).forEach( function ( el ) {
				// Never hijack the mobile toggle, submenu buttons, close buttons, or an element another panel already owns.
				if ( el.closest( '[data-cozy-addons-menu-toggle],[data-cozy-addons-menu-trigger],[data-cozy-addons-menu-close],[data-cozy-addons-menu-portal]' ) ) { return; }
				self.addTrigger( el, true );
			} );
		}
		this.backdrop.addEventListener( 'click', function () { if ( self.bdClose ) { self.close( true ); } } );
		if ( this.closeBtn ) { this.closeBtn.addEventListener( 'click', function () { self.close( true ); } ); }
	};

	/** Attach a trigger. bindClick=false is used for [data-cozy-addons-menu-oc-open] elements, which the delegated handler serves. */
	Panel.prototype.addTrigger = function ( el, bindClick ) {
		if ( el._cozyAddonsMenuOc ) { return; }              // one trigger opens one panel: the first owner wins
		el._cozyAddonsMenuOc = this;
		this.triggers.push( el );
		el.setAttribute( 'aria-controls', this.drawer.id );
		el.setAttribute( 'aria-expanded', this.state ? 'true' : 'false' );
		if ( this.modal ) { el.setAttribute( 'aria-haspopup', 'dialog' ); }
		if ( bindClick ) {
			var self = this;
			el.addEventListener( 'click', function ( e ) { e.preventDefault(); self.toggle( el ); } );
		}
	};

	Panel.prototype.isOpen = function () { return this.state; };

	/** Is the desktop off-canvas active at the current width? Mirrors the media queries that show the trigger. */
	Panel.prototype.visible = function () {
		var B = this.menu.bp, T = this.tablet;
		if ( this.show.indexOf( 'd' ) > -1 && mq( '(min-width:' + ( T + 1 ) + 'px)' ) ) { return true; }
		if ( this.show.indexOf( 't' ) > -1 && T > B && mq( '(min-width:' + ( B + 1 ) + 'px) and (max-width:' + T + 'px)' ) ) { return true; }
		if ( this.show.indexOf( 'm' ) > -1 && mq( '(max-width:' + B + 'px)' ) ) { return true; }
		return false;
	};

	Panel.prototype.duration = function () {
		if ( this.reduced.matches ) { return 0; }
		return parseFloat( getComputedStyle( this.portal ).getPropertyValue( '--oc-dur' ) ) || 0;
	};

	Panel.prototype.syncExternal = function () {
		var on = this.visible();
		this.triggers.forEach( function ( el ) {
			if ( ! el.hasAttribute( 'data-cozy-addons-menu-oc-open' ) ) { return; }
			if ( on ) { el.removeAttribute( 'data-cozy-addons-menu-oc-off' ); } else { el.setAttribute( 'data-cozy-addons-menu-oc-off', '' ); }
		} );
	};

	Panel.prototype.setExpanded = function ( open ) {
		this.triggers.forEach( function ( el ) { el.setAttribute( 'aria-expanded', open ? 'true' : 'false' ); } );
	};

	Panel.prototype.focusables = function () {
		return qsa( FOCUSABLE, this.drawer ).filter( function ( el ) { return el.getClientRects().length > 0 && getComputedStyle( el ).visibility !== 'hidden'; } );
	};

	Panel.prototype.toggle = function ( trigger ) { if ( this.state ) { this.close( true ); } else { this.open( trigger ); } };

	Panel.prototype.open = function ( trigger ) {
		if ( this.state || ! this.visible() ) { return; }
		if ( current && current !== this ) { current.close( false ); }
		this.lastTrigger = trigger || document.activeElement;
		this.menu.closeAllSubs();
		this.setTop();
		this.state = true; current = this;
		this.portal.classList.add( 'is-oc-open' );
		this.setExpanded( true );
		if ( this.lock ) { lockScroll(); this.locked = true; }
		if ( this.layout === 'push' ) { this.pushOpen(); }
		if ( this.modal ) {
			this.drawer.setAttribute( 'role', 'dialog' );
			this.drawer.setAttribute( 'aria-modal', 'true' );
			this.drawer.setAttribute( 'aria-label', this.label );
			this.inertOthers();
		}
		var self = this;
		requestAnimationFrame( function () {
			if ( ! self.state ) { return; }
			var f = self.focusables();
			if ( f.length ) { f[ 0 ].focus( { preventScroll: true } ); }
		} );
	};

	Panel.prototype.close = function ( returnFocus ) {
		if ( ! this.state ) { return; }
		this.state = false;
		if ( current === this ) { current = null; }
		this.portal.classList.remove( 'is-oc-open' );
		this.setExpanded( false );
		if ( this.modal ) {
			this.restoreInert();
			this.drawer.removeAttribute( 'role' );
			this.drawer.removeAttribute( 'aria-modal' );
			this.drawer.removeAttribute( 'aria-label' );
		}
		if ( this.locked ) { unlockScroll(); this.locked = false; }
		if ( this.layout === 'push' ) { this.pushClose(); }
		this.menu.closeAllSubs();
		this.portal.style.removeProperty( '--oc-top-abs' );
		var t = this.lastTrigger;
		this.lastTrigger = null;
		if ( returnFocus !== false && t && document.contains( t ) && t.getClientRects().length ) { t.focus( { preventScroll: true } ); }
	};

	/* ---- modal: make the rest of the page inert while the panel is open ---- */
	Panel.prototype.inertOthers = function () {
		var self = this;
		this.inerted = [];
		Array.prototype.forEach.call( document.body.children, function ( el ) {
			if ( el === self.portal || SKIP_TAGS.test( el.tagName ) || el.hasAttribute( 'inert' ) ) { return; }
			el.setAttribute( 'inert', '' );
			self.inerted.push( el );
		} );
	};
	Panel.prototype.restoreInert = function () {
		this.inerted.forEach( function ( el ) { el.removeAttribute( 'inert' ); } );
		this.inerted = [];
	};

	/* ---- offset below a fixed or sticky header ---- */
	Panel.prototype.setTop = function () {
		if ( ! this.offsetAuto || this.layout === 'fullscreen' ) { return; }
		var A = CMB.locate( this.root ).A;
		this.portal.style.setProperty( '--oc-top-abs', Math.max( 0, Math.round( A.getBoundingClientRect().bottom ) ) + 'px' );
	};

	/* ---- push sidebar ---- */
	Panel.prototype.findPushTargets = function () {
		var self = this, out = [], A = CMB.locate( this.root ).A;
		if ( this.pushMode === 'custom' && this.pushSel && this.pushSel.length <= 150 && SELECTOR_OK.test( this.pushSel ) ) {
			try { out = qsa( this.pushSel ).slice( 0, 12 ); } catch ( e ) { out = []; }
		}
		if ( ! out.length ) {
			var parent = A && A.parentElement;
			if ( parent && parent !== html ) {
				out = Array.prototype.slice.call( parent.children ).filter( function ( el ) {
					if ( el === self.portal || SKIP_TAGS.test( el.tagName ) || el.id === 'wpadminbar' || el.classList.contains( 'cozy-addons-menu-overlay' ) ) { return false; }
					var kind = ( el === A || el.contains( self.root ) || el.tagName === 'HEADER' || el.getAttribute( 'role' ) === 'banner' ) ? 'h'
						: ( el.tagName === 'FOOTER' || el.getAttribute( 'role' ) === 'contentinfo' ) ? 'f' : 'm';
					// Floating widgets (chat bubbles, cookie bars) are not page sections: leave fixed elements alone, except the header.
					if ( kind !== 'h' && getComputedStyle( el ).position === 'fixed' ) { return false; }
					return self.pushParts.indexOf( kind ) > -1;
				} );
			}
		}
		out = out.filter( function ( el ) { return el !== self.portal && ! el.contains( self.portal ) && el.getClientRects().length > 0; } );
		// Never translate an element and one of its ancestors: that would move the child twice.
		return out.filter( function ( el ) { return ! out.some( function ( o ) { return o !== el && o.contains( el ); } ); } );
	};

	Panel.prototype.pushOpen = function () {
		clearTimeout( this.pushTimer );
		if ( ! this.pushTargets.length ) { this.pushTargets = this.findPushTargets(); }
		if ( ! this.pushTargets.length ) {
			// No compatible container: degrade to a plain overlay drawer and say so, instead of breaking the page.
			this.root.setAttribute( 'data-cozy-addons-menu-push', 'fallback' );
			this.portal.classList.add( 'is-push-fallback' );
			return;
		}
		this.root.setAttribute( 'data-cozy-addons-menu-push', 'active' );
		this.pushTargets.forEach( function ( el ) {
			el._cozyAddonsMenuHadClass = el.hasAttribute( 'class' ); // so close can put the element back exactly as it was
			el.classList.add( 'cozy-addons-menu-push-target' );
		} );
		html.style.setProperty( '--cozy-addons-menu-push-dur', this.duration() + 'ms' );
		html.classList.add( 'cozy-addons-menu-push-lock' );
		void html.offsetWidth;                                    // commit the starting position so the move animates
		this.pushApply();
	};

	Panel.prototype.pushApply = function () {
		if ( ! this.pushTargets.length ) { return; }
		var w = this.drawer.getBoundingClientRect().width;
		html.style.setProperty( '--cozy-addons-menu-push-x', ( this.side === 'left' ? w : -w ) + 'px' );
	};

	Panel.prototype.pushClose = function () {
		var self = this, targets = this.pushTargets;
		this.root.removeAttribute( 'data-cozy-addons-menu-push' );
		this.portal.classList.remove( 'is-push-fallback' );
		if ( ! targets.length ) { return; }
		var done = function () {
			targets.forEach( function ( el ) {
				el.classList.remove( 'cozy-addons-menu-push-target' );
				if ( el._cozyAddonsMenuHadClass === false && ! el.getAttribute( 'class' ) ) { el.removeAttribute( 'class' ); }
				delete el._cozyAddonsMenuHadClass;
			} );
			html.style.removeProperty( '--cozy-addons-menu-push-x' );
			html.style.removeProperty( '--cozy-addons-menu-push-dur' );
			html.classList.remove( 'cozy-addons-menu-push-lock' );
			self.pushTargets = [];
		};
		html.style.setProperty( '--cozy-addons-menu-push-x', '0px' );
		var ms = this.duration();
		if ( ms === 0 ) { done(); } else { this.pushTimer = setTimeout( done, ms + 60 ); }
	};

	/* ------------------------------------------------------------------ wiring */

	function panelById( id ) {
		if ( ! id ) { return null; }
		for ( var i = 0; i < registry.length; i++ ) { if ( registry[ i ].id === id ) { return registry[ i ]; } }
		return null;
	}

	// Triggers created by the "Off-Canvas Trigger" block or a menu item that "opens a panel".
	function adopt( el ) {
		if ( el._cozyAddonsMenuOc ) { return el._cozyAddonsMenuOc; }
		var p = panelById( el.getAttribute( 'data-cozy-addons-menu-oc-open' ) );
		if ( p ) { p.addTrigger( el, false ); }
		return p;
	}
	document.addEventListener( 'click', function ( e ) {
		var t = e.target.closest && e.target.closest( '[data-cozy-addons-menu-oc-open]' );
		if ( ! t ) { return; }
		var p = adopt( t );
		if ( p && p.triggers.indexOf( t ) > -1 ) { e.preventDefault(); p.toggle( t ); }
	} );

	// Modal panels trap Tab; non-modal (push) panels never do.
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'Tab' || ! current || ! current.modal ) { return; }
		var f = current.focusables();
		if ( ! f.length ) { e.preventDefault(); return; }
		var first = f[ 0 ], last = f[ f.length - 1 ], a = document.activeElement;
		if ( ! current.drawer.contains( a ) ) { e.preventDefault(); first.focus(); return; }
		if ( e.shiftKey && a === first ) { e.preventDefault(); last.focus(); }
		else if ( ! e.shiftKey && a === last ) { e.preventDefault(); first.focus(); }
	} );

	var raf = 0;
	function onViewport() {
		cancelAnimationFrame( raf );
		raf = requestAnimationFrame( function () {
			registry.forEach( function ( p ) {
				p.syncExternal();
				if ( p.state ) {
					if ( ! p.visible() ) { p.close( false ); } else { p.setTop(); if ( p.layout === 'push' ) { p.pushApply(); } }
				}
			} );
		} );
	}
	window.addEventListener( 'resize', onViewport );
	window.addEventListener( 'scroll', function () { if ( current && current.offsetAuto ) { onViewport(); } }, { passive: true } );

	function init() {
		CMB.init();
		qsa( '[data-cozy-addons-menu][data-display="offcanvas"]' ).forEach( function ( root ) {
			if ( root._cozyAddonsMenuPanel || ! root._cozyAddonsMenu ) { return; }
			var p = new Panel( root._cozyAddonsMenu );
			if ( p.ok ) { root._cozyAddonsMenuPanel = p; registry.push( p ); }
		} );
		qsa( '[data-cozy-addons-menu-oc-open]' ).forEach( adopt );
		registry.forEach( function ( p ) { p.syncExternal(); } );
	}

	CMB.panels = registry;
	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', init ); } else { init(); }
}() );
