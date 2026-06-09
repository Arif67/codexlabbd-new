/**
 * Lightweight SPA navigation — no framework (no React/Vue), pure vanilla JS.
 *
 * How it works:
 *   - Intercepts clicks on internal links
 *   - Fetches the target page with fetch()
 *   - Swaps only the #spa-main region (navbar + header + content)
 *   - Updates <title> and the URL via the History API (pushState)
 *   - Handles browser back/forward (popstate)
 *   - Submits the contact form via AJAX (no reload)
 *
 * The footer, spinner and back-to-top button stay in place (never reloaded).
 */
(function () {
    "use strict";

    var ROOT_ID = 'spa-main';
    var ORIGIN = window.location.origin;
    var progress = null;

    /* ---------------------------------------------------------------- *
     * Top progress bar
     * ---------------------------------------------------------------- */
    function ensureProgress() {
        if (progress) return;
        progress = document.createElement('div');
        progress.id = 'spa-progress';
        document.body.appendChild(progress);
    }
    function startProgress() {
        ensureProgress();
        progress.classList.remove('active');
        // force reflow so the transition restarts
        void progress.offsetWidth;
        progress.classList.add('active');
    }
    function stopProgress() {
        if (!progress) return;
        progress.style.width = '100%';
        progress.classList.remove('active');
        setTimeout(function () {
            if (progress) {
                progress.style.opacity = '0';
                progress.style.width = '0';
            }
        }, 250);
    }

    /* ---------------------------------------------------------------- *
     * Link filtering
     * ---------------------------------------------------------------- */
    function isInternalLink(a) {
        if (!a || !a.getAttribute) return false;
        if (a.target && a.target !== '' && a.target !== '_self') return false;
        if (a.hasAttribute('download')) return false;
        if (a.dataset && a.dataset.noSpa !== undefined) return false;

        var href = a.getAttribute('href');
        if (!href) return false;
        if (href.charAt(0) === '#') return false;                 // in-page anchor
        if (/^(mailto:|tel:|javascript:)/i.test(href)) return false;

        var url;
        try { url = new URL(a.href, window.location.href); }
        catch (e) { return false; }

        if (url.origin !== ORIGIN) return false;                  // external host
        // Admin & auth use a different (AdminLTE) layout — let them load normally
        if (/^\/(admin|login)/.test(url.pathname)) return false;
        // Direct file links (e.g. portfolio image popups)
        if (/\.(jpe?g|png|gif|webp|svg|pdf|zip|docx?|xlsx?)$/i.test(url.pathname)) return false;

        return true;
    }

    /* ---------------------------------------------------------------- *
     * Content swap
     * ---------------------------------------------------------------- */
    function swap(html, url, push) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        var fresh = doc.getElementById(ROOT_ID);
        var current = document.getElementById(ROOT_ID);

        if (!fresh || !current) {
            window.location.href = url;   // fallback to a normal load
            return;
        }

        current.innerHTML = fresh.innerHTML;
        if (doc.title) document.title = doc.title;

        if (push) {
            history.pushState({ spa: true }, '', url);
        }

        window.scrollTo(0, 0);
        afterSwap();
    }

    function afterSwap() {
        // Re-run entrance animations on the new content
        if (window.WOW) {
            try { new WOW({ live: false }).init(); } catch (e) {}
        }
        // Safety net: never leave .wow elements stuck hidden
        requestAnimationFrame(function () {
            var nodes = document.querySelectorAll('#' + ROOT_ID + ' .wow');
            for (var i = 0; i < nodes.length; i++) {
                nodes[i].style.visibility = 'visible';
            }
        });
        bindForms();
    }

    /* ---------------------------------------------------------------- *
     * Navigation
     * ---------------------------------------------------------------- */
    function navigate(url, push) {
        startProgress();
        var main = document.getElementById(ROOT_ID);
        if (main) main.classList.add('spa-leaving');

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(function (res) {
                return res.text().then(function (text) {
                    return { text: text, url: res.url || url };
                });
            })
            .then(function (r) {
                swap(r.text, r.url, push);
            })
            .catch(function () {
                window.location.href = url;   // network error -> hard load
            })
            .finally(function () {
                stopProgress();
                var m = document.getElementById(ROOT_ID);
                if (m) m.classList.remove('spa-leaving');
            });
    }

    // Intercept link clicks (event delegation on document)
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        var a = e.target.closest ? e.target.closest('a') : null;
        if (!isInternalLink(a)) return;

        e.preventDefault();
        if (a.href === window.location.href) return;   // already here

        // close the mobile navbar if it is open
        var nav = document.getElementById('navbarCollapse');
        if (nav && nav.classList.contains('show')) nav.classList.remove('show');

        navigate(a.href, true);
    });

    // Browser back / forward
    window.addEventListener('popstate', function () {
        navigate(window.location.href, false);
    });

    /* ---------------------------------------------------------------- *
     * Forms (contact form) — AJAX submit, no reload
     * ---------------------------------------------------------------- */
    function bindForms() {
        var forms = document.querySelectorAll('#' + ROOT_ID + ' form');
        for (var i = 0; i < forms.length; i++) {
            (function (form) {
                if (form.dataset.spaBound) return;
                if ((form.getAttribute('method') || '').toLowerCase() !== 'post') return;
                form.dataset.spaBound = '1';

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    startProgress();

                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    })
                        .then(function (res) {
                            return res.text().then(function (text) {
                                return { text: text, url: res.url || form.action };
                            });
                        })
                        .then(function (r) {
                            // Response is the redirected page (success flash or
                            // the form re-rendered with validation errors).
                            swap(r.text, r.url, true);
                        })
                        .catch(function () {
                            form.submit();   // fallback to normal submit
                        })
                        .finally(stopProgress);
                });
            })(forms[i]);
        }
    }

    // Bind forms present on first (server-rendered) load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindForms);
    } else {
        bindForms();
    }
})();
