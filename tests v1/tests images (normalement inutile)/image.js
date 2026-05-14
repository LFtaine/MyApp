let FIXED_FILENAME = 'image' + (bdd.length - 1);
// ======================================================

const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');
const previewImage = document.getElementById('previewImage');
const fileInfo = document.getElementById('fileInfo');
const saveBtn = document.getElementById('saveBtn');
const successMessage = document.getElementById('successMessage');
const errorMessage = document.getElementById('errorMessage');

let selectedFile = null;
let fileExtension = '';

// Click sur la zone de drop
dropZone.addEventListener('click', () => {
    fileInput.click();
});

// Drag over
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

// Drag leave
dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

// Drop
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFile(files[0]);
    }
});

// Sélection de fichier via input
fileInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
        handleFile(e.target.files[0]);
    }
});

function handleFile(file) {
    // Vérifier que c'est bien une image
    if (!file.type.startsWith('image/')) {
        showError('Veuillez sélectionner une image valide');
        return;
    }

    selectedFile = file;
    fileExtension = file.name.split('.').pop();

    // Afficher l'aperçu
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImage.src = e.target.result;
        previewContainer.classList.add('active');

        // Afficher les infos du fichier
        const sizeKB = (file.size / 1024).toFixed(2);
        fileInfo.innerHTML = `
                    <strong>Fichier:</strong> ${file.name}<br>
                    <strong>Taille:</strong> ${sizeKB} KB<br>
                    <strong>Type:</strong> ${file.type}<br>
                `;

        // Activer le bouton de sauvegarde
        saveBtn.disabled = false;

        // Masquer les messages
        successMessage.classList.remove('show');
        errorMessage.classList.remove('show');
    };
    reader.readAsDataURL(file);
}

// Sauvegarder l'image
saveBtn.addEventListener('click', () => {
    if (!selectedFile) {
        showError('Aucune image sélectionnée');
        return;
    }

    // Créer un lien de téléchargement avec le nom fixe
    const reader = new FileReader();
    reader.onload = (e) => {
        const link = document.createElement('a');
        link.href = e.target.result;
        link.download = `${FIXED_FILENAME}.${fileExtension}`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Afficher le message de succès
        successMessage.textContent = `✓ Image sauvegardée sous ${FIXED_FILENAME}.${fileExtension}`;
        successMessage.classList.add('show');
        errorMessage.classList.remove('show');
    };
    reader.readAsDataURL(selectedFile);
});

function showError(message) {
    errorMessage.textContent = `✗ ${message}`;
    errorMessage.classList.add('show');
    successMessage.classList.remove('show');

    setTimeout(() => {
        errorMessage.classList.remove('show');
    }, 3000);
}