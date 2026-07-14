document.addEventListener('DOMContentLoaded', function () {

    /* ================================================================
       CART DRAWER
    ================================================================ */
    var overlay     = document.getElementById('cartDrawerOverlay');
    var panel       = document.getElementById('cartDrawerPanel');
    var drawerBody  = document.getElementById('cartDrawerBody');
    var badge       = document.getElementById('cartBadge');
    var totalAmount = document.getElementById('cartDrawerTotalAmount');
    var totalRow    = document.getElementById('cartDrawerTotalRow');

    function openDrawer() {
        if (overlay) overlay.classList.add('open');
    }

    function closeDrawer() {
        if (overlay) overlay.classList.remove('open');
    }

    if (overlay) {
        document.querySelectorAll('.js-open-cart').forEach(function (el) {
            el.addEventListener('click', function (e) { e.preventDefault(); openDrawer(); });
        });
        document.querySelectorAll('.js-close-cart').forEach(function (el) {
            el.addEventListener('click', function (e) { e.preventDefault(); closeDrawer(); });
        });
        overlay.addEventListener('click', function (e) { if (e.target === overlay) closeDrawer(); });
        if (panel) panel.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    function updateBadge(count) {
        if (!badge) return;
        badge.textContent = count;
        badge.classList.remove('bump');
        void badge.offsetWidth;
        badge.classList.add('bump');
    }

    function updateTotal(total, count) {
        if (totalAmount) totalAmount.textContent = total;
        if (totalRow) totalRow.style.display = count > 0 ? '' : 'none';
    }

    function submitCartForm(form, onSuccess) {
        fetch(form.getAttribute('action'), {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form),
        })
        .then(function (r) { if (!r.ok) throw new Error('failed'); return r.json(); })
        .then(function (data) {
            if (drawerBody) { drawerBody.innerHTML = data.html; bindDrawerForms(); }
            updateBadge(data.count);
            updateTotal(data.total, data.count);
            if (onSuccess) onSuccess(data);
        })
        .catch(function () { form.submit(); });
    }

    function bindDrawerForms() {
        if (!drawerBody) return;
        drawerBody.querySelectorAll('form.js-cart-form').forEach(function (form) {
            form.addEventListener('submit', function (e) { e.preventDefault(); submitCartForm(form); });
        });
    }

    document.querySelectorAll('form.js-add-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            submitCartForm(form, function () { openDrawer(); });
        });
    });

    bindDrawerForms();


    /* ================================================================
       SPICE SLIDER
    ================================================================ */
    var SPICE_COLORS = ['#43A047', '#FDD835', '#FB8C00', '#E53935'];

    function buildSpiceSlider(group) {
        var levels  = group.choices;
        var n       = levels.length;
        var current = Math.floor(n / 2) - (n % 2 === 0 ? 1 : 0);

        var container = document.createElement('div');
        container.className = 'spice-widget';

        var hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = 'options[' + group.name + ']';
        hidden.value = levels[current];
        container.appendChild(hidden);

        var bar = document.createElement('div');
        bar.className = 'spice-bar';

        var minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.className = 'spice-end-btn';
        minusBtn.innerHTML = '<span class="spice-circle">−</span><span>' + levels[0] + '</span>';

        var track = document.createElement('div');
        track.className = 'spice-track';
        var thumb = document.createElement('div');
        thumb.className = 'spice-thumb';
        thumb.textContent = '🌶️';
        track.appendChild(thumb);

        var plusBtn = document.createElement('button');
        plusBtn.type = 'button';
        plusBtn.className = 'spice-end-btn';
        plusBtn.innerHTML = '<span>' + levels[n - 1] + '</span><span class="spice-circle">+</span>';

        bar.appendChild(minusBtn);
        bar.appendChild(track);
        bar.appendChild(plusBtn);
        container.appendChild(bar);

        var lbl = document.createElement('div');
        lbl.className = 'spice-level-label';
        container.appendChild(lbl);

        function setLevel(idx) {
            idx = Math.max(0, Math.min(n - 1, idx));
            current = idx;
            var pct = n > 1 ? (idx / (n - 1)) * 100 : 50;
            thumb.style.left        = pct + '%';
            thumb.style.borderColor = SPICE_COLORS[idx] || '#FB8C00';
            hidden.value            = levels[idx];
            lbl.textContent         = levels[idx];
        }

        setLevel(current);
        minusBtn.addEventListener('click', function () { setLevel(current - 1); });
        plusBtn.addEventListener('click',  function () { setLevel(current + 1); });
        track.addEventListener('click', function (e) {
            var rect = track.getBoundingClientRect();
            setLevel(Math.round(((e.clientX - rect.left) / rect.width) * (n - 1)));
        });

        return container;
    }


    /* ================================================================
       OPTIONS MODAL
    ================================================================ */
    var optModal        = document.getElementById('optionsModal');
    var optTitle        = document.getElementById('optionsModalTitle');
    var optClose        = document.getElementById('optionsModalClose');
    var optForm         = document.getElementById('optionsModalForm');
    var optProductId    = document.getElementById('optionsModalProductId');
    var optGroups       = document.getElementById('optionsModalGroups');
    var optPriceDisplay = document.getElementById('optionsModalPrice');

    if (!optModal) return;

    // ---- price display helpers ----
    var _basePrice  = 0;
    var _modalConfig = [];

    function calcModalSurcharge() {
        var extra = 0;
        _modalConfig.forEach(function (group) {
            if (!group.surcharge || group.surcharge <= 0) return;
            var noneVal = group.none_value || null;
            var radios = optForm.querySelectorAll('input[name="options[' + group.name + ']"]');
            radios.forEach(function (r) {
                if (r.checked && r.value !== noneVal) extra += group.surcharge;
            });
        });
        return extra;
    }

    function refreshModalPrice() {
        if (!optPriceDisplay) return;
        var surcharge = calcModalSurcharge();
        var total     = _basePrice + surcharge;
        var html      = total.toFixed(2) + '<span class="dt">DT</span>';
        if (surcharge > 0) {
            html += '<span class="surcharge-badge">+' + surcharge.toFixed(2) + ' DT</span>';
        }
        optPriceDisplay.innerHTML = html;
        // Update submit button label too
        var submitBtn = optForm.querySelector('.options-modal-submit');
        if (submitBtn) {
            submitBtn.textContent = 'Ajouter · ' + total.toFixed(2) + ' DT';
        }
    }

    // ---- open / close ----
    function openOptionsModal(btn) {
        var productId   = btn.dataset.productId;
        var productName = btn.dataset.productName;
        _basePrice      = parseFloat(btn.dataset.productPrice || 0);
        var cartUrl     = btn.dataset.cartUrl;
        _modalConfig    = JSON.parse(btn.dataset.options || '[]');

        optTitle.textContent = productName;
        optForm.setAttribute('action', cartUrl);
        optProductId.value = productId;

        var hasSurcharge = _modalConfig.some(function (g) { return g.surcharge && g.surcharge > 0; });
        if (optPriceDisplay) optPriceDisplay.style.display = hasSurcharge ? '' : 'none';

        optGroups.innerHTML = '';
        _modalConfig.forEach(function (group) {
            var fieldset = document.createElement('fieldset');
            fieldset.className = 'options-group';

            var legend = document.createElement('legend');
            legend.textContent = group.name
                + (group.surcharge && group.surcharge > 0 ? '  (+' + group.surcharge.toFixed(2) + ' DT)' : '');
            fieldset.appendChild(legend);

            if (group.name.toLowerCase().includes('piquant')) {
                fieldset.appendChild(buildSpiceSlider(group));
            } else {
                group.choices.forEach(function (choice, ci) {
                    var label = document.createElement('label');
                    label.className = 'options-choice';

                    var radio = document.createElement('input');
                    radio.type  = 'radio';
                    radio.name  = 'options[' + group.name + ']';
                    radio.value = choice;
                    if (ci === 0) radio.checked = true;

                    // Update price display on change
                    radio.addEventListener('change', refreshModalPrice);

                    label.appendChild(radio);
                    label.appendChild(document.createTextNode(choice));

                    // Show surcharge hint on non-none choices
                    var noneVal = group.none_value || null;
                    if (group.surcharge && group.surcharge > 0 && choice !== noneVal) {
                        var hint = document.createElement('span');
                        hint.style.cssText = 'margin-left:auto;font-size:11px;color:var(--accent);font-weight:600;';
                        hint.textContent   = '+' + group.surcharge.toFixed(2) + ' DT';
                        label.appendChild(hint);
                    }

                    fieldset.appendChild(label);
                });
            }

            optGroups.appendChild(fieldset);
        });

        refreshModalPrice();
        optModal.classList.add('open');
    }

    function closeOptionsModal() {
        optModal.classList.remove('open');
    }

    document.querySelectorAll('.js-options-btn').forEach(function (btn) {
        btn.addEventListener('click', function () { openOptionsModal(btn); });
    });

    optClose.addEventListener('click', closeOptionsModal);
    optModal.addEventListener('click', function (e) { if (e.target === optModal) closeOptionsModal(); });

    optForm.addEventListener('submit', function (e) {
        e.preventDefault();
        submitCartForm(optForm, function () { closeOptionsModal(); openDrawer(); });
    });
});
