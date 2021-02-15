<nav class="navbar">
        <div class="navbar__logo">
            <i class="far fa-paper-plane"></i>
            <a href="/"> GO.HANDONG</a>
        </div>

        <ul class="navbar__menu">
            <li>
            <a href="/main"> 
                <i class="fas fa-home"></i> 
                Main
            </a>

            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="/write"> 
                    <i class="fas fa-pencil-alt"></i> 
                        Post 
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        
        <ul class="navbar__user">
            <li>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="/login/google"> <i class="fab fa-google"></i> Login</a>
                <?php else: ?>
                    <a href="/login/google?logout=1"> <i class="fab fa-google"></i> Logout</a>
                <?php endif; ?>
            </li>
        </ul>

        <a class="navbar__toggleBtn">
            <i class="fas fa-bars"></i>
        </a>
    </nav>