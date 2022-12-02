<div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <ul class="flex-row navbar-item">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        <img src="assets/img/tecno.png" class="navbar-logo" alt="logo">
                        <b style="font-size: 15px; color:#ffffff">TecnoAka</b>
                    </a>
                </li>
            </ul>

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg></a>

            <livewire:search-controller>
            <ul class="flex-row navbar-item navbar-dropdown">


                <li class="order-1 nav-item dropdown user-profile-dropdown order-lg-0">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user text-dark"></i>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="mx-auto media">
                                <img src="assets/img/livewire.png" class="mr-2 img-fluid" alt="avatar">
                                <div class="media-body">
                                    <h5>Cristian Hernandez</h5>
                                    <p>Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="user_profile.html">
                                <i class="fas fa-user"></i> <span>Mi Perfil</span>
                            </a>
                        </div>


                      <div class="dropdown-item">

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">

                            <i class="fas fa-sign-out-alt"></i>


                            <span>Log Out</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </div>
                    </div>
                </li>
            </ul>
</header>
</div>
