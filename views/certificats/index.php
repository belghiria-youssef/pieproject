<?php
$pageTitle = 'Gestion des Certificats';
$pageSubtitle = 'Générez et gérez les certificats de formation';
$currentPage = 'certificats';
$breadcrumb = 'Certificats';

// Demo data
$groupesEligibles = [
    ['id' => 1, 'nom' => 'Développement Web Full Stack', 'code' => 'DWFS-2026', 'nb_etudiants' => 18, 'taux_reussite' => 94, 'date_fin' => '2026-12-15', 'statut' => 'termine'],
    ['id' => 2, 'nom' => 'Data Science & IA', 'code' => 'DSIA-2026', 'nb_etudiants' => 15, 'taux_reussite' => 87, 'date_fin' => '2026-11-30', 'statut' => 'termine'],
    ['id' => 3, 'nom' => 'DevOps & Cloud', 'code' => 'DOC-2026', 'nb_etudiants' => 12, 'taux_reussite' => 92, 'date_fin' => '2026-12-20', 'statut' => 'termine'],
];

$topStudents = [
    ['nom' => 'Marie Laurent', 'groupe' => 'DWFS-2026', 'score' => 97],
    ['nom' => 'Thomas Dubois', 'groupe' => 'DSIA-2026', 'score' => 95],
    ['nom' => 'Sophie Martin', 'groupe' => 'DOC-2026', 'score' => 94],
    ['nom' => 'Lucas Bernard', 'groupe' => 'DWFS-2026', 'score' => 93],
    ['nom' => 'Emma Petit', 'groupe' => 'DSIA-2026', 'score' => 91],
];

$totalCerts = 45;
$certsThisMonth = 12;
$avgScore = 91;

$pageActions = '
<button class="cert-btn cert-btn--outline" onclick="openModal(\'settingsModal\')" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border: 1px solid #e2e8f0; color: #64748b; border-radius: 8px; font-weight: 500; cursor: pointer; margin-right: 12px;">
    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-settings"/></svg>
    Paramètres
</button>
<button class="cert-btn cert-btn--primary" onclick="generateBulkCerts()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
    <svg width="16" height="16"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
    Générer en masse
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

/* Layout */
.cert-page {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
}

/* Stats Row */
.cert-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.cert-stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
}

.cert-stat-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cert-stat-card__icon svg { width: 24px; height: 24px; color: white; }

.cert-stat-card__icon--purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
.cert-stat-card__icon--blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.cert-stat-card__icon--green { background: linear-gradient(135deg, #10b981, #34d399); }

.cert-stat-card__content { flex: 1; }
.cert-stat-card__title { font-size: 13px; color: #64748b; margin-bottom: 4px; }
.cert-stat-card__value { font-size: 26px; font-weight: 700; color: #1a1a2e; }

/* Card */
.cert-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    overflow: hidden;
}

.cert-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
}

.cert-card__title {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.cert-card__body { padding: 20px 24px; }
.cert-card__body--flush { padding: 0; }

/* Group List */
.cert-group-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.cert-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #f1f5f9;
    transition: all 0.2s;
}

.cert-group-item:hover {
    background: white;
    border-color: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.cert-group-item__info { flex: 1; }

.cert-group-item__name {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.cert-group-item__meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #64748b;
}

.cert-group-item__meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.cert-group-item__meta svg { width: 12px; height: 12px; color: #94a3b8; }

.cert-group-item__stats {
    display: flex;
    align-items: center;
    gap: 20px;
}

.cert-group-item__rate {
    text-align: center;
}

.cert-group-item__rate-value {
    font-size: 18px;
    font-weight: 700;
    color: #10b981;
}

.cert-group-item__rate-label {
    font-size: 11px;
    color: #94a3b8;
    text-transform: uppercase;
}

.cert-group-item__actions { display: flex; gap: 8px; }

/* Ranking */
.cert-ranking-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.cert-ranking-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    background: #f8fafc;
    border-radius: 10px;
}

.cert-ranking-item__rank {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.cert-ranking-item__rank--gold { background: #fef3c7; color: #b45309; }
.cert-ranking-item__rank--silver { background: #f1f5f9; color: #475569; }
.cert-ranking-item__rank--bronze { background: #fed7aa; color: #c2410c; }
.cert-ranking-item__rank--default { background: #f1f5f9; color: #64748b; }

.cert-ranking-item__info { flex: 1; min-width: 0; }

.cert-ranking-item__name {
    font-size: 13px;
    font-weight: 600;
    color: #1a1a2e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cert-ranking-item__group {
    font-size: 11px;
    color: #94a3b8;
}

.cert-ranking-item__score {
    font-size: 14px;
    font-weight: 700;
    color: #8b5cf6;
}

/* Buttons */
.cert-btn {
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

.cert-btn svg { width: 16px; height: 16px; }

.cert-btn--primary { background: #8b5cf6; color: white; }
.cert-btn--primary:hover { background: #7c3aed; }

.cert-btn--success { background: #10b981; color: white; }
.cert-btn--success:hover { background: #059669; }

.cert-btn--outline { background: white; border: 1px solid #e2e8f0; color: #64748b; }
.cert-btn--outline:hover { background: #f8fafc; border-color: #cbd5e1; color: #1a1a2e; }

.cert-btn--ghost { background: transparent; color: #64748b; }
.cert-btn--ghost:hover { background: #f1f5f9; color: #1a1a2e; }

.cert-btn--icon { width: 32px; height: 32px; padding: 0; }

.cert-btn--sm { padding: 6px 10px; font-size: 12px; }

/* Badge */
.cert-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.cert-badge--green { background: #dcfce7; color: #16a34a; }
.cert-badge--blue { background: #dbeafe; color: #2563eb; }

/* Modal */
.cert-modal-backdrop {
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

.cert-modal-backdrop.active { display: flex; }

.cert-modal {
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

.cert-modal--lg { max-width: 680px; }

.cert-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}

.cert-modal__header h3 {
    font-size: 17px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.cert-modal__close {
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

.cert-modal__close:hover { background: #f1f5f9; }
.cert-modal__close svg { width: 18px; height: 18px; }

.cert-modal__body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.cert-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    flex-shrink: 0;
}

/* Form Elements */
.cert-form-group { margin-bottom: 20px; }
.cert-form-group:last-child { margin-bottom: 0; }

.cert-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.cert-form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
}

.cert-form-input,
.cert-form-select,
.cert-form-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.cert-form-input:focus,
.cert-form-select:focus,
.cert-form-textarea:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.cert-form-textarea { resize: vertical; min-height: 80px; }

/* Checkbox */
.cert-checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.cert-checkbox-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px;
    background: #f8fafc;
    border-radius: 10px;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.2s;
}

.cert-checkbox-item:hover { background: #f1f5f9; }
.cert-checkbox-item.active { background: #f3e8ff; border-color: #8b5cf6; }

.cert-checkbox-item input { display: none; }

.cert-checkbox-item__box {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}

.cert-checkbox-item.active .cert-checkbox-item__box {
    background: #8b5cf6;
    border-color: #8b5cf6;
}

.cert-checkbox-item__box svg { width: 12px; height: 12px; color: white; opacity: 0; transition: opacity 0.2s; }
.cert-checkbox-item.active .cert-checkbox-item__box svg { opacity: 1; }

.cert-checkbox-item__content { flex: 1; }

.cert-checkbox-item__title {
    font-size: 14px;
    font-weight: 500;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.cert-checkbox-item__desc {
    font-size: 12px;
    color: #64748b;
}

/* Certificate Preview */
.cert-preview {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 32px;
    text-align: center;
}

.cert-preview__header {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #64748b;
    margin-bottom: 8px;
}

.cert-preview__title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 24px;
}

.cert-preview__name {
    font-size: 20px;
    font-weight: 600;
    color: #8b5cf6;
    padding: 16px 0;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 24px;
}

.cert-preview__desc {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 24px;
}

.cert-preview__details {
    display: flex;
    justify-content: center;
    gap: 32px;
    font-size: 13px;
    color: #64748b;
}

/* Progress Circle */
.cert-progress-circle {
    width: 120px;
    height: 120px;
    margin: 0 auto 16px;
    position: relative;
}

.cert-progress-circle svg { transform: rotate(-90deg); }

.cert-progress-circle__bg {
    fill: none;
    stroke: #e2e8f0;
    stroke-width: 8;
}

.cert-progress-circle__bar {
    fill: none;
    stroke: #8b5cf6;
    stroke-width: 8;
    stroke-linecap: round;
    transition: stroke-dashoffset 0.5s ease;
}

.cert-progress-circle__text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
}

/* Responsive */
@media (max-width: 1200px) {
    .cert-page { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .cert-stats { grid-template-columns: 1fr; }
    .cert-form-row { grid-template-columns: 1fr; }
    .cert-group-item { flex-direction: column; align-items: flex-start; gap: 12px; }
    .cert-group-item__stats { width: 100%; justify-content: space-between; }
}
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Stats Row -->
<div class="cert-stats">
    <div class="cert-stat-card">
        <div class="cert-stat-card__icon cert-stat-card__icon--purple">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-award"/></svg>
        </div>
        <div class="cert-stat-card__content">
            <div class="cert-stat-card__title">Total Certificats</div>
            <div class="cert-stat-card__value"><?= $totalCerts ?></div>
        </div>
    </div>
    <div class="cert-stat-card">
        <div class="cert-stat-card__icon cert-stat-card__icon--blue">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-calendar"/></svg>
        </div>
        <div class="cert-stat-card__content">
            <div class="cert-stat-card__title">Ce Mois</div>
            <div class="cert-stat-card__value"><?= $certsThisMonth ?></div>
        </div>
    </div>
    <div class="cert-stat-card">
        <div class="cert-stat-card__icon cert-stat-card__icon--green">
            <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-trending-up"/></svg>
        </div>
        <div class="cert-stat-card__content">
            <div class="cert-stat-card__title">Score Moyen</div>
            <div class="cert-stat-card__value"><?= $avgScore ?>%</div>
        </div>
    </div>
</div>

<div class="cert-page">
    <!-- Main Content -->
    <div class="cert-main">
        <!-- Eligible Groups -->
        <div class="cert-card" style="margin-bottom: 24px;">
            <div class="cert-card__header">
                <h3 class="cert-card__title">Groupes Éligibles</h3>
                <span class="cert-badge cert-badge--green"><?= count($groupesEligibles) ?> groupes</span>
            </div>
            <div class="cert-card__body">
                <div class="cert-group-list">
                    <?php foreach ($groupesEligibles as $groupe): ?>
                    <div class="cert-group-item">
                        <div class="cert-group-item__info">
                            <div class="cert-group-item__name"><?= htmlspecialchars($groupe['nom']) ?></div>
                            <div class="cert-group-item__meta">
                                <span>
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-hash"/></svg>
                                    <?= $groupe['code'] ?>
                                </span>
                                <span>
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-users"/></svg>
                                    <?= $groupe['nb_etudiants'] ?> étudiants
                                </span>
                                <span>
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-calendar"/></svg>
                                    <?= date('d/m/Y', strtotime($groupe['date_fin'])) ?>
                                </span>
                            </div>
                        </div>
                        <div class="cert-group-item__stats">
                            <div class="cert-group-item__rate">
                                <div class="cert-group-item__rate-value"><?= $groupe['taux_reussite'] ?>%</div>
                                <div class="cert-group-item__rate-label">Réussite</div>
                            </div>
                            <div class="cert-group-item__actions">
                                <button class="cert-btn cert-btn--outline cert-btn--sm" onclick="previewCert(<?= $groupe['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                                    Aperçu
                                </button>
                                <button class="cert-btn cert-btn--success cert-btn--sm" onclick="generateCerts(<?= $groupe['id'] ?>)">
                                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
                                    Générer
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Certificate Preview -->
        <div class="cert-card">
            <div class="cert-card__header">
                <h3 class="cert-card__title">Aperçu du Certificat</h3>
                <button class="cert-btn cert-btn--outline cert-btn--sm" onclick="openModal('settingsModal')">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-edit"/></svg>
                    Personnaliser
                </button>
            </div>
            <div class="cert-card__body">
                <div class="cert-preview">
                    <div class="cert-preview__header">Certificat de Réussite</div>
                    <div class="cert-preview__title">Formation Professionnelle</div>
                    <div class="cert-preview__name">Marie Laurent</div>
                    <div class="cert-preview__desc">
                        A complété avec succès la formation<br>
                        <strong>Développement Web Full Stack</strong><br>
                        avec un score de 97%
                    </div>
                    <div class="cert-preview__details">
                        <span>Date : 15/12/2026</span>
                        <span>Réf : DWFS-2026-001</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="cert-sidebar">
        <!-- Top Students -->
        <div class="cert-card" style="margin-bottom: 24px;">
            <div class="cert-card__header">
                <h3 class="cert-card__title">Top Étudiants</h3>
            </div>
            <div class="cert-card__body">
                <div class="cert-ranking-list">
                    <?php foreach ($topStudents as $index => $student): ?>
                    <?php
                    $rankClass = match($index) {
                        0 => 'gold',
                        1 => 'silver',
                        2 => 'bronze',
                        default => 'default'
                    };
                    ?>
                    <div class="cert-ranking-item">
                        <div class="cert-ranking-item__rank cert-ranking-item__rank--<?= $rankClass ?>">
                            <?= $index + 1 ?>
                        </div>
                        <div class="cert-ranking-item__info">
                            <div class="cert-ranking-item__name"><?= htmlspecialchars($student['nom']) ?></div>
                            <div class="cert-ranking-item__group"><?= $student['groupe'] ?></div>
                        </div>
                        <div class="cert-ranking-item__score"><?= $student['score'] ?>%</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Global Stats -->
        <div class="cert-card">
            <div class="cert-card__header">
                <h3 class="cert-card__title">Taux Global</h3>
            </div>
            <div class="cert-card__body" style="text-align: center;">
                <div class="cert-progress-circle">
                    <svg viewBox="0 0 120 120" width="120" height="120">
                        <circle class="cert-progress-circle__bg" cx="60" cy="60" r="52"/>
                        <circle class="cert-progress-circle__bar" cx="60" cy="60" r="52" 
                            stroke-dasharray="327" stroke-dashoffset="26"/>
                    </svg>
                    <div class="cert-progress-circle__text">92%</div>
                </div>
                <div style="font-size: 13px; color: #64748b;">Taux de réussite global</div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div class="cert-modal-backdrop" id="settingsModal">
    <div class="cert-modal cert-modal--lg">
        <div class="cert-modal__header">
            <h3>Paramètres du Certificat</h3>
            <button class="cert-modal__close" onclick="closeModal('settingsModal')">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <div class="cert-modal__body">
            <div class="cert-form-group">
                <label class="cert-form-label">Titre du certificat</label>
                <input type="text" class="cert-form-input" value="Certificat de Réussite">
            </div>
            
            <div class="cert-form-group">
                <label class="cert-form-label">Sous-titre</label>
                <input type="text" class="cert-form-input" value="Formation Professionnelle">
            </div>
            
            <div class="cert-form-group">
                <label class="cert-form-label">Texte du certificat</label>
                <textarea class="cert-form-textarea" rows="4">A complété avec succès la formation {formation} avec un score de {score}%</textarea>
            </div>
            
            <div class="cert-form-row">
                <div class="cert-form-group">
                    <label class="cert-form-label">Signataire</label>
                    <input type="text" class="cert-form-input" value="Le Directeur">
                </div>
                <div class="cert-form-group">
                    <label class="cert-form-label">Nom du signataire</label>
                    <input type="text" class="cert-form-input" value="M. Pierre Durant">
                </div>
            </div>
            
            <div class="cert-form-group">
                <label class="cert-form-label">Éléments à inclure</label>
                <div class="cert-checkbox-group">
                    <label class="cert-checkbox-item active">
                        <input type="checkbox" checked>
                        <div class="cert-checkbox-item__box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <div class="cert-checkbox-item__content">
                            <div class="cert-checkbox-item__title">Score final</div>
                            <div class="cert-checkbox-item__desc">Afficher le score de l'étudiant</div>
                        </div>
                    </label>
                    <label class="cert-checkbox-item active">
                        <input type="checkbox" checked>
                        <div class="cert-checkbox-item__box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <div class="cert-checkbox-item__content">
                            <div class="cert-checkbox-item__title">Numéro de référence</div>
                            <div class="cert-checkbox-item__desc">Identifiant unique du certificat</div>
                        </div>
                    </label>
                    <label class="cert-checkbox-item">
                        <input type="checkbox">
                        <div class="cert-checkbox-item__box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <div class="cert-checkbox-item__content">
                            <div class="cert-checkbox-item__title">QR Code de vérification</div>
                            <div class="cert-checkbox-item__desc">Code pour vérifier l'authenticité</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="cert-modal__footer">
            <button type="button" class="cert-btn cert-btn--outline" onclick="closeModal('settingsModal')">Annuler</button>
            <button type="button" class="cert-btn cert-btn--primary" onclick="saveSettings()">
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

// Checkbox toggles
document.querySelectorAll('.cert-checkbox-item').forEach(item => {
    item.addEventListener('click', function() {
        const checkbox = this.querySelector('input');
        checkbox.checked = !checkbox.checked;
        this.classList.toggle('active', checkbox.checked);
    });
});

// Certificate actions
function previewCert(groupeId) {
    showToast('Aperçu du certificat chargé', 'info');
}

function generateCerts(groupeId) {
    showToast('Certificats générés avec succès', 'success');
}

function generateBulkCerts() {
    showToast('Génération en masse démarrée', 'info');
}

function saveSettings() {
    showToast('Paramètres enregistrés', 'success');
    closeModal('settingsModal');
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
