@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
  --c-primary: #33116C;
  --c-primary-light: #5B2DA8;
  --c-primary-lighter: #9B7FD4;
  --c-secondary: #FED50B;
  --c-tertiary: #EB3B02;
  --c-neutral: #2B2B2B;
  --c-card-0: #2D1A56;
  --c-card-1: #3A2268;
  --c-card-2: #452A7A;
  --c-card-3: #52328C;
  --font-headline: 'Manrope', sans-serif;
  --font-body: 'Plus Jakarta Sans', sans-serif;
}

.scene {
  padding: 20px 16px 32px;
  font-family: var(--font-body);
  background: transparent;
}

.top-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 28px;
}

.section-label {
  font-family: var(--font-body);
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--color-text-secondary, #888);
}

.order-count {
  font-family: var(--font-body);
  font-size: 12px;
  font-weight: 600;
  color: var(--c-primary-lighter);
  background: rgba(155,127,212,0.12);
  border: 1px solid rgba(155,127,212,0.2);
  padding: 3px 10px;
  border-radius: 100px;
}

.stack-container {
  position: relative;
  height: 310px;
  margin-bottom: 32px;
  perspective: 1000px;
}

.card {
  position: absolute;
  width: 100%;
  border-radius: 22px;
  padding: 20px;
  cursor: pointer;
  user-select: none;
  transform-origin: center bottom;
  transition: transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94), opacity 0.4s ease;
  border: 1px solid rgba(255,255,255,0.08);
}

.card[data-pos="0"] {
  background: var(--c-card-0);
  transform: translateY(0px) scale(1) rotate(0deg);
  z-index: 10;
  box-shadow: 0 16px 48px rgba(51,17,108,0.55), 0 4px 16px rgba(0,0,0,0.3);
}
.card[data-pos="1"] {
  background: var(--c-card-1);
  transform: translateY(18px) scale(0.955) rotate(1.5deg);
  z-index: 9;
  opacity: 0.9;
  box-shadow: 0 8px 24px rgba(51,17,108,0.3);
}
.card[data-pos="2"] {
  background: var(--c-card-2);
  transform: translateY(34px) scale(0.91) rotate(-1.2deg);
  z-index: 8;
  opacity: 0.75;
}
.card[data-pos="3"] {
  background: var(--c-card-3);
  transform: translateY(48px) scale(0.865) rotate(2deg);
  z-index: 7;
  opacity: 0.5;
}

.card.exit-right {
  animation: exitRight 0.46s cubic-bezier(0.4,0,0.2,1) forwards;
  z-index: 20 !important;
}
.card.exit-left {
  animation: exitLeft 0.46s cubic-bezier(0.4,0,0.2,1) forwards;
  z-index: 20 !important;
}
.card.exit-taken {
  animation: exitTaken 0.52s cubic-bezier(0.4,0,0.2,1) forwards;
  z-index: 20 !important;
}

@keyframes exitRight {
  0%  { transform: translateY(0) scale(1) rotate(0deg); opacity: 1; }
  30% { transform: translateY(-18px) scale(1.03) rotate(4deg); opacity: 1; }
  100%{ transform: translateY(-20px) translateX(140%) rotate(18deg); opacity: 0; }
}
@keyframes exitLeft {
  0%  { transform: translateY(0) scale(1) rotate(0deg); opacity: 1; }
  30% { transform: translateY(-14px) scale(1.02) rotate(-4deg); opacity: 1; }
  100%{ transform: translateY(-10px) translateX(-140%) rotate(-18deg); opacity: 0; }
}
@keyframes exitTaken {
  0%  { transform: translateY(0) scale(1); opacity: 1; }
  35% { transform: translateY(-22px) scale(1.04); opacity: 1; }
  100%{ transform: translateY(-200px) scale(0.7); opacity: 0; }
}

.card-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 10px;
}

.task-meta { flex: 1; }

.task-id {
  font-family: var(--font-body);
  font-size: 10px;
  font-weight: 600;
  color: rgba(255,255,255,0.38);
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 3px;
}

.task-title {
  font-family: var(--font-headline);
  font-size: 19px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.01em;
}

.truck-badge {
  width: 42px;
  height: 42px;
  border-radius: 13px;
  background: rgba(254,213,11,0.13);
  border: 1px solid rgba(254,213,11,0.22);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--c-secondary);
  font-size: 19px;
  flex-shrink: 0;
}

.status-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(254,213,11,0.08);
  border: 1px solid rgba(254,213,11,0.22);
  color: var(--c-secondary);
  border-radius: 100px;
  font-family: var(--font-body);
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.07em;
  text-transform: uppercase;
  padding: 4px 11px;
  margin-bottom: 14px;
}

.blink {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--c-secondary);
  animation: blink 1.3s infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }

.info-row {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-body);
  font-size: 12px;
  font-weight: 400;
  color: rgba(255,255,255,0.6);
  margin-bottom: 7px;
}
.info-row i { font-size: 14px; color: rgba(255,255,255,0.28); flex-shrink: 0; }

.sep {
  height: 1px;
  background: rgba(255,255,255,0.07);
  margin: 14px 0;
}

.actions {
  display: flex;
  gap: 10px;
}

.btn-confirm {
  flex: 1;
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.02em;
  background: var(--c-secondary);
  color: #1a1a1a;
  border: none;
  border-radius: 13px;
  padding: 13px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  transition: transform 0.1s, opacity 0.1s;
}
.btn-confirm:active { transform: scale(0.97); opacity: 0.9; }
.btn-confirm:disabled { opacity: 0.7; cursor: not-allowed; }

.btn-reject {
  width: 50px;
  flex-shrink: 0;
  background: rgba(235,59,2,0.12);
  border: 1px solid rgba(235,59,2,0.3);
  color: #FF6B4A;
  border-radius: 13px;
  padding: 13px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  transition: transform 0.1s, background 0.15s;
}
.btn-reject:active { transform: scale(0.97); background: rgba(235,59,2,0.22); }
.btn-reject:disabled { opacity: 0.7; cursor: not-allowed; }

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 260px;
  color: var(--color-text-secondary, #888);
  font-family: var(--font-body);
  font-size: 14px;
  gap: 10px;
}
.empty-state i { font-size: 36px; }

.notif-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.62);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.18s ease;
}
@keyframes fadeIn { from{opacity:0} to{opacity:1} }

.notif-box {
  background: var(--color-background-primary, #fff);
  border-radius: 22px;
  padding: 28px 22px;
  width: 80%;
  max-width: 280px;
  text-align: center;
  animation: popIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
  border: 0.5px solid var(--color-border-tertiary, #e5e5e5);
}
@keyframes popIn { from{transform:scale(0.72);opacity:0} to{transform:scale(1);opacity:1} }

.notif-emoji { font-size: 40px; margin-bottom: 14px; }
.notif-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: var(--color-text-primary, #000);
  margin-bottom: 8px;
}
.notif-msg {
  font-family: var(--font-body);
  font-size: 13px;
  color: var(--color-text-secondary, #666);
  line-height: 1.55;
  margin-bottom: 20px;
}
.notif-btn {
  font-family: var(--font-body);
  font-size: 14px;
  font-weight: 700;
  background: var(--c-primary);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 12px 32px;
  cursor: pointer;
}
</style>
@endpush

@php
    $formattedAntrian = collect($antrianTugas)->map(function($p) {
        return [
            'id' => $p->id_pesanan,
            'location' => 'GUDANG ' . strtoupper($p->cabang?->nama_cabang ?? 'PUSAT'),
            'time' => $p->created_at->format('H:i') . ' WIB',
            'customer' => strtoupper($p->pelanggan?->user?->nama ?? 'PELANGGAN')
        ];
    })->filter(function($item) {
        return !empty($item['id']);
    })->values()->all();
@endphp

<div class="scene">
  <div class="top-row">
    <h2 style="font-family: var(--font-headline); font-size: 20px; font-weight: 800; color: var(--c-primary); margin: 0;">Daftar Antrean Pesanan</h2>
    <span class="order-count" id="orderCount"></span>
  </div>

  <div class="stack-container" id="stackContainer"></div>
</div>

<div id="notifOverlay" style="display:none" class="notif-overlay" onclick="closeNotif()">
  <div class="notif-box" onclick="event.stopPropagation()">
    <div class="notif-emoji" id="nIcon"></div>
    <div class="notif-title" id="nTitle"></div>
    <div class="notif-msg" id="nMsg"></div>
    <button class="notif-btn" onclick="closeNotif()" id="nBtn">OK, Lanjut</button>
  </div>
</div>

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const allOrders = @json($formattedAntrian);
    let rejectedIds = new Set();
    let orders = [...allOrders];
    let busy = false;
    let pollingInterval = null;

    function render() {
        const wrap = document.getElementById('stackContainer');
        const countEl = document.getElementById('orderCount');
        wrap.innerHTML = '';

        countEl.textContent = orders.length + ' pesanan';

        if (orders.length === 0) {
            wrap.innerHTML = `<div class="empty-state"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><span>Semua tugas selesai!</span></div>`;
            return;
        }

        const visible = orders.slice(0, 4);
        for (let i = visible.length - 1; i >= 0; i--) {
            const o = visible[i];
            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.pos = i;
            card.dataset.id = o.id;

            if (i === 0) {
                card.innerHTML = `
                  <div class="card-header">
                    <div class="task-meta">
                      <p class="task-id">ID Tugas: ${o.id}</p>
                      <p class="task-title">Pengiriman Pesanan</p>
                    </div>
                    <div class="truck-badge"><i class="bi bi-truck" aria-hidden="true"></i></div>
                  </div>
                  <div class="status-pill"><span class="blink"></span>Menunggu Konfirmasi</div>
                  <div class="info-row"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i>${o.location}</div>
                  <div class="info-row"><i class="bi bi-clock-fill" aria-hidden="true"></i>Estimasi: ${o.time}</div>
                  <div class="info-row"><i class="bi bi-person-fill" aria-hidden="true"></i>${o.customer}</div>
                  <div class="sep"></div>
                  <div class="actions">
                    <button class="btn-confirm" onclick="doConfirm(event, '${o.id}')" id="btn-confirm-top"><i class="bi bi-check-lg" aria-hidden="true"></i>Konfirmasi</button>
                    <button class="btn-reject" onclick="doReject(event)" aria-label="Tolak"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
                  </div>
                `;
            } else {
                card.innerHTML = `
                  <div class="card-header">
                    <div class="task-meta">
                      <p class="task-id">ID Tugas: ${o.id}</p>
                      <p class="task-title">Pengiriman Pesanan</p>
                    </div>
                  </div>
                  <div class="info-row" style="margin-top:4px"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i>${o.location}</div>
                  <div class="info-row"><i class="bi bi-person-fill" aria-hidden="true"></i>${o.customer}</div>
                `;
            }
            wrap.appendChild(card);
        }
    }

    function dismiss(animClass, cb) {
        if (busy) return;
        busy = true;
        const top = document.querySelector('.card[data-pos="0"]');
        if (!top) { busy = false; return; }
        top.classList.add(animClass);
        setTimeout(() => {
            orders.shift();
            render();
            busy = false;
            if (cb) cb();
        }, 500);
    }

    function doConfirm(e, idPesanan) {
        e.stopPropagation();
        if (busy) return;
        busy = true;

        const btn = document.getElementById('btn-confirm-top');
        if (btn) {
            btn.innerHTML = '<i class="spinner-border spinner-border-sm" aria-hidden="true"></i> Memproses...';
            btn.disabled = true;
        }

        stopPolling();

        fetch(`/driver/pesanan/${idPesanan}/ambil`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                busy = false; 
                dismiss('exit-right', () => {
                    showNotif('✅','Pesanan Diterima!','Kamu sudah mengambil pesanan ini. Selamat mengantarkan!','Mulai Perjalanan', () => {
                        window.location.href = `/driver/tugas/${idPesanan}`;
                    });
                });
            } else {
                busy = false;
                dismiss('exit-taken', () => {
                    showNotif('🚫','Keduluan!','Pesanan ini sudah diambil driver lain duluan. Lanjut ke pesanan berikutnya.','OK, Lanjut', () => {
                        fetchLatestQueue();
                        startPolling();
                    });
                });
            }
        })
        .catch(err => {
            busy = false;
            console.error(err);
            showNotif('⚠️','Error','Terjadi masalah jaringan. Silakan coba lagi.','OK', () => {
                startPolling();
                render();
            });
        });
    }

    function doReject(e) {
        e.stopPropagation();
        if (busy) return;
        
        const topId = orders[0]?.id;
        if (topId) rejectedIds.add(topId);
        
        dismiss('exit-left', () => showNotif('↩️','Pesanan Dilewati','Pesanan dilewati sementara. Pesanan berikutnya siap.','OK, Lanjut'));
    }

    let notifCallback = null;
    function showNotif(icon, title, msg, btn, cb = null) {
        document.getElementById('nIcon').textContent = icon;
        document.getElementById('nTitle').textContent = title;
        document.getElementById('nMsg').textContent = msg;
        document.getElementById('nBtn').textContent = btn;
        document.getElementById('notifOverlay').style.display = 'flex';
        notifCallback = cb;
    }

    function closeNotif() {
        document.getElementById('notifOverlay').style.display = 'none';
        if (notifCallback) {
            notifCallback();
            notifCallback = null;
        }
    }

    function startPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(fetchLatestQueue, 5000);
    }

    function stopPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
    }

    function fetchLatestQueue() {
        if (busy) return;
        
        fetch("{{ route('driver.pesanan.antrian.latest') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!busy && Array.isArray(data)) {
                orders = data.filter(o => !rejectedIds.has(o.id));
                render();
            }
        })
        .catch(err => console.error("Polling error:", err));
    }

    render();
    startPolling();
</script>
@endpush
