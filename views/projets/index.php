<?php
$pageTitle = 'Documents & Travaux';
$pageSubtitle = 'Gérez les documents et travaux des groupes';
$currentPage = 'projets';
$breadcrumb = 'Documents & Travaux';

// Demo data - Groups
$groupes = [
    ['id' => 1, 'nom' => 'Groupe A', 'color' => '#8b5cf6'],
    ['id' => 2, 'nom' => 'Groupe B', 'color' => '#3b82f6'],
    ['id' => 3, 'nom' => 'Groupe C', 'color' => '#10b981'],
    ['id' => 4, 'nom' => 'Groupe D', 'color' => '#f59e0b'],
];

// Demo data - Documents
$documents = [
    [
        'id' => 1,
        'nom' => 'Présentation Projet Final.pptx',
        'type' => 'presentation',
        'taille' => '4.2 MB',
        'groupe_id' => 1,
        'groupe' => 'Groupe A',
        'date_ajout' => '2026-01-28',
        'phase' => 'Phase 5'
    ],
    [
        'id' => 2,
        'nom' => 'Rapport Technique.pdf',
        'type' => 'document',
        'taille' => '2.8 MB',
        'groupe_id' => 1,
        'groupe' => 'Groupe A',
        'date_ajout' => '2026-01-25',
        'phase' => 'Phase 4'
    ],
    [
        'id' => 3,
        'nom' => 'Maquette UI Design.png',
        'type' => 'image',
        'taille' => '1.5 MB',
        'groupe_id' => 2,
        'groupe' => 'Groupe B',
        'date_ajout' => '2026-01-27',
        'phase' => 'Phase 3'
    ],
    [
        'id' => 4,
        'nom' => 'Démo Application.mp4',
        'type' => 'video',
        'taille' => '45.6 MB',
        'groupe_id' => 2,
        'groupe' => 'Groupe B',
        'date_ajout' => '2026-01-30',
        'phase' => 'Phase 5'
    ],
    [
        'id' => 5,
        'nom' => 'Code Source.zip',
        'type' => 'archive',
        'taille' => '12.3 MB',
        'groupe_id' => 3,
        'groupe' => 'Groupe C',
        'date_ajout' => '2026-01-29',
        'phase' => 'Phase 4'
    ],
    [
        'id' => 6,
        'nom' => 'Cahier des Charges.docx',
        'type' => 'document',
        'taille' => '856 KB',
        'groupe_id' => 3,
        'groupe' => 'Groupe C',
        'date_ajout' => '2026-01-15',
        'phase' => 'Phase 1'
    ],
    [
        'id' => 7,
        'nom' => 'Diagramme Architecture.png',
        'type' => 'image',
        'taille' => '980 KB',
        'groupe_id' => 4,
        'groupe' => 'Groupe D',
        'date_ajout' => '2026-01-20',
        'phase' => 'Phase 2'
    ],
    [
        'id' => 8,
        'nom' => 'Tutoriel Installation.mp4',
        'type' => 'video',
        'taille' => '28.4 MB',
        'groupe_id' => 1,
        'groupe' => 'Groupe A',
        'date_ajout' => '2026-01-31',
        'phase' => 'Phase 5'
    ],
];

// File type icons and colors
$fileTypes = [
    'document' => ['icon' => 'file-text', 'color' => '#3b82f6', 'label' => 'Document'],
    'presentation' => ['icon' => 'presentation', 'color' => '#f59e0b', 'label' => 'Présentation'],
    'image' => ['icon' => 'image', 'color' => '#10b981', 'label' => 'Image'],
    'video' => ['icon' => 'video', 'color' => '#ef4444', 'label' => 'Vidéo'],
    'archive' => ['icon' => 'archive', 'color' => '#8b5cf6', 'label' => 'Archive'],
];

// Stats
$totalDocs = count($documents);
$totalSize = '96.6 MB';
$docsThisWeek = 5;

$pageActions = '
<button class="projets-btn projets-btn--primary" onclick="openModal(\'uploadModal\')" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
    <svg width="18" height="18"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-upload"/></svg>
    Ajouter un fichier
</button>
';

ob_start();
?>

<style>
/* Tabs */
.projets-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.projets-tab-btn {
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

.projets-tab-btn:hover {
    color: #8b5cf6;
}

.projets-tab-btn.active {
    color: #8b5cf6;
    border-bottom-color: #8b5cf6;
}

.projets-tab-btn svg {
    width: 18px;
    height: 18px;
}

.projets-tab-content {
    display: none;
}

.projets-tab-content.active {
    display: block;
}

/* Search & Filters */
.projets-filters {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.projets-search {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.projets-search__icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #94a3b8;
}

.projets-search__input {
    width: 100%;
    padding: 10px 14px 10px 44px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.projets-search__input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.projets-filter-group {
    display: flex;
    gap: 12px;
}

.projets-select {
    padding: 10px 36px 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center;
    cursor: pointer;
    -webkit-appearance: none;
    min-width: 160px;
}

.projets-select:focus {
    outline: none;
    border-color: #8b5cf6;
}

/* File Grid */
.files-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.file-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.file-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.file-card__preview {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.file-card__icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-card__icon svg {
    width: 28px;
    height: 28px;
    color: white;
}

.file-card__type-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
    color: white;
}

.file-card__body {
    padding: 16px;
}

.file-card__name {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 8px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-card__meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.file-card__groupe {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
}

.file-card__groupe-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.file-card__size {
    font-size: 12px;
    color: #94a3b8;
}

.file-card__info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}

.file-card__phase {
    font-size: 12px;
    color: #8b5cf6;
    font-weight: 500;
}

.file-card__date {
    font-size: 12px;
    color: #94a3b8;
}

.file-card__actions {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
}

.file-card__btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.file-card__btn svg {
    width: 16px;
    height: 16px;
}

.file-card__btn--ghost {
    background: transparent;
    color: #64748b;
}

.file-card__btn--ghost:hover {
    background: #e2e8f0;
    color: #1a1a2e;
}

.file-card__btn--primary {
    background: #8b5cf6;
    color: white;
}

.file-card__btn--primary:hover {
    background: #7c3aed;
}

/* Group View */
.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.group-folder {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.group-folder__header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.group-folder__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.group-folder__icon svg {
    width: 24px;
    height: 24px;
    color: white;
}

.group-folder__info h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
}

.group-folder__info p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.group-folder__body {
    padding: 16px 20px;
}

.group-folder__stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 16px;
}

.group-folder__stat {
    background: #f8fafc;
    border-radius: 8px;
    padding: 12px;
    text-align: center;
}

.group-folder__stat-value {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a2e;
}

.group-folder__stat-label {
    font-size: 12px;
    color: #64748b;
}

.group-folder__types {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.group-folder__type-tag {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: 12px;
    color: #475569;
}

.group-folder__type-tag svg {
    width: 14px;
    height: 14px;
}

.group-folder__footer {
    display: flex;
    gap: 12px;
    padding: 16px 20px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
}

/* Recent Activity */
.activity-list {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.activity-list__header {
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.activity-list__header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background: #f8fafc;
}

.activity-item__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-item__icon svg {
    width: 20px;
    height: 20px;
    color: white;
}

.activity-item__content {
    flex: 1;
    min-width: 0;
}

.activity-item__name {
    font-size: 14px;
    font-weight: 500;
    color: #1a1a2e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-item__meta {
    display: flex;
    gap: 12px;
    font-size: 13px;
    color: #64748b;
}

.activity-item__actions {
    display: flex;
    gap: 8px;
}

/* Buttons */
.projets-btn {
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

.projets-btn svg {
    width: 16px;
    height: 16px;
}

.projets-btn--ghost {
    background: transparent;
    color: #64748b;
}

.projets-btn--ghost:hover {
    background: #f1f5f9;
    color: #1a1a2e;
}

.projets-btn--primary {
    background: #8b5cf6;
    color: white;
}

.projets-btn--primary:hover {
    background: #7c3aed;
}

.projets-btn--sm {
    padding: 6px 12px;
    font-size: 13px;
}

/* Modal */
.projets-modal-backdrop {
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

.projets-modal-backdrop.active {
    display: flex;
}

.projets-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.projets-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
}

.projets-modal__header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.projets-modal__close {
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

.projets-modal__close:hover {
    background: #f1f5f9;
}

.projets-modal__body {
    padding: 24px;
}

.projets-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
}

/* Upload Zone */
.upload-zone {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    transition: all 0.2s;
    cursor: pointer;
    margin-bottom: 20px;
}

.upload-zone:hover,
.upload-zone.dragover {
    border-color: #8b5cf6;
    background: #f8f5ff;
}

.upload-zone__icon {
    width: 56px;
    height: 56px;
    background: #f3e8ff;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.upload-zone__icon svg {
    width: 28px;
    height: 28px;
    color: #8b5cf6;
}

.upload-zone__text {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 8px;
}

.upload-zone__text strong {
    color: #8b5cf6;
}

.upload-zone__hint {
    font-size: 12px;
    color: #94a3b8;
}

/* Form Elements */
.projets-form-group {
    margin-bottom: 20px;
}

.projets-form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.projets-form-input,
.projets-form-select {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1a1a2e;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}

.projets-form-input:focus,
.projets-form-select:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
    margin: 0 0 20px 0;
}

@media (max-width: 768px) {
    .projets-filters {
        flex-direction: column;
    }
    
    .projets-filter-group {
        flex-direction: column;
    }
    
    .projets-select {
        width: 100%;
    }
    
    .files-grid,
    .groups-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Tabs -->
<div class="projets-tabs">
    <button class="projets-tab-btn active" data-tab="files-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-file-text"/></svg>
        Tous les fichiers
    </button>
    <button class="projets-tab-btn" data-tab="groups-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-folder"/></svg>
        Par groupe
    </button>
    <button class="projets-tab-btn" data-tab="recent-tab">
        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-clock"/></svg>
        Récents
    </button>
</div>

<!-- All Files Tab -->
<div class="projets-tab-content active" id="files-tab">
    <!-- Filters -->
    <div class="projets-filters">
        <div class="projets-search">
            <svg class="projets-search__icon"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-search"/></svg>
            <input type="text" class="projets-search__input" placeholder="Rechercher un fichier..." id="searchFile">
        </div>
        <div class="projets-filter-group">
            <select class="projets-select" id="filterGroupe">
                <option value="">Tous les groupes</option>
                <?php foreach ($groupes as $groupe): ?>
                <option value="<?= $groupe['id'] ?>"><?= $groupe['nom'] ?></option>
                <?php endforeach; ?>
            </select>
            <select class="projets-select" id="filterType">
                <option value="">Tous les types</option>
                <option value="document">Documents</option>
                <option value="presentation">Présentations</option>
                <option value="image">Images</option>
                <option value="video">Vidéos</option>
                <option value="archive">Archives</option>
            </select>
        </div>
    </div>
    
    <!-- Files Grid -->
    <div class="files-grid" id="filesGrid">
        <?php foreach ($documents as $doc): 
            $typeInfo = $fileTypes[$doc['type']];
            $groupeColor = '#8b5cf6';
            foreach ($groupes as $g) {
                if ($g['id'] == $doc['groupe_id']) {
                    $groupeColor = $g['color'];
                    break;
                }
            }
        ?>
        <div class="file-card" data-groupe="<?= $doc['groupe_id'] ?>" data-type="<?= $doc['type'] ?>">
            <div class="file-card__preview" style="background: linear-gradient(135deg, <?= $typeInfo['color'] ?>20, <?= $typeInfo['color'] ?>10);">
                <div class="file-card__icon" style="background: <?= $typeInfo['color'] ?>;">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-<?= $typeInfo['icon'] ?>"/></svg>
                </div>
                <span class="file-card__type-badge" style="background: <?= $typeInfo['color'] ?>;"><?= $typeInfo['label'] ?></span>
            </div>
            <div class="file-card__body">
                <h4 class="file-card__name" title="<?= htmlspecialchars($doc['nom']) ?>"><?= htmlspecialchars($doc['nom']) ?></h4>
                <div class="file-card__meta">
                    <span class="file-card__groupe">
                        <span class="file-card__groupe-dot" style="background: <?= $groupeColor ?>;"></span>
                        <?= htmlspecialchars($doc['groupe']) ?>
                    </span>
                    <span class="file-card__size"><?= $doc['taille'] ?></span>
                </div>
                <div class="file-card__info">
                    <span class="file-card__phase"><?= $doc['phase'] ?></span>
                    <span class="file-card__date"><?= date('d/m/Y', strtotime($doc['date_ajout'])) ?></span>
                </div>
            </div>
            <div class="file-card__actions">
                <button class="file-card__btn file-card__btn--ghost" onclick="previewFile(<?= $doc['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                    Aperçu
                </button>
                <button class="file-card__btn file-card__btn--primary" onclick="downloadFile(<?= $doc['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
                    Télécharger
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Groups Tab -->
<div class="projets-tab-content" id="groups-tab">
    <div class="groups-grid">
        <?php foreach ($groupes as $groupe): 
            $groupDocs = array_filter($documents, fn($d) => $d['groupe_id'] == $groupe['id']);
            $docCount = count($groupDocs);
            $typeCount = count(array_unique(array_column($groupDocs, 'type')));
        ?>
        <div class="group-folder">
            <div class="group-folder__header">
                <div class="group-folder__icon" style="background: <?= $groupe['color'] ?>;">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-folder"/></svg>
                </div>
                <div class="group-folder__info">
                    <h3><?= htmlspecialchars($groupe['nom']) ?></h3>
                    <p><?= $docCount ?> fichiers</p>
                </div>
            </div>
            <div class="group-folder__body">
                <div class="group-folder__stats">
                    <div class="group-folder__stat">
                        <div class="group-folder__stat-value"><?= $docCount ?></div>
                        <div class="group-folder__stat-label">Fichiers</div>
                    </div>
                    <div class="group-folder__stat">
                        <div class="group-folder__stat-value"><?= $typeCount ?></div>
                        <div class="group-folder__stat-label">Types</div>
                    </div>
                </div>
                <div class="group-folder__types">
                    <?php 
                    $types = array_unique(array_column(iterator_to_array($groupDocs), 'type'));
                    foreach ($types as $type):
                        $tInfo = $fileTypes[$type];
                    ?>
                    <span class="group-folder__type-tag">
                        <svg style="color: <?= $tInfo['color'] ?>;"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-<?= $tInfo['icon'] ?>"/></svg>
                        <?= $tInfo['label'] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="group-folder__footer">
                <button class="projets-btn projets-btn--ghost projets-btn--sm" style="flex: 1;" onclick="viewGroupFiles(<?= $groupe['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                    Voir les fichiers
                </button>
                <button class="projets-btn projets-btn--primary projets-btn--sm" style="flex: 1;" onclick="uploadToGroup(<?= $groupe['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-upload"/></svg>
                    Ajouter
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recent Tab -->
<div class="projets-tab-content" id="recent-tab">
    <div class="activity-list">
        <div class="activity-list__header">
            <h3>Activité récente</h3>
        </div>
        <?php 
        usort($documents, fn($a, $b) => strtotime($b['date_ajout']) - strtotime($a['date_ajout']));
        foreach ($documents as $doc): 
            $typeInfo = $fileTypes[$doc['type']];
        ?>
        <div class="activity-item">
            <div class="activity-item__icon" style="background: <?= $typeInfo['color'] ?>;">
                <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-<?= $typeInfo['icon'] ?>"/></svg>
            </div>
            <div class="activity-item__content">
                <div class="activity-item__name"><?= htmlspecialchars($doc['nom']) ?></div>
                <div class="activity-item__meta">
                    <span><?= $doc['groupe'] ?></span>
                    <span><?= $doc['phase'] ?></span>
                    <span><?= date('d/m/Y', strtotime($doc['date_ajout'])) ?></span>
                </div>
            </div>
            <div class="activity-item__actions">
                <button class="projets-btn projets-btn--ghost projets-btn--sm" onclick="previewFile(<?= $doc['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-eye"/></svg>
                </button>
                <button class="projets-btn projets-btn--primary projets-btn--sm" onclick="downloadFile(<?= $doc['id'] ?>)">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-download"/></svg>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Upload Modal -->
<div class="projets-modal-backdrop" id="uploadModal">
    <div class="projets-modal">
        <div class="projets-modal__header">
            <h3>Ajouter un fichier</h3>
            <button class="projets-modal__close" onclick="closeModal('uploadModal')">
                <svg width="20" height="20"><use href="/PIE_PROJECT/public/icons/icons.svg#icon-x"/></svg>
            </button>
        </div>
        <form onsubmit="uploadFile(event)">
            <div class="projets-modal__body">
                <div class="upload-zone" id="uploadZone">
                    <div class="upload-zone__icon">
                        <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-upload"/></svg>
                    </div>
                    <p class="upload-zone__text">
                        Glissez vos fichiers ici ou <strong>parcourez</strong>
                    </p>
                    <p class="upload-zone__hint">PDF, DOCX, PPTX, PNG, JPG, MP4, ZIP (max 50MB)</p>
                    <input type="file" id="fileInput" hidden multiple>
                </div>
                
                <div class="projets-form-group">
                    <label class="projets-form-label">Groupe</label>
                    <select class="projets-form-select" id="uploadGroupe" required>
                        <option value="">Sélectionnez un groupe</option>
                        <?php foreach ($groupes as $groupe): ?>
                        <option value="<?= $groupe['id'] ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="projets-form-group">
                    <label class="projets-form-label">Phase</label>
                    <select class="projets-form-select" id="uploadPhase">
                        <option value="">Sélectionnez une phase</option>
                        <option value="Phase 1">Phase 1 - Initiation</option>
                        <option value="Phase 2">Phase 2 - Fondamentaux</option>
                        <option value="Phase 3">Phase 3 - Approfondissement</option>
                        <option value="Phase 4">Phase 4 - Projet Final</option>
                        <option value="Phase 5">Phase 5 - Soutenance</option>
                    </select>
                </div>
                
                <div class="projets-form-group">
                    <label class="projets-form-label">Description (optionnel)</label>
                    <input type="text" class="projets-form-input" id="uploadDesc" placeholder="Ajoutez une description...">
                </div>
            </div>
            <div class="projets-modal__footer">
                <button type="button" class="projets-btn projets-btn--ghost" onclick="closeModal('uploadModal')">Annuler</button>
                <button type="submit" class="projets-btn projets-btn--primary">
                    <svg><use href="/PIE_PROJECT/public/icons/icons.svg#icon-upload"/></svg>
                    Téléverser
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
// Tab functionality
document.querySelectorAll('.projets-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.projets-tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const targetId = this.dataset.tab;
        document.querySelectorAll('.projets-tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(targetId).classList.add('active');
    });
});

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

// Search and filter
document.getElementById('searchFile')?.addEventListener('input', filterFiles);
document.getElementById('filterGroupe')?.addEventListener('change', filterFiles);
document.getElementById('filterType')?.addEventListener('change', filterFiles);

function filterFiles() {
    const search = document.getElementById('searchFile').value.toLowerCase();
    const groupe = document.getElementById('filterGroupe').value;
    const type = document.getElementById('filterType').value;
    
    document.querySelectorAll('.file-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        const cardGroupe = card.dataset.groupe;
        const cardType = card.dataset.type;
        
        const matchSearch = text.includes(search);
        const matchGroupe = !groupe || cardGroupe === groupe;
        const matchType = !type || cardType === type;
        
        card.style.display = (matchSearch && matchGroupe && matchType) ? '' : 'none';
    });
}

// Upload zone
const uploadZone = document.getElementById('uploadZone');
const fileInput = document.getElementById('fileInput');

uploadZone?.addEventListener('click', () => fileInput.click());

uploadZone?.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});

uploadZone?.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragover');
});

uploadZone?.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    handleFiles(files);
});

fileInput?.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    console.log('Files selected:', files);
    // Handle file upload
}

function uploadFile(e) {
    e.preventDefault();
    alert('Fichier téléversé avec succès');
    closeModal('uploadModal');
}

// File actions
function previewFile(id) {
    alert('Aperçu du fichier #' + id);
}

function downloadFile(id) {
    alert('Téléchargement du fichier #' + id);
}

function viewGroupFiles(groupId) {
    document.getElementById('filterGroupe').value = groupId;
    document.querySelector('[data-tab="files-tab"]').click();
    filterFiles();
}

function uploadToGroup(groupId) {
    document.getElementById('uploadGroupe').value = groupId;
    openModal('uploadModal');
}
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
