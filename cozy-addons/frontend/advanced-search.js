/**
 * Cozy Blocks: Advanced Search block front-end (ported from Advanced Search Pro).
 * Accessible combobox/listbox search with modal and inline modes.
 */
( function () {
	'use strict';

	var SELECTOR = '.cozy-block-advanced-search';
	var STORE_KEY = 'cozy_search_recent';
	var responseCache = new Map();
	var popularCache = null;
	var popularRequested = false;
	var registry = [];
	var shortcutBound = false;
	var isMac = /Mac|iPhone|iPad/i.test( navigator.platform || navigator.userAgent || '' );

	/* ------------------------------------------------------------ utilities */

	function el( tag, cls, text ) {
		var n = document.createElement( tag );
		if ( cls ) {
			n.className = cls;
		}
		if ( text !== undefined && text !== null ) {
			n.textContent = text;
		}
		return n;
	}

	/** Text read by screen readers only. */
	function srText( text ) {
		return el( 'span', 'cozy-search-sr', text );
	}

	function storageGet() {
		try {
			var v = JSON.parse( window.localStorage.getItem( STORE_KEY ) || '[]' );
			return Array.isArray( v ) ? v.filter( function ( x ) { return typeof x === 'string'; } ) : [];
		} catch ( e ) {
			return [];
		}
	}

	function storageSet( list ) {
		try {
			window.localStorage.setItem( STORE_KEY, JSON.stringify( list ) );
		} catch ( e ) {}
	}

	function escapeRe( s ) {
		return s.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
	}

	function queryTerms( q, extra ) {
		var words = String( q || '' ).replace( /"/g, ' ' ).split( /\s+/ ).filter( function ( t ) {
			return t && t.charAt( 0 ) !== '-';
		} );
		if ( extra ) {
			words = words.concat( String( extra ).split( /\s+/ ) );
		}
		var seen = {};
		return words.filter( function ( w ) {
			var k = w.toLowerCase();
			if ( ! w || seen[ k ] ) {
				return false;
			}
			seen[ k ] = true;
			return true;
		} ).sort( function ( a, b ) { return b.length - a.length; } );
	}

	/** Appends text to node, wrapping matches in <mark> (DOM nodes only, no innerHTML). */
	function highlight( node, text, terms ) {
		text = text || '';
		if ( ! terms.length || ! text ) {
			node.textContent = text;
			return;
		}
		var re = new RegExp( '(' + terms.map( escapeRe ).join( '|' ) + ')', 'gi' );
		text.split( re ).forEach( function ( part, i ) {
			if ( ! part ) {
				return;
			}
			if ( i % 2 === 1 ) {
				node.appendChild( el( 'mark', 'cozy-search-mark', part ) );
			} else {
				node.appendChild( document.createTextNode( part ) );
			}
		} );
	}

	/** Replaces the %s / %d placeholder of a translated string with a node. */
	function withNode( tpl, node ) {
		var p = el( 'p', 'cozy-search-notice-text' );
		var parts = String( tpl ).split( '%s' );
		p.appendChild( document.createTextNode( parts[ 0 ] ) );
		p.appendChild( node );
		if ( parts.length > 1 ) {
			p.appendChild( document.createTextNode( parts.slice( 1 ).join( '%s' ) ) );
		}
		return p;
	}

	function lockScroll() {
		var sw = window.innerWidth - document.documentElement.clientWidth;
		if ( sw > 0 ) {
			document.documentElement.style.setProperty( '--cozy-search-sbw', sw + 'px' );
		}
		document.documentElement.classList.add( 'cozy-search-lock' );
	}

	function unlockScroll() {
		document.documentElement.classList.remove( 'cozy-search-lock' );
		document.documentElement.style.removeProperty( '--cozy-search-sbw' );
	}

	function visible( n ) {
		return !! ( n && n.getClientRects().length );
	}

	/* ----------------------------------------------------------------- init */

	function readConfig( root ) {
		var d = root.dataset;
		var parse = function ( s, fb ) {
			try { return JSON.parse( s ); } catch ( e ) { return fb; }
		};
		return {
			mode: d.mode || 'form',
			restUrl: d.restUrl,
			popularUrl: d.popularUrl,
			trackUrl: d.trackUrl,
			searchUrl: d.searchUrl || '/',
			postTypes: d.postTypes || '',
			taxonomies: d.taxonomies || '',
			types: parse( d.types, [] ),
			perPage: parseInt( d.perPage, 10 ) || 8,
			minChars: Math.max( 1, parseInt( d.minChars, 10 ) || 2 ),
			debounce: Math.max( 0, parseInt( d.debounce, 10 ) || 0 ),
			recentLimit: parseInt( d.recentLimit, 10 ) || 0,
			recent: d.recent === '1',
			popular: d.popular === '1',
			topics: d.topics === '1',
			queries: d.queries === '1',
			group: d.group === '1',
			fuzzy: d.fuzzy === '1',
			images: d.images === '1',
			excerpts: d.excerpts === '1',
			highlight: d.highlight === '1',
			tabs: d.tabs === '1',
			viewAll: d.viewAll === '1',
			loadMore: d.loadMore === '1',
			shortcut: d.shortcut === '1',
			voice: d.voice === '1',
			i18n: parse( d.i18n, {} )
		};
	}

	function init( root ) {
		if ( ! root || root.dataset.cozySearchReady ) {
			return;
		}
		root.dataset.cozySearchReady = '1';

		var cfg = readConfig( root );
		var t = cfg.i18n;
		var inline = cfg.mode === 'inline';
		var trigger = root.querySelector( '.cozy-search-trigger' );
		var modal = root.querySelector( '.cozy-search-modal' );
		var panel = root.querySelector( '.cozy-search-panel' );
		var dialog = root.querySelector( '.cozy-search-dialog' );
		var form = root.querySelector( '.cozy-search-form-search' );
		var input = root.querySelector( '.cozy-search-input' );
		var tabsEl = root.querySelector( '.cozy-search-tabs' );
		var statusEl = root.querySelector( '.cozy-search-status' );
		var notice = root.querySelector( '.cozy-search-notice' );
		var suggestions = root.querySelector( '.cozy-search-suggestions' );
		var results = root.querySelector( '.cozy-search-results' );
		var more = root.querySelector( '.cozy-search-more' );
		var viewAll = root.querySelector( '.cozy-search-viewall' );
		var closeBtn = root.querySelector( '.cozy-search-close' );
		var voiceSlot = root.querySelector( '.cozy-search-voice-slot' );
		var uid = ( input.id || 'cozy-search' ).replace( /-input$/, '' );

		if ( ! form || ! input || ! panel ) {
			return;
		}

		var state = {
			term: '',
			type: '',
			page: 1,
			items: [],
			payload: null,
			mode: 'home',
			active: -1,
			req: 0,
			loaded: false,
			committed: '',
			noFuzzy: false,
			focusFrom: -1
		};
		var groupSeq = 0;
		var isOpen = false;
		var lastFocus = null;
		var timer = null;
		var controller = null;
		var composing = false;

		/* ---- platform hint for the keyboard shortcut ---- */
		root.querySelectorAll( '.cozy-search-kbd-mod' ).forEach( function ( k ) {
			k.textContent = isMac ? '⌘' : 'Ctrl';
		} );
		if ( cfg.shortcut ) {
			var shortcutTarget = inline ? input : trigger;
			if ( shortcutTarget ) {
				shortcutTarget.setAttribute( 'aria-keyshortcuts', 'Control+K Meta+K' );
			}
		}

		/*
		 * Inline mode: the visible status sits in the dropdown, which is hidden until it has content,
		 * so its updates would not be announced. A live region outside the dropdown announces them.
		 */
		var liveEl = null;
		if ( inline && statusEl ) {
			statusEl.removeAttribute( 'role' );
			statusEl.removeAttribute( 'aria-live' );
			statusEl.setAttribute( 'aria-hidden', 'true' );
			liveEl = el( 'div', 'cozy-search-sr' );
			liveEl.setAttribute( 'role', 'status' );
			liveEl.setAttribute( 'aria-live', 'polite' );
			( root.querySelector( '.cozy-search-inline-wrap' ) || root ).appendChild( liveEl );
		}

		/* ---- tracking ---- */
		function track( event, term ) {
			if ( ! cfg.trackUrl || ! term ) {
				return;
			}
			var body = JSON.stringify( { s: term, event: event, post_types: cfg.postTypes, per_page: cfg.perPage } );
			try {
				if ( navigator.sendBeacon ) {
					navigator.sendBeacon( cfg.trackUrl, new Blob( [ body ], { type: 'application/json' } ) );
					return;
				}
			} catch ( e ) {}
			try {
				fetch( cfg.trackUrl, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' }, body: body, keepalive: true } ).catch( function () {} );
			} catch ( e ) {}
		}

		function saveRecent( term ) {
			if ( ! cfg.recent || ! term ) {
				return;
			}
			var list = storageGet().filter( function ( x ) { return x.toLowerCase() !== term.toLowerCase(); } );
			list.unshift( term );
			storageSet( list.slice( 0, 20 ) );
		}

		/** Counts the search once per displayed term (on submit, click or close). */
		function commitSearch() {
			var term = state.term;
			if ( term && state.loaded && term.length >= cfg.minChars && state.committed !== term ) {
				state.committed = term;
				saveRecent( term );
				track( 'search', term );
			}
		}

		/* ---- open / close ---- */
		function syncPanel() {
			if ( ! inline ) {
				return;
			}
			var hasContent = state.mode === 'results' || suggestions.childElementCount > 0 || ( tabsEl && ! tabsEl.hidden );
			panel.hidden = ! ( isOpen && hasContent );
			input.setAttribute( 'aria-expanded', panel.hidden ? 'false' : 'true' );
		}

		function open() {
			if ( isOpen ) {
				return;
			}
			isOpen = true;
			root.classList.add( 'is-open' );
			input.setAttribute( 'aria-expanded', 'true' );
			if ( ! inline ) {
				lastFocus = document.activeElement;
				modal.hidden = false;
				trigger.setAttribute( 'aria-expanded', 'true' );
				lockScroll();
			}
			if ( cfg.popular && ! popularRequested ) {
				loadPopular();
			}
			if ( input.value.trim().length < cfg.minChars ) {
				renderHome();
			}
			syncPanel();
			if ( ! inline ) {
				input.focus();
			}
		}

		function close( restoreFocus ) {
			if ( ! isOpen ) {
				return;
			}
			commitSearch();
			isOpen = false;
			clearTimeout( timer );
			if ( voice ) {
				voice.cancel(); // Stop listening once the search closes.
			}
			root.classList.remove( 'is-open' );
			input.setAttribute( 'aria-expanded', 'false' );
			input.removeAttribute( 'aria-activedescendant' );
			if ( inline ) {
				panel.hidden = true;
			} else {
				modal.hidden = true;
				trigger.setAttribute( 'aria-expanded', 'false' );
				unlockScroll();
				if ( restoreFocus !== false && lastFocus && lastFocus.focus ) {
					lastFocus.focus();
				}
			}
		}

		/* ---- rendering helpers ---- */
		function setStatus( text ) {
			statusEl.textContent = text || '';
			if ( liveEl ) {
				liveEl.textContent = text || '';
			}
		}

		function plural( n ) {
			var cat = 'other';
			try {
				cat = new Intl.PluralRules( document.documentElement.lang || undefined ).select( n );
			} catch ( e ) {}
			var tpl = cat === 'one' ? t.resultOne : t.resultOther;
			return String( tpl || '%d' ).replace( '%d', n );
		}

		function setLoading( on ) {
			root.classList.toggle( 'is-loading', on );
			results.setAttribute( 'aria-busy', on ? 'true' : 'false' );
			if ( on ) {
				setStatus( t.searching );
			}
		}

		function searchPageUrl( term ) {
			var u;
			try {
				u = new URL( cfg.searchUrl, window.location.href );
			} catch ( e ) {
				return '#';
			}
			u.searchParams.set( 's', term );
			var types = state.type ? [ state.type ] : cfg.postTypes.split( ',' ).filter( Boolean );
			types.forEach( function ( p ) { u.searchParams.append( 'post_type[]', p ); } );
			return u.toString();
		}

		function updateViewAll( term ) {
			if ( ! viewAll ) {
				return;
			}
			if ( ! cfg.viewAll || ! term ) {
				viewAll.hidden = true;
				return;
			}
			viewAll.hidden = false;
			viewAll.href = searchPageUrl( term );
			viewAll.textContent = String( t.viewAll ).replace( '%s', term );
		}

		function chip( text, onClick ) {
			var b = el( 'button', 'cozy-search-chip', text );
			b.type = 'button';
			b.addEventListener( 'click', onClick );
			return b;
		}

		function chipGroup( title, nodes, extra ) {
			var g = el( 'div', 'cozy-search-chip-group' );
			var head = el( 'div', 'cozy-search-chip-head' );
			var label = el( 'span', 'cozy-search-chip-title', title );
			label.id = uid + '-chips-' + ( ++groupSeq );
			g.setAttribute( 'role', 'group' );
			g.setAttribute( 'aria-labelledby', label.id );
			head.appendChild( label );
			if ( extra ) {
				head.appendChild( extra );
			}
			g.appendChild( head );
			var wrap = el( 'div', 'cozy-search-chips' );
			nodes.forEach( function ( n ) { wrap.appendChild( n ); } );
			g.appendChild( wrap );
			return g;
		}

		function runTerm( term ) {
			input.value = term;
			state.noFuzzy = false;
			run( term, 1 );
			input.focus();
		}

		function recentChip( term ) {
			var w = el( 'span', 'cozy-search-chip-wrap' );
			w.appendChild( chip( term, function () { runTerm( term ); } ) );
			var rm = el( 'button', 'cozy-search-chip-remove' );
			rm.type = 'button';
			rm.setAttribute( 'aria-label', t.remove + ': ' + term );
			rm.textContent = '×';
			rm.addEventListener( 'click', function () {
				storageSet( storageGet().filter( function ( x ) { return x !== term; } ) );
				renderHome();
				input.focus();
			} );
			w.appendChild( rm );
			return w;
		}

		function renderTabs() {
			if ( ! tabsEl ) {
				return;
			}
			tabsEl.textContent = '';
			if ( ! cfg.tabs || cfg.types.length < 2 ) {
				tabsEl.hidden = true;
				return;
			}
			tabsEl.hidden = false;
			tabsEl.setAttribute( 'aria-label', t.filter );
			[ { name: '', label: t.all } ].concat( cfg.types ).forEach( function ( ty ) {
				var b = el( 'button', 'cozy-search-tab', ty.label );
				b.type = 'button';
				b.setAttribute( 'aria-pressed', state.type === ty.name ? 'true' : 'false' );
				b.addEventListener( 'click', function () {
					state.type = ty.name;
					renderTabs();
					if ( input.value.trim().length >= cfg.minChars ) {
						run( input.value.trim(), 1 );
					} else {
						renderHome();
					}
					input.focus();
				} );
				tabsEl.appendChild( b );
			} );
		}

		function renderHome() {
			state.mode = 'home';
			state.items = [];
			state.active = -1;
			state.loaded = false;
			input.removeAttribute( 'aria-activedescendant' );
			results.textContent = '';
			more.textContent = '';
			notice.textContent = '';
			suggestions.textContent = '';
			setStatus( '' );
			updateViewAll( '' );
			renderTabs();

			var recent = cfg.recent ? storageGet().slice( 0, cfg.recentLimit ) : [];
			if ( recent.length ) {
				var clr = el( 'button', 'cozy-search-chip-clear', t.clear );
				clr.type = 'button';
				clr.addEventListener( 'click', function () {
					storageSet( [] );
					renderHome();
					input.focus();
				} );
				suggestions.appendChild( chipGroup( t.recent, recent.map( recentChip ), clr ) );
			}
			if ( cfg.popular && popularCache && popularCache.length ) {
				suggestions.appendChild( chipGroup( t.popular, popularCache.map( function ( p ) {
					return chip( p, function () { runTerm( p ); } );
				} ) ) );
			}
			syncPanel();
		}

		function loadPopular() {
			popularRequested = true;
			fetch( cfg.popularUrl, { credentials: 'same-origin', headers: { Accept: 'application/json' } } )
				.then( function ( r ) { return r.ok ? r.json() : { popular: [] }; } )
				.then( function ( d ) {
					popularCache = Array.isArray( d.popular ) ? d.popular : [];
					if ( isOpen && state.mode === 'home' ) {
						renderHome();
					}
				} )
				.catch( function () { popularCache = []; } );
		}

		function resultNode( item, idx, terms, grouped ) {
			var a = el( 'a', 'cozy-search-result' );
			a.href = item.url;
			a.id = uid + '-opt-' + idx;
			a.setAttribute( 'role', 'option' );
			a.setAttribute( 'aria-selected', 'false' );
			a.tabIndex = -1;
			a.dataset.index = String( idx );

			if ( cfg.images && item.image ) {
				var img = el( 'img', 'cozy-search-result-img' );
				img.src = item.image;
				img.alt = '';
				img.loading = 'lazy';
				img.width = 56;
				img.height = 56;
				a.appendChild( img );
			}

			var body = el( 'div', 'cozy-search-result-body' );
			// The option is named by its title and described by its details, instead of by all of its text.
			var title = el( 'div', 'cozy-search-result-title' );
			title.id = a.id + '-title';
			highlight( title, item.title, cfg.highlight ? terms : [] );
			body.appendChild( title );
			a.setAttribute( 'aria-labelledby', title.id );

			var meta = el( 'div', 'cozy-search-result-meta' );
			meta.id = a.id + '-meta';
			var bits = 0;
			function addMeta( node ) {
				if ( bits++ ) {
					meta.appendChild( el( 'span', 'cozy-search-dot', '·' ) );
				}
				meta.appendChild( node );
			}
			if ( ! grouped && item.typeLabel ) {
				addMeta( el( 'span', 'cozy-search-type', item.typeLabel ) );
			}
			if ( item.price ) {
				var price = el( 'span', 'cozy-search-price' );
				if ( item.onSale && item.regularPrice ) {
					// <del> has no meaning for screen readers, so the two prices are labelled.
					var old = el( 'del', 'cozy-search-price-old' );
					old.appendChild( srText( t.originalPrice + ' ' ) );
					old.appendChild( document.createTextNode( item.regularPrice ) );
					price.appendChild( old );
					price.appendChild( document.createTextNode( ' ' ) );
					price.appendChild( srText( t.currentPrice + ' ' ) );
				}
				price.appendChild( document.createTextNode( item.price ) );
				addMeta( price );
			}
			if ( item.onSale ) {
				addMeta( el( 'span', 'cozy-search-badge cozy-search-badge-sale', t.onSale ) );
			}
			if ( item.inStock === false ) {
				addMeta( el( 'span', 'cozy-search-badge cozy-search-badge-out', t.outOfStock ) );
			}
			if ( item.ratingCount > 0 && item.rating ) {
				var rating = el( 'span', 'cozy-search-rating' );
				var stars = el( 'span', '', '★ ' + item.rating.toFixed( 1 ) + ' (' + item.ratingCount + ')' );
				stars.setAttribute( 'aria-hidden', 'true' );
				rating.appendChild( stars );
				rating.appendChild( srText(
					String( t.rating || '' )
						.replace( '%1$s', item.rating.toFixed( 1 ) )
						.replace( '%2$s', String( item.ratingCount ) )
				) );
				addMeta( rating );
			}
			if ( item.date ) {
				addMeta( el( 'span', 'cozy-search-date', item.date ) );
			}
			if ( bits ) {
				body.appendChild( meta );
				a.setAttribute( 'aria-describedby', meta.id );
			}

			if ( cfg.excerpts && item.excerpt ) {
				var ex = el( 'div', 'cozy-search-result-excerpt' );
				highlight( ex, item.excerpt, cfg.highlight ? terms : [] );
				body.appendChild( ex );
			}
			a.appendChild( body );

			a.addEventListener( 'click', function () {
				saveRecent( state.term );
				if ( state.term && state.committed !== state.term ) {
					state.committed = state.term;
					track( 'search', state.term ); // The search row must exist before its click is counted.
				}
				track( 'click', state.term );
			} );
			a.addEventListener( 'mousemove', function () {
				if ( state.active !== idx ) {
					setActive( idx, false );
				}
			} );
			return a;
		}

		function renderResults( terms ) {
			results.textContent = '';
			var grouped = cfg.group && ! state.type;
			var groups = [];
			var byType = {};
			state.items.forEach( function ( item, idx ) {
				if ( ! grouped ) {
					groups.push( { label: '', entries: [ { item: item, idx: idx } ] } );
					return;
				}
				var key = item.type;
				if ( ! byType[ key ] ) {
					byType[ key ] = { label: item.typePlural || item.typeLabel, entries: [] };
					groups.push( byType[ key ] );
				}
				byType[ key ].entries.push( { item: item, idx: idx } );
			} );

			if ( grouped ) {
				groups.forEach( function ( g, gi ) {
					var wrap = el( 'div', 'cozy-search-group' );
					wrap.setAttribute( 'role', 'group' );
					var head = el( 'div', 'cozy-search-group-title', g.label );
					head.id = uid + '-grp-' + gi;
					wrap.setAttribute( 'aria-labelledby', head.id );
					wrap.appendChild( head );
					g.entries.forEach( function ( e ) { wrap.appendChild( resultNode( e.item, e.idx, terms, true ) ); } );
					results.appendChild( wrap );
				} );
			} else {
				groups.forEach( function ( g ) {
					g.entries.forEach( function ( e ) { results.appendChild( resultNode( e.item, e.idx, terms, false ) ); } );
				} );
			}
		}

		function renderNotice( d ) {
			notice.textContent = '';
			if ( d.fuzzy && d.corrected ) {
				var strong = el( 'strong', '', d.corrected );
				notice.appendChild( withNode( t.showingFor, strong ) );
				var b = el( 'button', 'cozy-search-link-btn' );
				b.type = 'button';
				b.appendChild( withNode( t.searchFor, el( 'strong', '', state.term ) ) );
				b.addEventListener( 'click', function () {
					state.noFuzzy = true;
					run( state.term, 1 );
					input.focus(); // The button is re-rendered away.
				} );
				notice.appendChild( b );
			} else if ( ! state.items.length && d.corrected ) {
				var fix = el( 'button', 'cozy-search-link-btn cozy-search-link-strong', d.corrected );
				fix.type = 'button';
				fix.addEventListener( 'click', function () { runTerm( d.corrected ); } );
				notice.appendChild( withNode( t.didYouMean, fix ) );
			}
		}

		function renderSuggestions( d ) {
			suggestions.textContent = '';
			if ( cfg.queries && d.queries && d.queries.length ) {
				suggestions.appendChild( chipGroup( t.suggested, d.queries.map( function ( q ) {
					return chip( q, function () { runTerm( q ); } );
				} ) ) );
			}
			if ( cfg.topics && d.suggestions && d.suggestions.length ) {
				var links = d.suggestions.map( function ( s ) {
					var a = el( 'a', 'cozy-search-chip cozy-search-chip-link', s.name + ' (' + s.count + ')' );
					a.href = s.url;
					a.title = s.taxonomyLabel;
					if ( s.taxonomyLabel ) {
						a.appendChild( srText( ', ' + s.taxonomyLabel ) );
					}
					return a;
				} );
				suggestions.appendChild( chipGroup( t.topics, links ) );
			}
			if ( ! state.items.length ) {
				var msg = el( 'div', 'cozy-search-empty' );
				msg.appendChild( el( 'p', 'cozy-search-empty-title', String( t.noResults ).replace( '%s', state.term ) ) );
				msg.appendChild( el( 'p', 'cozy-search-empty-tip', t.noResultsTip ) );
				// Not in the listbox, which may only hold options.
				notice.appendChild( msg );
				if ( cfg.popular && popularCache && popularCache.length ) {
					suggestions.appendChild( chipGroup( t.popular, popularCache.map( function ( p ) {
						return chip( p, function () { runTerm( p ); } );
					} ) ) );
				}
			}
		}

		function renderMore() {
			more.textContent = '';
			// Pro: the server only returns the first page on free sites.
			if ( cfg.loadMore && state.payload && state.payload.hasMore ) {
				var b = el( 'button', 'cozy-search-more-btn', t.loadMore );
				b.type = 'button';
				b.addEventListener( 'click', function () {
					// The button is replaced, so focus goes back to the input and the first new result becomes active.
					state.focusFrom = state.items.length;
					run( state.term, state.page + 1 );
					input.focus();
				} );
				more.appendChild( b );
			}
		}

		function apply( d, append ) {
			state.mode = 'results';
			state.loaded = true;
			state.payload = d;
			state.page = d.page || 1;
			state.items = append ? state.items.concat( d.results || [] ) : ( d.results || [] );
			var terms = queryTerms( state.term, d.corrected );

			renderTabs();
			renderResults( terms );
			if ( ! append ) {
				state.active = -1;
				input.removeAttribute( 'aria-activedescendant' );
				renderNotice( d );
				renderSuggestions( d );
			} else if ( state.focusFrom >= 0 && state.focusFrom < state.items.length ) {
				setActive( state.focusFrom, true );
			} else if ( state.active >= 0 ) {
				setActive( state.active, false );
			}
			state.focusFrom = -1;
			renderMore();
			setLoading( false );
			setStatus( state.items.length ? plural( state.items.length ) + ( d.hasMore || d.truncated ? '+' : '' ) : t.noneShort );
			updateViewAll( state.term );
			syncPanel();
			if ( ! append ) {
				var body = root.querySelector( '.cozy-search-body' );
				if ( body ) {
					body.scrollTop = 0;
				}
			}
		}

		function showError( message, term, page ) {
			state.mode = 'results';
			setLoading( false );
			setStatus( message );
			notice.textContent = '';
			var p = el( 'p', 'cozy-search-notice-text', message );
			var b = el( 'button', 'cozy-search-link-btn cozy-search-link-strong', t.retry );
			b.type = 'button';
			b.addEventListener( 'click', function () {
				run( term, page );
				input.focus(); // The button is re-rendered away.
			} );
			notice.appendChild( p );
			notice.appendChild( b );
			syncPanel();
		}

		/* ---- fetching ---- */
		function buildUrl( term, page ) {
			var u = new URL( cfg.restUrl, window.location.href );
			u.searchParams.set( 's', term );
			u.searchParams.set( 'post_types', state.type || cfg.postTypes );
			if ( cfg.taxonomies ) {
				u.searchParams.set( 'taxonomies', cfg.taxonomies );
			}
			u.searchParams.set( 'per_page', String( cfg.perPage ) );
			u.searchParams.set( 'page', String( page ) );
			u.searchParams.set( 'fuzzy', cfg.fuzzy && ! state.noFuzzy ? '1' : '0' );
			return u.toString();
		}

		function run( term, page ) {
			term = ( term || '' ).trim();
			if ( term.length < cfg.minChars ) {
				renderHome();
				return;
			}
			if ( controller ) {
				controller.abort();
			}
			var append = page > 1;
			if ( ! append ) {
				state.term = term;
			}
			var url = buildUrl( term, page );
			var id = ++state.req;

			if ( responseCache.has( url ) ) {
				apply( responseCache.get( url ), append );
				return;
			}

			controller = typeof AbortController === 'function' ? new AbortController() : null;
			setLoading( true );
			fetch( url, {
				credentials: 'same-origin',
				headers: { Accept: 'application/json' },
				signal: controller ? controller.signal : undefined
			} )
				.then( function ( r ) {
					if ( r.status === 429 ) {
						throw new Error( t.rateLimited );
					}
					if ( ! r.ok ) {
						throw new Error( t.error );
					}
					return r.json();
				} )
				.then( function ( d ) {
					if ( id !== state.req ) {
						return;
					}
					responseCache.set( url, d );
					apply( d, append );
				} )
				.catch( function ( err ) {
					if ( ( err && err.name === 'AbortError' ) || id !== state.req ) {
						return;
					}
					showError( ( err && err.message ) || t.error, term, page );
				} );
		}

		/* ---- keyboard / active option ---- */
		function options() {
			return results.querySelectorAll( '.cozy-search-result' );
		}

		function setActive( i, scroll ) {
			var opts = options();
			var prev = opts[ state.active ];
			if ( prev ) {
				prev.classList.remove( 'is-active' );
				prev.setAttribute( 'aria-selected', 'false' );
			}
			state.active = i;
			var cur = opts[ i ];
			if ( cur ) {
				cur.classList.add( 'is-active' );
				cur.setAttribute( 'aria-selected', 'true' );
				input.setAttribute( 'aria-activedescendant', cur.id );
				if ( scroll !== false ) {
					cur.scrollIntoView( { block: 'nearest' } );
				}
			} else {
				input.removeAttribute( 'aria-activedescendant' );
			}
		}

		function move( delta ) {
			var n = options().length;
			if ( ! n ) {
				return;
			}
			var i = state.active + delta;
			if ( i < 0 ) {
				i = n - 1;
			} else if ( i >= n ) {
				i = 0;
			}
			setActive( i, true );
		}

		function focusables() {
			return Array.prototype.filter.call(
				dialog.querySelectorAll( 'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"])' ),
				function ( n ) { return n.tabIndex !== -1 && visible( n ); }
			);
		}

		input.addEventListener( 'compositionstart', function () { composing = true; } );
		input.addEventListener( 'compositionend', function () {
			composing = false;
			input.dispatchEvent( new Event( 'input', { bubbles: true } ) );
		} );

		input.addEventListener( 'input', function () {
			if ( composing ) {
				return;
			}
			clearTimeout( timer );
			var v = input.value.trim();
			state.noFuzzy = false;
			if ( inline && ! isOpen ) {
				open();
			}
			if ( v.length < cfg.minChars ) {
				state.req++;
				if ( controller ) {
					controller.abort();
				}
				state.term = '';
				setLoading( false );
				renderHome();
				return;
			}
			timer = setTimeout( function () { run( v, 1 ); }, cfg.debounce );
		} );

		input.addEventListener( 'keydown', function ( e ) {
			if ( e.isComposing ) {
				return;
			}
			switch ( e.key ) {
				case 'ArrowDown':
					e.preventDefault();
					if ( ! isOpen ) {
						open();
					}
					move( 1 );
					break;
				case 'ArrowUp':
					e.preventDefault();
					move( -1 );
					break;
				case 'Home':
				case 'End':
					// Only while an option is active; otherwise they move the caret.
					if ( state.active >= 0 && options().length ) {
						e.preventDefault();
						setActive( e.key === 'Home' ? 0 : options().length - 1, true );
					}
					break;
				case 'Enter':
					var opt = options()[ state.active ];
					if ( opt ) {
						e.preventDefault();
						opt.click();
					}
					break;
			}
		} );

		if ( inline ) {
			input.addEventListener( 'focus', open );
			input.addEventListener( 'click', open );
			root.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' && isOpen ) {
					e.preventDefault();
					close( false );
				}
			} );
			document.addEventListener( 'pointerdown', function ( e ) {
				if ( isOpen && ! root.contains( e.target ) ) {
					close( false );
				}
			} );
			root.addEventListener( 'focusout', function ( e ) {
				if ( isOpen && e.relatedTarget && ! root.contains( e.relatedTarget ) ) {
					close( false );
				}
			} );
		} else {
			trigger.addEventListener( 'click', open );
			closeBtn.addEventListener( 'click', function () { close(); } );
			modal.querySelector( '.cozy-search-backdrop' ).addEventListener( 'click', function () { close(); } );
			modal.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' ) {
					e.preventDefault();
					e.stopPropagation();
					close();
				} else if ( e.key === 'Tab' ) {
					var f = focusables();
					if ( ! f.length ) {
						return;
					}
					var first = f[ 0 ];
					var last = f[ f.length - 1 ];
					if ( e.shiftKey && document.activeElement === first ) {
						e.preventDefault();
						last.focus();
					} else if ( ! e.shiftKey && document.activeElement === last ) {
						e.preventDefault();
						first.focus();
					}
				}
			} );
		}

		// Opening the full results page counts the search, like submitting the form does.
		// track() uses sendBeacon, so the request survives the navigation.
		if ( viewAll ) {
			viewAll.addEventListener( 'click', commitSearch );
		}

		form.addEventListener( 'submit', function ( e ) {
			if ( ! input.value.trim() ) {
				e.preventDefault();
				return;
			}
			state.term = state.term || input.value.trim();
			commitSearch();
		} );

		/* ---- voice search (progressive enhancement) ---- */
		var voice = null; // Set below when voice search is available; close() cancels it.
		var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
		if ( cfg.voice && SR && voiceSlot ) {
			var mic = el( 'button', 'cozy-search-icon-btn cozy-search-voice' );
			mic.type = 'button';
			mic.setAttribute( 'aria-label', t.voice );
			mic.setAttribute( 'aria-pressed', 'false' );
			var micSvg = '<svg class="cozy-search-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0M12 18v3"/></svg>';
			mic.innerHTML = micSvg;

			// Visual only: the status region already announces the same text to screen readers.
			var toast = el( 'div', 'cozy-search-toast' );
			toast.setAttribute( 'aria-hidden', 'true' );
			toast.hidden = true;
			var toastIcon = el( 'span', 'cozy-search-toast-icon' );
			toastIcon.innerHTML = micSvg;
			var toastText = el( 'span', 'cozy-search-toast-text' );
			toast.appendChild( toastIcon );
			toast.appendChild( toastText );
			root.appendChild( toast );
			var toastTimer = null;

			function showToast( text, isError ) {
				clearTimeout( toastTimer );
				toastText.textContent = text;
				toast.classList.toggle( 'is-error', !! isError );
				toast.hidden = false;
			}

			function hideToast( delay ) {
				clearTimeout( toastTimer );
				toastTimer = setTimeout( function () {
					toast.hidden = true;
				}, delay || 0 );
			}

			/* Typewriter: eases input.value toward the latest transcript so words appear as they
			   are spoken instead of all at once. */
			var reduceMotion = !! ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches );
			var typeTimer = null;
			var typeTarget = [];
			var typeDone = null;
			var typeStep = 1;

			function caretToEnd() {
				var n = input.value.length;
				try {
					input.setSelectionRange( n, n );
				} catch ( e ) {}
				input.scrollLeft = input.scrollWidth;
			}

			function stopTyping() {
				clearTimeout( typeTimer );
				typeTimer = null;
				typeDone = null;
			}

			function typeTick() {
				typeTimer = null;
				var cur = Array.from( input.value );
				var target = typeTarget;
				var i = 0;
				while ( i < cur.length && i < target.length && cur[ i ] === target[ i ] ) {
					i++;
				}
				// The recognizer revised earlier words: drop back to what still matches.
				cur = cur.slice( 0, i );
				if ( cur.length < target.length ) {
					cur = target.slice( 0, cur.length + typeStep );
				}
				input.value = cur.join( '' );
				caretToEnd();
				if ( cur.length < target.length ) {
					typeTimer = setTimeout( typeTick, 16 );
					return;
				}
				var done = typeDone;
				typeDone = null;
				if ( done ) {
					done();
				}
			}

			function typeTo( text, done ) {
				typeTarget = Array.from( text );
				typeDone = done || null;
				// Each update is typed out within about 6 ticks (~100ms), so the input never lags speech.
				var cur = Array.from( input.value );
				var same = 0;
				while ( same < cur.length && same < typeTarget.length && cur[ same ] === typeTarget[ same ] ) {
					same++;
				}
				typeStep = Math.max( 1, Math.ceil( ( typeTarget.length - same ) / 6 ) );
				if ( reduceMotion ) {
					clearTimeout( typeTimer );
					typeTimer = null;
					input.value = text;
				}
				if ( ! typeTimer ) {
					typeTick();
				}
			}

			// Words go quiet this long before we end listening ourselves; Chrome can wait much longer.
			var SILENCE_MS = 800;
			// Search the words so far once they settle, so results are ready when speech ends.
			var PREVIEW_MS = 300;

			var rec = null;
			var session = null; // State of the current dictation.

			function setListening( on ) {
				mic.classList.toggle( 'is-listening', on );
				mic.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
			}

			function clearVoiceTimers( s ) {
				if ( s ) {
					clearTimeout( s.silence );
					clearTimeout( s.preview );
				}
			}

			function voiceSearch( text ) {
				state.noFuzzy = false;
				if ( inline && ! isOpen ) {
					open();
				}
				// The preview may already be loading or showing this term; don't restart it.
				if ( text !== state.term ) {
					run( text, 1 );
				}
			}

			function endDictation() {
				clearVoiceTimers( session );
				root.classList.remove( 'is-dictating', 'is-interim' );
				session = null;
			}

			function submitVoice( text ) {
				endDictation();
				hideToast( 0 );
				voiceSearch( text );
			}

			voice = {
				cancel: function () {
					stopTyping();
					endDictation();
					hideToast( 0 );
					if ( rec ) {
						rec.abort();
					}
				}
			};

			// Typing during dictation means the visitor took over: stop listening, keep their text.
			input.addEventListener( 'input', function () {
				if ( ! session ) {
					return;
				}
				session.takenOver = true;
				stopTyping();
				hideToast( 0 );
				endDictation();
				if ( rec ) {
					rec.abort();
				}
			} );

			mic.addEventListener( 'click', function () {
				if ( rec ) {
					rec.stop(); // Ends with a final result for whatever was heard.
					return;
				}
				stopTyping();
				var current = { saved: input.value, heard: false, final: false, failed: false, takenOver: false, lastText: '' };
				session = current;
				rec = new SR();
				rec.lang = document.documentElement.lang || 'en-US';
				rec.interimResults = true;
				rec.continuous = false;
				rec.onspeechstart = function () {
					showToast( t.heard );
				};
				rec.onresult = function ( ev ) {
					if ( session !== current ) {
						return;
					}
					var text = '';
					for ( var i = 0; i < ev.results.length; i++ ) {
						text += ev.results[ i ][ 0 ].transcript;
					}
					text = text.replace( /\s+/g, ' ' ).replace( /^ /, '' );
					var isFinal = ev.results[ ev.results.length - 1 ].isFinal;
					if ( ! current.heard ) {
						current.heard = true;
						input.value = ''; // Replace the old text, but only once speech arrives.
						showToast( t.heard );
					}
					root.classList.toggle( 'is-interim', ! isFinal );
					clearVoiceTimers( current );
					if ( ! isFinal ) {
						typeTo( text );
						var soFar = text.trim();
						current.lastText = soFar;
						current.preview = setTimeout( function () {
							if ( session === current && soFar.length >= cfg.minChars ) {
								voiceSearch( soFar );
							}
						}, PREVIEW_MS );
						current.silence = setTimeout( function () {
							if ( rec && session === current ) {
								rec.stop(); // Chrome then sends the final result right away.
							}
						}, SILENCE_MS );
						return;
					}
					// Final: show it at once and search without waiting for the typing to finish.
					current.final = true;
					text = text.trim();
					stopTyping();
					if ( text ) {
						input.value = text;
						caretToEnd();
						submitVoice( text );
					} else {
						input.value = current.saved;
						endDictation();
					}
				};
				rec.onerror = function ( ev ) {
					var code = ev && ev.error;
					if ( 'aborted' === code ) {
						return; // Stopped by us, not a failure.
					}
					current.failed = true;
					var msg = 'no-speech' === code ? t.noSpeech : t.voiceError;
					setStatus( msg );
					showToast( msg, true );
				};
				rec.onend = function () {
					rec = null;
					clearVoiceTimers( current );
					setListening( false );
					if ( current.final || current.takenOver ) {
						return; // Already searched, or the visitor is typing.
					}
					stopTyping();
					// Ended early without a final result: keep and search the words already heard.
					if ( session === current && current.lastText && ! current.failed ) {
						input.value = current.lastText;
						caretToEnd();
						submitVoice( current.lastText );
						return;
					}
					// Nothing usable was heard (silence, an error or the search closed).
					input.value = current.saved;
					if ( session === current ) {
						endDictation();
					}
					hideToast( current.failed ? 3000 : 0 );
				};

				root.classList.add( 'is-dictating' );
				setListening( true );
				setStatus( t.listening );
				showToast( t.listening );
				if ( inline && ! isOpen ) {
					open();
				}
				// Show the caret without raising the on-screen keyboard on touch devices.
				if ( ! ( window.matchMedia && window.matchMedia( '(pointer: coarse)' ).matches ) ) {
					input.focus();
				}
				try {
					rec.start();
				} catch ( e ) {
					rec = null;
					setListening( false );
					endDictation();
					setStatus( t.voiceError );
					showToast( t.voiceError, true );
					hideToast( 3000 );
				}
			} );
			voiceSlot.appendChild( mic );
		}

		registry.push( {
			cfg: cfg,
			inline: inline,
			isOpen: function () { return isOpen; },
			close: function () { close(); },
			visible: function () { return visible( inline ? input : trigger ); },
			activate: function () {
				if ( inline ) {
					input.focus();
				} else {
					open();
				}
			}
		} );

		if ( ! inline ) {
			renderHome();
		}
		bindShortcut();
	}

	/* Ctrl/Cmd + K opens the first visible search that enabled the shortcut. */
	function bindShortcut() {
		if ( shortcutBound ) {
			return;
		}
		shortcutBound = true;
		document.addEventListener( 'keydown', function ( e ) {
			if ( ! ( e.ctrlKey || e.metaKey ) || e.altKey || e.shiftKey || ( e.key !== 'k' && e.key !== 'K' ) ) {
				return;
			}
			if ( e.target && e.target.isContentEditable ) {
				return;
			}
			var openOne = registry.filter( function ( r ) { return r.isOpen() && ! r.inline; } )[ 0 ];
			if ( openOne ) {
				e.preventDefault();
				openOne.close();
				return;
			}
			var target = registry.filter( function ( r ) { return r.cfg.shortcut && r.visible(); } )[ 0 ];
			if ( target ) {
				e.preventDefault();
				target.activate();
			}
		} );
	}

	function boot( scope ) {
		( scope || document ).querySelectorAll( SELECTOR ).forEach( init );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () { boot(); } );
	} else {
		boot();
	}

	// Blocks injected later (popups, navigation overlays): only inspect added nodes.
	if ( 'MutationObserver' in window ) {
		new MutationObserver( function ( list ) {
			list.forEach( function ( m ) {
				m.addedNodes.forEach( function ( n ) {
					if ( n.nodeType !== 1 ) {
						return;
					}
					if ( n.matches && n.matches( SELECTOR ) ) {
						init( n );
					}
					if ( n.querySelectorAll ) {
						boot( n );
					}
				} );
			} );
		} ).observe( document.documentElement, { childList: true, subtree: true } );
	}
}() );
