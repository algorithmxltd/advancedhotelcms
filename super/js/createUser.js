// js/createUser.js
document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.getElementById('submitUserBtn');
    const form = document.getElementById('createUserForm');
    const closeBtn = document.getElementById('closeResponseBtn');
    const endpoint = 'processing/createUser.php';

    let isProcessing = false;

    // === Button State Management ===
    function setButtonProcessing(isProcessing) {
        if (isProcessing) {
            submitBtn.disabled = true;
            submitBtn.style.backgroundColor = '#95a5a6';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.style.opacity = '0.7';
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating User...';
            submitBtn.classList.add('loading');
        } else {
            submitBtn.disabled = false;
            submitBtn.style.backgroundColor = '';
            submitBtn.style.cursor = 'pointer';
            submitBtn.style.opacity = '1';
            submitBtn.innerHTML = 'Create User';
            submitBtn.classList.remove('loading');
        }
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

    // === Submit User Creation ===
    submitBtn?.addEventListener('click', function (e) {
        e.preventDefault();

        // Prevent multiple submissions
        if (isProcessing) {
            console.log('Already processing, please wait...');
            return;
        }

        // Basic form validation
        const userName = document.getElementById('userName').value.trim();
        const nationalId = document.getElementById('nationalId').value.trim();
        const userEmail = document.getElementById('userEmail').value.trim();
        const userPhone = document.getElementById('userPhone').value.trim();
        const userRole = document.getElementById('userRole').value;

        if (!userName || !nationalId || !userEmail || !userPhone || !userRole) {
            showResponse('Please fill in all required fields.', 400);
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(userEmail)) {
            showResponse('Please enter a valid email address.', 400);
            return;
        }

        // Set processing state
        isProcessing = true;
        setButtonProcessing(true);

        const formData = new FormData();
        formData.append('action', 'createUser');
        formData.append('userName', userName);
        formData.append('nationalId', nationalId);
        formData.append('userEmail', userEmail);
        formData.append('userPhone', userPhone);
        formData.append('userRole', userRole);

        // Debug data
        const debugData = {};
        for (const [key, value] of formData.entries()) {
            debugData[key] = value;
        }
        console.log('Creating user with data:', JSON.stringify(debugData, null, 2));

        fetch(endpoint, { 
            method: 'POST', 
            body: formData 
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            showResponse(data.message, data.status);
            
            if (data.success) {
                // Clear form on success
                form.reset();
                // Keep button in loading state for a moment before resetting
                setTimeout(() => {
                    isProcessing = false;
                    setButtonProcessing(false);
                }, 1500);
            } else {
                // Re-enable button on server error
                isProcessing = false;
                setButtonProcessing(false);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showResponse('Network Error: ' + err.message, 500);
            isProcessing = false;
            setButtonProcessing(false);
        })
        .finally(() => {
            // Safety timeout to re-enable button after 10 seconds even if no response
            setTimeout(() => {
                if (isProcessing) {
                    isProcessing = false;
                    setButtonProcessing(false);
                    console.warn('Request timeout - button re-enabled');
                }
            }, 10000);
        });
    });

    // Optional: Add real-time validation
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });

    function validateField(field) {
        const value = field.value.trim();
        
        switch(field.id) {
            case 'userEmail':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value && !emailRegex.test(value)) {
                    field.style.borderColor = '#ff4444';
                } else {
                    field.style.borderColor = '';
                }
                break;
                
            case 'nationalId':
                if (value && !/^\d+$/.test(value)) {
                    field.style.borderColor = '#ff4444';
                } else {
                    field.style.borderColor = '';
                }
                break;
                
            case 'userPhone':
                if (value && !/^[\d\s\-\+\(\)]+$/.test(value)) {
                    field.style.borderColor = '#ff4444';
                } else {
                    field.style.borderColor = '';
                }
                break;
                
            default:
                if (!value && field.required) {
                    field.style.borderColor = '#ff4444';
                } else {
                    field.style.borderColor = '';
                }
        }
    }
});