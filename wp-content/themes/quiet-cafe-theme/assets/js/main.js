/**
 * The Quiet Café – main.js
 * Handles: sticky nav, mobile menu, menu tabs,
 *          scroll reveal, reservation AJAX, min date
 *
 * No jQuery required. Pure vanilla JS.
 * @package QuietCafe
 */

( function () {
    'use strict';

    /* ────────────────────────────────────────
       DOM READY
    ─────────────────────────────────────── */
    document.addEventListener( 'DOMContentLoaded', function () {
        initStickyNav();
        initMobileMenu();
        initMenuTabs();
        initScrollReveal();
        initReservationForm();
        initMinDate();
    } );

    /* ────────────────────────────────────────
       STICKY NAV — adds shadow on scroll
    ─────────────────────────────────────── */
    function initStickyNav() {
        const header = document.getElementById( 'masthead' );
        if ( ! header ) return;

        let ticking = false;

        window.addEventListener( 'scroll', function () {
            if ( ! ticking ) {
                window.requestAnimationFrame( function () {
                    header.classList.toggle( 'is-scrolled', window.scrollY > 20 );
                    ticking = false;
                } );
                ticking = true;
            }
        }, { passive: true } );
    }

    /* ────────────────────────────────────────
       MOBILE MENU TOGGLE
    ─────────────────────────────────────── */
    function initMobileMenu() {
        const toggle = document.getElementById( 'menu-toggle' );
        const nav    = document.getElementById( 'site-navigation' );
        if ( ! toggle || ! nav ) return;

        toggle.addEventListener( 'click', function () {
            const isOpen = nav.classList.toggle( 'is-open' );
            toggle.setAttribute( 'aria-expanded', isOpen );
            document.body.style.overflow = isOpen ? 'hidden' : '';
        } );

        // Close on nav link click
        nav.querySelectorAll( 'a' ).forEach( function ( link ) {
            link.addEventListener( 'click', function () {
                nav.classList.remove( 'is-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
                document.body.style.overflow = '';
            } );
        } );

        // Close on Escape key
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
                nav.classList.remove( 'is-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
                document.body.style.overflow = '';
                toggle.focus();
            }
        } );
    }

    /* ────────────────────────────────────────
       MENU TABS
    ─────────────────────────────────────── */
    function initMenuTabs() {
        const tabs   = document.querySelectorAll( '.menu-tab' );
        const panels = document.querySelectorAll( '.menu-panel' );
        if ( ! tabs.length ) return;

        tabs.forEach( function ( tab ) {
            tab.addEventListener( 'click', function () {
                const target = tab.dataset.tab;

                tabs.forEach( function ( t ) {
                    t.classList.remove( 'is-active' );
                    t.setAttribute( 'aria-selected', 'false' );
                } );

                panels.forEach( function ( p ) {
                    p.classList.remove( 'is-active' );
                } );

                tab.classList.add( 'is-active' );
                tab.setAttribute( 'aria-selected', 'true' );

                const panel = document.getElementById( 'menu-panel-' + target );
                if ( panel ) panel.classList.add( 'is-active' );
            } );

            // Arrow key navigation for accessibility
            tab.addEventListener( 'keydown', function ( e ) {
                const tabArr = Array.from( tabs );
                const idx    = tabArr.indexOf( tab );
                if ( e.key === 'ArrowRight' ) {
                    tabArr[ ( idx + 1 ) % tabArr.length ].focus();
                } else if ( e.key === 'ArrowLeft' ) {
                    tabArr[ ( idx - 1 + tabArr.length ) % tabArr.length ].focus();
                }
            } );
        } );
    }

    /* ────────────────────────────────────────
       SCROLL REVEAL
    ─────────────────────────────────────── */
    function initScrollReveal() {
        const els = document.querySelectorAll( '.reveal' );
        if ( ! els.length ) return;

        if ( 'IntersectionObserver' in window ) {
            const observer = new IntersectionObserver( function ( entries ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        entry.target.classList.add( 'is-visible' );
                        observer.unobserve( entry.target );
                    }
                } );
            }, { threshold: 0.12 } );

            els.forEach( function ( el ) { observer.observe( el ); } );
        } else {
            // Fallback: show all immediately
            els.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
        }
    }

    /* ────────────────────────────────────────
       RESERVATION AJAX FORM
    ─────────────────────────────────────── */
    function initReservationForm() {
        const form = document.getElementById( 'qc-reservation-form' );
        if ( ! form ) return;

        form.addEventListener( 'submit', function ( e ) {
            e.preventDefault();

            const btn     = document.getElementById( 'qc-submit-btn' );
            const msgEl   = document.getElementById( 'qc-form-message' );
            const data    = new FormData( form );

            // Add AJAX action & nonce
            data.append( 'action', 'qc_reservation' );
            data.append( 'nonce',  form.querySelector( '[name="qc_nonce"]' ) ? form.querySelector( '[name="qc_nonce"]' ).value : '' );

            // Disable button
            btn.disabled       = true;
            btn.textContent    = typeof qcData !== 'undefined' ? '…' : 'Sending…';
            msgEl.style.display = 'none';

            const ajaxUrl = ( typeof qcData !== 'undefined' && qcData.ajaxUrl )
                ? qcData.ajaxUrl
                : '/wp-admin/admin-ajax.php';

            fetch( ajaxUrl, {
                method:      'POST',
                credentials: 'same-origin',
                body:        data,
            } )
            .then( function ( res ) { return res.json(); } )
            .then( function ( response ) {
                if ( response.success ) {
                    showFormMessage( msgEl, response.data.message, 'success' );
                    btn.textContent = response.data.message;
                    btn.style.background = 'var(--qc-sage)';
                    form.reset();
                    setTimeout( function () {
                        btn.textContent      = 'Confirm Reservation →';
                        btn.style.background = '';
                        btn.disabled         = false;
                    }, 5000 );
                } else {
                    const errMsg = response.data && response.data.message ? response.data.message : 'Something went wrong.';
                    showFormMessage( msgEl, errMsg, 'error' );
                    btn.textContent = 'Confirm Reservation →';
                    btn.disabled    = false;
                }
            } )
            .catch( function () {
                showFormMessage( msgEl, 'Network error. Please try again.', 'error' );
                btn.textContent = 'Confirm Reservation →';
                btn.disabled    = false;
            } );
        } );
    }

    function showFormMessage( el, text, type ) {
        el.textContent     = text;
        el.style.display   = 'block';
        el.style.background = type === 'success' ? 'rgba(92,107,74,0.12)' : 'rgba(176,58,46,0.1)';
        el.style.color     = type === 'success' ? 'var(--qc-sage)' : 'var(--qc-warm-red)';
        el.style.border    = '1px solid ' + ( type === 'success' ? 'var(--qc-sage)' : 'var(--qc-warm-red)' );
    }

    /* ────────────────────────────────────────
       SET MINIMUM DATE ON RESERVATION FIELD
    ─────────────────────────────────────── */
    function initMinDate() {
        const dateInput = document.getElementById( 'res-date' );
        if ( dateInput ) {
            dateInput.min = new Date().toISOString().split( 'T' )[ 0 ];
        }
    }

} )();
