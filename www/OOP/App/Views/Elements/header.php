<div class="header">
    <a href='/contacts'>
        <div class="img-logo"></div>
    </a>

    <?php if ($_SESSION['logined'] == true): ?>
        <ul class="control-panel">
            <li class="control-buttons" id="home-button">
                <a href='/contacts'>
                    <div class="control-buttons-content">
                        <div class="home-img"></div>
                        <p id="home-p">Home</p>
                    </div>
                </a>
            </li>
            <li class="control-buttons" id="selection-button">
                <a href='/contacts/selection'>
                    <div class="control-buttons-content">
                        <div class="selection-img"></div>
                        <p id="selection-p">Selection page</p>
                    </div>
                </a>
            </li>
            <li class="control-buttons" id="logout-button">
                <a href='/contacts/logout'>
                    <div class="control-buttons-content">
                        <div class="logout-img"></div>
                        <p id="auth-p">Logout</p>
                    </div>
                </a>
            </li>
        </ul>
    <?php endif; ?>
</div>