<div class="span3">
    <div class="sidebar">
        <ul class="widget widget-menu unstyled">
            <li>
                <a href="{{ URL::route('home') }}">
                    <i class="menu-icon icon-home"></i>HALAMAN UTAMA
                </a>
            </li>
            <li>
                <a href="{{ URL::route('student-registration') }}">
                    <i class="menu-icon icon-plus"></i>REGISTRASI MURID
                </a>
            </li>
            <li>
                <a href="{{ URL::route('students-for-approval') }}">
                    <i class="menu-icon icon-filter"></i>MURID YANG BELUM DISETUJUI
                </a>
            </li>
            <li>
                <a href="{{ URL::route('registered-students') }}">
                    <i class="menu-icon icon-group"></i>MURID YANG SUDAH DISETUJUI
                </a>
            </li>
            <li>
                <a href="{{ URL::route('all-books') }}">
                    <i class="menu-icon icon-th-list"></i>DAFTAR BUKU
                </a>
            </li>
            <li>
                <a href="{{ URL::route('add-book-category') }}">
                    <i class="menu-icon icon-folder-open-alt"></i>KATEGORI BUKU
                </a>
            </li>
            <li>
                <a href="{{ URL::route('add-books') }}">
                    <i class="menu-icon icon-folder-open-alt"></i>TAMBAH BUKU
                </a>
            </li>
            <li>
                <a href="{{ URL::route('settings') }}">
                    <i class="menu-icon icon-cog"></i>KELAS
                </a>
            </li>

            <li>
                <a href="{{ URL::route('issue-return') }}">
                    <i class="menu-icon icon-signout"></i>PINJAM / KEMBALIKAN BUKU
                </a>
            </li>
            <li>
                <a href="{{ URL::route('currently-issued') }}">
                    <i class="menu-icon icon-list-ul"></i>BUKU YANG SEDANG DIPINJAM
                </a>
            </li>
            <li>
                <a href="{{ URL::route('laporan-total') }}">
                    <i class="menu-icon fas fa-book-reader"></i> LAPORAN TOTAL
                </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li><a href="{{ URL::route('account-sign-out') }}"><i class="menu-icon icon-wrench"></i>LOGOUT </a></li>
        </ul>
    </div>
</div>