<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- SVG Logo ici -->
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: red; text-transform: uppercase;">
                CENTRE BOUTA
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('tuteur.dashboard') ? 'active' : '' }}">
            <a href="{{ route('tuteur.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Gestion pédagogique -->
        <li class="menu-item {{ request()->routeIs('emploi.*') ? 'active open' : '' }}">
           
            <ul class="menu-sub">
                
                <li class="menu-item {{ request()->routeIs('emploi.*') ? 'active' : '' }}">
                    <a href="{{route('emploi.index')}}" class="menu-link">
                        <div data-i18n="Fluid">Emploi du Temps</div>
                    </a>
                </li>
                
            </ul>
        </li>

        <!-- Gestion élèves -->
        <li class="menu-item {{ request()->routeIs('eleve.*','note.*','bulletin.*') ? 'active open' : '' }}">
            
            <ul class="menu-sub">
                
                <li class="menu-item {{ request()->routeIs('admin.bulletin.*') ? 'active' : '' }}">
                    <a href="{{ route('bulletin.select') }}" class="menu-link">
                        <div data-i18n="Connections">Bulletins</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Comptabilité -->
        <li class="menu-item {{ request()->routeIs('frais.*') ? 'active open' : '' }}">
            
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('frais.*') ? 'active' : '' }}">
                    <a href="{{ route('frais.index') }}" class="menu-link">
                        <div data-i18n="Basic">Frais scolaire</div>
                    </a>
                </li>
            </ul>
        </li>



    </ul>
</aside>