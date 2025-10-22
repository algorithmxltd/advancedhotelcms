document.addEventListener('DOMContentLoaded', function () {
  // === Element References ===
  const browseBtn = document.getElementById('browseBtn');
  const fileInput = document.getElementById('roomPhotos');
  const dropZone = document.getElementById('dropZone');
  const previewContainer = document.getElementById('previewContainer');
  const submitBtn = document.getElementById('updateRoomBtn');
  const deleteRoomBtn = document.getElementById('delete-room-btn');
  const form = document.getElementById('editRoomForm');
  const closeBtn = document.getElementById('closeResponseBtn');
  const endpoint = 'processing/editRoom.php';

  let selectedFiles = [];

  // === Get Room ID from URL ===
  const urlParams = new URLSearchParams(window.location.search);
  const roomId = urlParams.get('id');
  console.log('This is the room ID:', roomId);

  // === Confirmation Modal ===
  function showConfirm(message, confirmCallback) {
    const existing = document.getElementById('confirm-box');
    if (existing) existing.remove();

    const overlay = document.createElement('div');
    overlay.id = 'confirm-box';
    Object.assign(overlay.style, {
      position: 'fixed',
      top: 0,
      left: 0,
      width: '100%',
      height: '100%',
      background: 'rgba(0,0,0,0.4)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      zIndex: 10000
    });

    const box = document.createElement('div');
    Object.assign(box.style, {
      background: '#ff4444',
      color: '#fff',
      padding: '25px',
      borderRadius: '10px',
      textAlign: 'center',
      minWidth: '260px',
      fontSize: '15px',
      boxShadow: '0 2px 10px rgba(0,0,0,0.2)'
    });

    const msg = document.createElement('p');
    msg.textContent = message;
    msg.style.marginBottom = '20px';

    const btnContainer = document.createElement('div');
    btnContainer.style.display = 'flex';
    btnContainer.style.justifyContent = 'space-around';

    const confirmBtn = document.createElement('button');
    confirmBtn.textContent = 'Confirm';
    Object.assign(confirmBtn.style, {
      background: '#fff',
      color: '#ff4444',
      border: 'none',
      padding: '6px 14px',
      borderRadius: '6px',
      cursor: 'pointer',
      fontWeight: '600'
    });

    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Cancel';
    Object.assign(cancelBtn.style, {
      background: 'rgba(255,255,255,0.2)',
      color: '#fff',
      border: 'none',
      padding: '6px 14px',
      borderRadius: '6px',
      cursor: 'pointer'
    });

    confirmBtn.addEventListener('click', () => {
      overlay.remove();
      confirmCallback(true);
    });
    cancelBtn.addEventListener('click', () => overlay.remove());

    btnContainer.append(confirmBtn, cancelBtn);
    box.append(msg, btnContainer);
    overlay.appendChild(box);
    document.body.appendChild(overlay);
  }

  // === File Upload (Browse + Drag-Drop) ===
  browseBtn?.addEventListener('click', () => fileInput.click());

  fileInput?.addEventListener('change', function () {
    selectedFiles = Array.from(fileInput.files).filter(file => file.type.startsWith('image/'));
    updatePreview();
  });

  dropZone?.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone?.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

  dropZone?.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = Array.from(e.dataTransfer.files);
    selectedFiles = files.filter(file => file.type.startsWith('image/'));
    updatePreview();
  });

  // === Existing Image Preview + Delete ===
  function createImagePreview(imagePath, imageId) {
    const wrapper = document.createElement('div');
    wrapper.classList.add('image-item');
    wrapper.dataset.imageId = imageId;

    const img = document.createElement('img');
    img.src = `../uploads/rooms/${imagePath}`;
    img.alt = 'Room Image';

    const deleteBtn = document.createElement('button');
    deleteBtn.classList.add('delete-image');
    deleteBtn.textContent = '✖';

    deleteBtn.addEventListener('click', () => {
      showConfirm('Delete this image?', (confirmed) => {
        if (!confirmed) return;

        fetch(endpoint, {
          method: 'POST',
          body: new URLSearchParams({ action: 'deleteImage', imageId, roomId })
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) wrapper.remove();
            else alert(data.message || 'Failed to delete image.');
          })
          .catch(err => alert('Error deleting image: ' + err));
      });
    });

    wrapper.append(img, deleteBtn);
    previewContainer?.appendChild(wrapper);
  }

  // === Preview Newly Added Images ===
  function updatePreview() {
    selectedFiles.forEach((file, index) => {
      const wrapper = document.createElement('div');
      Object.assign(wrapper.style, {
        position: 'relative',
        display: 'inline-block',
        margin: '5px'
      });

      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.alt = 'Preview';
      Object.assign(img.style, {
        maxWidth: '150px',
        borderRadius: '6px',
        boxShadow: '0 1px 3px rgba(0,0,0,0.2)'
      });

      const cancelBtn = document.createElement('button');
      cancelBtn.textContent = '✖';
      Object.assign(cancelBtn.style, {
        position: 'absolute',
        top: '2px',
        right: '2px',
        background: 'rgba(0,0,0,0.6)',
        color: '#fff',
        border: 'none',
        borderRadius: '50%',
        width: '20px',
        height: '20px',
        cursor: 'pointer',
        fontSize: '12px'
      });

      cancelBtn.addEventListener('click', () => {
        URL.revokeObjectURL(img.src);
        selectedFiles.splice(index, 1);
        wrapper.remove();
      });

      wrapper.append(img, cancelBtn);
      previewContainer?.appendChild(wrapper);
    });

    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
  }

  // === Response Box ===
  function showResponse(message, statusCode) {
    const box = document.getElementById('responseBox');
    const msg = document.getElementById('responseMessage');

    if (!box || !msg) {
      alert(message);
      console.warn('Missing responseBox or responseMessage element.');
      return;
    }

    msg.textContent = message;
    box.className = 'response-container';
    box.classList.add(statusCode === 200 ? 'response-success' : 'response-error');
    box.style.display = 'block';
  }

  closeBtn?.addEventListener('click', () => {
    const box = document.getElementById('responseBox');
    if (box) box.style.display = 'none';
  });

  // === Submit Room Update ===
  submitBtn?.addEventListener('click', function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('roomId', roomId);
    formData.append('action', 'updateDetails');

    if (selectedFiles.length > 0) {
      selectedFiles.forEach(file => formData.append('newImages[]', file));
    }

    const debugData = {};
    for (const [key, value] of formData.entries()) {
      debugData[key] = value instanceof File
        ? { name: value.name, size: value.size, type: value.type }
        : value;
    }
    console.log('Uploading room data:', JSON.stringify(debugData, null, 2));

    fetch(endpoint, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => showResponse(data.message, data.status))
      .catch(err => showResponse('Network Error: ' + err, 500));
  });

  // === Delete Entire Room ===
  deleteRoomBtn?.addEventListener('click', () => {
    showConfirm('Are you sure you want to delete this room?', (confirmed) => {
      if (!confirmed) return;

      fetch(endpoint, {
        method: 'POST',
        body: new URLSearchParams({ action: 'deleteRoom', roomId })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            showResponse('Room deleted successfully.', 200);
            setTimeout(() => window.location.href = 'rooms.php', 1000);
          } else {
            showResponse(data.message || 'Failed to delete room.', 500);
          }
        })
        .catch(err => showResponse('Error deleting room: ' + err, 500));
    });
  });
});
