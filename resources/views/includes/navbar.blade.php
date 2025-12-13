<nav>
        <div class="nav_item">
            <a class="left_item" href="/">
                <button>
                    <svg class="dit_logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" role="img" aria-labelledby="title desc" class="logo-docintown">
                        <path d="M80 8
                                 a72 72 0 1 0 0 144
                                 a72 72 0 1 0 0-144"
                                fill="white" stroke="black" stroke-width="6"/>

                        <path d="M68 38
                                 a4 4 0 0 1 4-4h16a4 4 0 0 1 4 4v30h30a4 4 0 0 1 4 4v16a4 4 0 0 1-4 4h-30v30a4 4 0 0 1-4 4h-16a4 4 0 0 1-4-4v-30h-30a4 4 0 0 1-4-4v-16a4 4 0 0 1 4-4h30z
                                 M74 50h12v24h24v12h-24v24h-12v-24H50v-12h24z"
                                fill="black" fill-rule="evenodd"/>
                    </svg>
                </button>
                <div class="title">DOC IN TOWN</div>
            </a>
            <div class="right_item">
    @if(!Auth::check())
        <div class="login_item">
            <button class="login">Log In</button>
            <div class="auth_dropdown">
                <form id="login_form">
                    @csrf
                    <input type="text" name="email" class="email-input" placeholder="Email o Username" required>
                    <input type="password" name="password" class="password-input" placeholder="Password" required>
                    <button type="submit" id="login-button" class="log-in">Accedi</button>
                    <div class="form_message"></div>
                </form>
            </div>
        </div>
        <div class="register_item">
            <button class="register">Registrati</button>
            <div class="auth_dropdown">
                <form id="register_form">
                    @csrf
                    <input type="text" id="regUsername" name="username" placeholder="Username" required>
                    <input type="email" id="regEmail" name="email" placeholder="Email" required>
                    <input type="password" id="regPassword" name="password" placeholder="Password" required>
                    <input type="password" id="regPasswordConfirm" name="password_confirm" placeholder="Ripeti Password" required>
                    <button type="submit" id="submitRegister">Crea Account</button>
                    <div class="form_message"></div>
                </form>
            </div>
        </div>
    @else
        <div class="user_item">
            <a href="{{ route('profilo_utente') }}" style="text-decoration: none; color: inherit;">
                <span class="username">{{ Auth::user()->name }}</span>
            </a>
            
            <div class="user_dropdown">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout_button" href="/">Logout</button>
                </form>
            </div>
        </div>
    @endif
</div>

            </div>
        </div>               
    </div>
</nav>