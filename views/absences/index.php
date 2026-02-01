<?php
$pageTitle = 'Gestion des Absences';
$pageSubtitle = 'Suivez les absences de vos groupes';
$currentPage = 'absences';
$breadcrumb = 'Absences';

// Demo data - Groups with students
$groupes = [
    [
        'id' => 1, 
        'nom' => 'Groupe A', 
        'color' => '#8b5cf6',
        'etudiants' => [
            ['id' => 1, 'nom' => 'Marie Dupont', 'absences' => 4, 'retards' => 1, 'justifiees' => 2],
            ['id' => 2, 'nom' => 'Sophie Bernard', 'absences' => 2, 'retards' => 0, 'justifiees' => 2],
            ['id' => 3, 'nom' => 'Hugo Richard', 'absences' => 1, 'retards' => 2, 'justifiees' => 1],
            ['id' => 4, 'nom' => 'Léa Martin', 'absences' => 0, 'retards' => 1, 'justifiees' => 0],
            ['id' => 5, 'nom' => 'Nicolas Petit', 'absences' => 3, 'retards' => 0, 'justifiees' => 1],
        ]
    ],
    [
        'id' => 2, 
        'nom' => 'Groupe B', 
        'color' => '#3b82f6',
        'etudiants' => [
            ['id' => 6, 'nom' => 'Lucas Martin', 'absences' => 2, 'retards' => 3, 'justifiees' => 2],
            ['id' => 7, 'nom' => 'Emma Robert', 'absences' => 1, 'retards' => 1, 'justifiees' => 1],
            ['id' => 8, 'nom' => 'Nathan Leroy', 'absences' => 0, 'retards' => 2, 'justifiees' => 1],
            ['id' => 9, 'nom' => 'Camille Durand', 'absences' => 5, 'retards' => 0, 'justifiees' => 2],
        ]
    ],
    [
        'id' => 3, 
        'nom' => 'Groupe C', 
        'color' => '#10b981',
        'etudiants' => [
            ['id' => 10, 'nom' => 'Thomas Petit', 'absences' => 3, 'retards' => 1, 'justifiees' => 1],
            ['id' => 11, 'nom' => 'Julie Moreau', 'absences' => 0, 'retards' => 0, 'justifiees' => 0],
            ['id' => 12, 'nom' => 'Antoine Blanc', 'absences' => 2, 'retards' => 2, 'justifiees' => 2],
            ['id' => 13, 'nom' => 'Clara Roux', 'absences' => 1, 'retards' => 0, 'justifiees' => 0],
        ]
    ],
    [
        'id' => 4, 
        'nom' => 'Groupe D', 
        'color' => '#f59e0b',
        'etudiants' => [
            ['id' => 14, 'nom' => 'Maxime Girard', 'absences' => 2, 'retards' => 1, 'justifiees' => 1],
            ['id' => 15, 'nom' => 'Chloé Lambert', 'absences' => 0, 'retards' => 1, 'justifiees' => 0],
            ['id' => 16, 'nom' => 'Paul Mercier', 'absences' => 4, 'retards' => 0, 'justifiees' => 3],
        ]
    ],
];

$pageActions = '';

ob_start();
?>

<style>
/* Group Selector */
.group-selector {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 24px;
}

.group-selector__label {
    font-size: 14px;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 12px;
    display: block;
}

.group-selector__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
}

.group-selector__item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.group-selector__item:hover {
    border-color: #8b5cf6;
    background: #f8f5ff;
}

.group-selector__item.active {
    border-color: #8b5cf6;
    background: #f3e8ff;
}

.group-selector__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.group-selector__icon svg {
    width: 20px;
    height: 20px;
    color: white;
}

.group-selector__info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 2px 0;
}

.group-selector__info p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

/* Stats Row */
.absences-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.absences-stat-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
}

.absences-stat-box__value {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 4px;
}

.absences-stat-box__label {
    font-size: 13px;
    color: #64748b;
}

/* Content Area */
.absences-content {
    display: none;
}

.absences-content.active {
    display: block;
}

/* Actions Bar */
.absences-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.absences-actions__title {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.absences-actions__title span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.absences-actions__buttons {
    display: flex;
    gap: 12px;
}

/* Table Card */
.absences-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.absences-table {
    width: 100%;
    border-collapse: collapse;
}

.absences-table th,
.absences-table td {
    padding: 14px 20px;
    text-align: left;
}

.absences-table th {
    background: #f8fafc;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e2e8f0;
}

.absences-table td {
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #1a1a2e;
}

.absences-table tr:last-child td {
    border-bottom: none;
}

.absences-table tr:hover td {
    background: #f8fafc;
}

.absences-table .text-center {
    text-align: center;
}

/* Checkbox */
.student-checkbox {
    width: 20px;
    height: 20px;
    border: 2px solid #e2e8f0;
    border-radius: 4px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background: white;
    transition: all 0.2s;
    flex-shrink: 0;
}

.student-checkbox:checked {
    background: #8b5cf6;
    border-color: #8b5cf6;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'%3E%3Cpath d='M5 13l4 4L19 7'/%3E%3C/svg%3E");
    background-size: 14px;
    background-position: center;
    background-repeat: no-repeat;
}

.student-checkbox:hover {
    border-color: #8b5cf6;
}

/* Selection Bar */
.selection-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    background: #f3e8ff;
    border-radius: 10px;
    margin-bottom: 16px;
}

.selection-bar.active {
    display: flex;
}

.selection-bar__info {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: #6b21a8;
    font-weight: 500;
}

.selection-bar__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 8px;
    background: #8b5cf6;
    color: white;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
}

.selection-bar__actions {
    display: flex;
    gap: 8px;
}

/* Student Cell */
.student-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.student-cell__avatar {
    width: 36px;
    height: 36px;
    background: #8b5cf6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 13px;
    flex-shrink: 0;
}

.student-cell__name {
    font-weight: 500;
}

/* Count Badges */
.count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    padding: 0 8px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
}

.count-badge--danger {
    background: #fef2f2;
    color: #dc2626;
}

.count-badge--warning {
    background: #fffbeb;
    color: #d97706;
}

.count-badge--success {
    background: #f0fdf4;
    color: #16a34a;
}

.count-badge--zero {
    background: #f1f5f9;
    color: #94a3b8;
}

/* Progress Bar */
.justify-progress {
    display: flex;
    align-items: center;
    gap: 10px;
}

.justify-progress__bar {
    flex: 1;
    height: 8px;
    background: #fef2f2;
    border-radius: 4px;
    overflow: hidden;
    max-width: 80px;
}

.justify-progress__fill {
    height: 100%;
    background: #10b981;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.justify-progress__text {
    font-size: 13px;
    color: #64748b;
    min-width: 45px;
}

/* Action Button */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    color: #64748b;
    transition: all 0.2s;
}

.action-btn:hover {
    background: #f1f5f9;
    color: #1a1a2e;
}

.action-btn svg {
    width: 18px;
    height: 18px;
}

/* Buttons */
.absences-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.absences-btn svg {
    width: 18px;
    height: 18px;
}

.absences-btn--ghost {
    background: transparent;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.absences-btn--ghost:hover {
    background: #f1f5f9;
    color: #1a1a2e;
}

.absences-btn--primary {
    background: #8b5cf6;
    color: white;
}

.absences-btn--primary:hover {
    background: #7c3aed;
}

.absences-btn--success {
    background: #10b981;
    color: white;
}

.absences-btn--success:hover {
    background: #059669;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state__icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-state__icon svg {
    width: 40px;
    height: 40px;
    color: #94a3b8;
}

.empty-state__title {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 8px 0;
}

.empty-state__text {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

/* Modal */
.absences-modal-backdrop {
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

.absences-modal-backdrop.active {
    display: flex;
}

.absences-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.absences-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
}

.absences-modal__header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.absences-modal__close {
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

.absences-modal__close:hover {
    background: #f1f5f9;
}

.absences-modal__body {
    padding: 24px;
    max-height: calc(90vh - 140px);
    overflow-y: auto;
}

.absences-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
}

/* Form Elements */
.absences-form-group {
    margin-bottom: 20px;
}

.absences-form-group:last-child {
    margin-bottom: 0;
}

.absences-form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.absences-form-input,
.absences-form-select {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.absences-form-input:focus,
.absences-form-select:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.absences-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Student Detail in Modal */
.student-detail {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #f8fafc;
    border-radius: 10px;
    margin-bottom: 20px;
}

.student-detail__avatar {
    width: 48px;
    height: 48px;
    background: #8b5cf6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}

.student-detail__info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
}

.student-detail__info p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Export Options */
.export-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.export-option {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.export-option:hover {
    border-color: #8b5cf6;
    background: #f8f5ff;
}

.export-option__icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.export-option__icon svg {
    width: 22px;
    height: 22px;
    color: white;
}

.export-option__info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 2px 0;
}

.export-option__info p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

@media (max-width: 768px) {
    .absences-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .group-selector__grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .absences-actions {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .absences-form-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .absences-stats {
        grid-template-columns: 1fr;
    }
    
    .group-selector__grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Group Selector -->
<div class="group-selector">
    <label class="group-selector__label">Sélectionnez un groupe pour voir les absences</label>
    <div class="group-selector__grid">
        <?php foreach ($groupes as $groupe): 
            $totalAbsences = array_sum(array_column($groupe['etudiants'], 'absences'));
            $totalRetards = array_sum(array_column($groupe['etudiants'], 'retards'));
        ?>
        <div class="group-selector__item" data-group="<?= $groupe['id'] ?>" onclick="selectGroup(<?= $groupe['id'] ?>)">
            <div class="group-selector__icon" style="background: <?= $groupe['color'] ?>;">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-users"/></svg>
            </div>
            <div class="group-selector__info">
                <h4><?= htmlspecialchars($groupe['nom']) ?></h4>
                <p><?= count($groupe['etudiants']) ?> étudiants • <?= $totalAbsences ?> abs.</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Content for each group -->
<?php foreach ($groupes as $groupe): 
    $totalAbsences = array_sum(array_column($groupe['etudiants'], 'absences'));
    $totalRetards = array_sum(array_column($groupe['etudiants'], 'retards'));
    $totalJustifiees = array_sum(array_column($groupe['etudiants'], 'justifiees'));
    $totalNonJustifiees = $totalAbsences - $totalJustifiees;
?>
<div class="absences-content" id="group-<?= $groupe['id'] ?>">
    
    <!-- Stats -->
    <div class="absences-stats">
        <div class="absences-stat-box">
            <div class="absences-stat-box__value" style="color: #dc2626;"><?= $totalAbsences ?></div>
            <div class="absences-stat-box__label">Absences totales</div>
        </div>
        <div class="absences-stat-box">
            <div class="absences-stat-box__value" style="color: #d97706;"><?= $totalRetards ?></div>
            <div class="absences-stat-box__label">Retards</div>
        </div>
        <div class="absences-stat-box">
            <div class="absences-stat-box__value" style="color: #16a34a;"><?= $totalJustifiees ?></div>
            <div class="absences-stat-box__label">Justifiées</div>
        </div>
        <div class="absences-stat-box">
            <div class="absences-stat-box__value" style="color: #64748b;"><?= $totalNonJustifiees ?></div>
            <div class="absences-stat-box__label">Non justifiées</div>
        </div>
    </div>
    
    <!-- Actions Bar -->
    <div class="absences-actions">
        <h2 class="absences-actions__title">
            <?= htmlspecialchars($groupe['nom']) ?>
            <span style="background: <?= $groupe['color'] ?>20; color: <?= $groupe['color'] ?>;">
                <?= count($groupe['etudiants']) ?> étudiants
            </span>
        </h2>
        <div class="absences-actions__buttons">
            <button class="absences-btn absences-btn--ghost" onclick="openModal('exportModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
                Exporter
            </button>
            <button class="absences-btn absences-btn--primary" onclick="openAddAbsenceModal(<?= $groupe['id'] ?>)">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
                Déclarer une absence
            </button>
        </div>
    </div>
    
    <!-- Selection Bar -->
    <div class="selection-bar" id="selectionBar-<?= $groupe['id'] ?>">
        <div class="selection-bar__info">
            <span class="selection-bar__count" id="selectedCount-<?= $groupe['id'] ?>">0</span>
            <span>étudiant(s) sélectionné(s)</span>
        </div>
        <div class="selection-bar__actions">
            <button class="absences-btn absences-btn--ghost" onclick="clearSelection(<?= $groupe['id'] ?>)">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
                Annuler
            </button>
            <button class="absences-btn absences-btn--primary" onclick="declareAbsenceForSelected(<?= $groupe['id'] ?>)">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-user-x"/></svg>
                Déclarer absents
            </button>
        </div>
    </div>
    
    <!-- Table -->
    <div class="absences-table-card">
        <table class="absences-table">
            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox" class="student-checkbox" id="selectAll-<?= $groupe['id'] ?>" onchange="toggleSelectAll(<?= $groupe['id'] ?>)">
                    </th>
                    <th>Étudiant</th>
                    <th class="text-center">Absences</th>
                    <th class="text-center">Retards</th>
                    <th>Justification</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groupe['etudiants'] as $etudiant): 
                    $initials = implode('', array_map(fn($p) => strtoupper(substr($p, 0, 1)), explode(' ', $etudiant['nom'])));
                    $total = $etudiant['absences'] + $etudiant['retards'];
                    $justifyPercent = $total > 0 ? round(($etudiant['justifiees'] / $total) * 100) : 100;
                ?>
                <tr data-student-id="<?= $etudiant['id'] ?>" data-student-name="<?= htmlspecialchars($etudiant['nom']) ?>">
                    <td>
                        <input type="checkbox" class="student-checkbox student-check-<?= $groupe['id'] ?>" 
                               value="<?= $etudiant['id'] ?>" 
                               data-name="<?= htmlspecialchars($etudiant['nom']) ?>"
                               onchange="updateSelection(<?= $groupe['id'] ?>)">
                    </td>
                    <td>
                        <div class="student-cell">
                            <div class="student-cell__avatar" style="background: <?= $groupe['color'] ?>;"><?= $initials ?></div>
                            <span class="student-cell__name"><?= htmlspecialchars($etudiant['nom']) ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="count-badge <?= $etudiant['absences'] > 0 ? 'count-badge--danger' : 'count-badge--zero' ?>">
                            <?= $etudiant['absences'] ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="count-badge <?= $etudiant['retards'] > 0 ? 'count-badge--warning' : 'count-badge--zero' ?>">
                            <?= $etudiant['retards'] ?>
                        </span>
                    </td>
                    <td>
                        <div class="justify-progress">
                            <div class="justify-progress__bar">
                                <div class="justify-progress__fill" style="width: <?= $justifyPercent ?>%;"></div>
                            </div>
                            <span class="justify-progress__text"><?= $etudiant['justifiees'] ?>/<?= $total ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <button class="action-btn" title="Voir détails" onclick="viewStudentDetails(<?= $etudiant['id'] ?>, '<?= htmlspecialchars($etudiant['nom']) ?>')">
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<!-- Initial Empty State -->
<div class="absences-content active" id="empty-state">
    <div class="absences-table-card">
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-users"/></svg>
            </div>
            <h3 class="empty-state__title">Sélectionnez un groupe</h3>
            <p class="empty-state__text">Choisissez un groupe ci-dessus pour voir les absences des étudiants</p>
        </div>
    </div>
</div>

<!-- Add Absence Modal (for multiple students) -->
<div class="absences-modal-backdrop" id="addAbsenceModal">
    <div class="absences-modal">
        <div class="absences-modal__header">
            <h3 id="absenceModalTitle">Déclarer une absence</h3>
            <button class="absences-modal__close" onclick="closeModal('addAbsenceModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form onsubmit="saveAbsence(event)">
            <div class="absences-modal__body">
                <!-- Selected Students List -->
                <div class="absences-form-group" id="selectedStudentsList" style="display: none;">
                    <label class="absences-form-label">Étudiants sélectionnés</label>
                    <div id="selectedStudentsContainer" style="display: flex; flex-wrap: wrap; gap: 8px;"></div>
                </div>
                
                <div class="absences-form-row">
                    <div class="absences-form-group">
                        <label class="absences-form-label">Date</label>
                        <input type="date" class="absences-form-input" id="absenceDate" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="absences-form-group">
                        <label class="absences-form-label">Type</label>
                        <select class="absences-form-select" id="absenceType">
                            <option value="absence">Absence</option>
                            <option value="retard">Retard</option>
                        </select>
                    </div>
                </div>
                
                <div class="absences-form-group">
                    <label class="absences-form-label">Justifiée ?</label>
                    <select class="absences-form-select" id="absenceJustified">
                        <option value="0">Non justifiée</option>
                        <option value="1">Justifiée</option>
                    </select>
                </div>
                
                <div class="absences-form-group">
                    <label class="absences-form-label">Motif (optionnel)</label>
                    <textarea class="absences-form-input" id="absenceMotif" rows="2" placeholder="Raison de l'absence..."></textarea>
                </div>
            </div>
            <div class="absences-modal__footer">
                <button type="button" class="absences-btn absences-btn--ghost" onclick="closeModal('addAbsenceModal')">Annuler</button>
                <button type="submit" class="absences-btn absences-btn--primary">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Export Modal -->
<div class="absences-modal-backdrop" id="exportModal">
    <div class="absences-modal">
        <div class="absences-modal__header">
            <h3>Exporter les absences</h3>
            <button class="absences-modal__close" onclick="closeModal('exportModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="absences-modal__body">
            <p style="color: #64748b; font-size: 14px; margin: 0 0 20px 0;">Choisissez le format d'export pour les absences du groupe sélectionné</p>
            
            <div class="export-options">
                <div class="export-option" onclick="exportAs('pdf')">
                    <div class="export-option__icon" style="background: #ef4444;">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-file-text"/></svg>
                    </div>
                    <div class="export-option__info">
                        <h4>Exporter en PDF</h4>
                        <p>Document formaté prêt à imprimer</p>
                    </div>
                </div>
                
                <div class="export-option" onclick="exportAs('excel')">
                    <div class="export-option__icon" style="background: #10b981;">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-table"/></svg>
                    </div>
                    <div class="export-option__info">
                        <h4>Exporter en Excel</h4>
                        <p>Fichier .xlsx pour analyse détaillée</p>
                    </div>
                </div>
                
                <div class="export-option" onclick="exportAs('csv')">
                    <div class="export-option__icon" style="background: #3b82f6;">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
                    </div>
                    <div class="export-option__info">
                        <h4>Exporter en CSV</h4>
                        <p>Format simple pour import dans d'autres outils</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absences-modal__footer">
            <button type="button" class="absences-btn absences-btn--ghost" onclick="closeModal('exportModal')">Fermer</button>
        </div>
    </div>
</div>

<!-- Student Details Modal -->
<div class="absences-modal-backdrop" id="studentModal">
    <div class="absences-modal">
        <div class="absences-modal__header">
            <h3>Détails des absences</h3>
            <button class="absences-modal__close" onclick="closeModal('studentModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="absences-modal__body">
            <div class="student-detail">
                <div class="student-detail__avatar" id="studentModalAvatar">MD</div>
                <div class="student-detail__info">
                    <h4 id="studentModalName">Marie Dupont</h4>
                    <p id="studentModalGroup">Groupe A</p>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div style="text-align: center; padding: 12px; background: #fef2f2; border-radius: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #dc2626;">4</div>
                    <div style="font-size: 12px; color: #64748b;">Absences</div>
                </div>
                <div style="text-align: center; padding: 12px; background: #fffbeb; border-radius: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #d97706;">1</div>
                    <div style="font-size: 12px; color: #64748b;">Retards</div>
                </div>
                <div style="text-align: center; padding: 12px; background: #f0fdf4; border-radius: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #16a34a;">2</div>
                    <div style="font-size: 12px; color: #64748b;">Justifiées</div>
                </div>
            </div>
            
            <h4 style="font-size: 14px; font-weight: 600; color: #1a1a2e; margin: 0 0 12px 0;">Historique récent</h4>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border-radius: 8px;">
                    <span style="font-size: 13px; color: #1a1a2e;">28/01/2026</span>
                    <span style="padding: 4px 8px; background: #fef2f2; color: #dc2626; border-radius: 4px; font-size: 12px; font-weight: 500;">Absence</span>
                    <span style="font-size: 12px; color: #94a3b8;">Non justifiée</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border-radius: 8px;">
                    <span style="font-size: 13px; color: #1a1a2e;">25/01/2026</span>
                    <span style="padding: 4px 8px; background: #fef2f2; color: #dc2626; border-radius: 4px; font-size: 12px; font-weight: 500;">Absence</span>
                    <span style="font-size: 12px; color: #10b981;">Justifiée</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border-radius: 8px;">
                    <span style="font-size: 13px; color: #1a1a2e;">20/01/2026</span>
                    <span style="padding: 4px 8px; background: #fffbeb; color: #d97706; border-radius: 4px; font-size: 12px; font-weight: 500;">Retard</span>
                    <span style="font-size: 12px; color: #94a3b8;">Non justifié</span>
                </div>
            </div>
        </div>
        <div class="absences-modal__footer">
            <button type="button" class="absences-btn absences-btn--ghost" onclick="closeModal('studentModal')">Fermer</button>
            <button type="button" class="absences-btn absences-btn--primary" onclick="addAbsenceForStudent(1, 'Marie Dupont')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
                Ajouter une absence
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
let selectedGroup = null;
let selectedStudents = [];

// Select group
function selectGroup(groupId) {
    selectedGroup = groupId;
    selectedStudents = [];
    
    // Update selector UI
    document.querySelectorAll('.group-selector__item').forEach(item => {
        item.classList.remove('active');
        if (item.dataset.group == groupId) {
            item.classList.add('active');
        }
    });
    
    // Show corresponding content
    document.querySelectorAll('.absences-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById('group-' + groupId).classList.add('active');
    
    // Reset checkboxes
    clearSelection(groupId);
}

// Toggle select all
function toggleSelectAll(groupId) {
    const selectAllCheckbox = document.getElementById('selectAll-' + groupId);
    const checkboxes = document.querySelectorAll('.student-check-' + groupId);
    
    checkboxes.forEach(cb => {
        cb.checked = selectAllCheckbox.checked;
    });
    
    updateSelection(groupId);
}

// Update selection count and show/hide bar
function updateSelection(groupId) {
    const checkboxes = document.querySelectorAll('.student-check-' + groupId + ':checked');
    const selectionBar = document.getElementById('selectionBar-' + groupId);
    const countEl = document.getElementById('selectedCount-' + groupId);
    const selectAllCheckbox = document.getElementById('selectAll-' + groupId);
    const allCheckboxes = document.querySelectorAll('.student-check-' + groupId);
    
    selectedStudents = [];
    checkboxes.forEach(cb => {
        selectedStudents.push({
            id: cb.value,
            name: cb.dataset.name
        });
    });
    
    countEl.textContent = selectedStudents.length;
    
    if (selectedStudents.length > 0) {
        selectionBar.classList.add('active');
    } else {
        selectionBar.classList.remove('active');
    }
    
    // Update select all checkbox state
    selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
    selectAllCheckbox.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
}

// Clear selection
function clearSelection(groupId) {
    const checkboxes = document.querySelectorAll('.student-check-' + groupId);
    const selectAllCheckbox = document.getElementById('selectAll-' + groupId);
    const selectionBar = document.getElementById('selectionBar-' + groupId);
    
    checkboxes.forEach(cb => cb.checked = false);
    if (selectAllCheckbox) selectAllCheckbox.checked = false;
    if (selectionBar) selectionBar.classList.remove('active');
    
    selectedStudents = [];
}

// Declare absence for selected students
function declareAbsenceForSelected(groupId) {
    if (selectedStudents.length === 0) return;
    
    // Update modal title
    document.getElementById('absenceModalTitle').textContent = 
        selectedStudents.length === 1 
            ? 'Déclarer une absence' 
            : `Déclarer ${selectedStudents.length} absences`;
    
    // Show selected students in modal
    const container = document.getElementById('selectedStudentsContainer');
    const listDiv = document.getElementById('selectedStudentsList');
    
    container.innerHTML = selectedStudents.map(s => `
        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #f3e8ff; color: #6b21a8; border-radius: 20px; font-size: 13px; font-weight: 500;">
            ${s.name}
        </span>
    `).join('');
    
    listDiv.style.display = 'block';
    
    openModal('addAbsenceModal');
}

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    
    // Reset modal state when closing
    if (id === 'addAbsenceModal') {
        document.getElementById('selectedStudentsList').style.display = 'none';
        document.getElementById('selectedStudentsContainer').innerHTML = '';
    }
}

// View student details
function viewStudentDetails(studentId, studentName) {
    const initials = studentName.split(' ').map(n => n[0]).join('');
    document.getElementById('studentModalAvatar').textContent = initials;
    document.getElementById('studentModalName').textContent = studentName;
    openModal('studentModal');
}

// Save absence
function saveAbsence(e) {
    e.preventDefault();
    
    const count = selectedStudents.length || 1;
    const type = document.getElementById('absenceType').value;
    const typeLabel = type === 'absence' ? 'Absence(s)' : 'Retard(s)';
    
    alert(`${count} ${typeLabel} enregistrée(s) avec succès !`);
    
    // Clear selection after saving
    if (selectedGroup) {
        clearSelection(selectedGroup);
    }
    
    closeModal('addAbsenceModal');
}

// Export functions
function exportAs(format) {
    closeModal('exportModal');
    alert('Export en ' + format.toUpperCase() + ' en cours...');
    setTimeout(() => {
        alert('Export terminé !');
    }, 1000);
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
