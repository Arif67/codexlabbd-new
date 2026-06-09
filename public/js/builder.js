/**
 * BoostBuilder — a custom, dependency-free content builder.
 *
 * Block types: heading, text, image (upload), video (YouTube/Vimeo), row (1-3 columns).
 * - Builds an editable canvas from a JSON model (round-trip editing).
 * - On form submit it writes:
 *      <input name="content_json"> = JSON block model (to rebuild the editor)
 *      <textarea name="description"> = rendered Bootstrap HTML (for the public site)
 */
(function (window, document) {
    "use strict";

    var COL_CLASS = { 1: 'col-12', 2: 'col-md-6', 3: 'col-md-4' };

    function el(tag, cls, html) {
        var n = document.createElement(tag);
        if (cls) n.className = cls;
        if (html != null) n.innerHTML = html;
        return n;
    }

    function youtubeEmbed(url) {
        if (!url) return '';
        var yt = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/))([\w-]{11})/);
        if (yt) return 'https://www.youtube.com/embed/' + yt[1];
        var vm = url.match(/vimeo\.com\/(\d+)/);
        if (vm) return 'https://player.vimeo.com/video/' + vm[1];
        return url; // assume already an embed URL
    }

    function escapeAttr(s) {
        return String(s || '').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    /* =====================================================================
       Block element factory (canvas DOM)
       ===================================================================== */
    function Builder(root) {
        this.root = root;
        this.uploadUrl = root.dataset.uploadUrl;
        this.csrf = root.dataset.csrf;
        this.canvas = root.querySelector('.cb-canvas');
        this.build();
        this.wireToolbar();
    }

    Builder.prototype.build = function () {
        var data = [];
        try { data = JSON.parse(this.root.dataset.initial || '[]') || []; } catch (e) { data = []; }
        var self = this;
        data.forEach(function (m) { self.canvas.appendChild(self.makeBlock(m)); });
    };

    /* ---- block toolbar (move/delete) ---- */
    Builder.prototype.blockHead = function (label, type) {
        var head = el('div', 'cb-block-head');
        head.appendChild(el('span', null, label));
        var tools = el('div', 'cb-block-tools');
        var up = el('button', null, '↑');   up.type = 'button'; up.dataset.act = 'up';   up.title = 'Move up';
        var dn = el('button', null, '↓');   dn.type = 'button'; dn.dataset.act = 'down'; dn.title = 'Move down';
        var del = el('button', 'cb-del', '✕'); del.type = 'button'; del.dataset.act = 'del'; del.title = 'Delete';
        tools.appendChild(up); tools.appendChild(dn);
        if (type === 'video' || type === 'image') {
            var ed = el('button', null, '✎'); ed.type = 'button'; ed.dataset.act = 'edit'; ed.title = 'Change';
            tools.appendChild(ed);
        }
        tools.appendChild(del);
        head.appendChild(tools);
        return head;
    };

    Builder.prototype.makeBlock = function (m) {
        m = m || {};
        switch (m.type) {
            case 'heading': return this.headingBlock(m);
            case 'text':    return this.textBlock(m);
            case 'image':   return this.imageBlock(m);
            case 'video':   return this.videoBlock(m);
            case 'row':     return this.rowBlock(m);
            default:        return this.textBlock(m);
        }
    };

    Builder.prototype.headingBlock = function (m) {
        var b = el('div', 'cb-block'); b.dataset.type = 'heading';
        b.appendChild(this.blockHead('Heading'));
        var body = el('div', 'cb-block-body');
        var h = el('div', 'cb-heading-el'); h.contentEditable = 'true';
        h.innerHTML = m.text || 'Section heading';
        body.appendChild(h);
        b.appendChild(body);
        return b;
    };

    Builder.prototype.textBlock = function (m) {
        var b = el('div', 'cb-block'); b.dataset.type = 'text';
        b.appendChild(this.blockHead('Text'));
        var body = el('div', 'cb-block-body');
        // inline format toolbar
        var fmt = el('div', 'cb-format');
        [['B', 'bold'], ['I', 'italic'], ['U', 'underline'], ['•', 'insertUnorderedList'], ['🔗', 'createLink']].forEach(function (p) {
            var btn = el('button', null, p[0]); btn.type = 'button';
            btn.addEventListener('mousedown', function (e) {
                e.preventDefault();
                if (p[1] === 'createLink') {
                    var url = prompt('Link URL:', 'https://');
                    if (url) document.execCommand('createLink', false, url);
                } else {
                    document.execCommand(p[1], false, null);
                }
            });
            fmt.appendChild(btn);
        });
        var t = el('div', 'cb-text-el'); t.contentEditable = 'true';
        t.innerHTML = m.html || 'Write your text here…';
        body.appendChild(fmt); body.appendChild(t);
        b.appendChild(body);
        return b;
    };

    Builder.prototype.imageBlock = function (m) {
        var b = el('div', 'cb-block'); b.dataset.type = 'image';
        b.appendChild(this.blockHead('Image', 'image'));
        var body = el('div', 'cb-block-body');
        if (m.url) {
            var img = el('img', 'cb-img-el'); img.src = m.url; img.alt = m.alt || '';
            body.appendChild(img);
        } else {
            body.appendChild(this.imagePlaceholder());
        }
        b.appendChild(body);
        return b;
    };

    Builder.prototype.imagePlaceholder = function () {
        var ph = el('div', 'cb-img-placeholder', '🖼 Click to upload an image');
        var self = this;
        ph.addEventListener('click', function () { self.pickImage(ph); });
        return ph;
    };

    Builder.prototype.pickImage = function (placeholder) {
        var self = this;
        var input = document.createElement('input');
        input.type = 'file'; input.accept = 'image/*';
        input.addEventListener('change', function () {
            if (!input.files || !input.files[0]) return;
            var fd = new FormData();
            fd.append('image', input.files[0]);
            fd.append('_token', self.csrf);
            placeholder.textContent = 'Uploading…';
            fetch(self.uploadUrl, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    if (!d.url) throw new Error('no url');
                    var img = el('img', 'cb-img-el'); img.src = d.url; img.alt = '';
                    placeholder.replaceWith(img);
                })
                .catch(function () {
                    placeholder.textContent = '⚠ Upload failed — click to retry';
                });
        });
        input.click();
    };

    Builder.prototype.videoBlock = function (m) {
        var b = el('div', 'cb-block'); b.dataset.type = 'video';
        b.appendChild(this.blockHead('Video', 'video'));
        var body = el('div', 'cb-block-body');
        var ifr = el('iframe', 'cb-video-el');
        ifr.src = m.embed || '';
        ifr.setAttribute('allowfullscreen', '');
        ifr.setAttribute('frameborder', '0');
        body.appendChild(ifr);
        b.appendChild(body);
        return b;
    };

    Builder.prototype.rowBlock = function (m) {
        var cols = m.cols && m.cols.length ? m.cols.length : (m.colCount || 2);
        var b = el('div', 'cb-block'); b.dataset.type = 'row'; b.dataset.cols = cols;
        b.appendChild(this.blockHead('Row · ' + cols + ' column' + (cols > 1 ? 's' : '')));
        var body = el('div', 'cb-block-body');
        var rowEl = el('div', 'cb-row');
        for (var i = 0; i < cols; i++) {
            rowEl.appendChild(this.makeColumn((m.cols && m.cols[i]) || []));
        }
        body.appendChild(rowEl);
        b.appendChild(body);
        return b;
    };

    Builder.prototype.makeColumn = function (blocks) {
        var self = this;
        var col = el('div', 'cb-col');
        var head = el('div', 'cb-col-head');
        [['+ Text', 'text'], ['+ Heading', 'heading'], ['+ Image', 'image'], ['+ Video', 'video']].forEach(function (p) {
            var btn = el('button', 'cb-mini', p[0]); btn.type = 'button';
            btn.addEventListener('click', function () { self.addInto(colBody, p[1]); });
            head.appendChild(btn);
        });
        var colBody = el('div', 'cb-col-body');
        (blocks || []).forEach(function (mb) { colBody.appendChild(self.makeBlock(mb)); });
        col.appendChild(head); col.appendChild(colBody);
        return col;
    };

    /* =====================================================================
       Adding blocks / interactions
       ===================================================================== */
    Builder.prototype.addInto = function (container, type) {
        if (type === 'video') {
            var url = prompt('Paste a YouTube or Vimeo URL:');
            if (!url) return;
            container.appendChild(this.makeBlock({ type: 'video', embed: youtubeEmbed(url) }));
            return;
        }
        var block = this.makeBlock({ type: type });
        container.appendChild(block);
        if (type === 'image') {
            var ph = block.querySelector('.cb-img-placeholder');
            if (ph) this.pickImage(ph);
        }
    };

    Builder.prototype.addRow = function (cols) {
        this.canvas.appendChild(this.makeBlock({ type: 'row', colCount: cols, cols: makeEmptyCols(cols) }));
    };

    function makeEmptyCols(n) { var a = []; for (var i = 0; i < n; i++) a.push([]); return a; }

    Builder.prototype.wireToolbar = function () {
        var self = this;
        this.root.querySelectorAll('[data-add]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var type = btn.dataset.add;
                if (type === 'row1') return self.addRow(1);
                if (type === 'row2') return self.addRow(2);
                if (type === 'row3') return self.addRow(3);
                self.addInto(self.canvas, type);
            });
        });

        // Delegated block tools (move/delete/edit)
        this.root.addEventListener('click', function (e) {
            var btn = e.target.closest ? e.target.closest('.cb-block-tools button') : null;
            if (!btn) return;
            var block = btn.closest('.cb-block');
            var act = btn.dataset.act;
            if (act === 'del') { block.remove(); }
            else if (act === 'up') { var p = block.previousElementSibling; if (p) block.parentNode.insertBefore(block, p); }
            else if (act === 'down') { var n = block.nextElementSibling; if (n) block.parentNode.insertBefore(n, block); }
            else if (act === 'edit') {
                if (block.dataset.type === 'video') {
                    var url = prompt('New video URL:');
                    if (url) block.querySelector('.cb-video-el').src = youtubeEmbed(url);
                } else if (block.dataset.type === 'image') {
                    var body = block.querySelector('.cb-block-body');
                    var ph = self.imagePlaceholder();
                    body.innerHTML = ''; body.appendChild(ph);
                    self.pickImage(ph);
                }
            }
        });
    };

    /* =====================================================================
       Serialize  (DOM -> model)  &  Render (model -> Bootstrap HTML)
       ===================================================================== */
    function serializeContainer(container) {
        var out = [];
        container.querySelectorAll(':scope > .cb-block').forEach(function (b) {
            var t = b.dataset.type;
            if (t === 'heading') {
                out.push({ type: 'heading', text: b.querySelector('.cb-heading-el').innerHTML.trim() });
            } else if (t === 'text') {
                out.push({ type: 'text', html: b.querySelector('.cb-text-el').innerHTML.trim() });
            } else if (t === 'image') {
                var img = b.querySelector('.cb-img-el');
                if (img && img.src) out.push({ type: 'image', url: img.src, alt: img.alt || '' });
            } else if (t === 'video') {
                var ifr = b.querySelector('.cb-video-el');
                if (ifr && ifr.src) out.push({ type: 'video', embed: ifr.src });
            } else if (t === 'row') {
                var cols = [];
                b.querySelectorAll(':scope .cb-row > .cb-col > .cb-col-body').forEach(function (cbody) {
                    cols.push(serializeContainer(cbody));
                });
                out.push({ type: 'row', cols: cols });
            }
        });
        return out;
    }

    function renderModel(model) {
        return (model || []).map(function (m) {
            if (m.type === 'heading') return '<h3 class="mb-3 mt-2">' + (m.text || '') + '</h3>';
            if (m.type === 'text')    return '<div class="mb-4">' + (m.html || '') + '</div>';
            if (m.type === 'image')   return '<figure class="mb-4"><img src="' + escapeAttr(m.url) + '" alt="' + escapeAttr(m.alt) + '" class="img-fluid rounded w-100"></figure>';
            if (m.type === 'video')   return '<div class="ratio ratio-16x9 mb-4"><iframe src="' + escapeAttr(m.embed) + '" frameborder="0" allowfullscreen></iframe></div>';
            if (m.type === 'row') {
                var n = m.cols.length || 1;
                var cls = COL_CLASS[n] || 'col';
                var inner = m.cols.map(function (c) { return '<div class="' + cls + '">' + renderModel(c) + '</div>'; }).join('');
                return '<div class="row g-4 mb-4">' + inner + '</div>';
            }
            return '';
        }).join('\n');
    }

    /* =====================================================================
       Public init + form hook
       ===================================================================== */
    window.BoostBuilder = {
        init: function (selector) {
            var root = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (!root) return null;
            var builder = new Builder(root);

            var form = root.closest('form');
            var jsonField = form.querySelector('[name="content_json"]');
            var htmlField = form.querySelector('[name="description"]');

            form.addEventListener('submit', function () {
                var model = serializeContainer(builder.canvas);
                if (jsonField) jsonField.value = JSON.stringify(model);
                if (htmlField) htmlField.value = renderModel(model);
            });

            return builder;
        }
    };
})(window, document);
