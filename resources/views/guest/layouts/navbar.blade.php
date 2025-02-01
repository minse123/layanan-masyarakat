               <!-- Topbar -->
               <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                       <i class="fa fa-bars"></i>
                   </button>

                   <ul class="navbar-nav ml-auto">
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('buku-tamu') }}">Buku Tamu</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('konsultasi-pelatihan') }}">Konsultasi Pelatihan</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('tentang-kami') }}">Tentang Kami</a>
                       </li>
                       <div class="topbar-divider d-none d-sm-block"></div>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ url('login') }}">
                               <span class="mr-2 d-none d-lg-inline text-gray-600 small">Login</span>
                               <i class="fas fa-user-circle text-gray-600"></i>
                           </a>
                       </li>
                   </ul>
               </nav>
