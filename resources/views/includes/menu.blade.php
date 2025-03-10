  <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="../../../html/rtl/vertical-menu-template-bordered/index.html"><span class="brand-logo">
                <img src="{{ asset('images/jkr_logo.png') }}" height="30px" width="200px"/>
                        </span>
                    <h2 class="brand-text">JKR</h2>
                </a></li>
            {{-- <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li> --}}
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        @if(!empty(Auth::user()))
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Menu - Menu</span><i data-feather="more-horizontal"></i>
            </li>

            {{-- <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Menu Besar</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Menu Kedua">Menu Kedua</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a class="d-flex align-items-center" href="#" target="_blank">
                                    <span class="menu-item text-truncate" data-i18n="menu kecil">Menu Kecil</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
            @role(['secretariat','superadmin'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">BPSM</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/urussetia/kumpulan/">
                            <i data-feather='users'></i>
                            <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Pengurusan <br/> Kumpulan</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/urussetia/appl/main/">
                            <i data-feather="inbox"></i>
                            <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Pengurusan <br/> Permohonan</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/urussetia/resume/">
                            <i data-feather='file-text'></i>
                                <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Resume</span>
                            </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/urussetia/resume/lampiran/">
                            <i data-feather='link-2'></i>
                                <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Lampiran</span>
                            </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/bpsm/question/">
                            <i data-feather='link-2'></i>
                            <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">LNPK Bank Soalan</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['coordinator','superadmin'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">BPSK</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/hr2/pinkform/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">Surat Pink</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            @role('superadmin')
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Admin</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/admin/pengguna/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Pengurusan <br/> Pengguna</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="d-flex align-items-center" href="/admin/pengguna/mockup1">
                            <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Mockup Perakuan Pegawai</span>
                            </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/admin/pengguna/mockup2">
                            <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Mockup Tapisan Keutuhan</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/admin/pengguna/mockup3">
                            <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="Pengurusan Pengguna">Mockup Butir-Butir Peribadi</span>
                            </a>
                    </li> --}}
                </ul>
            </li>
            @endrole
            @role(['user','superadmin'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Pemangku</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/pemangku/tawaran/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">Tawaran</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Naik Pangkat</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/naikpangkat/ukp13/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">UKP 13</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['clerk','superadmin'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Ketua Bahagian</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/kb/pengesahan-pink/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">Pengesahan</span>
                        </a>
                    </li>
                </ul>
            </li>

            @endrole
            @role(['hod','superadmin'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Ketua Jabatan</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/kj/pengesahan-pink/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">Pengesahan</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['supervisor'])
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Pages">Penyelia</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="/penyelia/lpnk/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Surat Pink">Borang LPNK</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
        </ul>
        @endif
    </div>
</div>
