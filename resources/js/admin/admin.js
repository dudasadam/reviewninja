/**
 * ReviewNinja – Admin Panel JS
 */

document.addEventListener('DOMContentLoaded', () => {

    // ─── Sidebar mobile toggle ────────────────────────────────────────────────
    const sidebar  = document.getElementById('rnSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const openBtn  = document.getElementById('sidebarOpen');
    const closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar?.classList.add('open');
        overlay?.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('show');
        document.body.style.overflow = '';
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // ─── Toggle switches ──────────────────────────────────────────────────────
    document.querySelectorAll('.rn-toggle').forEach(t => {
        t.addEventListener('click', () => {
            t.classList.toggle('rn-toggle--on');
        });
    });

    // ─── Chart bar tooltip / hover ────────────────────────────────────────────
    document.querySelectorAll('.rn-chart-bar').forEach(bar => {
        bar.addEventListener('mouseenter', (e) => {
            const tip = document.createElement('div');
            tip.className = 'rn-chart-tooltip';
            tip.textContent = bar.dataset.value + ' értékelés';
            document.body.appendChild(tip);
            const rect = bar.getBoundingClientRect();
            tip.style.left = (rect.left + rect.width / 2 - tip.offsetWidth / 2) + 'px';
            tip.style.top  = (rect.top - 32 + window.scrollY) + 'px';
            bar._tip = tip;
        });
        bar.addEventListener('mouseleave', () => {
            bar._tip?.remove();
        });
    });

    // ─── Range buttons (chart period) ────────────────────────────────────────
    document.querySelectorAll('.rn-chip-btn[data-range]').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.d-flex')?.querySelectorAll('.rn-chip-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // ─── Platform connect modal ───────────────────────────────────────────────
    const connectModal  = document.getElementById('connectModal');
    const modalClose    = document.getElementById('modalClose');
    const modalCancel   = document.getElementById('modalCancel');
    const modalTitle    = document.getElementById('modalTitle');

    document.querySelectorAll('.rn-connect-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const platform = btn.dataset.platform;
            if (modalTitle) modalTitle.textContent = platform + ' csatlakoztatása';
            openModal(connectModal);
        });
    });
    modalClose?.addEventListener('click',  () => closeModal(connectModal));
    modalCancel?.addEventListener('click', () => closeModal(connectModal));

    // ─── Template modal ───────────────────────────────────────────────────────
    const templateModal       = document.getElementById('templateModal');
    const templateModalClose  = document.getElementById('templateModalClose');
    const templateModalCancel = document.getElementById('templateModalCancel');
    const templateModalTitle  = document.getElementById('templateModalTitle');
    const tplBodyEl           = document.getElementById('tplBody');
    const smsPreview          = document.getElementById('smsPreview');
    const newTemplateBtn      = document.getElementById('newTemplateBtn');

    document.querySelectorAll('.rn-edit-template-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (templateModalTitle) templateModalTitle.textContent = 'Sablon: ' + btn.dataset.name;
            openModal(templateModal);
        });
    });

    newTemplateBtn?.addEventListener('click', () => {
        if (templateModalTitle) templateModalTitle.textContent = 'Új sablon létrehozása';
        openModal(templateModal);
    });

    templateModalClose?.addEventListener('click',  () => closeModal(templateModal));
    templateModalCancel?.addEventListener('click', () => closeModal(templateModal));

    // Live SMS preview
    tplBodyEl?.addEventListener('input', () => {
        if (smsPreview) {
            smsPreview.textContent = tplBodyEl.value
                .replace('{{name}}',         'Kovács Péter')
                .replace('{{review_link}}',  'https://g.page/r/...')
                .replace('{{company_name}}', 'ReviewNinja Demo')
                .replace('{{service}}',      'Fogszabályozás');
        }
    });

    // ─── Integration modal ────────────────────────────────────────────────────
    const integrationModal       = document.getElementById('integrationModal');
    const integrationModalClose  = document.getElementById('integrationModalClose');
    const integrationModalCancel = document.getElementById('integrationModalCancel');
    const integrationModalTitle  = document.getElementById('integrationModalTitle');

    document.querySelectorAll('.rn-connect-integration-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (integrationModalTitle) integrationModalTitle.textContent = btn.dataset.name + ' beállítása';
            openModal(integrationModal);
        });
    });
    integrationModalClose?.addEventListener('click',  () => closeModal(integrationModal));
    integrationModalCancel?.addEventListener('click', () => closeModal(integrationModal));

    // ─── Reminder rows ────────────────────────────────────────────────────────
    const addReminderBtn = document.getElementById('addReminder');
    const reminderList   = document.getElementById('reminderList');

    addReminderBtn?.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'rn-reminder-row';
        row.innerHTML = `
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="rn-muted-text">Ha nem reagál:</span>
                <input type="number" class="rn-input" value="14" style="width:70px">
                <select class="rn-input" style="width:auto">
                    <option>nappal később</option>
                    <option>héttel később</option>
                </select>
                <select class="rn-input" style="width:auto">
                    <option>SMS</option>
                    <option>Email</option>
                </select>
                <button class="btn rn-btn-icon rn-btn-danger-icon" onclick="this.closest('.rn-reminder-row').remove()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>`;
        reminderList?.appendChild(row);
    });

    // ─── Webhook copy ─────────────────────────────────────────────────────────
    window.copyWebhook = () => {
        const el = document.getElementById('webhookUrl');
        if (el) {
            navigator.clipboard.writeText(el.value).then(() => {
                const btn = document.querySelector('.rn-copy-btn');
                if (btn) {
                    const orig = btn.innerHTML;
                    btn.textContent = '✓ Másolva';
                    setTimeout(() => { btn.innerHTML = orig; }, 2000);
                }
            });
        }
    };

    // ─── Template var insert ──────────────────────────────────────────────────
    window.insertVar = (v) => {
        const ta = document.getElementById('tplBody');
        if (!ta) return;
        const start = ta.selectionStart;
        const end   = ta.selectionEnd;
        ta.value = ta.value.slice(0, start) + v + ta.value.slice(end);
        ta.selectionStart = ta.selectionEnd = start + v.length;
        ta.focus();
        ta.dispatchEvent(new Event('input'));
    };

    // ─── Logo upload zone ─────────────────────────────────────────────────────
    const logoUpload = document.getElementById('logoUpload');
    logoUpload?.addEventListener('click', () => {
        const inp = document.createElement('input');
        inp.type = 'file';
        inp.accept = 'image/*';
        inp.onchange = (e) => {
            const file = e.target.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = url;
            img.style.cssText = 'max-height:60px; max-width:200px; margin-top:8px; border-radius:6px;';
            logoUpload.innerHTML = '';
            logoUpload.appendChild(img);
            const label = document.createElement('p');
            label.className = 'mt-2 mb-0 rn-muted-text';
            label.textContent = file.name;
            logoUpload.appendChild(label);
        };
        inp.click();
    });

    // ─── Color picker sync ────────────────────────────────────────────────────
    document.querySelectorAll('.rn-color-input').forEach(picker => {
        const text = picker.nextElementSibling;
        picker.addEventListener('input', () => {
            if (text) text.value = picker.value;
        });
        text?.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) {
                picker.value = text.value;
            }
        });
    });

    // ─── Helpers ──────────────────────────────────────────────────────────────
    function openModal(el) {
        if (!el) return;
        el.style.display = 'flex';
        requestAnimationFrame(() => el.classList.add('show'));
    }

    function closeModal(el) {
        if (!el) return;
        el.classList.remove('show');
        setTimeout(() => { el.style.display = 'none'; }, 220);
    }

    // Close modals on overlay click
    document.querySelectorAll('.rn-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay);
        });
    });
});
