<?php
$pageTitle = 'Mes Groupes';
$currentPage = 'groupes';
$breadcrumb = 'Groupes';

// Demo data
$groupes = [
    [
        'id' => 1, 
        'nom' => 'Groupe A', 
        'description' => 'Développement Web Full Stack',
        'nb_etudiants' => 12,
        'phase' => 'Phase 3',
        'points' => 485,
        'progress' => 85
    ],
    [
        'id' => 2, 
        'nom' => 'Groupe B', 
        'description' => 'Data Science & IA',
        'nb_etudiants' => 10,
        'phase' => 'Phase 3',
        'points' => 420,
        'progress' => 75
    ],
    [
        'id' => 3, 
        'nom' => 'Groupe C', 
        'description' => 'Cybersécurité',
        'nb_etudiants' => 14,
        'phase' => 'Phase 2',
        'points' => 380,
        'progress' => 65
    ],
    [
        'id' => 4, 
        'nom' => 'Groupe D', 
        'description' => 'DevOps & Cloud',
        'nb_etudiants' => 12,
        'phase' => 'Phase 2',
        'points' => 350,
        'progress' => 60
    ],
];

ob_start();
?>

<div class="groupes-container">
    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-box__icon stat-box__icon--purple">
                <svg width="18" height="18"><use href="#icon-group"/></svg>
            </div>
            <div class="stat-box__content">
                <span class="stat-box__value"><?= count($groupes) ?></span>
                <span class="stat-box__label">Groupes</span>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-box__icon stat-box__icon--blue">
                <svg width="18" height="18"><use href="#icon-users"/></svg>
            </div>
            <div class="stat-box__content">
                <span class="stat-box__value"><?= array_sum(array_column($groupes, 'nb_etudiants')) ?></span>
                <span class="stat-box__label">Étudiants</span>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-box__icon stat-box__icon--green">
                <svg width="18" height="18"><use href="#icon-check"/></svg>
            </div>
            <div class="stat-box__content">
                <span class="stat-box__value"><?= round(array_sum(array_column($groupes, 'progress')) / count($groupes)) ?>%</span>
                <span class="stat-box__label">Progression</span>
            </div>
        </div>
    </div>

    <!-- Groups Grid -->
    <div class="groups-grid">
        <?php foreach ($groupes as $groupe): ?>
        <div class="group-card">
            <div class="group-card__header">
                <div class="group-card__avatar">
                    <?= substr($groupe['nom'], -1) ?>
                </div>
                <div class="group-card__info">
                    <h3 class="group-card__name"><?= htmlspecialchars($groupe['nom']) ?></h3>
                    <p class="group-card__desc"><?= htmlspecialchars($groupe['description']) ?></p>
                </div>
                <button class="group-card__menu">
                    <svg width="16" height="16"><use href="#icon-more"/></svg>
                </button>
            </div>
            
            <div class="group-card__body">
                <div class="group-card__stats">
                    <div class="group-card__stat">
                        <svg width="14" height="14"><use href="#icon-users"/></svg>
                        <span><?= $groupe['nb_etudiants'] ?> étudiants</span>
                    </div>
                    <div class="group-card__stat">
                        <svg width="14" height="14"><use href="#icon-phases"/></svg>
                        <span><?= $groupe['phase'] ?></span>
                    </div>
                </div>
                
                <div class="group-card__progress">
                    <div class="group-card__progress-header">
                        <span>Progression</span>
                        <span class="group-card__points"><?= $groupe['points'] ?> pts</span>
                    </div>
                    <div class="group-card__progress-bar">
                        <div class="group-card__progress-fill" style="width: <?= $groupe['progress'] ?>%"></div>
                    </div>
                </div>
            </div>
            
            <div class="group-card__footer">
                <a href="/PIE_PROJECT/views/etudiants/index.php?groupe=<?= $groupe['id'] ?>" class="btn btn--ghost btn--sm">
                    <svg width="14" height="14"><use href="#icon-users"/></svg>
                    Étudiants
                </a>
                <a href="/PIE_PROJECT/views/phases/index.php?groupe=<?= $groupe['id'] ?>" class="btn btn--primary btn--sm">
                    <svg width="14" height="14"><use href="#icon-phases"/></svg>
                    Points
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
/* Groupes Container */
.groupes-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
}

.stat-box {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 18px;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.06);
}

.stat-box__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-box__icon--purple {
    background: rgba(167, 139, 250, 0.12);
    color: #8b5cf6;
}

.stat-box__icon--blue {
    background: rgba(59, 130, 246, 0.12);
    color: #3b82f6;
}

.stat-box__icon--green {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
}

.stat-box__content {
    display: flex;
    flex-direction: column;
}

.stat-box__value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.2;
}

.stat-box__label {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Groups Grid */
.groups-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

@media (max-width: 1024px) {
    .groups-grid {
        grid-template-columns: 1fr;
    }
}

/* Group Card */
.group-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.group-card__header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
}

.group-card__avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    flex-shrink: 0;
}

.group-card__info {
    flex: 1;
    min-width: 0;
}

.group-card__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.group-card__desc {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 2px 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.group-card__menu {
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

.group-card__menu:hover {
    background: rgba(0, 0, 0, 0.04);
    color: #1a1a2e;
}

.group-card__body {
    padding: 16px;
}

.group-card__stats {
    display: flex;
    gap: 16px;
    margin-bottom: 14px;
}

.group-card__stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    color: #6b7280;
}

.group-card__stat svg {
    color: #9ca3af;
}

.group-card__progress {
    margin-bottom: 0;
}

.group-card__progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.group-card__progress-header span {
    font-size: 0.75rem;
    color: #6b7280;
}

.group-card__points {
    font-weight: 600;
    color: #1a1a2e !important;
}

.group-card__progress-bar {
    height: 6px;
    background: rgba(0, 0, 0, 0.06);
    border-radius: 3px;
    overflow: hidden;
}

.group-card__progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #a78bfa, #8b5cf6);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.group-card__footer {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    background: rgba(0, 0, 0, 0.02);
    border-top: 1px solid rgba(0, 0, 0, 0.04);
}

.group-card__footer .btn {
    flex: 1;
}

/* Buttons */
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
}

.btn--primary {
    background: #8b5cf6;
    color: white;
}

.btn--primary:hover {
    background: #7c3aed;
}

.btn--ghost {
    background: transparent;
    color: #6b7280;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.btn--ghost:hover {
    background: rgba(0, 0, 0, 0.04);
    color: #1a1a2e;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
