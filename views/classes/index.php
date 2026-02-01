<?php
$pageTitle = 'Gestion des Classes';
$pageSubtitle = 'Planifiez les cours et gérez les présences';
$currentPage = 'classes';
$breadcrumb = 'Classes';

// Demo data
$classes = [
    ['id' => 1, 'titre' => 'Introduction à PHP', 'formateur' => 'M. Durand', 'groupe' => 'Groupe A', 'date' => '2026-01-20', 'heure_debut' => '09:00', 'heure_fin' => '12:00', 'salle' => 'Salle 101', 'type' => 'cours', 'statut' => 'planifie'],
    ['id' => 2, 'titre' => 'JavaScript Avancé', 'formateur' => 'Mme. Lefebvre', 'groupe' => 'Groupe B', 'date' => '2026-01-20', 'heure_debut' => '14:00', 'heure_fin' => '17:00', 'salle' => 'Salle 203', 'type' => 'cours', 'statut' => 'en_cours'],
    ['id' => 3, 'titre' => 'Base de Données MySQL', 'formateur' => 'M. Garcia', 'groupe' => 'Groupe C', 'date' => '2026-01-20', 'heure_debut' => '09:00', 'heure_fin' => '12:00', 'salle' => 'Salle 105', 'type' => 'tp', 'statut' => 'termine'],
    ['id' => 4, 'titre' => 'Framework Laravel', 'formateur' => 'M. Durand', 'groupe' => 'Groupe A', 'date' => '2026-01-21', 'heure_debut' => '09:00', 'heure_fin' => '12:00', 'salle' => 'Salle 101', 'type' => 'cours', 'statut' => 'planifie'],
    ['id' => 5, 'titre' => 'React.js Fondamentaux', 'formateur' => 'Mme. Lefebvre', 'groupe' => 'Groupe B', 'date' => '2026-01-21', 'heure_debut' => '14:00', 'heure_fin' => '17:00', 'salle' => 'Salle 203', 'type' => 'cours', 'statut' => 'planifie'],
    ['id' => 6, 'titre' => 'Projet - Sprint Review', 'formateur' => 'M. Martinez', 'groupe' => 'Groupe D', 'date' => '2026-01-22', 'heure_debut' => '10:00', 'heure_fin' => '12:00', 'salle' => 'Amphi A', 'type' => 'projet', 'statut' => 'planifie'],
];

$formateurs = [
    ['id' => 1, 'nom' => 'M. Durand'],
    ['id' => 2, 'nom' => 'Mme. Lefebvre'],
    ['id' => 3, 'nom' => 'M. Garcia'],
    ['id' => 4, 'nom' => 'M. Martinez'],
];

$groupes = [
    ['id' => 1, 'nom' => 'Groupe A'],
    ['id' => 2, 'nom' => 'Groupe B'],
    ['id' => 3, 'nom' => 'Groupe C'],
    ['id' => 4, 'nom' => 'Groupe D'],
];

$salles = ['Salle 101', 'Salle 102', 'Salle 103', 'Salle 105', 'Salle 201', 'Salle 203', 'Amphi A', 'Amphi B'];

// Stats
$totalClasses = count($classes);
$todayClasses = count(array_filter($classes, fn($c) => $c['date'] === '2026-01-20'));
$enCours = count(array_filter($classes, fn($c) => $c['statut'] === 'en_cours'));

$pageActions = '
<button class="cls-btn cls-btn--primary" onclick="openModal(\'addClassModal\')" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
    Nouvelle classe
</button>
';

ob_start();
?>

<style>
/* Toast Container */
.toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    pointer-events: none;
}

.toast {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    background: #2d3438;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    min-width: 300px;
    max-width: 400px;
    pointer-events: auto;
    animation: toastIn 0.3s ease-out;
}

.toast.hiding { animation: toastOut 0.3s ease-in forwards; }

@keyframes toastIn {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes toastOut {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(100%); }
}

.toast__icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.toast__icon svg { width: 16px; height: 16px; color: white; }

.toast--success { background: #ecfdf5; border: 1px solid #10b981; }
.toast--success .toast__icon { background: #10b981; }
.toast--success .toast__message { color: #065f46; }

.toast--error { background: #fef2f2; border: 1px solid #ef4444; }
.toast--error .toast__icon { background: #ef4444; }
.toast--error .toast__message { color: #991b1b; }

.toast--info { background: #eff6ff; border: 1px solid #3b82f6; }
.toast--info .toast__icon { background: #3b82f6; }
.toast--info .toast__message { color: #1e40af; }

.toast__message { flex: 1; font-size: 14px; font-weight: 500; }

.toast__close {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    color: #64748b;
}

.toast__close:hover { background: rgba(0, 0, 0, 0.05); }
.toast__close svg { width: 14px; height: 14px; }

/* Stats Row */
.cls-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.cls-stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
}

.cls-stat-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cls-stat-card__icon svg { width: 24px; height: 24px; color: white; }

.cls-stat-card__icon--purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
.cls-stat-card__icon--blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.cls-stat-card__icon--green { background: linear-gradient(135deg, #10b981, #34d399); }
.cls-stat-card__icon--orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

.cls-stat-card__content { flex: 1; }
.cls-stat-card__title { font-size: 13px; color: #64748b; margin-bottom: 4px; }
.cls-stat-card__value { font-size: 26px; font-weight: 700; color: #1a1a2e; }

/* Card */
.cls-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    overflow: hidden;
}

.cls-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
}

.cls-card__title {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.cls-card__body { padding: 0; }

/* Filters */
.cls-filters {
    display: flex;
    gap: 12px;
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
}

.cls-search {
    flex: 1;
    min-width: 240px;
    position: relative;
}

.cls-search__icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #94a3b8;
}

.cls-search__input {
    width: 100%;
    padding: 10px 14px 10px 44px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.cls-search__input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.cls-select {
    padding: 10px 36px 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center;
    cursor: pointer;
    -webkit-appearance: none;
    min-width: 150px;
}

.cls-select:focus {
    outline: none;
    border-color: #8b5cf6;
}

/* Table */
.cls-table-wrapper {
    overflow-x: auto;
}

.cls-table {
    width: 100%;
    border-collapse: collapse;
}

.cls-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.cls-table td {
    padding: 16px 20px;
    font-size: 14px;
    color: #1a1a2e;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.cls-table tr:hover td {
    background: #f8fafc;
}

.cls-table tr:last-child td {
    border-bottom: none;
}

/* Table Cell Elements */
.cls-table__title {
    font-weight: 600;
    color: #1a1a2e;
}

.cls-table__user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.cls-table__avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    color: white;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cls-table__datetime {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.cls-table__date { font-weight: 500; }
.cls-table__time { font-size: 12px; color: #64748b; }

/* Badge */
.cls-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.cls-badge--primary { background: #f3e8ff; color: #7c3aed; }
.cls-badge--blue { background: #dbeafe; color: #2563eb; }
.cls-badge--green { background: #dcfce7; color: #16a34a; }
.cls-badge--orange { background: #fef3c7; color: #d97706; }
.cls-badge--gray { background: #f1f5f9; color: #64748b; }
.cls-badge--red { background: #fee2e2; color: #dc2626; }

/* Buttons */
.cls-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.cls-btn svg { width: 16px; height: 16px; }

.cls-btn--primary { background: #8b5cf6; color: white; }
.cls-btn--primary:hover { background: #7c3aed; }

.cls-btn--outline { background: white; border: 1px solid #e2e8f0; color: #64748b; }
.cls-btn--outline:hover { background: #f8fafc; border-color: #cbd5e1; color: #1a1a2e; }

.cls-btn--ghost { background: transparent; color: #64748b; }
.cls-btn--ghost:hover { background: #f1f5f9; color: #1a1a2e; }

.cls-btn--icon { width: 32px; height: 32px; padding: 0; }

.cls-btn--sm { padding: 6px 10px; font-size: 12px; }

.cls-btn-group { display: flex; gap: 4px; }

/* Modal */
.cls-modal-backdrop {
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
    padding: 20px;
}

.cls-modal-backdrop.active { display: flex; }

.cls-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    display: flex;
    flex-direction: column;
}

.cls-modal--lg { max-width: 680px; }

.cls-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}

.cls-modal__header h3 {
    font-size: 17px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.cls-modal__close {
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

.cls-modal__close:hover { background: #f1f5f9; }
.cls-modal__close svg { width: 18px; height: 18px; }

.cls-modal__body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.cls-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    flex-shrink: 0;
}

/* Form Elements */
.cls-form-group { margin-bottom: 20px; }
.cls-form-group:last-child { margin-bottom: 0; }

.cls-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.cls-form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
}

.cls-form-label .required { color: #ef4444; }

.cls-form-input,
.cls-form-select,
.cls-form-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.cls-form-input:focus,
.cls-form-select:focus,
.cls-form-textarea:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.cls-form-textarea { resize: vertical; min-height: 80px; }

/* Attendance */
.cls-attendance-header {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f5f9;
}

.cls-attendance-header h4 {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
}

.cls-attendance-header p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.cls-attendance-actions {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

.cls-attendance-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 320px;
    overflow-y: auto;
    padding-right: 8px;
}

.cls-attendance-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #f1f5f9;
}

.cls-attendance-item__user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.cls-attendance-item__avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    color: white;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cls-attendance-item__name {
    font-size: 14px;
    font-weight: 500;
    color: #1a1a2e;
}

.cls-attendance-btns {
    display: flex;
    gap: 6px;
}

.cls-attendance-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid #e2e8f0;
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}

.cls-attendance-btn:hover { background: #f8fafc; }
.cls-attendance-btn svg { width: 14px; height: 14px; }

.cls-attendance-btn.active.present { background: #10b981; border-color: #10b981; color: white; }
.cls-attendance-btn.active.absent { background: #ef4444; border-color: #ef4444; color: white; }
.cls-attendance-btn.active.late { background: #f59e0b; border-color: #f59e0b; color: white; }

/* Responsive */
@media (max-width: 1200px) {
    .cls-stats { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .cls-stats { grid-template-columns: 1fr; }
    .cls-form-row { grid-template-columns: 1fr; }
    .cls-filters { flex-direction: column; }
    .cls-search { min-width: 100%; }
}
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Stats Row -->
<div class="cls-stats">
    <div class="cls-stat-card">
        <div class="cls-stat-card__icon cls-stat-card__icon--purple">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-calendar"/></svg>
        </div>
        <div class="cls-stat-card__content">
            <div class="cls-stat-card__title">Total Classes</div>
            <div class="cls-stat-card__value"><?= $totalClasses ?></div>
        </div>
    </div>
    <div class="cls-stat-card">
        <div class="cls-stat-card__icon cls-stat-card__icon--blue">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-clock"/></svg>
        </div>
        <div class="cls-stat-card__content">
            <div class="cls-stat-card__title">Aujourd'hui</div>
            <div class="cls-stat-card__value"><?= $todayClasses ?></div>
        </div>
    </div>
    <div class="cls-stat-card">
        <div class="cls-stat-card__icon cls-stat-card__icon--green">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-play"/></svg>
        </div>
        <div class="cls-stat-card__content">
            <div class="cls-stat-card__title">En Cours</div>
            <div class="cls-stat-card__value"><?= $enCours ?></div>
        </div>
    </div>
    <div class="cls-stat-card">
        <div class="cls-stat-card__icon cls-stat-card__icon--orange">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-users"/></svg>
        </div>
        <div class="cls-stat-card__content">
            <div class="cls-stat-card__title">Groupes</div>
            <div class="cls-stat-card__value"><?= count($groupes) ?></div>
        </div>
    </div>
</div>

<!-- Classes Table -->
<div class="cls-card">
    <div class="cls-card__header">
        <h3 class="cls-card__title">Liste des Classes</h3>
    </div>
    
    <!-- Filters -->
    <div class="cls-filters">
        <div class="cls-search">
            <svg class="cls-search__icon"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-search"/></svg>
            <input type="text" class="cls-search__input" placeholder="Rechercher une classe..." id="searchClass">
        </div>
        <input type="date" class="cls-select" id="filterDate" style="padding-right: 14px;">
        <select class="cls-select" id="filterFormateur">
            <option value="">Tous les formateurs</option>
            <?php foreach ($formateurs as $formateur): ?>
            <option value="<?= $formateur['id'] ?>"><?= htmlspecialchars($formateur['nom']) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="cls-select" id="filterGroupe">
            <option value="">Tous les groupes</option>
            <?php foreach ($groupes as $groupe): ?>
            <option value="<?= $groupe['id'] ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="cls-card__body">
        <div class="cls-table-wrapper">
            <table class="cls-table" id="classesTable">
                <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Formateur</th>
                        <th>Groupe</th>
                        <th>Date & Heure</th>
                        <th>Salle</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $classe): ?>
                    <?php
                    $typeBadge = match($classe['type']) {
                        'cours' => 'primary',
                        'tp' => 'blue',
                        'projet' => 'orange',
                        default => 'gray'
                    };
                    $typeLabel = match($classe['type']) {
                        'cours' => 'Cours',
                        'tp' => 'TP',
                        'projet' => 'Projet',
                        default => $classe['type']
                    };
                    $statutBadge = match($classe['statut']) {
                        'planifie' => 'gray',
                        'en_cours' => 'orange',
                        'termine' => 'green',
                        'annule' => 'red',
                        default => 'gray'
                    };
                    $statutLabel = match($classe['statut']) {
                        'planifie' => 'Planifié',
                        'en_cours' => 'En cours',
                        'termine' => 'Terminé',
                        'annule' => 'Annulé',
                        default => $classe['statut']
                    };
                    ?>
                    <tr data-id="<?= $classe['id'] ?>">
                        <td>
                            <span class="cls-table__title"><?= htmlspecialchars($classe['titre']) ?></span>
                        </td>
                        <td>
                            <div class="cls-table__user">
                                <div class="cls-table__avatar"><?= strtoupper(substr($classe['formateur'], 0, 1)) ?></div>
                                <span><?= htmlspecialchars($classe['formateur']) ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="cls-badge cls-badge--primary"><?= htmlspecialchars($classe['groupe']) ?></span>
                        </td>
                        <td>
                            <div class="cls-table__datetime">
                                <span class="cls-table__date"><?= date('d/m/Y', strtotime($classe['date'])) ?></span>
                                <span class="cls-table__time"><?= $classe['heure_debut'] ?> - <?= $classe['heure_fin'] ?></span>
                            </div>
                        </td>
                        <td style="color: #64748b;"><?= htmlspecialchars($classe['salle']) ?></td>
                        <td><span class="cls-badge cls-badge--<?= $typeBadge ?>"><?= $typeLabel ?></span></td>
                        <td><span class="cls-badge cls-badge--<?= $statutBadge ?>"><?= $statutLabel ?></span></td>
                        <td>
                            <div class="cls-btn-group">
                                <?php if ($classe['statut'] !== 'annule'): ?>
                                <button class="cls-btn cls-btn--ghost cls-btn--icon" title="Présences" onclick="manageAttendance(<?= $classe['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check-square"/></svg>
                                </button>
                                <?php endif; ?>
                                <button class="cls-btn cls-btn--ghost cls-btn--icon" title="Modifier" onclick="editClass(<?= $classe['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                                </button>
                                <button class="cls-btn cls-btn--ghost cls-btn--icon" title="Supprimer" onclick="deleteClass(<?= $classe['id'] ?>)" style="color: #ef4444;">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-trash"/></svg>
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

<!-- Add/Edit Class Modal -->
<div class="cls-modal-backdrop" id="addClassModal">
    <div class="cls-modal cls-modal--lg">
        <div class="cls-modal__header">
            <h3 id="classModalTitle">Nouvelle Classe</h3>
            <button class="cls-modal__close" onclick="closeModal('addClassModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form id="classForm" onsubmit="saveClass(event)">
            <div class="cls-modal__body">
                <input type="hidden" id="classId" name="id">
                
                <div class="cls-form-group">
                    <label class="cls-form-label">Titre de la classe <span class="required">*</span></label>
                    <input type="text" class="cls-form-input" id="classTitre" name="titre" required>
                </div>
                
                <div class="cls-form-row">
                    <div class="cls-form-group">
                        <label class="cls-form-label">Formateur <span class="required">*</span></label>
                        <select class="cls-form-select" id="classFormateur" name="formateur_id" required>
                            <option value="">Sélectionnez un formateur</option>
                            <?php foreach ($formateurs as $formateur): ?>
                            <option value="<?= $formateur['id'] ?>"><?= htmlspecialchars($formateur['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="cls-form-group">
                        <label class="cls-form-label">Groupe <span class="required">*</span></label>
                        <select class="cls-form-select" id="classGroupe" name="groupe_id" required>
                            <option value="">Sélectionnez un groupe</option>
                            <?php foreach ($groupes as $groupe): ?>
                            <option value="<?= $groupe['id'] ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="cls-form-row">
                    <div class="cls-form-group">
                        <label class="cls-form-label">Date <span class="required">*</span></label>
                        <input type="date" class="cls-form-input" id="classDate" name="date" required>
                    </div>
                    <div class="cls-form-group">
                        <label class="cls-form-label">Salle</label>
                        <select class="cls-form-select" id="classSalle" name="salle">
                            <option value="">Sélectionnez une salle</option>
                            <?php foreach ($salles as $salle): ?>
                            <option value="<?= $salle ?>"><?= $salle ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="cls-form-row">
                    <div class="cls-form-group">
                        <label class="cls-form-label">Heure de début <span class="required">*</span></label>
                        <input type="time" class="cls-form-input" id="classHeureDebut" name="heure_debut" required>
                    </div>
                    <div class="cls-form-group">
                        <label class="cls-form-label">Heure de fin <span class="required">*</span></label>
                        <input type="time" class="cls-form-input" id="classHeureFin" name="heure_fin" required>
                    </div>
                </div>
                
                <div class="cls-form-group">
                    <label class="cls-form-label">Type</label>
                    <select class="cls-form-select" id="classType" name="type">
                        <option value="cours">Cours</option>
                        <option value="tp">TP</option>
                        <option value="projet">Projet</option>
                    </select>
                </div>
                
                <div class="cls-form-group">
                    <label class="cls-form-label">Description</label>
                    <textarea class="cls-form-textarea" id="classDescription" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="cls-modal__footer">
                <button type="button" class="cls-btn cls-btn--outline" onclick="closeModal('addClassModal')">Annuler</button>
                <button type="submit" class="cls-btn cls-btn--primary">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Modal -->
<div class="cls-modal-backdrop" id="attendanceModal">
    <div class="cls-modal cls-modal--lg">
        <div class="cls-modal__header">
            <h3>Gestion des Présences</h3>
            <button class="cls-modal__close" onclick="closeModal('attendanceModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="cls-modal__body">
            <div class="cls-attendance-header">
                <h4 id="attendanceClassTitle">Introduction à PHP</h4>
                <p id="attendanceClassInfo">20/01/2026 • 09:00 - 12:00 • Groupe A</p>
            </div>
            
            <div class="cls-attendance-actions">
                <button class="cls-btn cls-btn--outline cls-btn--sm" onclick="markAllPresent()">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Tous présents
                </button>
                <button class="cls-btn cls-btn--outline cls-btn--sm" onclick="markAllAbsent()">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
                    Tous absents
                </button>
            </div>
            
            <div class="cls-attendance-list" id="attendanceList">
                <?php
                $demoStudents = [
                    ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Marie'],
                    ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Lucas'],
                    ['id' => 3, 'nom' => 'Bernard', 'prenom' => 'Sophie'],
                    ['id' => 4, 'nom' => 'Petit', 'prenom' => 'Thomas'],
                    ['id' => 5, 'nom' => 'Robert', 'prenom' => 'Emma'],
                ];
                foreach ($demoStudents as $student):
                ?>
                <div class="cls-attendance-item">
                    <div class="cls-attendance-item__user">
                        <div class="cls-attendance-item__avatar">
                            <?= strtoupper(substr($student['prenom'], 0, 1) . substr($student['nom'], 0, 1)) ?>
                        </div>
                        <span class="cls-attendance-item__name"><?= $student['prenom'] ?> <?= $student['nom'] ?></span>
                    </div>
                    <div class="cls-attendance-btns">
                        <button class="cls-attendance-btn present" data-student="<?= $student['id'] ?>" data-status="present" onclick="setAttendance(this)">
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                            Présent
                        </button>
                        <button class="cls-attendance-btn absent" data-student="<?= $student['id'] ?>" data-status="absent" onclick="setAttendance(this)">
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
                            Absent
                        </button>
                        <button class="cls-attendance-btn late" data-student="<?= $student['id'] ?>" data-status="late" onclick="setAttendance(this)">
                            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-clock"/></svg>
                            Retard
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="cls-modal__footer">
            <button type="button" class="cls-btn cls-btn--outline" onclick="closeModal('attendanceModal')">Fermer</button>
            <button type="button" class="cls-btn cls-btn--primary" onclick="saveAttendance()">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                Enregistrer
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
// Toast System
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast toast--${type}`;
    
    const icons = {
        success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>',
        error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };
    
    toast.innerHTML = `
        <div class="toast__icon">${icons[type] || icons.info}</div>
        <div class="toast__message">${message}</div>
        <button class="toast__close" onclick="dismissToast(this.parentElement)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    `;
    
    container.appendChild(toast);
    setTimeout(() => dismissToast(toast), 5000);
}

function dismissToast(toast) {
    if (!toast || toast.classList.contains('hiding')) return;
    toast.classList.add('hiding');
    setTimeout(() => toast.remove(), 300);
}

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

// Search
document.getElementById('searchClass')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('#classesTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
});

// Class CRUD
function editClass(id) {
    document.getElementById('classModalTitle').textContent = 'Modifier la Classe';
    document.getElementById('classId').value = id;
    openModal('addClassModal');
}

function deleteClass(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')) {
        showToast('Classe supprimée avec succès', 'success');
    }
}

function saveClass(e) {
    e.preventDefault();
    showToast('Classe enregistrée avec succès', 'success');
    closeModal('addClassModal');
}

// Attendance
function manageAttendance(classId) {
    openModal('attendanceModal');
}

function setAttendance(btn) {
    btn.parentElement.querySelectorAll('.cls-attendance-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function markAllPresent() {
    document.querySelectorAll('.cls-attendance-btn.present').forEach(btn => {
        btn.parentElement.querySelectorAll('.cls-attendance-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
}

function markAllAbsent() {
    document.querySelectorAll('.cls-attendance-btn.absent').forEach(btn => {
        btn.parentElement.querySelectorAll('.cls-attendance-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
}

function saveAttendance() {
    showToast('Présences enregistrées avec succès', 'success');
    closeModal('attendanceModal');
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
