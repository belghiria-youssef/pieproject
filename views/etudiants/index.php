<?php
$pageTitle = 'Gestion des Étudiants';
$pageSubtitle = 'Gérez tous les étudiants du centre de formation';
$currentPage = 'etudiants';
$breadcrumb = 'Étudiants';

// Demo data
$etudiants = [
    ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Marie', 'email' => 'marie.dupont@email.com', 'telephone' => '06 12 34 56 78', 'groupe' => 'Groupe A', 'groupe_id' => 1, 'date_inscription' => '2026-01-15', 'statut' => 'actif'],
    ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Lucas', 'email' => 'lucas.martin@email.com', 'telephone' => '06 23 45 67 89', 'groupe' => 'Groupe B', 'groupe_id' => 2, 'date_inscription' => '2026-01-14', 'statut' => 'actif'],
    ['id' => 3, 'nom' => 'Bernard', 'prenom' => 'Sophie', 'email' => 'sophie.bernard@email.com', 'telephone' => '06 34 56 78 90', 'groupe' => 'Groupe A', 'groupe_id' => 1, 'date_inscription' => '2026-01-13', 'statut' => 'actif'],
    ['id' => 4, 'nom' => 'Petit', 'prenom' => 'Thomas', 'email' => 'thomas.petit@email.com', 'telephone' => '06 45 67 89 01', 'groupe' => 'Groupe C', 'groupe_id' => 3, 'date_inscription' => '2026-01-12', 'statut' => 'inactif'],
    ['id' => 5, 'nom' => 'Robert', 'prenom' => 'Emma', 'email' => 'emma.robert@email.com', 'telephone' => '06 56 78 90 12', 'groupe' => 'Groupe B', 'groupe_id' => 2, 'date_inscription' => '2026-01-11', 'statut' => 'actif'],
    ['id' => 6, 'nom' => 'Richard', 'prenom' => 'Hugo', 'email' => 'hugo.richard@email.com', 'telephone' => '06 67 89 01 23', 'groupe' => 'Groupe A', 'groupe_id' => 1, 'date_inscription' => '2026-01-10', 'statut' => 'actif'],
    ['id' => 7, 'nom' => 'Durand', 'prenom' => 'Léa', 'email' => 'lea.durand@email.com', 'telephone' => '06 78 90 12 34', 'groupe' => 'Groupe C', 'groupe_id' => 3, 'date_inscription' => '2026-01-09', 'statut' => 'actif'],
    ['id' => 8, 'nom' => 'Leroy', 'prenom' => 'Nathan', 'email' => 'nathan.leroy@email.com', 'telephone' => '06 89 01 23 45', 'groupe' => 'Groupe B', 'groupe_id' => 2, 'date_inscription' => '2026-01-08', 'statut' => 'en_attente'],
];

$groupes = [
    ['id' => 1, 'nom' => 'Groupe A'],
    ['id' => 2, 'nom' => 'Groupe B'],
    ['id' => 3, 'nom' => 'Groupe C'],
    ['id' => 4, 'nom' => 'Groupe D'],
];

// Stats
$totalEtudiants = count($etudiants);
$actifs = count(array_filter($etudiants, fn($e) => $e['statut'] === 'actif'));
$enAttente = count(array_filter($etudiants, fn($e) => $e['statut'] === 'en_attente'));

$pageActions = '
<button class="etu-btn etu-btn--outline" onclick="exportStudents()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border: 1px solid #e2e8f0; color: #64748b; border-radius: 8px; font-weight: 500; cursor: pointer; margin-right: 12px;">
    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
    Exporter
</button>
<button class="etu-btn etu-btn--primary" onclick="openModal(\'addStudentModal\')" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-plus"/></svg>
    Ajouter un étudiant
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
.etu-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.etu-stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
}

.etu-stat-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.etu-stat-card__icon svg { width: 24px; height: 24px; color: white; }

.etu-stat-card__icon--purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
.etu-stat-card__icon--blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.etu-stat-card__icon--green { background: linear-gradient(135deg, #10b981, #34d399); }
.etu-stat-card__icon--orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

.etu-stat-card__content { flex: 1; }
.etu-stat-card__title { font-size: 13px; color: #64748b; margin-bottom: 4px; }
.etu-stat-card__value { font-size: 26px; font-weight: 700; color: #1a1a2e; }

/* Card */
.etu-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    overflow: hidden;
}

.etu-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
}

.etu-card__title {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.etu-card__body { padding: 0; }

/* Filters */
.etu-filters {
    display: flex;
    gap: 12px;
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
}

.etu-search {
    flex: 1;
    min-width: 240px;
    position: relative;
}

.etu-search__icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #94a3b8;
}

.etu-search__input {
    width: 100%;
    padding: 10px 14px 10px 44px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.etu-search__input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.etu-select {
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

.etu-select:focus {
    outline: none;
    border-color: #8b5cf6;
}

/* Table */
.etu-table-wrapper {
    overflow-x: auto;
}

.etu-table {
    width: 100%;
    border-collapse: collapse;
}

.etu-table th {
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

.etu-table td {
    padding: 16px 20px;
    font-size: 14px;
    color: #1a1a2e;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.etu-table tr:hover td {
    background: #f8fafc;
}

.etu-table tr:last-child td {
    border-bottom: none;
}

/* Checkbox */
.etu-checkbox {
    width: 18px;
    height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    transition: all 0.15s;
    position: relative;
}

.etu-checkbox:checked {
    background: #8b5cf6;
    border-color: #8b5cf6;
}

.etu-checkbox:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.etu-checkbox:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
}

/* User Cell */
.etu-table__user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.etu-table__avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    color: white;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.etu-table__name {
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.etu-table__id {
    font-size: 12px;
    color: #94a3b8;
}

/* Badge */
.etu-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.etu-badge--primary { background: #f3e8ff; color: #7c3aed; }
.etu-badge--green { background: #dcfce7; color: #16a34a; }
.etu-badge--red { background: #fee2e2; color: #dc2626; }
.etu-badge--orange { background: #fef3c7; color: #d97706; }
.etu-badge--gray { background: #f1f5f9; color: #64748b; }

/* Buttons */
.etu-btn {
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

.etu-btn svg { width: 16px; height: 16px; }

.etu-btn--primary { background: #8b5cf6; color: white; }
.etu-btn--primary:hover { background: #7c3aed; }

.etu-btn--danger { background: #ef4444; color: white; }
.etu-btn--danger:hover { background: #dc2626; }

.etu-btn--outline { background: white; border: 1px solid #e2e8f0; color: #64748b; }
.etu-btn--outline:hover { background: #f8fafc; border-color: #cbd5e1; color: #1a1a2e; }

.etu-btn--ghost { background: transparent; color: #64748b; }
.etu-btn--ghost:hover { background: #f1f5f9; color: #1a1a2e; }

.etu-btn--icon { width: 32px; height: 32px; padding: 0; }

.etu-btn-group { display: flex; gap: 4px; }

/* Pagination */
.etu-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
}

.etu-pagination__info {
    font-size: 13px;
    color: #64748b;
}

.etu-pagination__buttons {
    display: flex;
    gap: 4px;
}

.etu-pagination__btn {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #64748b;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.etu-pagination__btn:hover:not(:disabled) {
    background: #f8fafc;
    border-color: #cbd5e1;
}

.etu-pagination__btn.active {
    background: #8b5cf6;
    border-color: #8b5cf6;
    color: white;
}

.etu-pagination__btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.etu-pagination__btn svg { width: 16px; height: 16px; }

/* Modal */
.etu-modal-backdrop {
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

.etu-modal-backdrop.active { display: flex; }

.etu-modal {
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

.etu-modal--lg { max-width: 640px; }
.etu-modal--sm { max-width: 400px; }

.etu-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}

.etu-modal__header h3 {
    font-size: 17px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.etu-modal__close {
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

.etu-modal__close:hover { background: #f1f5f9; }
.etu-modal__close svg { width: 18px; height: 18px; }

.etu-modal__body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.etu-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    flex-shrink: 0;
}

/* Form Elements */
.etu-form-group { margin-bottom: 20px; }
.etu-form-group:last-child { margin-bottom: 0; }

.etu-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.etu-form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
}

.etu-form-label .required { color: #ef4444; }

.etu-form-input,
.etu-form-select,
.etu-form-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.etu-form-input:focus,
.etu-form-select:focus,
.etu-form-textarea:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.etu-form-textarea { resize: vertical; min-height: 80px; }

/* Delete Modal */
.etu-modal__icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.etu-modal__icon--danger {
    background: #fee2e2;
    color: #ef4444;
}

.etu-modal__icon svg { width: 32px; height: 32px; }

/* View Modal */
.etu-view-header {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 20px;
}

.etu-view-avatar {
    width: 72px;
    height: 72px;
    border-radius: 16px;
    background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    color: white;
    font-size: 24px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.etu-view-name {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.etu-view-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.etu-view-row {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}

.etu-view-row:last-child { border-bottom: none; }

.etu-view-label {
    width: 140px;
    font-size: 13px;
    color: #64748b;
    flex-shrink: 0;
}

.etu-view-value {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    color: #1a1a2e;
}

/* Responsive */
@media (max-width: 1200px) {
    .etu-stats { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .etu-stats { grid-template-columns: 1fr; }
    .etu-form-row { grid-template-columns: 1fr; }
    .etu-filters { flex-direction: column; }
    .etu-search { min-width: 100%; }
    .etu-pagination { flex-direction: column; gap: 12px; }
}
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Stats Row -->
<div class="etu-stats">
    <div class="etu-stat-card">
        <div class="etu-stat-card__icon etu-stat-card__icon--purple">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-users"/></svg>
        </div>
        <div class="etu-stat-card__content">
            <div class="etu-stat-card__title">Total Étudiants</div>
            <div class="etu-stat-card__value"><?= $totalEtudiants ?></div>
        </div>
    </div>
    <div class="etu-stat-card">
        <div class="etu-stat-card__icon etu-stat-card__icon--green">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check-circle"/></svg>
        </div>
        <div class="etu-stat-card__content">
            <div class="etu-stat-card__title">Actifs</div>
            <div class="etu-stat-card__value"><?= $actifs ?></div>
        </div>
    </div>
    <div class="etu-stat-card">
        <div class="etu-stat-card__icon etu-stat-card__icon--orange">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-clock"/></svg>
        </div>
        <div class="etu-stat-card__content">
            <div class="etu-stat-card__title">En Attente</div>
            <div class="etu-stat-card__value"><?= $enAttente ?></div>
        </div>
    </div>
    <div class="etu-stat-card">
        <div class="etu-stat-card__icon etu-stat-card__icon--blue">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-group"/></svg>
        </div>
        <div class="etu-stat-card__content">
            <div class="etu-stat-card__title">Groupes</div>
            <div class="etu-stat-card__value"><?= count($groupes) ?></div>
        </div>
    </div>
</div>

<!-- Students Table -->
<div class="etu-card">
    <div class="etu-card__header">
        <h3 class="etu-card__title">Liste des Étudiants</h3>
    </div>
    
    <!-- Filters -->
    <div class="etu-filters">
        <div class="etu-search">
            <svg class="etu-search__icon"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-search"/></svg>
            <input type="text" class="etu-search__input" placeholder="Rechercher un étudiant..." id="searchStudent">
        </div>
        <select class="etu-select" id="filterGroupe">
            <option value="">Tous les groupes</option>
            <?php foreach ($groupes as $groupe): ?>
            <option value="<?= $groupe['id'] ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="etu-select" id="filterStatut">
            <option value="">Tous les statuts</option>
            <option value="actif">Actif</option>
            <option value="inactif">Inactif</option>
            <option value="en_attente">En attente</option>
        </select>
        <button class="etu-btn etu-btn--ghost" onclick="resetFilters()">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            Réinitialiser
        </button>
    </div>
    
    <div class="etu-card__body">
        <div class="etu-table-wrapper">
            <table class="etu-table" id="studentsTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="etu-checkbox" id="selectAll">
                        </th>
                        <th>Étudiant</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Groupe</th>
                        <th>Inscription</th>
                        <th>Statut</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant): ?>
                    <?php
                    $statutBadge = match($etudiant['statut']) {
                        'actif' => 'green',
                        'inactif' => 'red',
                        'en_attente' => 'orange',
                        default => 'gray'
                    };
                    $statutLabel = match($etudiant['statut']) {
                        'actif' => 'Actif',
                        'inactif' => 'Inactif',
                        'en_attente' => 'En attente',
                        default => $etudiant['statut']
                    };
                    ?>
                    <tr data-id="<?= $etudiant['id'] ?>">
                        <td>
                            <input type="checkbox" class="etu-checkbox row-checkbox" value="<?= $etudiant['id'] ?>">
                        </td>
                        <td>
                            <div class="etu-table__user">
                                <div class="etu-table__avatar">
                                    <?= strtoupper(substr($etudiant['prenom'], 0, 1) . substr($etudiant['nom'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="etu-table__name"><?= htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']) ?></div>
                                    <div class="etu-table__id">ID: #<?= str_pad($etudiant['id'], 4, '0', STR_PAD_LEFT) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="color: #64748b;"><?= htmlspecialchars($etudiant['email']) ?></td>
                        <td style="color: #64748b;"><?= htmlspecialchars($etudiant['telephone']) ?></td>
                        <td><span class="etu-badge etu-badge--primary"><?= htmlspecialchars($etudiant['groupe']) ?></span></td>
                        <td style="color: #64748b;"><?= date('d/m/Y', strtotime($etudiant['date_inscription'])) ?></td>
                        <td><span class="etu-badge etu-badge--<?= $statutBadge ?>"><?= $statutLabel ?></span></td>
                        <td>
                            <div class="etu-btn-group">
                                <button class="etu-btn etu-btn--ghost etu-btn--icon" title="Voir" onclick="viewStudent(<?= $etudiant['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                                </button>
                                <button class="etu-btn etu-btn--ghost etu-btn--icon" title="Modifier" onclick="editStudent(<?= $etudiant['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                                </button>
                                <button class="etu-btn etu-btn--ghost etu-btn--icon" title="Supprimer" onclick="deleteStudent(<?= $etudiant['id'] ?>)" style="color: #ef4444;">
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
    
    <!-- Pagination -->
    <div class="etu-pagination">
        <div class="etu-pagination__info">
            Affichage de 1 à <?= count($etudiants) ?> sur <?= count($etudiants) ?> entrées
        </div>
        <div class="etu-pagination__buttons">
            <button class="etu-pagination__btn" disabled>
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-chevron-left"/></svg>
            </button>
            <button class="etu-pagination__btn active">1</button>
            <button class="etu-pagination__btn">2</button>
            <button class="etu-pagination__btn">3</button>
            <button class="etu-pagination__btn">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-chevron-right"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- Add/Edit Student Modal -->
<div class="etu-modal-backdrop" id="addStudentModal">
    <div class="etu-modal etu-modal--lg">
        <div class="etu-modal__header">
            <h3 id="studentModalTitle">Ajouter un Étudiant</h3>
            <button class="etu-modal__close" onclick="closeModal('addStudentModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form id="studentForm" onsubmit="saveStudent(event)">
            <div class="etu-modal__body">
                <input type="hidden" id="studentId" name="id">
                
                <div class="etu-form-row">
                    <div class="etu-form-group">
                        <label class="etu-form-label">Prénom <span class="required">*</span></label>
                        <input type="text" class="etu-form-input" id="prenom" name="prenom" required>
                    </div>
                    <div class="etu-form-group">
                        <label class="etu-form-label">Nom <span class="required">*</span></label>
                        <input type="text" class="etu-form-input" id="nom" name="nom" required>
                    </div>
                </div>
                
                <div class="etu-form-row">
                    <div class="etu-form-group">
                        <label class="etu-form-label">Email <span class="required">*</span></label>
                        <input type="email" class="etu-form-input" id="studentEmail" name="email" required>
                    </div>
                    <div class="etu-form-group">
                        <label class="etu-form-label">Téléphone</label>
                        <input type="tel" class="etu-form-input" id="telephone" name="telephone" placeholder="06 XX XX XX XX">
                    </div>
                </div>
                
                <div class="etu-form-row">
                    <div class="etu-form-group">
                        <label class="etu-form-label">Groupe <span class="required">*</span></label>
                        <select class="etu-form-select" id="groupe_id" name="groupe_id" required>
                            <option value="">Sélectionnez un groupe</option>
                            <?php foreach ($groupes as $groupe): ?>
                            <option value="<?= $groupe['id'] ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="etu-form-group">
                        <label class="etu-form-label">Date d'inscription</label>
                        <input type="date" class="etu-form-input" id="date_inscription" name="date_inscription" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                
                <div class="etu-form-group">
                    <label class="etu-form-label">Statut</label>
                    <select class="etu-form-select" id="statut" name="statut">
                        <option value="actif">Actif</option>
                        <option value="en_attente">En attente</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>
                
                <div class="etu-form-group">
                    <label class="etu-form-label">Notes</label>
                    <textarea class="etu-form-textarea" id="notes" name="notes" rows="3" placeholder="Notes supplémentaires..."></textarea>
                </div>
            </div>
            <div class="etu-modal__footer">
                <button type="button" class="etu-btn etu-btn--outline" onclick="closeModal('addStudentModal')">Annuler</button>
                <button type="submit" class="etu-btn etu-btn--primary">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Student Modal -->
<div class="etu-modal-backdrop" id="viewStudentModal">
    <div class="etu-modal">
        <div class="etu-modal__header">
            <h3>Détails de l'Étudiant</h3>
            <button class="etu-modal__close" onclick="closeModal('viewStudentModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="etu-modal__body" id="viewStudentContent">
            <!-- Content loaded dynamically -->
        </div>
        <div class="etu-modal__footer">
            <button type="button" class="etu-btn etu-btn--outline" onclick="closeModal('viewStudentModal')">Fermer</button>
            <button type="button" class="etu-btn etu-btn--primary" id="editFromView">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                Modifier
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="etu-modal-backdrop" id="deleteModal">
    <div class="etu-modal etu-modal--sm">
        <div class="etu-modal__header">
            <h3>Confirmer la suppression</h3>
            <button class="etu-modal__close" onclick="closeModal('deleteModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="etu-modal__body" style="text-align: center;">
            <div class="etu-modal__icon etu-modal__icon--danger">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-alert-triangle"/></svg>
            </div>
            <p style="font-size: 15px; color: #1a1a2e; margin-bottom: 8px;">Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
            <p style="font-size: 13px; color: #64748b;">Cette action est irréversible.</p>
        </div>
        <div class="etu-modal__footer" style="justify-content: center;">
            <button type="button" class="etu-btn etu-btn--outline" onclick="closeModal('deleteModal')">Annuler</button>
            <button type="button" class="etu-btn etu-btn--danger" id="confirmDeleteBtn">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-trash"/></svg>
                Supprimer
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

// Select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Search functionality
document.getElementById('searchStudent').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Filter by group
document.getElementById('filterGroupe').addEventListener('change', filterTable);
document.getElementById('filterStatut').addEventListener('change', filterTable);

function filterTable() {
    const groupeFilter = document.getElementById('filterGroupe').value;
    const statutFilter = document.getElementById('filterStatut').value;
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    
    rows.forEach(row => {
        const groupe = row.querySelector('td:nth-child(5) .etu-badge')?.textContent || '';
        const statut = row.querySelector('td:nth-child(7) .etu-badge')?.textContent.toLowerCase() || '';
        
        let showGroupe = !groupeFilter || groupe.includes('Groupe ' + String.fromCharCode(64 + parseInt(groupeFilter)));
        let showStatut = !statutFilter || statut.includes(statutFilter.replace('_', ' '));
        
        row.style.display = (showGroupe && showStatut) ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('searchStudent').value = '';
    document.getElementById('filterGroupe').value = '';
    document.getElementById('filterStatut').value = '';
    
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    rows.forEach(row => row.style.display = '');
}

// Student CRUD operations
function viewStudent(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    const name = row.querySelector('.etu-table__name').textContent;
    const initials = row.querySelector('.etu-table__avatar').textContent;
    const email = row.querySelector('td:nth-child(3)').textContent;
    const phone = row.querySelector('td:nth-child(4)').textContent;
    const groupe = row.querySelector('td:nth-child(5) .etu-badge').textContent;
    const date = row.querySelector('td:nth-child(6)').textContent;
    const statut = row.querySelector('td:nth-child(7) .etu-badge').textContent;
    const statutClass = statut === 'Actif' ? 'green' : statut === 'Inactif' ? 'red' : 'orange';
    
    document.getElementById('viewStudentContent').innerHTML = `
        <div class="etu-view-header">
            <div class="etu-view-avatar">${initials}</div>
            <div class="etu-view-name">${name}</div>
            <span class="etu-badge etu-badge--${statutClass}">${statut}</span>
        </div>
        <div class="etu-view-details">
            <div class="etu-view-row">
                <div class="etu-view-label">Email</div>
                <div class="etu-view-value">${email.trim()}</div>
            </div>
            <div class="etu-view-row">
                <div class="etu-view-label">Téléphone</div>
                <div class="etu-view-value">${phone.trim()}</div>
            </div>
            <div class="etu-view-row">
                <div class="etu-view-label">Groupe</div>
                <div class="etu-view-value"><span class="etu-badge etu-badge--primary">${groupe}</span></div>
            </div>
            <div class="etu-view-row">
                <div class="etu-view-label">Inscription</div>
                <div class="etu-view-value">${date.trim()}</div>
            </div>
        </div>
    `;
    
    document.getElementById('editFromView').onclick = () => {
        closeModal('viewStudentModal');
        editStudent(id);
    };
    
    openModal('viewStudentModal');
}

function editStudent(id) {
    document.getElementById('studentModalTitle').textContent = 'Modifier l\'Étudiant';
    document.getElementById('studentId').value = id;
    
    const row = document.querySelector(`tr[data-id="${id}"]`);
    const nameParts = row.querySelector('.etu-table__name').textContent.split(' ');
    
    document.getElementById('prenom').value = nameParts[0];
    document.getElementById('nom').value = nameParts.slice(1).join(' ');
    document.getElementById('studentEmail').value = row.querySelector('td:nth-child(3)').textContent.trim();
    document.getElementById('telephone').value = row.querySelector('td:nth-child(4)').textContent.trim();
    
    openModal('addStudentModal');
}

let deleteStudentId = null;

function deleteStudent(id) {
    deleteStudentId = id;
    openModal('deleteModal');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteStudentId) {
        const row = document.querySelector(`tr[data-id="${deleteStudentId}"]`);
        if (row) {
            row.remove();
            showToast('Étudiant supprimé avec succès', 'success');
        }
        closeModal('deleteModal');
        deleteStudentId = null;
    }
});

function saveStudent(e) {
    e.preventDefault();
    
    const id = document.getElementById('studentId').value;
    
    if (id) {
        showToast('Étudiant mis à jour avec succès', 'success');
    } else {
        showToast('Étudiant ajouté avec succès', 'success');
    }
    
    closeModal('addStudentModal');
    e.target.reset();
}

function exportStudents() {
    showToast('Export en cours...', 'info');
    setTimeout(() => {
        showToast('Export terminé', 'success');
    }, 1500);
}

// Reset form when opening add modal
document.querySelector('[onclick="openModal(\'addStudentModal\')"]')?.addEventListener('click', function() {
    document.getElementById('studentModalTitle').textContent = 'Ajouter un Étudiant';
    document.getElementById('studentForm').reset();
    document.getElementById('studentId').value = '';
});
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
