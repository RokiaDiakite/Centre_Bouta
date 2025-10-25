<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
                <a href="{{ route('maitre.dashboard') }}" class="app-brand-link">
                        <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: red; text-transform: uppercase;">
                                CENTRE BOUTA
                        </span>
                </a>
        </div>


        <ul class="menu-inner py-1">

                <li class="menu-item {{ request()->routeIs('maitre.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('maitre.dashboard') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                <div data-i18n="Analytics">Dashboard</div>
                        </a>
                </li>

                <li class="menu-item {{ request()->routeIs('maitre.emploi.*') ? 'active' : '' }}">
                        <a href="{{ route('maitre.emploi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-time-five"></i>
                                <div data-i18n="Fluid">Emploi du Temps</div>
                        </a>
                </li>


                <li class="menu-item {{ request()->routeIs('maitre.paiement.*') ? 'active' : '' }}">
                        <a href="{{ route('maitre.paiement.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-book"></i>
                                <div data-i18n="Basic">Paiements des maitres</div>
                        </a>
                </li>
        </ul>


</aside>