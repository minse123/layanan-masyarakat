               <!-- Topbar -->
               <nav class="navbar navbar-expand-lg">
                   <div class="container">
                       <a class="navbar-brand" href="index.html">
                           <img src="{{ asset('frontend/images/logo-kementerian.png') }}" alt="Logo"
                               class="navbar-brand-icon"> <span>BPPMDDTT</span>
                           <span>Banjarmasin</span>
                       </a>

                       {{-- <div class="d-lg-none ms-auto me-3">
                           <a href="/login" class="btn custom-btn custom-border-btn btn-naira btn-inverted">
                               <i class="btn-icon bi-cloud-download"></i>
                               <span>Login</span><!-- duplicated another one below for mobile -->
                           </a>
                       </div> --}}

                       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                           aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                       </button>

                       <div class="collapse navbar-collapse" id="navbarNav">
                           <ul class="navbar-nav ms-lg-auto me-lg-4">
                               <li class="nav-item">
                                   <a class="nav-link click-scroll" href="#section_1">Beranda</a>
                               </li>

                               <li class="nav-item">
                                   <a class="nav-link click-scroll" href="#section_2">The Book</a>
                               </li>

                               <li class="nav-item">
                                   <a class="nav-link click-scroll" href="#section_3">Author</a>
                               </li>

                               <li class="nav-item">
                                   <a class="nav-link click-scroll" href="#section_4">Reviews</a>
                               </li>

                               <li class="nav-item">
                                   <a class="nav-link click-scroll" href="#section_5">Contact</a>
                               </li>
                           </ul>

                           <div class="d-none d-lg-block">
                               <a href="/login" class="btn custom-btn custom-border-btn btn-naira btn-inverted">
                                   <i class="btn-icon bi-lock"></i>
                                   <span>Login</span><!-- updated text to match the new link -->
                               </a>
                           </div>
                       </div>
                   </div>
               </nav>
