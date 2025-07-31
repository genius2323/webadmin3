<style>
  .custom-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 18px 0;
    transition: margin-left 0.3s, width 0.3s;
    position: relative;
    z-index: 100;
  }
  .custom-footer-inner {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
  }
  @media (min-width: 768px) {
    .custom-footer-inner {
      flex-direction: row;
    }
  }
  .custom-footer-left {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
  }
  .custom-footer-right ul {
    display: flex;
    flex-direction: row;
    gap: 18px;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
  }
  .custom-footer-right .nav-link {
    color: #6c757d;
    padding: 0;
    font-size: 1rem;
    transition: color 0.2s;
  }
  .custom-footer-right .nav-link:hover {
    color: #3f6ad8;
    text-decoration: underline;
  }
    @media (max-width: 991.98px) {
    .custom-footer {
      margin-left: 0 !important;
      width: 100% !important;
    }
  }
</style>
<footer id="mainFooter" class="custom-footer">
  <div class="container-fluid custom-footer-inner">
    <div class="custom-footer-left">
      &copy; <?= date('Y') ?> <b>Web Admin</b> | Sistem POS &amp; Akuntansi
    </div>
    <div class="custom-footer-right">
      <ul>
        <li><a href="#" class="nav-link">Bantuan</a></li>
        <li><a href="#" class="nav-link">Kebijakan Privasi</a></li>
        <li><a href="https://dashboardpack.com" class="nav-link" target="_blank">ArchitectUI</a></li>
      </ul>
    </div>
  </div>
</footer>
<script>
  // Script agar footer mengikuti sidebar
  function updateFooterSidebar() {
    var appContainer = document.querySelector('.app-container');
    var footer = document.getElementById('mainFooter');
    if (!appContainer || !footer) return;
    if (appContainer.classList.contains('closed-sidebar')) {
      footer.style.marginLeft = '80px'; // sidebar minified
      footer.style.width = 'calc(100% - 80px)';
    } else {
      footer.style.marginLeft = '280px'; // sidebar normal
      footer.style.width = 'calc(100% - 280px)';
    }
  }
  document.addEventListener('DOMContentLoaded', function() {
    updateFooterSidebar();
    document.querySelectorAll('.close-sidebar-btn, .mobile-toggle-nav').forEach(function(btn) {
      btn.addEventListener('click', function() {
        setTimeout(updateFooterSidebar, 350);
      });
    });
    window.addEventListener('resize', updateFooterSidebar);
  });
</script>
