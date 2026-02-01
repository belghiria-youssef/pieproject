<?php
$pageTitle = 'Tableau de bord';
$currentPage = 'dashboard';
$breadcrumb = 'Accueil';

// Simulated data for UI demonstration
$stats = [
    [
        'title' => 'Mes Étudiants',
        'value' => '48',
        'change' => '+3',
        'changeType' => 'positive',
        'icon' => 'users',
        'color' => 'purple'
    ],
    [
        'title' => 'Mes Groupes',
        'value' => '4',
        'change' => '',
        'changeType' => 'neutral',
        'icon' => 'group',
        'color' => 'blue'
    ],
    [
        'title' => 'Cours Aujourd\'hui',
        'value' => '3',
        'change' => '',
        'changeType' => 'neutral',
        'icon' => 'class',
        'color' => 'orange'
    ],
    [
        'title' => 'Taux Présence',
        'value' => '94%',
        'change' => '+2%',
        'changeType' => 'positive',
        'icon' => 'check',
        'color' => 'green'
    ]
];

$recentStudents = [
    ['nom' => 'El Amrani', 'prenom' => 'Fatima', 'email' => 'fatima.elamrani@email.com', 'groupe' => 'Groupe A', 'date' => '15 Jan 2026'],
    ['nom' => 'Benali', 'prenom' => 'Youssef', 'email' => 'youssef.benali@email.com', 'groupe' => 'Groupe B', 'date' => '14 Jan 2026'],
    ['nom' => 'Chakir', 'prenom' => 'Sara', 'email' => 'sara.chakir@email.com', 'groupe' => 'Groupe A', 'date' => '13 Jan 2026'],
    ['nom' => 'Idrissi', 'prenom' => 'Omar', 'email' => 'omar.idrissi@email.com', 'groupe' => 'Groupe C', 'date' => '12 Jan 2026'],
    ['nom' => 'Tazi', 'prenom' => 'Amina', 'email' => 'amina.tazi@email.com', 'groupe' => 'Groupe B', 'date' => '11 Jan 2026'],
];

$upcomingClasses = [
    ['titre' => 'Introduction PHP', 'heure' => '09:00', 'groupe' => 'Groupe A', 'salle' => 'Salle 101'],
    ['titre' => 'JavaScript Avancé', 'heure' => '10:30', 'groupe' => 'Groupe B', 'salle' => 'Salle 203'],
    ['titre' => 'Base de Données', 'heure' => '14:00', 'groupe' => 'Groupe C', 'salle' => 'Salle 105'],
];

$topGroups = [
    ['nom' => 'Groupe A', 'points' => 485, 'phase' => 'Phase 3', 'progress' => 85],
    ['nom' => 'Groupe B', 'points' => 420, 'phase' => 'Phase 3', 'progress' => 75],
    ['nom' => 'Groupe C', 'points' => 380, 'phase' => 'Phase 2', 'progress' => 65],
    ['nom' => 'Groupe D', 'points' => 350, 'phase' => 'Phase 2', 'progress' => 60],
];

ob_start();
?>

<div class="dashboard-container">
    <!-- Stats Cards Row -->
    <div class="stats-grid">
        <?php foreach ($stats as $stat): ?>
        <div class="stat-card stat-card--<?= $stat['color'] ?>">
            <div class="stat-card__header">
                <div class="stat-card__icon stat-card__icon--<?= $stat['color'] ?>">
                    <svg width="20" height="20"><use href="#icon-<?= $stat['icon'] ?>"/></svg>
                </div>
                <?php if (!empty($stat['change'])): ?>
                <div class="stat-card__change <?= $stat['changeType'] === 'positive' ? 'stat-card__change--up' : ($stat['changeType'] === 'negative' ? 'stat-card__change--down' : '') ?>">
                    <?php if ($stat['changeType'] === 'positive'): ?>
                    <svg width="12" height="12"><use href="#icon-trending-up"/></svg>
                    <?php elseif ($stat['changeType'] === 'negative'): ?>
                    <svg width="12" height="12"><use href="#icon-trending-down"/></svg>
                    <?php endif; ?>
                    <span><?= $stat['change'] ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="stat-card__body">
                <span class="stat-card__value"><?= $stat['value'] ?></span>
                <span class="stat-card__title"><?= $stat['title'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Main Content Area -->
    <div class="dashboard-grid">
        <!-- Left Column - Main Content -->
        <div class="dashboard-main">
            <!-- Chart Card -->
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <div class="dashboard-card__header-left">
                        <h3 class="dashboard-card__title">Statistiques des Présences</h3>
                        <p class="dashboard-card__subtitle">Évolution sur les 7 derniers jours</p>
                    </div>
                    <div class="dashboard-card__header-right">
                        <div class="btn-group">
                            <button class="btn-group__item active">7J</button>
                            <button class="btn-group__item">30J</button>
                            <button class="btn-group__item">90J</button>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card__body">
                    <div class="chart-wrapper">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Students Table -->
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <div class="dashboard-card__header-left">
                        <h3 class="dashboard-card__title">Derniers Étudiants Inscrits</h3>
                        <p class="dashboard-card__subtitle">Les 5 dernières inscriptions</p>
                    </div>
                    <a href="/PIE_PROJECT/views/etudiants/index.php" class="btn btn--outline btn--sm">
                        <span>Voir tout</span>
                        <svg width="14" height="14"><use href="#icon-arrow-right"/></svg>
                    </a>
                </div>
                <div class="dashboard-card__body dashboard-card__body--flush">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Email</th>
                                    <th>Groupe</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentStudents as $student): ?>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-cell__avatar">
                                                <?= strtoupper(substr($student['prenom'], 0, 1) . substr($student['nom'], 0, 1)) ?>
                                            </div>
                                            <span class="user-cell__name"><?= $student['prenom'] ?> <?= $student['nom'] ?></span>
                                        </div>
                                    </td>
                                    <td class="text-muted"><?= $student['email'] ?></td>
                                    <td>
                                        <span class="badge badge--primary"><?= $student['groupe'] ?></span>
                                    </td>
                                    <td class="text-muted"><?= $student['date'] ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn" title="Voir">
                                                <svg width="14" height="14"><use href="#icon-eye"/></svg>
                                            </button>
                                            <button class="action-btn" title="Modifier">
                                                <svg width="14" height="14"><use href="#icon-edit"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Sidebar Widgets -->
        <div class="dashboard-sidebar">
            <!-- Today's Classes -->
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <div class="dashboard-card__header-left">
                        <h3 class="dashboard-card__title">Mes Cours Aujourd'hui</h3>
                        <p class="dashboard-card__subtitle"><?= date('d M Y') ?></p>
                    </div>
                </div>
                <div class="dashboard-card__body">
                    <div class="schedule-list">
                        <?php foreach ($upcomingClasses as $class): ?>
                        <div class="schedule-item">
                            <div class="schedule-item__time">
                                <span class="schedule-item__hour"><?= $class['heure'] ?></span>
                                <span class="schedule-item__room"><?= $class['salle'] ?></span>
                            </div>
                            <div class="schedule-item__content">
                                <span class="schedule-item__title"><?= $class['titre'] ?></span>
                                <span class="badge badge--secondary badge--sm"><?= $class['groupe'] ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="/PIE_PROJECT/views/classes/index.php" class="btn btn--ghost btn--block">
                        <svg width="14" height="14"><use href="#icon-calendar"/></svg>
                        <span>Voir le planning</span>
                    </a>
                </div>
            </div>
            
            <!-- Top Groups Ranking -->
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <div class="dashboard-card__header-left">
                        <h3 class="dashboard-card__title">Classement des Groupes</h3>
                        <p class="dashboard-card__subtitle">Par points accumulés</p>
                    </div>
                </div>
                <div class="dashboard-card__body">
                    <div class="ranking-list">
                        <?php foreach ($topGroups as $index => $group): ?>
                        <div class="ranking-item">
                            <div class="ranking-item__position ranking-item__position--<?= $index + 1 ?>">
                                <?= $index + 1 ?>
                            </div>
                            <div class="ranking-item__content">
                                <div class="ranking-item__header">
                                    <span class="ranking-item__name"><?= $group['nom'] ?></span>
                                    <span class="ranking-item__points"><?= $group['points'] ?> pts</span>
                                </div>
                                <div class="ranking-item__meta">
                                    <span class="badge badge--info badge--sm"><?= $group['phase'] ?></span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-bar__fill progress-bar__fill--<?= $index + 1 ?>" style="width: <?= $group['progress'] ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="/PIE_PROJECT/views/phases/index.php" class="btn btn--ghost btn--block">
                        <svg width="14" height="14"><use href="#icon-phases"/></svg>
                        <span>Voir les détails</span>
                    </a>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Actions Rapides</h3>
                </div>
                <div class="dashboard-card__body">
                    <div class="quick-actions-grid">
                        <a href="/PIE_PROJECT/views/absences/index.php" class="quick-action">
                            <div class="quick-action__icon quick-action__icon--purple">
                                <svg width="18" height="18"><use href="#icon-check"/></svg>
                            </div>
                            <span class="quick-action__label">Faire l'appel</span>
                        </a>
                        <a href="/PIE_PROJECT/views/etudiants/index.php" class="quick-action">
                            <div class="quick-action__icon quick-action__icon--blue">
                                <svg width="18" height="18"><use href="#icon-users"/></svg>
                            </div>
                            <span class="quick-action__label">Voir étudiants</span>
                        </a>
                        <a href="/PIE_PROJECT/views/phases/index.php" class="quick-action">
                            <div class="quick-action__icon quick-action__icon--orange">
                                <svg width="18" height="18"><use href="#icon-phases"/></svg>
                            </div>
                            <span class="quick-action__label">Notes & points</span>
                        </a>
                        <a href="/PIE_PROJECT/views/certificats/index.php" class="quick-action">
                            <div class="quick-action__icon quick-action__icon--green">
                                <svg width="18" height="18"><use href="#icon-certificate"/></svg>
                            </div>
                            <span class="quick-action__label">Attestations</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== Dashboard Layout ===== */
.dashboard-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ===== Stats Grid ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

@media (max-width: 1280px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* ===== Stat Card ===== */
.stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
}

.stat-card__header {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.stat-card__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-card__icon--purple {
    background: rgba(167, 139, 250, 0.12);
    color: #8b5cf6;
}

.stat-card__icon--blue {
    background: rgba(59, 130, 246, 0.12);
    color: #3b82f6;
}

.stat-card__icon--orange {
    background: rgba(245, 158, 11, 0.12);
    color: #f59e0b;
}

.stat-card__icon--green {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
}

.stat-card__change {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
    color: #6b7280;
    background: rgba(0, 0, 0, 0.04);
}

.stat-card__change--up {
    color: #10b981;
    background: rgba(16, 185, 129, 0.1);
}

.stat-card__change--down {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

.stat-card__body {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 2px;
}

.stat-card__value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.2;
}

.stat-card__title {
    font-size: 0.8125rem;
    color: #6b7280;
    font-weight: 400;
}

/* ===== Dashboard Grid ===== */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
}

@media (max-width: 1280px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

.dashboard-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 0;
}

.dashboard-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

@media (max-width: 1280px) {
    .dashboard-sidebar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
}

/* ===== Dashboard Card ===== */
.dashboard-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.dashboard-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    flex-wrap: wrap;
    gap: 10px;
}

.dashboard-card__header-left {
    min-width: 0;
}

.dashboard-card__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.dashboard-card__subtitle {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 2px 0 0;
}

.dashboard-card__body {
    padding: 16px 20px;
}

.dashboard-card__body--flush {
    padding: 0;
}

/* ===== Button Group ===== */
.btn-group {
    display: flex;
    background: rgba(0, 0, 0, 0.04);
    border-radius: 8px;
    padding: 3px;
}

.btn-group__item {
    padding: 6px 12px;
    border: none;
    background: transparent;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-group__item:hover {
    color: #1a1a2e;
}

.btn-group__item.active {
    background: #ffffff;
    color: #1a1a2e;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* ===== Chart ===== */
.chart-wrapper {
    height: 280px;
    position: relative;
}

/* ===== Data Table ===== */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    padding: 10px 16px;
    text-align: left;
    font-size: 0.6875rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(0, 0, 0, 0.02);
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    white-space: nowrap;
}

.data-table td {
    padding: 12px 16px;
    font-size: 0.8125rem;
    color: #1a1a2e;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.15s ease;
}

.data-table tbody tr:hover {
    background: rgba(167, 139, 250, 0.04);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* User Cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-cell__avatar {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6875rem;
    font-weight: 600;
    flex-shrink: 0;
}

.user-cell__name {
    font-weight: 500;
    font-size: 0.8125rem;
    white-space: nowrap;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 2px;
}

.action-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: transparent;
    border-radius: 6px;
    color: #9ca3af;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}

.action-btn:hover {
    background: rgba(167, 139, 250, 0.1);
    color: #8b5cf6;
}

/* ===== Badges ===== */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.6875rem;
    font-weight: 500;
}

.badge--sm {
    padding: 2px 6px;
    font-size: 0.625rem;
}

.badge--primary {
    background: rgba(167, 139, 250, 0.12);
    color: #7c3aed;
}

.badge--secondary {
    background: rgba(107, 114, 128, 0.12);
    color: #4b5563;
}

.badge--info {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

/* ===== Schedule List ===== */
.schedule-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 14px;
}

.schedule-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 10px;
    transition: all 0.15s ease;
}

.schedule-item:hover {
    background: rgba(167, 139, 250, 0.06);
}

.schedule-item__time {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 52px;
}

.schedule-item__hour {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1a1a2e;
}

.schedule-item__room {
    font-size: 0.625rem;
    color: #9ca3af;
    margin-top: 1px;
}

.schedule-item__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.schedule-item__title {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #1a1a2e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ===== Ranking List ===== */
.ranking-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 14px;
}

.ranking-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.ranking-item__position {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    flex-shrink: 0;
}

.ranking-item__position--1 {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.ranking-item__position--2 {
    background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
    color: white;
}

.ranking-item__position--3 {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    color: white;
}

.ranking-item__position--4 {
    background: rgba(0, 0, 0, 0.06);
    color: #6b7280;
}

.ranking-item__content {
    flex: 1;
    min-width: 0;
}

.ranking-item__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 3px;
}

.ranking-item__name {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #1a1a2e;
}

.ranking-item__points {
    font-size: 0.6875rem;
    font-weight: 500;
    color: #6b7280;
}

.ranking-item__meta {
    margin-bottom: 6px;
}

/* Progress Bar */
.progress-bar {
    height: 5px;
    background: rgba(0, 0, 0, 0.06);
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar__fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-bar__fill--1 {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
}

.progress-bar__fill--2 {
    background: linear-gradient(90deg, #a78bfa, #8b5cf6);
}

.progress-bar__fill--3 {
    background: linear-gradient(90deg, #60a5fa, #3b82f6);
}

.progress-bar__fill--4 {
    background: linear-gradient(90deg, #6ee7b7, #10b981);
}

/* ===== Quick Actions Grid ===== */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.quick-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 14px 10px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.15s ease;
}

.quick-action:hover {
    background: rgba(167, 139, 250, 0.08);
    transform: translateY(-1px);
}

.quick-action__icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action__icon--purple {
    background: rgba(167, 139, 250, 0.15);
    color: #8b5cf6;
}

.quick-action__icon--green {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
}

.quick-action__icon--orange {
    background: rgba(245, 158, 11, 0.15);
    color: #f59e0b;
}

.quick-action__icon--blue {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
}

.quick-action__label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #1a1a2e;
    text-align: center;
}

/* ===== Buttons ===== */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s ease;
}

.btn--sm {
    padding: 6px 12px;
    font-size: 0.75rem;
    border-radius: 6px;
}

.btn--outline {
    background: transparent;
    border: 1px solid rgba(0, 0, 0, 0.1);
    color: #1a1a2e;
}

.btn--outline:hover {
    border-color: #8b5cf6;
    color: #8b5cf6;
    background: rgba(167, 139, 250, 0.04);
}

.btn--ghost {
    background: transparent;
    color: #6b7280;
}

.btn--ghost:hover {
    background: rgba(0, 0, 0, 0.04);
    color: #1a1a2e;
}

.btn--block {
    width: 100%;
}

/* ===== Utilities ===== */
.text-muted {
    color: #9ca3af;
}

.text-center {
    text-align: center;
}

/* ===== Responsive adjustments ===== */
@media (max-width: 768px) {
    .dashboard-card__header {
        padding: 14px 16px;
    }
    
    .dashboard-card__body {
        padding: 14px 16px;
    }
    
    .data-table th,
    .data-table td {
        padding: 10px 12px;
    }
    
    .stat-card {
        padding: 14px;
    }
    
    .stat-card__value {
        font-size: 1.375rem;
    }
}

@media (max-width: 480px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .btn-group {
        width: 100%;
    }
    
    .btn-group__item {
        flex: 1;
        text-align: center;
    }
}
</style>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
// Initialize attendance chart
const ctx = document.getElementById('attendanceChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [
                {
                    label: 'Présents',
                    data: [220, 235, 228, 240, 232, 180, 0],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Absents',
                    data: [28, 13, 20, 8, 16, 68, 248],
                    borderColor: '#f87171',
                    backgroundColor: 'rgba(248, 113, 113, 0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f87171',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        boxWidth: 8,
                        font: {
                            family: 'Inter',
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { family: 'Inter', size: 13, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 14,
                    cornerRadius: 10,
                    displayColors: true,
                    boxWidth: 8,
                    boxHeight: 8,
                    boxPadding: 4
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 12,
                            weight: '500'
                        },
                        color: '#9ca3af'
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.04)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 12
                        },
                        color: '#9ca3af',
                        padding: 10
                    },
                    border: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
