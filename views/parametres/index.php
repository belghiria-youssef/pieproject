<?php
$pageTitle = 'Paramètres';
$currentPage = 'parametres';
$breadcrumb = 'Paramètres';

ob_start();
?>

<div class="settings-container">
    <!-- Profile Section -->
    <div class="settings-card">
        <div class="settings-card__header">
            <h3 class="settings-card__title">Mon Profil</h3>
            <p class="settings-card__subtitle">Informations personnelles</p>
        </div>
        <div class="settings-card__body">
            <div class="profile-section">
                <div class="profile-avatar">
                    <div class="profile-avatar__image">
                        <?= strtoupper(substr($_SESSION['user']['prenom'] ?? 'F', 0, 1)) ?>
                    </div>
                    <button class="profile-avatar__edit">
                        <svg width="14" height="14"><use href="#icon-edit"/></svg>
                    </button>
                </div>
                <div class="profile-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'Formateur') ?> <?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?></h4>
                    <p>Formateur</p>
                </div>
            </div>
            
            <form class="settings-form">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-input" value="<?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'Mohammed') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-input" value="<?= htmlspecialchars($_SESSION['user']['nom'] ?? 'Alaoui') ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? 'formateur@email.com') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-input" value="+212 6 12 34 56 78">
                    </div>
                </div>
            </form>
        </div>
        <div class="settings-card__footer">
            <button class="btn btn--primary">
                <svg width="14" height="14"><use href="#icon-check"/></svg>
                Enregistrer
            </button>
        </div>
    </div>
    
    <!-- Security Section -->
    <div class="settings-card">
        <div class="settings-card__header">
            <h3 class="settings-card__title">Sécurité</h3>
            <p class="settings-card__subtitle">Mot de passe et connexion</p>
        </div>
        <div class="settings-card__body">
            <form class="settings-form">
                <div class="form-group">
                    <label class="form-label">Mot de passe actuel</label>
                    <input type="password" class="form-input" placeholder="••••••••">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-input" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirmer</label>
                        <input type="password" class="form-input" placeholder="••••••••">
                    </div>
                </div>
            </form>
        </div>
        <div class="settings-card__footer">
            <button class="btn btn--outline">
                Changer le mot de passe
            </button>
        </div>
    </div>
</div>

<style>
/* Settings Container */
.settings-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 720px;
}

/* Settings Card */
.settings-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.settings-card__header {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.settings-card__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.settings-card__subtitle {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 2px 0 0;
}

.settings-card__body {
    padding: 20px;
}

.settings-card__footer {
    padding: 14px 20px;
    background: rgba(0, 0, 0, 0.02);
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

/* Profile Section */
.profile-section {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.profile-avatar {
    position: relative;
}

.profile-avatar__image {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 600;
}

.profile-avatar__edit {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 24px;
    height: 24px;
    border-radius: 6px;
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.1);
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.profile-avatar__edit:hover {
    background: #f3f4f6;
    color: #1a1a2e;
}

.profile-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}

.profile-info p {
    font-size: 0.8125rem;
    color: #9ca3af;
    margin: 2px 0 0;
}

/* Form Elements */
.settings-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #374151;
}

.form-input,
.form-select {
    height: 38px;
    padding: 0 12px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    font-size: 0.8125rem;
    color: #1a1a2e;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

/* Preference Items */
.preference-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
}

.preference-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.preference-item:first-child {
    padding-top: 0;
}

.preference-item__info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.preference-item__label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #1a1a2e;
}

.preference-item__desc {
    font-size: 0.75rem;
    color: #9ca3af;
}

.preference-item .form-select {
    width: 160px;
}

/* Toggle Switch */
.toggle {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 22px;
}

.toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle__slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #d1d5db;
    border-radius: 11px;
    transition: 0.2s ease;
}

.toggle__slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: 0.2s ease;
}

.toggle input:checked + .toggle__slider {
    background-color: #8b5cf6;
}

.toggle input:checked + .toggle__slider:before {
    transform: translateX(18px);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn--primary {
    background: #8b5cf6;
    color: white;
}

.btn--primary:hover {
    background: #7c3aed;
}

.btn--outline {
    background: transparent;
    border: 1px solid rgba(0, 0, 0, 0.1);
    color: #1a1a2e;
}

.btn--outline:hover {
    border-color: #8b5cf6;
    color: #8b5cf6;
}

/* Responsive */
@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .preference-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .preference-item .form-select {
        width: 100%;
    }
}
</style>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
// Form submit handler
document.querySelectorAll('.settings-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        showToast('Paramètres enregistrés avec succès', 'success');
    });
});

// Save button handler
document.querySelectorAll('.btn--primary').forEach(btn => {
    btn.addEventListener('click', function() {
        showToast('Modifications enregistrées', 'success');
    });
});
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
