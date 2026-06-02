<aside id="sidebar">
    <a href="{{ route('admin-cabang.dashboard') }}" class="sidebar-brand">
        <i class="bi bi-shop"></i>
        <div>
            BORMA
            <span>Admin Cabang</span>
        </div>
    </a>
    <ul class="sidebar-nav">
        @if(auth()->user()->canAccessMenu('admincabang_dashboard'))
        <li><a href="{{ route('admin-cabang.dashboard') }}" class="{{ request()->routeIs('admin-cabang.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_produk'))
        <li><a href="{{ route('admin-cabang.produk') }}" class="{{ request()->routeIs('admin-cabang.produk*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Manajemen Produk</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_pesanan'))
        <li><a href="{{ route('admin-cabang.pesanan') }}" class="{{ request()->routeIs('admin-cabang.pesanan*') ? 'active' : '' }}"><i class="bi bi-cart3"></i> Daftar Pesanan</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_member'))
        <li><a href="{{ route('admin-cabang.member') }}" class="{{ request()->routeIs('admin-cabang.member*') ? 'active' : '' }}"><i class="bi bi-people"></i> Manajemen Member</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_promo'))
        <li><a href="{{ route('admin-cabang.promo') }}" class="{{ request()->routeIs('admin-cabang.promo*') ? 'active' : '' }}"><i class="bi bi-ticket-perforated"></i> Promo & Voucher</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_laporan'))
        <li><a href="{{ route('admin-cabang.laporan') }}" class="{{ request()->routeIs('admin-cabang.laporan*') ? 'active' : '' }}"><i class="bi bi-bar-chart-fill"></i> Laporan Cabang</a></li>
        @endif
        @if(auth()->user()->canAccessMenu('admincabang_pengaturan'))
        <li><a href="{{ route('admin-cabang.pengaturan') }}" class="{{ request()->routeIs('admin-cabang.pengaturan*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan</a></li>
        @endif
    </ul>
    <div style="padding: 24px; border-top: 1px solid #E5E7EB;" class="sidebar-footer">
        <form action="{{ route('internal.logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" style="background:none; border:none; color: #EF4444; text-decoration: none; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; gap: 12px; transition: all 0.2s; padding:0; width:100%; text-align:left;" onmouseover="this.style.color='#DC2626'" onmouseout="this.style.color='#EF4444'">
                <i class="bi bi-box-arrow-left" style="font-size: 1.2rem;"></i> Log Out
            </button>
        </form>
    </div>
</aside>
