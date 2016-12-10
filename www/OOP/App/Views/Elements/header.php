<div id="header">
    <a href='/contacts'>
        <img id="img-logo">
    </a>

    <?php if ($_SESSION['logined'] == true): ?>
        <div id="control-panel">
            <div class="control-buttons" id="home-button">
                <a href='/contacts'>
                    <div class="control-buttons-content">
                        <img id="home-img">
                        <p id="home-p">Home</p>
                    </div>
                </a>
            </div>

            <div class="control-buttons" id="selection-button">
                <a href='/contacts/selection'>
                    <div class="control-buttons-content">
                        <img id="selection-img">
                        <p id="selection-p">Selection page</p>
                    </div>
                </a>
            </div>

            <div class="control-buttons" id="logout-button">
                <a href='/contacts/logout'>
                    <div class="control-buttons-content">
                        <img id="logout-img">
                        <p id="auth-p">Logout</p>
                    </div>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>