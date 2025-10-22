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
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                <div data-i18n="Analytics">Dashboard</div>
                        </a>
                </li>

                <!-- Gestion pédagogique -->
                <li class="menu-item {{ request()->routeIs('annee.*','classe.*','matiere.*','emploi.*','evaluation.*','maitre.*','inscription.*','tuteur.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-layout"></i>
                                <div data-i18n="Layouts">Gestion Pedagogique</div>
                        </a>
                        <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('annee.*') ? 'active' : '' }}">
                                        <a href="{{route('annee.index')}}" class="menu-link">
                                                <div data-i18n="Without menu">Année scolaire</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('classe.*') ? 'active' : '' }}">
                                        <a href="{{route('classe.index')}}" class="menu-link">
                                                <div data-i18n="Without navbar">Classe</div>
                                        </a>
                                </li>

                                <li class="menu-item {{ request()->routeIs('evaluation.*') ? 'active' : '' }}">
                                        <a href="{{route('evaluation.index')}}" class="menu-link">
                                                <div data-i18n="Without navbar">Evaluation</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('matiere.*') ? 'active' : '' }}">
                                        <a href="{{route('matiere.index')}}" class="menu-link">
                                                <div data-i18n="Container">Matière</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('maitre.*') ? 'active' : '' }}">
                                        <a href="{{route('maitre.index')}}" class="menu-link">
                                                <div data-i18n="Blank">Maitre</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('emploi.*') ? 'active' : '' }}">
                                        <a href="{{route('emploi.index')}}" class="menu-link">
                                                <div data-i18n="Fluid">Emploi du Temps</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('inscription.*') ? 'active' : '' }}">
                                        <a href="{{route('inscription.index')}}" class="menu-link">
                                                <div data-i18n="Blank">Inscription</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('tuteur.*') ? 'active' : '' }}">
                                        <a href="{{route('tuteur.index')}}" class="menu-link">
                                                <div data-i18n="Blank">Tuteur</div>
                                        </a>
                                </li>
                        </ul>
                </li>

                <!-- Gestion élèves -->
                <li class="menu-item {{ request()->routeIs('eleve.*','note.*','bulletin.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                                <div data-i18n="Account Settings">Gestion élèves</div>
                        </a>
                        <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('eleve.*') ? 'active' : '' }}">
                                        <a href="{{ route('eleve.index') }}" class="menu-link">
                                                <div data-i18n="Account">Elèves</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('note.*') ? 'active' : '' }}">
                                        <a href="{{ route('note.index') }}" class="menu-link">
                                                <div data-i18n="Notifications">Notes</div>
                                        </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.bulletin.*') ? 'active' : '' }}">
                                        <a href="{{ route('bulletin.select') }}" class="menu-link">
                                                <div data-i18n="Connections">Bulletins</div>
                                        </a>
                                </li>

                        </ul>
                </li>

                <!-- Comptabilité -->
                <li class="menu-item {{ request()->routeIs('paiement-maitre.*','frais.*','depense.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                                <div data-i18n="Authentications">Comptabilité</div>
                        </a>
                        <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('frais.*') ? 'active' : '' }}">
                                        <a href="{{ route('frais.index') }}" class="menu-link">
                                                <div data-i18n="Basic">Frais scolaire</div>
                                        </a>
                                </li>
                        </ul>
                        <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('paiement-maitre.*') ? 'active' : '' }}">
                                        <a href="{{ route('paiement-maitre.index') }}" class="menu-link">
                                                <div data-i18n="Basic">Paiements des maitres</div>
                                        </a>
                                </li>
                        </ul>
                        <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('depense.*') ? 'active' : '' }}">
                                        <a href="{{ route('depense.index') }}" class="menu-link">
                                                <div data-i18n="Basic">Depenses</div>
                                        </a>
                                </li>
                        </ul>
                </li>

                <!-- Gestion utilisateurs -->
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Gestion Utilisateurs</span></li>
                <li class="menu-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Utilisateurs</div>
                        </a>
                </li>

        </ul>
</aside>