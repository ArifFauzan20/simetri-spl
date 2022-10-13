<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header d-flex flex-column justify-content-center align-items-center">
            <img src="/assets/images/logo-simetri.png" alt="logo-simetri" srcset="" class="w-25 mb-2">
            <span class="fs-4 text-dark">SPl</span>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">

                @if (Auth()->user()->role_id == 1)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'superadmin'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>

                        </a>
                    </li>
                    <li class='sidebar-title'>Setting</li>
                    <li
                        class="sidebar-item {{ request()->route()->getName() == 'superadmin.poin-lembur'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Poin Lembur</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-item  has-sub {{ request()->route()->getName() == 'superadmin.users'? 'active': '' }}">
                        <a href="#" class='sidebar-link'>
                            <i data-feather="users" width="20"></i>
                            <span>Pengguna</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="/superadmin/users">Data Pengguna</a>
                                <a href="/superadmin/divisions">Data Divisi</a>
                                <a href="/superadmin/employee">Data Karyawan</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth()->user()->role_id == 2)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'supervisor'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>

                        </a>
                    </li>
                    <li
                        class="sidebar-item has-sub {{ request()->route()->getName() == 'supervisor.data-pengajuan'? 'active': '' }}">
                        <a href="#" class='sidebar-link'>
                            <i data-feather="folder" width="20"></i>
                            <span>Pengajuan Lembur</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="/supervisor/data-pengajuan">Data Pengajuan</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth()->user()->role_id == 3)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'headproduction'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>

                        </a>
                    </li>
                    <li
                        class="sidebar-item has-sub {{ request()->route()->getName() == 'supervisor.data-pengajuan'? 'active': '' }}">
                        <a href="#" class='sidebar-link'>
                            <i data-feather="folder" width="20"></i>
                            <span>Pengajuan Lembur</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="/head-production/data-pengajuan">Data Pengajuan</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth()->user()->role_id == 4)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'headproduction'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>

                        </a>
                    </li>
                    <li
                        class="sidebar-item has-sub {{ request()->route()->getName() == 'supervisor.data-pengajuan'? 'active': '' }}">
                        <a href="#" class='sidebar-link'>
                            <i data-feather="folder" width="20"></i>
                            <span>Pengajuan Lembur</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="/finance/data-pengajuan">Data Pengajuan</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth()->user()->role->role_user == 5)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'adminwo'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-item {{ request()->route()->getName() == 'adminwo.data-pengajuan'? 'active': '' }}">
                        <a href="/admin-worker-officer/data-pengajuan"class='sidebar-link'>
                            <i data-feather="folder" width="20"></i>
                            <span>Data Pengajuan</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-item {{ request()->route()->getName() == 'adminwo.upload-signature'? 'active': '' }}">
                        <a href="{{ route('adminwo.upload-signature') }}"class='sidebar-link'>
                            <i class="bi bi-vector-pen" width="20"></i>
                            <span>Data Tanda Tangan</span>
                        </a>
                    </li>
                    <li class='sidebar-title'>Labour</li>
                    <li
                        class="sidebar-item {{ request()->route()->getName() == 'adminwo.data-labour'? 'active': '' }}">
                        <a href="/admin-worker-officer/data-labour" class='sidebar-link'>
                            <i data-feather="users" width="20"></i>
                            <span>Data Labour</span>

                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'adminwo.uang-makan'? 'active': '' }}">
                        <a href="/admin-worker-officer/uang-makan" class='sidebar-link'>
                            <i data-feather="dollar-sign" width="20"></i>
                            <span>Uang Makan</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-item {{ request()->route()->getName() == 'adminwo.data-bagian'? 'active': '' }}">
                        <a href="{{ route('adminwo.data-bagian') }}" class='sidebar-link'>
                            <i data-feather="layers" width="20"></i>
                            <span>Data Bagian</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'adminwo.data-akun'? 'active': '' }}">
                        <a href="{{ route('adminwo.data-akun') }}" class='sidebar-link'>
                            <i data-feather="unlock" width="20"></i>
                            <span>Data Akun</span>
                        </a>
                    </li>
                @endif
                @if (Auth()->user()->role_id == 6)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'koordinator'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-item  has-sub {{ request()->route()->getName() == 'koordinator.data-pengajuan' ||request()->route()->getName() == 'koordinator.buat-pengajuan-lembur'? 'active': '' }}">
                        <a href="#" class='sidebar-link'>
                            <i data-feather="book" width="20"></i>
                            <span>Pengajuan Lembur</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="/koordinator/data-pengajuan">Data Pengajuan</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth()->user()->role_id == 7)
                    <li class='sidebar-title'>Menu Utama</li>
                    <li class="sidebar-item {{ request()->route()->getName() == 'labour'? 'active': '' }}">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
