<nav class="navbar">
        <div class="navbar__logo">
            <i class="far fa-paper-plane"></i>
            <a href="/">  TAKEME</a>
        </div>

        <ul class="navbar__menu">
            <li>
                <a href="/write"> 
                <i class="fas fa-link"></i> 
                    링크 만들기 
                </a>
            </li>
        </ul>
        
        <ul class="navbar__user">
            <li>
                <a href="https://github.com/HGUfuzzing/TakeMe" target="_blank"> 
                    <i class="fab fa-github" data-tooltip-text="Github"></i> 
                </a>
            </li>
            <li>
                <a href="/about"> 
                    <i class="far fa-question-circle" data-tooltip-text="About"></i>
                </a>
            </li>
            <li>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="/login/google"> 
                        <i class="fab fa-google"></i> Login
                    </a>
                <?php else: ?>
                    <a href="/login/google?logout=1"> 
                    <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php endif; ?>
            </li>
        </ul>

        <a class="navbar__toggleBtn">
            <i class="fas fa-bars"></i>
        </a>
    </nav>