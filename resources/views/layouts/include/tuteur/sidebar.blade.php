<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('tuteur.dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: red; text-transform: uppercase;">
                CENTRE BOUTA
            </span>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('tuteur.dashboard') ? 'active' : '' }}">
            <a href="{{ route('tuteur.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Emploi du Temps -->
        <li class="menu-item {{ request()->routeIs('emploi.*') ? 'active open' : '' }}">
            <a href="{{ route('tuteur.emplois.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div>Emploi du Temps</div>
            </a>
        </li>

        <!-- Bulletins -->
        <li class="menu-item {{ request()->routeIs('tuteur.bulletin.*') ? 'active open' : '' }}">
            <a href="{{ route('tuteur.bulletin.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div>Bulletins</div>
            </a>
        </li>

        <!-- Frais scolaire -->
        <li class="menu-item {{ request()->routeIs('frais.*') ? 'active open' : '' }}">
            <a href="{{ route('tuteur.frais_scolaire.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div>Frais scolaire</div>
            </a>
        </li>
    </ul>
</aside>