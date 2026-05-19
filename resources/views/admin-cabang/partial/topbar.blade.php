<header id="topbar">
    <div class="cabang-info">
        <span class="badge">Cabang Aktif</span>
        {{ auth()->user()?->adminCabang?->cabang?->nama_cabang ?? 'Antapani' }}
    </div>
    
    <div class="topbar-actions">
        <!-- Notifications Dropdown -->
        <div class="dropdown topbar-dropdown">
            <a href="#" class="icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell-fill"></i>
                <span class="badge-notif"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold" style="font-family: var(--font-heading); color: var(--borma-primary);">Notifikasi</h6>
                    <span class="badge bg-danger rounded-pill">3 Baru</span>
                </div>
                <div style="max-height: 300px; overflow-y: auto;">
                    <a href="{{ route('admin-cabang.pesanan') }}" class="notif-item">
                        <div class="notif-icon bg-warning" style="background: rgba(254, 213, 11, 0.2) !important;"><i class="bi bi-cart-fill text-warning" style="color: #D97706 !important;"></i></div>
                        <div>
                            <div class="text-dark" style="font-weight: 700; font-size: 0.85rem;">Pesanan Baru #BRM-9021</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Budi Santoso - 3 Item</div>
                            <div class="text-muted mt-1" style="font-size: 0.7rem;"><i class="bi bi-clock"></i> 2 menit lalu</div>
                        </div>
                    </a>
                    <a href="{{ route('admin-cabang.pesanan') }}" class="notif-item">
                        <div class="notif-icon bg-success" style="background: #ECFDF5 !important;"><i class="bi bi-truck text-success"></i></div>
                        <div>
                            <div class="text-dark" style="font-weight: 700; font-size: 0.85rem;">Pesanan #BRM-9018 Selesai</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Kurir: Asep telah mengonfirmasi.</div>
                            <div class="text-muted mt-1" style="font-size: 0.7rem;"><i class="bi bi-clock"></i> 1 jam lalu</div>
                        </div>
                    </a>
                    <a href="{{ route('admin-cabang.produk') }}" class="notif-item">
                        <div class="notif-icon bg-danger" style="background: #FEF2F2 !important;"><i class="bi bi-exclamation-triangle-fill text-danger"></i></div>
                        <div>
                            <div class="text-dark" style="font-weight: 700; font-size: 0.85rem;">Stok Menipis</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Minyak Goreng 2L tersisa 5 unit.</div>
                            <div class="text-muted mt-1" style="font-size: 0.7rem;"><i class="bi bi-clock"></i> 2 jam lalu</div>
                        </div>
                    </a>
                </div>
                <div class="p-2 border-top text-center">
                    <a href="{{ route('admin-cabang.notifikasi') }}" class="text-primary-custom" style="font-size: 0.8rem; font-weight: 700; text-decoration: none;">Lihat Semua</a>
                </div>
            </div>
        </div>
        
        <!-- Settings -->
        <a href="{{ route('admin-cabang.pengaturan') }}" class="icon-btn">
            <i class="bi bi-gear-fill"></i>
        </a>

        <div style="width: 1px; height: 32px; background: #E5E7EB; margin: 0 8px;"></div>
        
        <!-- User Profile Dropdown -->
        <div class="dropdown topbar-dropdown">
            <div class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 2)) }}</div>
                <div class="info">
                    <h6>{{ auth()->user()->nama ?? 'Admin' }}</h6>
                    <small>{{ auth()->user()->settings['jabatan'] ?? auth()->user()->role ?? 'Admin Cabang' }}</small>
                </div>
                <i class="bi bi-chevron-down ms-2 text-muted" style="font-size: 0.8rem;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <div class="px-3 py-2 border-bottom mb-2">
                    <p class="m-0" style="font-size: 0.75rem; color: #6B7280;">Login sebagai</p>
                    <p class="m-0 font-weight-bold" style="font-size: 0.85rem; color: var(--borma-neutral);">{{ auth()->user()->email ?? 'admin@borma.co.id' }}</p>
                </div>
                <li><a class="dropdown-item" href="{{ route('admin-cabang.pengaturan') }}"><i class="bi bi-person-circle" style="font-size: 1.1rem;"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('internal.logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger border-0 bg-transparent" style="cursor:pointer;">
                            <i class="bi bi-box-arrow-right" style="font-size: 1.1rem;"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
