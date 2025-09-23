document.addEventListener('DOMContentLoaded', function () {
  const browseBtn = document.getElementById('browseBtn');
  const fileInput = document.getElementById('roomPhotos');
  const dropZone = document.getElementById('dropZone');
  const previewContainer = document.getElementById('previewContainer');
  const submitBtn = document.getElementById('submitRoomBtn');
  const form = document.getElementById('addRoomForm');
  const closeBtn = document.getElementById('closeResponseBtn');

  let selectedFiles = [];

  // === File Upload Handling ===
  browseBtn.addEventListener('click', () => fileInput.click());

  fileInput.addEventListener('change', function () {
    selectedFiles = Array.from(fileInput.files).filter(file =>
      file.type.startsWith('image/')
    );
    updatePreview();
  });

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = Array.from(e.dataTransfer.files);
    selectedFiles = files.filter(file => file.type.startsWith('image/'));
    updatePreview();
  });

  function updatePreview() {
    previewContainer.innerHTML = '';
    if (selectedFiles.length === 0) {
      previewContainer.textContent = 'No images selected.';
      return;
    }

    selectedFiles.forEach((file, index) => {
      const wrapper = document.createElement('div');
      wrapper.style.position = 'relative';
      wrapper.style.display = 'inline-block';
      wrapper.style.margin = '5px';

      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.alt = 'Preview';
      img.style.maxWidth = '150px';
      img.style.borderRadius = '6px';
      img.style.boxShadow = '0 1px 3px rgba(0,0,0,0.2)';

      const cancelBtn = document.createElement('button');
      cancelBtn.textContent = '✖';
      cancelBtn.style.position = 'absolute';
      cancelBtn.style.top = '2px';
      cancelBtn.style.right = '2px';
      cancelBtn.style.background = 'rgba(0,0,0,0.6)';
      cancelBtn.style.color = '#fff';
      cancelBtn.style.border = 'none';
      cancelBtn.style.borderRadius = '50%';
      cancelBtn.style.width = '20px';
      cancelBtn.style.height = '20px';
      cancelBtn.style.cursor = 'pointer';
      cancelBtn.style.fontSize = '12px';

      cancelBtn.addEventListener('click', () => {
        URL.revokeObjectURL(img.src);
        selectedFiles.splice(index, 1);
        updatePreview();
      });

      wrapper.appendChild(img);
      wrapper.appendChild(cancelBtn);
      previewContainer.appendChild(wrapper);
    });

    // Sync input with selected files
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
  }

  // === Response Box ===
  function showResponse(message, statusCode) {
    const box = document.getElementById('responseBox');
    const msg = document.getElementById('responseMessage');

    msg.textContent = message; // display only message

    box.className = 'response-container'; // reset
    box.classList.add(statusCode === 200 ? 'response-success' : 'response-error');

    box.style.display = 'block';
  }

  function hideResponse() {
    document.getElementById('responseBox').style.display = 'none';
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', hideResponse);
  }

  // === Form Submission ===
  // === Form Submission ===
submitBtn.addEventListener('click', function (e) {
  e.preventDefault();

  const formData = new FormData(form);

  fetch('processing/addRoom.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json()) // parse JSON
    .then(data => {
      showResponse(data.message, data.status);

      if (data.success && data.status === 200) {
        previewContainer.innerHTML = '';
        selectedFiles = [];
      }
    })
    .catch(err => {
      showResponse('Network Error: ' + err, 500);
    });
});

});
