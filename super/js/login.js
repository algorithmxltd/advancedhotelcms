// js/login.js
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('form');
    const loginBtn = document.querySelector('button[type="submit"]');
    const nationalIdInput = document.getElementById('nationalId');
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordIcon = passwordToggle?.querySelector('i');
    const endpoint = 'processing/login';

    let isProcessing = false;

    // === Password Toggle Functionality ===
    if (passwordToggle && passwordInput && passwordIcon) {
        passwordToggle.addEventListener('click', function() {
            // Toggle password visibility
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            
            // Toggle eye icon
            if (isPassword) {
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
                passwordToggle.setAttribute('aria-label', 'Hide password');
            } else {
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
                passwordToggle.setAttribute('aria-label', 'Show password');
            }
            
            // Refocus on password input for better UX
            passwordInput.focus();
        });
        
        // Add keyboard support for accessibility
        passwordToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                passwordToggle.click();
            }
        });
    }

    // === Button State Management ===
    function setButtonProcessing(isProcessing) {
        if (isProcessing) {
            loginBtn.disabled = true;
            loginBtn.style.backgroundColor = '#95a5a6';
            loginBtn.style.cursor = 'not-allowed';
            loginBtn.style.opacity = '0.7';
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
            loginBtn.classList.add('loading');
        } else {
            loginBtn.disabled = false;
            loginBtn.style.backgroundColor = '';
            loginBtn.style.cursor = 'pointer';
            loginBtn.style.opacity = '1';
            loginBtn.innerHTML = 'Continue';
            loginBtn.classList.remove('loading');
        }
    }

    // === Show Error Message ===
    function showError(message) {
        // Remove existing error message
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm';
        errorDiv.style.whiteSpace = 'pre-wrap'; // Preserve formatting
        errorDiv.textContent = message;

        // Insert error message before the form
        loginForm.parentNode.insertBefore(errorDiv, loginForm);
    }

    // === Remove Error Message ===
    function removeError() {
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
    }

    // === Store User Data in Session Storage ===
    function storeUserData(userData) {
        try {
            // Store individual user fields
            sessionStorage.setItem('userId', userData.id);
            sessionStorage.setItem('userName', userData.name);
            sessionStorage.setItem('userRole', userData.role);
            sessionStorage.setItem('userEmail', userData.email);
            sessionStorage.setItem('userPhone', userData.phone);
            sessionStorage.setItem('nationalId', userData.national_id);
            sessionStorage.setItem('sessionToken', userData.session_token);
            sessionStorage.setItem('loginTime', userData.login_time);
            sessionStorage.setItem('expiresAt', userData.expires_at);
            sessionStorage.setItem('isLoggedIn', 'true');

            // Store complete session data object for easy access
            if (userData.session_data) {
                sessionStorage.setItem('userSessionData', JSON.stringify(userData.session_data));
            } else {
                // Fallback: create session data object from individual fields
                const sessionData = {
                    session_token: userData.session_token,
                    admin_id: userData.id,
                    role: userData.role,
                    name: userData.name,
                    email: userData.email,
                    national_id: userData.national_id,
                    login_time: userData.login_time,
                    expires_at: userData.expires_at
                };
                sessionStorage.setItem('userSessionData', JSON.stringify(sessionData));
            }

            console.log('User session data stored successfully:', {
                name: userData.name,
                role: userData.role,
                id: userData.id,
                session_token: userData.session_token?.substring(0, 10) + '...' // Log partial token for security
            });

            // Verify storage
            const storedName = sessionStorage.getItem('userName');
            const storedRole = sessionStorage.getItem('userRole');
            console.log('Session storage verified - Name:', storedName, 'Role:', storedRole);

        } catch (error) {
            console.error('Error storing user data in sessionStorage:', error);
            showError('Failed to store session data. Please try again.');
        }
    }

    // === Form Validation ===
    function validateForm() {
        const nationalId = nationalIdInput.value.trim();
        const password = passwordInput.value.trim();

        removeError();

        if (!nationalId) {
            showError('Please enter your National ID');
            nationalIdInput.focus();
            return false;
        }

        if (!password) {
            showError('Please enter your password');
            passwordInput.focus();
            return false;
        }

        if (nationalId.length < 5) {
            showError('Please enter a valid National ID');
            nationalIdInput.focus();
            return false;
        }

        if (password.length < 4) {
            showError('Password must be at least 4 characters');
            passwordInput.focus();
            return false;
        }

        return true;
    }

    // === Handle Form Submission ===
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Prevent multiple submissions
        if (isProcessing) {
            console.log('Already processing, please wait...');
            return;
        }

        // Validate form
        if (!validateForm()) {
            return;
        }

        // Set processing state
        isProcessing = true;
        setButtonProcessing(true);

        const formData = new FormData();
        formData.append('action', 'login');
        formData.append('nationalId', nationalIdInput.value.trim());
        formData.append('password', passwordInput.value.trim());

        // Debug data (remove in production)
        const debugData = {};
        for (const [key, value] of formData.entries()) {
            debugData[key] = value;
        }
        console.log('Login attempt:', JSON.stringify(debugData, null, 2));

        fetch(endpoint, {
            method: 'POST',
            body: formData
        })
        .then(res => {
            // First get the raw text response
            return res.text().then(text => {
                // If response is not OK, throw the raw text as error
                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}: ${text}`);
                }
                
                // Try to parse as JSON, but if it fails, return the raw text
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.warn('Response is not JSON, returning raw text:', text);
                    return { success: false, message: text, raw: true };
                }
            });
        })
        .then(data => {
            if (data.raw) {
                // Handle raw response (non-JSON)
                showError('Server returned raw response:\n' + data.message);
                isProcessing = false;
                setButtonProcessing(false);
                return;
            }

            if (data.success) {
                // Login successful - store user data in sessionStorage
                storeUserData(data.user);
                
                console.log('Login successful, redirecting...');
                console.log('Full user data received:', data.user);
                
                // Show success message briefly before redirect
                loginBtn.innerHTML = '<i class="fas fa-check"></i> Success! Redirecting...';
                loginBtn.style.backgroundColor = '#10b981';
                
                // Redirect to dashboard or intended page
                setTimeout(() => {
                    window.location.href = data.redirectUrl || 'index';
                }, 1000);
            } else {
                // Login failed
                showError(data.message || 'Login failed. Please try again.');
                isProcessing = false;
                setButtonProcessing(false);
                
                // Clear password field on failure
                passwordInput.value = '';
                passwordInput.focus();
            }
        })
        .catch(err => {
            console.error('Login error:', err);
            
            // Show the complete error including the raw PHP response
            let errorMessage = err.message;
            
            // If it's a network error, show generic message
            if (err.message.includes('Failed to fetch')) {
                errorMessage = 'Network error. Please check your connection and try again.';
            }
            
            showError('Error occurred:\n' + errorMessage);
            isProcessing = false;
            setButtonProcessing(false);
        })
        .finally(() => {
            // Safety timeout to re-enable button after 10 seconds
            setTimeout(() => {
                if (isProcessing) {
                    isProcessing = false;
                    setButtonProcessing(false);
                    console.warn('Login request timeout - button re-enabled');
                }
            }, 10000);
        });
    });

    // === Real-time Validation ===
    nationalIdInput.addEventListener('input', function() {
        removeError();
        // Basic input sanitization - only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    passwordInput.addEventListener('input', function() {
        removeError();
    });

    // === Enter Key Support ===
    loginForm.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !isProcessing) {
            loginForm.dispatchEvent(new Event('submit'));
        }
    });

    // === Forgot Password Link ===
    const forgotPasswordLink = document.querySelector('a[href="#"]');
    forgotPasswordLink?.addEventListener('click', function(e) {
        e.preventDefault();
        // Implement forgot password functionality
        alert('Forgot password functionality coming soon!');
    });

    // === Check for existing session on page load ===
    function checkExistingSession() {
        const isLoggedIn = sessionStorage.getItem('isLoggedIn');
        const userName = sessionStorage.getItem('userName');
        
        if (isLoggedIn === 'true' && userName) {
            console.log('Existing session found for user:', userName);
            
            if (window.location.pathname.includes('index')) {
               window.location.href = 'index';
             }
        }
    }

    // Check for existing session when page loads
    checkExistingSession();
});