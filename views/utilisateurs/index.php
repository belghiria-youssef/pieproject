<?php
$pageTitle = 'Utilisateurs';
$pageSubtitle = 'Gérez les comptes administrateurs et formateurs';
$currentPage = 'utilisateurs';
$breadcrumb = 'Utilisateurs';

// Demo data
$utilisateurs = [
    [
        'id' => 1,
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean.dupont@formation.com',
        'role' => 'Admin',
        'statut' => 'Actif',
        'derniere_connexion' => '2026-01-15 09:30',
        'date_creation' => '2023-06-01'
    ],
    [
        'id' => 2,
        'nom' => 'Martin',
        'prenom' => 'Sophie',
        'email' => 'sophie.martin@formation.com',
        'role' => 'Formateur',
        'statut' => 'Actif',
        'derniere_connexion' => '2026-01-15 14:45',
        'date_creation' => '2023-08-15'
    ],
    [
        'id' => 3,
        'nom' => 'Bernard',
        'prenom' => 'Pierre',
        'email' => 'pierre.bernard@formation.com',
        'role' => 'Formateur',
        'statut' => 'Actif',
        'derniere_connexion' => '2026-01-14 16:20',
        'date_creation' => '2023-09-01'
    ],
    [
        'id' => 4,
        'nom' => 'Leroy',
        'prenom' => 'Marie',
        'email' => 'marie.leroy@formation.com',
        'role' => 'Admin',
        'statut' => 'Inactif',
        'derniere_connexion' => '2023-12-20 11:00',
        'date_creation' => '2023-07-10'
    ],
    [
        'id' => 5,
        'nom' => 'Moreau',
        'prenom' => 'Paul',
        'email' => 'paul.moreau@formation.com',
        'role' => 'Formateur',
        'statut' => 'Actif',
        'derniere_connexion' => '2026-01-15 08:15',
        'date_creation' => '2023-10-20'
    ],
];

$roles = ['Admin', 'Formateur'];
$statuts = ['Actif', 'Inactif'];

$pageActions = '
<button class="btn btn-outline">
    <svg width="16" height="16"><use href="#icon-download"/></svg>
    Exporter
</button>
<button class="btn btn-primary" onclick="openModal(\'userModal\')">
    <svg width="16" height="16"><use href="#icon-plus"/></svg>
    Nouvel utilisateur
</button>
';

ob_start();
?>

<!-- Stats Row -->
<div class="stats-row mb-5">
    <div class="stat-card">
        <div class="stat-icon bg-primary-light">
            <svg width="24" height="24"><use href="#icon-users"/></svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= count($utilisateurs) ?></span>
            <span class="stat-label">Total utilisateurs</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-success-light">
            <svg width="24" height="24"><use href="#icon-shield"/></svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= count(array_filter($utilisateurs, fn($u) => $u['role'] === 'Admin')) ?></span>
            <span class="stat-label">Administrateurs</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-info-light">
            <svg width="24" height="24"><use href="#icon-user"/></svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= count(array_filter($utilisateurs, fn($u) => $u['role'] === 'Formateur')) ?></span>
            <span class="stat-label">Formateurs</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-warning-light">
            <svg width="24" height="24"><use href="#icon-check-circle"/></svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= count(array_filter($utilisateurs, fn($u) => $u['statut'] === 'Actif')) ?></span>
            <span class="stat-label">Utilisateurs actifs</span>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-5">
    <div class="card-body">
        <div class="filters-row">
            <div class="search-box">
                <svg width="20" height="20"><use href="#icon-search"/></svg>
                <input type="text" class="form-control" placeholder="Rechercher un utilisateur..." id="searchUser">
            </div>
            <select class="form-control" id="filterRole">
                <option value="">Tous les rôles</option>
                <?php foreach ($roles as $role): ?>
                <option value="<?= $role ?>"><?= $role ?></option>
                <?php endforeach; ?>
            </select>
            <select class="form-control" id="filterStatut">
                <option value="">Tous les statuts</option>
                <?php foreach ($statuts as $statut): ?>
                <option value="<?= $statut ?>"><?= $statut ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-ghost" onclick="resetFilters()">
                <svg width="16" height="16"><use href="#icon-x"/></svg>
                Réinitialiser
            </button>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Dernière connexion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <?php foreach ($utilisateurs as $user): ?>
                <tr data-id="<?= $user['id'] ?>">
                    <td>
                        <div class="d-flex align-center gap-3">
                            <div class="avatar avatar-md bg-<?= $user['role'] === 'Admin' ? 'primary' : 'secondary' ?>">
                                <?= strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)) ?>
                            </div>
                            <div>
                                <span class="font-medium"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                                <span class="d-block text-sm text-muted">Créé le <?= date('d/m/Y', strtotime($user['date_creation'])) ?></span>
                            </div>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <span class="badge badge-<?= $user['role'] === 'Admin' ? 'primary' : 'info' ?>">
                            <svg width="12" height="12"><use href="#icon-<?= $user['role'] === 'Admin' ? 'shield' : 'user' ?>"/></svg>
                            <?= $user['role'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-<?= $user['statut'] === 'Actif' ? 'success' : 'secondary' ?>">
                            <?= $user['statut'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="text-muted"><?= date('d/m/Y H:i', strtotime($user['derniere_connexion'])) ?></span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="btn btn-icon btn-ghost" title="Voir" onclick="viewUser(<?= $user['id'] ?>)">
                                <svg width="18" height="18"><use href="#icon-eye"/></svg>
                            </button>
                            <button class="btn btn-icon btn-ghost" title="Modifier" onclick="editUser(<?= $user['id'] ?>)">
                                <svg width="18" height="18"><use href="#icon-edit"/></svg>
                            </button>
                            <button class="btn btn-icon btn-ghost text-danger" title="Supprimer" onclick="confirmDelete(<?= $user['id'] ?>)">
                                <svg width="18" height="18"><use href="#icon-trash"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="card-footer">
        <div class="pagination-info">
            Affichage de 1-<?= count($utilisateurs) ?> sur <?= count($utilisateurs) ?> utilisateurs
        </div>
        <div class="pagination">
            <button class="pagination-btn" disabled>&laquo;</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn" disabled>&raquo;</button>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal-backdrop" id="userModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="userModalTitle">Nouvel utilisateur</h3>
            <button class="modal-close" onclick="closeModal('userModal')">
                <svg width="20" height="20"><use href="#icon-x"/></svg>
            </button>
        </div>
        <form id="userForm" onsubmit="saveUser(event)">
            <div class="modal-body">
                <input type="hidden" id="userId" name="id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="userPrenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" id="userPrenom" name="prenom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="userNom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" id="userNom" name="nom" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="userEmail" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" id="userEmail" name="email" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="userRole" class="form-label">Rôle <span class="text-danger">*</span></label>
                        <select id="userRole" name="role" class="form-control" required>
                            <option value="">Sélectionner un rôle</option>
                            <?php foreach ($roles as $role): ?>
                            <option value="<?= $role ?>"><?= $role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userStatut" class="form-label">Statut</label>
                        <select id="userStatut" name="statut" class="form-control">
                            <?php foreach ($statuts as $statut): ?>
                            <option value="<?= $statut ?>"><?= $statut ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" id="passwordGroup">
                    <label for="userPassword" class="form-label">Mot de passe <span class="text-danger" id="passwordRequired">*</span></label>
                    <div class="password-input-group">
                        <input type="password" id="userPassword" name="password" class="form-control">
                        <button type="button" class="btn btn-ghost btn-icon" onclick="togglePassword('userPassword')">
                            <svg width="18" height="18"><use href="#icon-eye"/></svg>
                        </button>
                    </div>
                    <span class="form-hint">Minimum 8 caractères</span>
                </div>
                
                <div class="form-group">
                    <label for="userPasswordConfirm" class="form-label">Confirmer le mot de passe</label>
                    <div class="password-input-group">
                        <input type="password" id="userPasswordConfirm" name="password_confirm" class="form-control">
                        <button type="button" class="btn btn-ghost btn-icon" onclick="togglePassword('userPasswordConfirm')">
                            <svg width="18" height="18"><use href="#icon-eye"/></svg>
                        </button>
                    </div>
                </div>
                
                <div class="permissions-section" id="permissionsSection">
                    <h4 class="text-sm font-medium mb-3">Permissions</h4>
                    <div class="permissions-grid">
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="view_students">
                            <span>Voir les étudiants</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="edit_students">
                            <span>Modifier les étudiants</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="manage_groups">
                            <span>Gérer les groupes</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="manage_classes">
                            <span>Gérer les classes</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="manage_projects">
                            <span>Gérer les projets</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="attribute_points">
                            <span>Attribuer des points</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="generate_certificates">
                            <span>Générer les certificats</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="permissions[]" value="manage_users">
                            <span>Gérer les utilisateurs</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('userModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16"><use href="#icon-check"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View User Modal -->
<div class="modal-backdrop" id="viewUserModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Détails de l'utilisateur</h3>
            <button class="modal-close" onclick="closeModal('viewUserModal')">
                <svg width="20" height="20"><use href="#icon-x"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="user-profile">
                <div class="user-profile-header">
                    <div class="avatar avatar-xl bg-primary" id="viewUserAvatar">JD</div>
                    <div>
                        <h3 id="viewUserName">Jean Dupont</h3>
                        <p class="text-muted" id="viewUserEmail">jean.dupont@formation.com</p>
                    </div>
                </div>
                
                <div class="user-details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Rôle</span>
                        <span class="detail-value" id="viewUserRole">Admin</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Statut</span>
                        <span class="detail-value" id="viewUserStatut">Actif</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date de création</span>
                        <span class="detail-value" id="viewUserCreation">01/06/2023</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Dernière connexion</span>
                        <span class="detail-value" id="viewUserLastLogin">15/01/2026 09:30</span>
                    </div>
                </div>
                
                <div class="user-activity">
                    <h4 class="text-sm font-medium mb-3">Activité récente</h4>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon bg-info-light">
                                <svg width="16" height="16"><use href="#icon-check-circle"/></svg>
                            </div>
                            <div class="activity-content">
                                <span>Connexion au système</span>
                                <span class="text-muted text-sm">Il y a 2 heures</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-success-light">
                                <svg width="16" height="16"><use href="#icon-edit"/></svg>
                            </div>
                            <div class="activity-content">
                                <span>Modification des points du Groupe A</span>
                                <span class="text-muted text-sm">Il y a 3 heures</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-primary-light">
                                <svg width="16" height="16"><use href="#icon-plus"/></svg>
                            </div>
                            <div class="activity-content">
                                <span>Ajout d'un nouvel étudiant</span>
                                <span class="text-muted text-sm">Hier</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('viewUserModal')">Fermer</button>
            <button class="btn btn-primary" onclick="closeModal('viewUserModal'); editUser(currentViewUserId)">
                <svg width="16" height="16"><use href="#icon-edit"/></svg>
                Modifier
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-backdrop" id="deleteModal">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Confirmer la suppression</h3>
            <button class="modal-close" onclick="closeModal('deleteModal')">
                <svg width="20" height="20"><use href="#icon-x"/></svg>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="delete-icon">
                <svg width="48" height="48"><use href="#icon-alert-triangle"/></svg>
            </div>
            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
            <p class="text-muted text-sm">Cette action est irréversible.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('deleteModal')">Annuler</button>
            <button class="btn btn-danger" onclick="deleteUser()">
                <svg width="16" height="16"><use href="#icon-trash"/></svg>
                Supprimer
            </button>
        </div>
    </div>
</div>

<style>
/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--space-4);
}

.stat-card {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon.bg-primary-light {
    background: var(--primary-lighter);
    color: var(--primary);
}

.stat-icon.bg-success-light {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.stat-icon.bg-info-light {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

.stat-icon.bg-warning-light {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Filters */
.filters-row {
    display: flex;
    gap: var(--space-3);
    align-items: center;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 200px;
}

.search-box svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}

.search-box .form-control {
    padding-left: 40px;
}

/* Table */
.table-actions {
    display: flex;
    gap: var(--space-1);
}

/* Form */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
}

.password-input-group {
    display: flex;
    gap: var(--space-2);
}

.password-input-group .form-control {
    flex: 1;
}

.permissions-section {
    margin-top: var(--space-4);
    padding-top: var(--space-4);
    border-top: 1px solid var(--border);
}

.permissions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-3);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    cursor: pointer;
    font-size: 0.875rem;
}

.checkbox-label input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--primary);
}

/* User Profile */
.user-profile-header {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    margin-bottom: var(--space-5);
}

.user-profile-header h3 {
    margin: 0;
}

.avatar-xl {
    width: 64px;
    height: 64px;
    font-size: 1.5rem;
}

.user-details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-4);
    margin-bottom: var(--space-5);
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-weight: 500;
    margin-top: 4px;
}

.user-activity {
    padding-top: var(--space-4);
    border-top: 1px solid var(--border);
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.activity-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.activity-content {
    display: flex;
    flex-direction: column;
}

/* Delete Modal */
.delete-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-4);
}

@media (max-width: 1024px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .form-row,
    .permissions-grid,
    .user-details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
$content = ob_get_clean();

$additionalScripts = <<<'JS'
<script>
let currentDeleteId = null;
let currentViewUserId = null;

// Filter functionality
document.getElementById('searchUser').addEventListener('input', filterUsers);
document.getElementById('filterRole').addEventListener('change', filterUsers);
document.getElementById('filterStatut').addEventListener('change', filterUsers);

function filterUsers() {
    const search = document.getElementById('searchUser').value.toLowerCase();
    const role = document.getElementById('filterRole').value;
    const statut = document.getElementById('filterStatut').value;
    
    document.querySelectorAll('#usersTableBody tr').forEach(row => {
        const name = row.querySelector('.font-medium').textContent.toLowerCase();
        const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const rowRole = row.querySelector('td:nth-child(3) .badge').textContent.trim();
        const rowStatut = row.querySelector('td:nth-child(4) .badge').textContent.trim();
        
        const matchesSearch = name.includes(search) || email.includes(search);
        const matchesRole = !role || rowRole === role;
        const matchesStatut = !statut || rowStatut === statut;
        
        row.style.display = matchesSearch && matchesRole && matchesStatut ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('searchUser').value = '';
    document.getElementById('filterRole').value = '';
    document.getElementById('filterStatut').value = '';
    filterUsers();
}

// CRUD Operations
function viewUser(id) {
    currentViewUserId = id;
    // In real app, fetch user data
    openModal('viewUserModal');
}

function editUser(id) {
    document.getElementById('userModalTitle').textContent = 'Modifier l\'utilisateur';
    document.getElementById('userId').value = id;
    document.getElementById('passwordRequired').style.display = 'none';
    document.getElementById('userPassword').removeAttribute('required');
    // In real app, populate form with user data
    openModal('userModal');
}

function saveUser(e) {
    e.preventDefault();
    
    const password = document.getElementById('userPassword').value;
    const confirm = document.getElementById('userPasswordConfirm').value;
    
    if (password && password !== confirm) {
        showToast('Les mots de passe ne correspondent pas', 'error');
        return;
    }
    
    if (password && password.length < 8) {
        showToast('Le mot de passe doit contenir au moins 8 caractères', 'error');
        return;
    }
    
    showToast('Utilisateur enregistré avec succès', 'success');
    closeModal('userModal');
    document.getElementById('userForm').reset();
}

function confirmDelete(id) {
    currentDeleteId = id;
    openModal('deleteModal');
}

function deleteUser() {
    showToast('Utilisateur supprimé avec succès', 'success');
    closeModal('deleteModal');
    // In real app, remove row from table
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

// Role change handler - show/hide permissions
document.getElementById('userRole').addEventListener('change', function() {
    const permissionsSection = document.getElementById('permissionsSection');
    if (this.value === 'Admin') {
        permissionsSection.style.display = 'none';
        // Check all permissions for admin
        document.querySelectorAll('[name="permissions[]"]').forEach(cb => cb.checked = true);
    } else {
        permissionsSection.style.display = 'block';
    }
});

// Reset form when modal opens for new user
document.querySelector('[onclick="openModal(\'userModal\')"]').addEventListener('click', function() {
    document.getElementById('userModalTitle').textContent = 'Nouvel utilisateur';
    document.getElementById('userId').value = '';
    document.getElementById('passwordRequired').style.display = '';
    document.getElementById('userPassword').setAttribute('required', '');
    document.getElementById('userForm').reset();
    document.getElementById('permissionsSection').style.display = 'block';
});
</script>
JS;

include __DIR__ . '/../layouts/main.php';
?>
