<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PIE - Plateforme de gestion des étudiants pour formateurs">
    <title><?= $pageTitle ?? 'Dashboard' ?> - PIE Gestion Étudiants</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main Styles -->
    <link rel="stylesheet" href="/PIE_PROJECT/public/css/style.css">
    
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <?php if (isset($additionalStyles)): ?>
    <style><?= $additionalStyles ?></style>
    <?php endif; ?>
</head>
<body>
    <!-- SVG Icons Sprite -->
    <?php include __DIR__ . '/../../public/icons/icons.svg'; ?>
    
    <div class="app-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">P</div>
                    <span class="sidebar-logo-text">PIE Project</span>
                </div>
            </div>
            
            <!-- User Info -->
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <?= strtoupper(substr($_SESSION['user']['prenom'] ?? 'F', 0, 1)) ?>
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'Formateur') ?> <?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?></div>
                    <div class="sidebar-user-role">Formateur</div>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <nav class="sidebar-nav">
                <!-- Main Section -->
                <div class="sidebar-section">
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/dashboard/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-dashboard"/></svg>
                                </span>
                                Tableau de bord
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Mes Étudiants Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Mes Étudiants</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/etudiants/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'etudiants' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-users"/></svg>
                                </span>
                                Liste Étudiants
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/groupes/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'groupes' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-group"/></svg>
                                </span>
                                Mes Groupes
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/absences/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'absences' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-absence"/></svg>
                                </span>
                                Présences
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Pédagogie Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Pédagogie</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/projets/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'projets' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-project"/></svg>
                                </span>
                                Projets
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/phases/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'phases' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-phases"/></svg>
                                </span>
                                Évaluations
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Documents Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Documents</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/certificats/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'certificats' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-certificate"/></svg>
                                </span>
                                Attestations
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Compte Section -->
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Compte</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item">
                            <a href="/PIE_PROJECT/views/parametres/index.php" class="sidebar-menu-link <?= ($currentPage ?? '') === 'parametres' ? 'active' : '' ?>">
                                <span class="sidebar-menu-icon">
                                    <svg width="18" height="18"><use href="#icon-settings"/></svg>
                                </span>
                                Paramètres
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <div class="sidebar-footer-logo">
                    <span style="font-size: 0.75rem; color: var(--text-muted);">© 2026 PIE Project</span>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="header">
                <div class="header-left">
                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-ghost btn-icon d-none" id="menuToggle">
                        <svg width="18" height="18"><use href="#icon-menu"/></svg>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <div class="header-breadcrumb">
                        <span class="header-breadcrumb-item">
                            <svg width="14" height="14"><use href="#icon-home"/></svg>
                        </span>
                        <span class="header-breadcrumb-separator">/</span>
                        <span class="header-breadcrumb-item"><?= htmlspecialchars($breadcrumb ?? 'Dashboard') ?></span>
                        <?php if (isset($subBreadcrumb)): ?>
                        <span class="header-breadcrumb-separator">/</span>
                        <span class="header-breadcrumb-item active"><?= htmlspecialchars($subBreadcrumb) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Search -->
                    <div class="header-search">
                        <svg class="header-search-icon" width="16" height="16"><use href="#icon-search"/></svg>
                        <input type="text" class="header-search-input" placeholder="Rechercher..." id="globalSearch">
                    </div>
                    
                    <!-- Actions -->
                    <div class="header-actions">
                        <button class="header-action-btn" title="Notifications" id="notificationsBtn">
                            <svg width="18" height="18"><use href="#icon-bell"/></svg>
                            <span class="badge"></span>
                        </button>
                        <div class="dropdown" id="userDropdown">
                            <button class="header-action-btn" onclick="toggleDropdown('userDropdown')">
                                <svg width="18" height="18"><use href="#icon-user"/></svg>
                            </button>
                            <div class="dropdown-menu">
                                <div class="dropdown-item" style="pointer-events: none; opacity: 0.7;">
                                    <?= htmlspecialchars($_SESSION['user']['email'] ?? 'utilisateur@email.com') ?>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="/PIE_PROJECT/views/parametres/index.php" class="dropdown-item">
                                    <svg width="14" height="14"><use href="#icon-user"/></svg>
                                    Mon profil
                                </a>
                                <a href="/PIE_PROJECT/views/parametres/index.php" class="dropdown-item">
                                    <svg width="14" height="14"><use href="#icon-settings"/></svg>
                                    Paramètres
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="/PIE_PROJECT/views/auth/login.php" class="dropdown-item" style="color: var(--danger);">
                                    <svg width="14" height="14"><use href="#icon-logout"/></svg>
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="content-area">
                <?php if (isset($flashMessage)): ?>
                <div class="alert alert-<?= $flashMessage['type'] ?? 'info' ?> mb-4">
                    <svg class="alert-icon" width="20" height="20">
                        <use href="#icon-<?= $flashMessage['type'] === 'success' ? 'check-circle' : ($flashMessage['type'] === 'danger' ? 'x-circle' : 'info') ?>"/>
                    </svg>
                    <div class="alert-content">
                        <?= htmlspecialchars($flashMessage['message']) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Page Title -->
                <?php if (isset($pageTitle)): ?>
                <div class="d-flex justify-between align-center mb-5">
                    <div>
                        <h1 style="font-size: 1.25rem; margin-bottom: 4px;"><?= htmlspecialchars($pageTitle) ?></h1>
                        <?php if (isset($pageSubtitle)): ?>
                        <p class="text-secondary" style="font-size: 0.875rem;"><?= htmlspecialchars($pageSubtitle) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($pageActions)): ?>
                    <div class="d-flex gap-3">
                        <?= $pageActions ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <!-- Main Content Slot -->
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
    
    <!-- Global Scripts -->
    <script>
        // Dropdown toggle
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('show');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }
        
        // Global search
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    window.location.href = '/recherche?q=' + encodeURIComponent(this.value);
                }
            });
        }
        
        // Tab functionality
        function initTabs() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabGroup = this.closest('.tabs');
                    const contentContainer = tabGroup.nextElementSibling;
                    const targetId = this.dataset.tab;
                    
                    // Update buttons
                    tabGroup.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update content
                    if (contentContainer) {
                        contentContainer.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                        const targetContent = document.getElementById(targetId);
                        if (targetContent) {
                            targetContent.classList.add('active');
                        }
                    }
                });
            });
        }
        
        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initTabs();
        });
        
        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
        
        // Close modal on backdrop click
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Form validation helper
        function validateForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return false;
            
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            return isValid;
        }
        
        // CSRF token getter
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }
        
        // Fetch wrapper with CSRF
        async function fetchWithCSRF(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCSRFToken()
                }
            };
            
            const mergedOptions = {
                ...defaultOptions,
                ...options,
                headers: {
                    ...defaultOptions.headers,
                    ...options.headers
                }
            };
            
            return fetch(url, mergedOptions);
        }
        
        // Toast notification
        function showToast(message, type = 'info', duration = 3000) {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type}`;
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 280px;
                animation: slideIn 0.3s ease;
            `;
            toast.innerHTML = `
                <svg class="alert-icon" width="20" height="20">
                    <use href="#icon-${type === 'success' ? 'check-circle' : type === 'danger' ? 'x-circle' : 'info'}"/>
                </svg>
                <div class="alert-content">${message}</div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }
        
        // Add CSS animations for toasts
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .is-invalid {
                border-color: var(--danger) !important;
            }
        `;
        document.head.appendChild(style);
    </script>
    
    <?php if (isset($additionalScripts)): ?>
    <?= $additionalScripts ?>
    <?php endif; ?>
</body>
</html>
