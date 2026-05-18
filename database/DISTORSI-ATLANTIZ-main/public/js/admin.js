"use strict";

// Data Dummy
let studios = [
    { id: 1, nama: 'Studio Regular', tipe: 'regular', harga: 75000 },
    { id: 2, nama: 'Studio Premium', tipe: 'premium', harga: 150000 },
];
let bookings = [
    { id: 1, user: 'Budi', studio: 'Studio Regular', tanggal: '2025-05-15', status: 'confirmed' },
    { id: 2, user: 'Siti', studio: 'Studio Premium', tanggal: '2025-05-16', status: 'pending' },
];
let users = [
    { id: 1, nama: 'Admin', email: 'admin@example.com', role: 'admin' },
    { id: 2, nama: 'Budi', email: 'budi@example.com', role: 'user' },
];

let currentType = '';

// Update Stats
function updateStats() {
    document.getElementById('totalStudios').innerText = studios.length;
    document.getElementById('totalBookings').innerText = bookings.length;
    document.getElementById('totalUsers').innerText = users.length;
    document.getElementById('totalRevenue').innerText = 'Rp' + bookings.length * 100000;
}

// Load Data
function loadRecentBookings() {
    let html = '';
    bookings.slice(0, 5).forEach(b => {
        html += `<tr><td>${b.user}</td><td>${b.studio}</td><td>${b.tanggal}</td><td><span class="status-badge status-${b.status}">${b.status}</span></td></tr>`;
    });
    document.getElementById('recentBookings').innerHTML = html;
}

function loadStudios() {
    let html = '';
    studios.forEach(s => {
        html += `<tr>
            <td>${s.nama}</td>
            <td>${s.tipe}</td>
            <td>Rp${s.harga}</td>
            <td><button class="btn-edit" onclick="editItem('studio',${s.id})"><i class="bi bi-pencil"></i></button><button class="btn-delete" onclick="deleteItem('studio',${s.id})"><i class="bi bi-trash"></i></button></td>
        </tr>`;
    });
    document.getElementById('studiosTable').innerHTML = html;
}

function loadBookings() {
    let html = '';
    bookings.forEach(b => {
        html += `<tr>
            <td>${b.user}</td>
            <td>${b.studio}</td>
            <td>${b.tanggal}</td>
            <td><span class="status-badge status-${b.status}">${b.status}</span></td>
            <td><button class="btn-edit" onclick="editItem('booking',${b.id})"><i class="bi bi-pencil"></i></button></td>
        </tr>`;
    });
    document.getElementById('bookingsTable').innerHTML = html;
}

function loadUsers() {
    let html = '';
    users.forEach(u => {
        html += `<tr>
            <td>${u.nama}</td>
            <td>${u.email}</td>
            <td>${u.role}</td>
            <td><button class="btn-edit" onclick="editItem('user',${u.id})"><i class="bi bi-pencil"></i></button><button class="btn-delete" onclick="deleteItem('user',${u.id})"><i class="bi bi-trash"></i></button></td>
        </tr>`;
    });
    document.getElementById('usersTable').innerHTML = html;
}

// Navigation
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        item.classList.add('active');
        const page = item.dataset.page;
        document.querySelectorAll('.admin-page').forEach(p => p.classList.remove('active'));
        document.getElementById(`page-${page}`).classList.add('active');
        document.getElementById('pageTitle').innerText = item.querySelector('span').innerText;
        if (page === 'studios') loadStudios();
        if (page === 'bookings') loadBookings();
        if (page === 'users') loadUsers();
    });
});

// Modal
function openModal(type) {
    currentType = type;
    document.getElementById('modalTitle').innerText = `Tambah ${type}`;
    let fields = '';
    if (type === 'studio') fields = `<div class="form-group"><label>Nama Studio</label><input type="text" id="nama" required></div><div class="form-group"><label>Tipe</label><select id="tipe"><option value="regular">Regular</option><option value="premium">Premium</option></select></div><div class="form-group"><label>Harga</label><input type="number" id="harga" required></div>`;
    if (type === 'user') fields = `<div class="form-group"><label>Nama</label><input type="text" id="nama" required></div><div class="form-group"><label>Email</label><input type="email" id="email" required></div><div class="form-group"><label>Role</label><select id="role"><option value="user">User</option><option value="admin">Admin</option></select></div>`;
    document.getElementById('modalFields').innerHTML = fields;
    document.getElementById('itemModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
    document.getElementById('modalForm').reset();
}

function editItem(type, id) {
    currentType = type;
    let item;
    if (type === 'studio') item = studios.find(s => s.id === id);
    if (type === 'user') item = users.find(u => u.id === id);
    if (!item) return;
    document.getElementById('modalTitle').innerText = `Edit ${type}`;
    let fields = '';
    if (type === 'studio') fields = `<div class="form-group"><label>Nama Studio</label><input type="text" id="nama" value="${item.nama}" required></div><div class="form-group"><label>Tipe</label><select id="tipe"><option value="regular" ${item.tipe==='regular'?'selected':''}>Regular</option><option value="premium" ${item.tipe==='premium'?'selected':''}>Premium</option></select></div><div class="form-group"><label>Harga</label><input type="number" id="harga" value="${item.harga}" required></div>`;
    if (type === 'user') fields = `<div class="form-group"><label>Nama</label><input type="text" id="nama" value="${item.nama}" required></div><div class="form-group"><label>Email</label><input type="email" id="email" value="${item.email}" required></div><div class="form-group"><label>Role</label><select id="role"><option value="user" ${item.role==='user'?'selected':''}>User</option><option value="admin" ${item.role==='admin'?'selected':''}>Admin</option></select></div>`;
    document.getElementById('modalFields').innerHTML = fields;
    document.getElementById('itemId').value = id;
    openModal(type);
}

function deleteItem(type, id) {
    if (!confirm('Yakin ingin menghapus?')) return;
    if (type === 'studio') studios = studios.filter(s => s.id !== id);
    if (type === 'user') users = users.filter(u => u.id !== id);
    updateStats();
    loadStudios();
    loadUsers();
}

document.getElementById('modalForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const id = document.getElementById('itemId').value;
    if (currentType === 'studio') {
        const newStudio = { id: id ? parseInt(id) : studios.length+1, nama: document.getElementById('nama').value, tipe: document.getElementById('tipe').value, harga: parseInt(document.getElementById('harga').value) };
        if (id) { const index = studios.findIndex(s => s.id == id); if (index !== -1) studios[index] = newStudio; }
        else studios.push(newStudio);
        loadStudios();
    }
    if (currentType === 'user') {
        const newUser = { id: id ? parseInt(id) : users.length+1, nama: document.getElementById('nama').value, email: document.getElementById('email').value, role: document.getElementById('role').value };
        if (id) { const index = users.findIndex(u => u.id == id); if (index !== -1) users[index] = newUser; }
        else users.push(newUser);
        loadUsers();
    }
    updateStats();
    closeModal();
});

// Initialize
updateStats();
loadRecentBookings();
loadStudios();
loadBookings();
loadUsers();
