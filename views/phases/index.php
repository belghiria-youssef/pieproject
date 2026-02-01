<?php
$pageTitle = 'Phases & Points';
$pageSubtitle = 'Gérez les phases de formation et attribuez les points';
$currentPage = 'phases';
$breadcrumb = 'Phases & Points';

// Demo data
$phases = [
    [
        'id' => 1,
        'nom' => 'Phase 1 - Initiation',
        'description' => 'Découverte des concepts de base et prise en main des outils',
        'points_max' => 100,
        'criteres' => ['Participation active', 'Exercices pratiques', 'Quiz de validation'],
        'ordre' => 1,
        'color' => '#8b5cf6'
    ],
    [
        'id' => 2,
        'nom' => 'Phase 2 - Fondamentaux',
        'description' => 'Maîtrise des fondamentaux techniques et méthodologiques',
        'points_max' => 120,
        'criteres' => ['Mini-projet individuel', 'Présentation orale', 'Documentation'],
        'ordre' => 2,
        'color' => '#6366f1'
    ],
    [
        'id' => 3,
        'nom' => 'Phase 3 - Approfondissement',
        'description' => 'Approfondissement des compétences et travail en équipe',
        'points_max' => 120,
        'criteres' => ['Projet d\'équipe', 'Code review', 'Tests unitaires'],
        'ordre' => 3,
        'color' => '#3b82f6'
    ],
    [
        'id' => 4,
        'nom' => 'Phase 4 - Projet Final',
        'description' => 'Réalisation du projet final en conditions réelles',
        'points_max' => 100,
        'criteres' => ['Qualité du code', 'Fonctionnalités', 'Respect des délais'],
        'ordre' => 4,
        'color' => '#10b981'
    ],
    [
        'id' => 5,
        'nom' => 'Phase 5 - Soutenance',
        'description' => 'Présentation et défense du projet devant le jury',
        'points_max' => 80,
        'criteres' => ['Clarté de la présentation', 'Réponses aux questions', 'Démonstration'],
        'ordre' => 5,
        'color' => '#f59e0b'
    ],
];

$groupes = [
    ['id' => 1, 'nom' => 'Groupe A', 'points' => [100, 120, 115, 80, 70], 'total' => 485],
    ['id' => 2, 'nom' => 'Groupe B', 'points' => [95, 110, 105, 70, 40], 'total' => 420],
    ['id' => 3, 'nom' => 'Groupe C', 'points' => [100, 115, 95, 70, 0], 'total' => 380],
    ['id' => 4, 'nom' => 'Groupe D', 'points' => [90, 100, 90, 70, 0], 'total' => 350],
    ['id' => 5, 'nom' => 'Groupe E', 'points' => [85, 100, 0, 0, 0], 'total' => 185],
];

$totalPointsMax = array_sum(array_column($phases, 'points_max'));

$pageActions = '
<button class="btn btn-primary" onclick="openModal(\'addPhaseModal\')" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
    <svg width="18" height="18"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
    Nouvelle phase
</button>
';

ob_start();
?>

<style>
/* Stats Row */
.phases-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.phases-stat-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
}

.phases-stat-box__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.phases-stat-box__icon svg {
    width: 24px;
    height: 24px;
    color: white;
}

.phases-stat-box__value {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.phases-stat-box__label {
    font-size: 14px;
    color: #64748b;
}

/* Tabs */
.phases-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 0;
}

.phases-tab-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: -1px;
}

.phases-tab-btn:hover {
    color: #8b5cf6;
}

.phases-tab-btn.active {
    color: #8b5cf6;
    border-bottom-color: #8b5cf6;
}

.phases-tab-btn svg {
    width: 18px;
    height: 18px;
}

.phases-tab-content {
    display: none;
}

.phases-tab-content.active {
    display: block;
}

/* Timeline */
.phases-timeline {
    position: relative;
}

.phase-item {
    display: flex;
    gap: 20px;
    margin-bottom: 24px;
}

.phase-item:last-child {
    margin-bottom: 0;
}

.phase-connector {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 48px;
}

.phase-number {
    width: 48px;
    height: 48px;
    background: #8b5cf6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    z-index: 1;
    flex-shrink: 0;
}

.phase-line {
    width: 3px;
    flex: 1;
    background: #e2e8f0;
    margin-top: 8px;
    border-radius: 2px;
}

.phase-card {
    flex: 1;
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.phase-card__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.phase-card__info h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
}

.phase-card__info p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

.phase-points-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px 16px;
    background: #f3e8ff;
    border-radius: 10px;
}

.phase-points-badge__value {
    font-size: 20px;
    font-weight: 700;
    color: #8b5cf6;
}

.phase-points-badge__label {
    font-size: 12px;
    color: #64748b;
}

.phase-card__body {
    padding: 20px;
}

.phase-card__body h4 {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    margin: 0 0 12px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.criteria-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.criteria-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    color: #475569;
    font-size: 14px;
}

.criteria-list li svg {
    width: 18px;
    height: 18px;
    color: #10b981;
    flex-shrink: 0;
}

.phase-card__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 20px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
}

/* Summary Card */
.phases-summary {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-top: 24px;
}

.phases-summary__row {
    display: flex;
    justify-content: space-around;
    text-align: center;
}

.phases-summary__item {
    padding: 0 20px;
}

.phases-summary__label {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 4px;
}

.phases-summary__value {
    font-size: 28px;
    font-weight: 700;
    color: #8b5cf6;
}

/* Attribution Table */
.attribution-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.attribution-card__header {
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.attribution-card__header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.attribution-table {
    width: 100%;
    border-collapse: collapse;
}

.attribution-table th,
.attribution-table td {
    padding: 14px 16px;
    text-align: left;
}

.attribution-table th {
    background: #f8fafc;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.attribution-table td {
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #1a1a2e;
}

.attribution-table tr:last-child td {
    border-bottom: none;
}

.attribution-table tr:hover td {
    background: #f8fafc;
}

.attribution-table .text-center {
    text-align: center;
}

.attribution-groupe {
    display: flex;
    align-items: center;
    gap: 12px;
}

.attribution-groupe__avatar {
    width: 36px;
    height: 36px;
    background: #8b5cf6;
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.attribution-groupe__name {
    font-weight: 500;
}

.points-cell {
    font-weight: 600;
}

.points-cell.success { color: #10b981; }
.points-cell.warning { color: #f59e0b; }
.points-cell.danger { color: #ef4444; }
.points-cell.muted { color: #94a3b8; }

.total-badge {
    display: inline-flex;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.total-badge.success {
    background: #dcfce7;
    color: #16a34a;
}

.total-badge.secondary {
    background: #f1f5f9;
    color: #64748b;
}

/* Ranking */
.ranking-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.ranking-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.ranking-card__header {
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.ranking-card__header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.ranking-card__body {
    padding: 20px;
}

.ranking-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.ranking-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 16px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.ranking-position {
    min-width: 36px;
    text-align: center;
}

.rank-medal {
    font-size: 24px;
}

.rank-number {
    width: 28px;
    height: 28px;
    background: #e2e8f0;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.ranking-info {
    flex: 1;
}

.ranking-info__name {
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 6px;
}

.ranking-progress {
    width: 100%;
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}

.ranking-progress__bar {
    height: 100%;
    background: linear-gradient(90deg, #8b5cf6, #6366f1);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.ranking-score {
    text-align: right;
}

.ranking-score__value {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
}

.ranking-score__label {
    font-size: 12px;
    color: #64748b;
}

.eligible-badge {
    padding: 4px 10px;
    background: #dcfce7;
    color: #16a34a;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

/* Chart Container */
.chart-container {
    height: 300px;
    position: relative;
}

/* Buttons */
.phases-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.phases-btn svg {
    width: 16px;
    height: 16px;
}

.phases-btn--ghost {
    background: transparent;
    color: #64748b;
}

.phases-btn--ghost:hover {
    background: #f1f5f9;
    color: #1a1a2e;
}

.phases-btn--primary {
    background: #8b5cf6;
    color: white;
}

.phases-btn--primary:hover {
    background: #7c3aed;
}

.phases-btn--sm {
    padding: 6px 12px;
    font-size: 13px;
}

/* Modal */
.phases-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.phases-modal-backdrop.active {
    display: flex;
}

.phases-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.phases-modal--lg {
    max-width: 700px;
}

.phases-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
}

.phases-modal__header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.phases-modal__close {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    color: #64748b;
}

.phases-modal__close:hover {
    background: #f1f5f9;
}

.phases-modal__body {
    padding: 24px;
    max-height: calc(90vh - 140px);
    overflow-y: auto;
}

.phases-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
}

/* Form Elements */
.phases-form-group {
    margin-bottom: 20px;
}

.phases-form-group:last-child {
    margin-bottom: 0;
}

.phases-form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.phases-form-label .required {
    color: #ef4444;
}

.phases-form-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.phases-form-input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.phases-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Points Form */
.points-form-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.points-form-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.points-phase-info {
    display: flex;
    flex-direction: column;
}

.points-phase-info__name {
    font-weight: 500;
    color: #1a1a2e;
}

.points-phase-info__desc {
    font-size: 13px;
    color: #64748b;
}

.points-input-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.points-input-group input {
    width: 80px;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
}

.points-input-group input:focus {
    outline: none;
    border-color: #8b5cf6;
}

.points-max {
    color: #64748b;
    font-size: 14px;
}

.points-total-display {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
    padding: 16px 20px;
    background: #f3e8ff;
    border-radius: 10px;
    margin-top: 16px;
    font-weight: 500;
}

.points-total-value {
    font-size: 20px;
    font-weight: 700;
    color: #8b5cf6;
}

/* Criteria Input */
.criteria-input-row {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
}

.criteria-input-row input {
    flex: 1;
}

.criteria-input-row button {
    padding: 8px;
}

@media (max-width: 1024px) {
    .phases-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .ranking-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .phases-stats {
        grid-template-columns: 1fr;
    }
    
    .phases-form-row {
        grid-template-columns: 1fr;
    }
    
    .phase-item {
        flex-direction: column;
    }
    
    .phase-connector {
        flex-direction: row;
    }
    
    .phase-line {
        width: auto;
        height: 3px;
        margin-top: 0;
        margin-left: 8px;
        flex: 1;
    }
}
</style>

<!-- Tabs -->
<div class="phases-tabs">
    <button class="phases-tab-btn active" data-tab="phases-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-layers"/></svg>
        Phases
    </button>
    <button class="phases-tab-btn" data-tab="attribution-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-star"/></svg>
        Attribution des Points
    </button>
    <button class="phases-tab-btn" data-tab="overview-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-bar-chart"/></svg>
        Vue d'ensemble
    </button>
</div>

<!-- Phases Tab -->
<div class="phases-tab-content active" id="phases-tab">
    <div class="phases-timeline">
        <?php foreach ($phases as $index => $phase): ?>
        <div class="phase-item">
            <div class="phase-connector">
                <div class="phase-number" style="background: <?= $phase['color'] ?>;"><?= $phase['ordre'] ?></div>
                <?php if ($index < count($phases) - 1): ?>
                <div class="phase-line"></div>
                <?php endif; ?>
            </div>
            
            <div class="phase-card">
                <div class="phase-card__header">
                    <div class="phase-card__info">
                        <h3><?= htmlspecialchars($phase['nom']) ?></h3>
                        <p><?= htmlspecialchars($phase['description']) ?></p>
                    </div>
                    <div class="phase-points-badge">
                        <span class="phase-points-badge__value"><?= $phase['points_max'] ?></span>
                        <span class="phase-points-badge__label">pts max</span>
                    </div>
                </div>
                <div class="phase-card__body">
                    <h4>Critères d'évaluation</h4>
                    <ul class="criteria-list">
                        <?php foreach ($phase['criteres'] as $critere): ?>
                        <li>
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check-circle"/></svg>
                            <?= htmlspecialchars($critere) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="phase-card__footer">
                    <button class="phases-btn phases-btn--ghost phases-btn--sm" onclick="editPhase(<?= $phase['id'] ?>)">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                        Modifier
                    </button>
                    <button class="phases-btn phases-btn--primary phases-btn--sm" onclick="attributePoints(<?= $phase['id'] ?>)">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-star"/></svg>
                        Attribuer des points
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="phases-summary">
        <div class="phases-summary__row">
            <div class="phases-summary__item">
                <div class="phases-summary__label">Nombre de phases</div>
                <div class="phases-summary__value"><?= count($phases) ?></div>
            </div>
            <div class="phases-summary__item">
                <div class="phases-summary__label">Points totaux possibles</div>
                <div class="phases-summary__value"><?= $totalPointsMax ?></div>
            </div>
            <div class="phases-summary__item">
                <div class="phases-summary__label">Seuil certificat</div>
                <div class="phases-summary__value">400 pts</div>
            </div>
        </div>
    </div>
</div>

<!-- Attribution Tab -->
<div class="phases-tab-content" id="attribution-tab">
    <div class="attribution-card">
        <div class="attribution-card__header">
            <h3>Attribution des Points par Groupe</h3>
        </div>
        <table class="attribution-table">
            <thead>
                <tr>
                    <th>Groupe</th>
                    <?php foreach ($phases as $phase): ?>
                    <th class="text-center">
                        P<?= $phase['ordre'] ?><br>
                        <small style="color: #94a3b8; font-weight: 400;">/ <?= $phase['points_max'] ?></small>
                    </th>
                    <?php endforeach; ?>
                    <th class="text-center">Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groupes as $groupe): ?>
                <tr>
                    <td>
                        <div class="attribution-groupe">
                            <div class="attribution-groupe__avatar"><?= substr($groupe['nom'], -1) ?></div>
                            <span class="attribution-groupe__name"><?= htmlspecialchars($groupe['nom']) ?></span>
                        </div>
                    </td>
                    <?php foreach ($groupe['points'] as $index => $points): 
                        $maxPoints = $phases[$index]['points_max'];
                        $percent = ($points / $maxPoints) * 100;
                        $colorClass = $points === 0 ? 'muted' : ($percent >= 80 ? 'success' : ($percent >= 50 ? 'warning' : 'danger'));
                    ?>
                    <td class="text-center">
                        <span class="points-cell <?= $colorClass ?>"><?= $points ?></span>
                    </td>
                    <?php endforeach; ?>
                    <td class="text-center">
                        <span class="total-badge <?= $groupe['total'] >= 400 ? 'success' : 'secondary' ?>">
                            <?= $groupe['total'] ?>
                        </span>
                    </td>
                    <td>
                        <button class="phases-btn phases-btn--primary phases-btn--sm" onclick="editGroupPoints(<?= $groupe['id'] ?>)">
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                            Modifier
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Overview Tab -->
<div class="phases-tab-content" id="overview-tab">
    <div class="ranking-grid">
        <!-- Chart -->
        <div class="ranking-card">
            <div class="ranking-card__header">
                <h3>Comparaison des Groupes</h3>
            </div>
            <div class="ranking-card__body">
                <div class="chart-container">
                    <canvas id="groupsComparisonChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Ranking -->
        <div class="ranking-card">
            <div class="ranking-card__header">
                <h3>Classement Actuel</h3>
            </div>
            <div class="ranking-card__body">
                <div class="ranking-list">
                    <?php 
                    usort($groupes, fn($a, $b) => $b['total'] - $a['total']);
                    foreach ($groupes as $index => $groupe): 
                    ?>
                    <div class="ranking-item">
                        <div class="ranking-position">
                            <?php if ($index === 0): ?>
                            <span class="rank-medal">🥇</span>
                            <?php elseif ($index === 1): ?>
                            <span class="rank-medal">🥈</span>
                            <?php elseif ($index === 2): ?>
                            <span class="rank-medal">🥉</span>
                            <?php else: ?>
                            <span class="rank-number"><?= $index + 1 ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="ranking-info">
                            <div class="ranking-info__name"><?= htmlspecialchars($groupe['nom']) ?></div>
                            <div class="ranking-progress">
                                <div class="ranking-progress__bar" style="width: <?= ($groupe['total'] / $totalPointsMax) * 100 ?>%"></div>
                            </div>
                        </div>
                        <div class="ranking-score">
                            <div class="ranking-score__value"><?= $groupe['total'] ?></div>
                            <div class="ranking-score__label">pts</div>
                        </div>
                        <?php if ($groupe['total'] >= 400): ?>
                        <span class="eligible-badge">Éligible</span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Phases Progress Chart -->
    <div class="ranking-card" style="margin-top: 24px;">
        <div class="ranking-card__header">
            <h3>Progression par Phase</h3>
        </div>
        <div class="ranking-card__body">
            <div class="chart-container">
                <canvas id="phasesProgressChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Phase Modal -->
<div class="phases-modal-backdrop" id="addPhaseModal">
    <div class="phases-modal">
        <div class="phases-modal__header">
            <h3 id="phaseModalTitle">Nouvelle Phase</h3>
            <button class="phases-modal__close" onclick="closeModal('addPhaseModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form id="phaseForm" onsubmit="savePhase(event)">
            <div class="phases-modal__body">
                <input type="hidden" id="phaseId" name="id">
                
                <div class="phases-form-group">
                    <label class="phases-form-label">Nom de la phase <span class="required">*</span></label>
                    <input type="text" id="phaseNom" name="nom" class="phases-form-input" required>
                </div>
                
                <div class="phases-form-group">
                    <label class="phases-form-label">Description</label>
                    <textarea id="phaseDescription" name="description" class="phases-form-input" rows="2"></textarea>
                </div>
                
                <div class="phases-form-row">
                    <div class="phases-form-group">
                        <label class="phases-form-label">Points maximum <span class="required">*</span></label>
                        <input type="number" id="phasePointsMax" name="points_max" class="phases-form-input" min="1" required>
                    </div>
                    <div class="phases-form-group">
                        <label class="phases-form-label">Ordre</label>
                        <input type="number" id="phaseOrdre" name="ordre" class="phases-form-input" min="1">
                    </div>
                </div>
                
                <div class="phases-form-group">
                    <label class="phases-form-label">Critères d'évaluation</label>
                    <div id="criteriaContainer">
                        <div class="criteria-input-row">
                            <input type="text" name="criteres[]" class="phases-form-input" placeholder="Critère 1">
                            <button type="button" class="phases-btn phases-btn--ghost" onclick="removeCriteria(this)">
                                <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="phases-btn phases-btn--ghost phases-btn--sm" style="margin-top: 8px;" onclick="addCriteria()">
                        <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
                        Ajouter un critère
                    </button>
                </div>
            </div>
            <div class="phases-modal__footer">
                <button type="button" class="phases-btn phases-btn--ghost" onclick="closeModal('addPhaseModal')">Annuler</button>
                <button type="submit" class="phases-btn phases-btn--primary">
                    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Group Points Modal -->
<div class="phases-modal-backdrop" id="groupPointsModal">
    <div class="phases-modal phases-modal--lg">
        <div class="phases-modal__header">
            <h3>Modifier les Points - <span id="groupPointsName">Groupe A</span></h3>
            <button class="phases-modal__close" onclick="closeModal('groupPointsModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form onsubmit="saveGroupPoints(event)">
            <div class="phases-modal__body">
                <input type="hidden" id="groupPointsId">
                
                <div class="points-form-grid">
                    <?php foreach ($phases as $phase): ?>
                    <div class="points-form-item">
                        <div class="points-phase-info">
                            <span class="points-phase-info__name"><?= htmlspecialchars($phase['nom']) ?></span>
                            <span class="points-phase-info__desc"><?= htmlspecialchars($phase['description']) ?></span>
                        </div>
                        <div class="points-input-group">
                            <input type="number" name="phase_<?= $phase['id'] ?>" class="phase-input" 
                                   min="0" max="<?= $phase['points_max'] ?>" value="0"
                                   data-max="<?= $phase['points_max'] ?>">
                            <span class="points-max">/ <?= $phase['points_max'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="points-total-display">
                    <span>Total des points:</span>
                    <span class="points-total-value" id="groupTotalPoints">0</span>
                    <span>/ <?= $totalPointsMax ?></span>
                </div>
            </div>
            <div class="phases-modal__footer">
                <button type="button" class="phases-btn phases-btn--ghost" onclick="closeModal('groupPointsModal')">Annuler</button>
                <button type="submit" class="phases-btn phases-btn--primary">
                    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tab functionality
document.querySelectorAll('.phases-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.phases-tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const targetId = this.dataset.tab;
        document.querySelectorAll('.phases-tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(targetId).classList.add('active');
        
        // Initialize charts when overview tab is shown
        if (targetId === 'overview-tab') {
            initCharts();
        }
    });
});

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

// Charts
function initCharts() {
    // Groups Comparison Chart
    const compCtx = document.getElementById('groupsComparisonChart');
    if (compCtx && !compCtx.chart) {
        compCtx.chart = new Chart(compCtx, {
            type: 'bar',
            data: {
                labels: ['Groupe A', 'Groupe B', 'Groupe C', 'Groupe D', 'Groupe E'],
                datasets: [
                    { label: 'Phase 1', data: [100, 95, 100, 90, 85], backgroundColor: '#a78bfa' },
                    { label: 'Phase 2', data: [120, 110, 115, 100, 100], backgroundColor: '#818cf8' },
                    { label: 'Phase 3', data: [115, 105, 95, 90, 0], backgroundColor: '#6366f1' },
                    { label: 'Phase 4', data: [80, 70, 70, 70, 0], backgroundColor: '#4f46e5' },
                    { label: 'Phase 5', data: [70, 40, 0, 0, 0], backgroundColor: '#4338ca' }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, max: 520 }
                }
            }
        });
    }
    
    // Phases Progress Chart
    const progCtx = document.getElementById('phasesProgressChart');
    if (progCtx && !progCtx.chart) {
        progCtx.chart = new Chart(progCtx, {
            type: 'radar',
            data: {
                labels: ['Phase 1', 'Phase 2', 'Phase 3', 'Phase 4', 'Phase 5'],
                datasets: [
                    { label: 'Groupe A', data: [100, 100, 96, 80, 88], borderColor: '#a78bfa', backgroundColor: 'rgba(167, 139, 250, 0.1)' },
                    { label: 'Groupe B', data: [95, 92, 88, 70, 50], borderColor: '#818cf8', backgroundColor: 'rgba(129, 140, 248, 0.1)' },
                    { label: 'Groupe C', data: [100, 96, 79, 70, 0], borderColor: '#6366f1', backgroundColor: 'rgba(99, 102, 241, 0.1)' }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: { min: 0, max: 100 }
                }
            }
        });
    }
}

// Calculate total points
function updateGroupTotalPoints() {
    let total = 0;
    document.querySelectorAll('.phase-input').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    document.getElementById('groupTotalPoints').textContent = total;
}

document.querySelectorAll('.phase-input').forEach(input => {
    input.addEventListener('input', function() {
        const max = parseInt(this.dataset.max);
        if (parseInt(this.value) > max) this.value = max;
        updateGroupTotalPoints();
    });
});

// CRUD Operations
function editPhase(id) {
    document.getElementById('phaseModalTitle').textContent = 'Modifier la Phase';
    document.getElementById('phaseId').value = id;
    openModal('addPhaseModal');
}

function savePhase(e) {
    e.preventDefault();
    alert('Phase enregistrée avec succès');
    closeModal('addPhaseModal');
}

function attributePoints(phaseId) {
    document.querySelector('[data-tab="attribution-tab"]').click();
}

function editGroupPoints(groupId) {
    document.getElementById('groupPointsId').value = groupId;
    document.getElementById('groupPointsName').textContent = 'Groupe ' + String.fromCharCode(64 + groupId);
    updateGroupTotalPoints();
    openModal('groupPointsModal');
}

function saveGroupPoints(e) {
    e.preventDefault();
    alert('Points mis à jour avec succès');
    closeModal('groupPointsModal');
}

// Criteria management
function addCriteria() {
    const container = document.getElementById('criteriaContainer');
    const count = container.children.length + 1;
    const row = document.createElement('div');
    row.className = 'criteria-input-row';
    row.innerHTML = `
        <input type="text" name="criteres[]" class="phases-form-input" placeholder="Critère ${count}">
        <button type="button" class="phases-btn phases-btn--ghost" onclick="removeCriteria(this)">
            <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
        </button>
    `;
    container.appendChild(row);
}

function removeCriteria(btn) {
    const container = document.getElementById('criteriaContainer');
    if (container.children.length > 1) {
        btn.closest('.criteria-input-row').remove();
    }
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
