@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/stacked-cards.css') }}">
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
    <h2 class="scene-title">Daftar Antrean Pesanan</h2>
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
