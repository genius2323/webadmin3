<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="" style="font-size:1.5rem;font-weight:bold;color:#3f6ad8;white-space:nowrap;transition:opacity 0.2s;" id="adminPanelLogo">AdminPanel</div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <div class="app-header-right">          
            <div class="widget-content-left ml-3 header-user-info d-flex align-items-center" style="gap: 10px;">
                <span class="widget-heading mb-0" style="font-weight:500;">
                    <?= esc(session()->get('user_nama')) ?>
                </span>
                <a href="<?= site_url('logout') ?>" class="btn btn-danger btn-sm" style="margin-left:10px;">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="close"></button>
            </div>
        </div>
        <div class="app-header-right">          
            <div class="widget-content-left ml-3 header-user-info d-flex align-items-center" style="gap: 10px;">
                <span class="widget-heading mb-0" style="font-weight:500;">
                    <?= esc(session()->get('user_nama')) ?>
                </span>
                <a href="<?= site_url('logout') ?>" class="btn btn-danger btn-sm" style="margin-left:10px;">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>
