<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Voter Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .demo-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .demo-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .demo-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        /* Modal Container */
        .modal {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }

        /* Modal Header */
        .modal-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        /* Modal Body */
        .modal-body {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-display {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .file-input-display:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .file-icon {
            color: #2563eb;
            font-size: 20px;
        }

        /* Delete Modal Specific */
        .delete-content {
            text-align: center;
            padding: 20px 0;
        }

        .delete-warning {
            color: #dc2626;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .delete-name {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .delete-subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 20px 30px;
            background: #f9fafb;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #d1d5db;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .modal {
                width: 95%;
                margin: 20px;
            }

            .modal-header, .modal-body, .modal-footer {
                padding: 20px;
            }

            .modal-footer {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation for file upload */
        .upload-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <button class="demo-btn" onclick="openModal('addModal')">
            <i class="fas fa-user-plus"></i>
            Add New Voter
        </button>
        <button class="demo-btn" onclick="openModal('editModal')">
            <i class="fas fa-edit"></i>
            Edit Voter
        </button>
        <button class="demo-btn" onclick="openModal('deleteModal')">
            <i class="fas fa-trash-alt"></i>
            Delete Voter
        </button>
        <button class="demo-btn" onclick="openModal('photoModal')">
            <i class="fas fa-camera"></i>
            Update Photo
        </button>
    </div>

    <!-- Add New Voter Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Add New Voter</h2>
                <button class="close-btn" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="voters_add.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label" for="firstname">First Name</label>
                        <input type="text" class="form-input" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lastname">Last Name</label>
                        <input type="text" class="form-input" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" class="form-input" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" class="form-input" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-input" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profile Photo</label>
                        <div class="file-input-wrapper">
                            <input type="file" class="file-input" id="photo" name="photo" accept="image/*">
                            <div class="file-input-display">
                                <i class="fas fa-cloud-upload-alt file-icon"></i>
                                <span>Choose photo or drag and drop</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" name="add">
                    <i class="fas fa-plus"></i>
                    Add Voter
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Voter Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Edit Voter</h2>
                <button class="close-btn" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="voters_edit.php">
                    <input type="hidden" name="id" class="voter-id">
                    <div class="form-group">
                        <label class="form-label" for="edit_firstname">First Name</label>
                        <input type="text" class="form-input" id="edit_firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_lastname">Last Name</label>
                        <input type="text" class="form-input" id="edit_lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_username">Username</label>
                        <input type="text" class="form-input" id="edit_username" name="username">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_email">Email Address</label>
                        <input type="email" class="form-input" id="edit_email" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_password">New Password</label>
                        <input type="password" class="form-input" id="edit_password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" name="edit">
                    <i class="fas fa-save"></i>
                    Update Voter
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Voter Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Delete Voter</h2>
                <button class="close-btn" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="voters_delete.php">
                    <input type="hidden" name="id" class="voter-id">
                    <div class="delete-content">
                        <div class="delete-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Warning: This action cannot be undone
                        </div>
                        <div class="delete-name">John Smith</div>
                        <div class="delete-subtitle">This voter and all associated data will be permanently deleted.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger" name="delete">
                    <i class="fas fa-trash"></i>
                    Delete Voter
                </button>
            </div>
        </div>
    </div>

    <!-- Update Photo Modal -->
    <div class="modal-overlay" id="photoModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Update Profile Photo</h2>
                <button class="close-btn" onclick="closeModal('photoModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="voters_photo.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="voter-id">
                    <div class="form-group">
                        <label class="form-label">New Profile Photo</label>
                        <div class="file-input-wrapper">
                            <input type="file" class="file-input" id="photo_update" name="photo" accept="image/*" required>
                            <div class="file-input-display">
                                <i class="fas fa-camera file-icon"></i>
                                <span>Choose new photo</span>
                            </div>
                        </div>
                        <small style="color: #6b7280; margin-top: 8px; display: block;">
                            Supported formats: JPG, PNG, GIF (Max 5MB)
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('photoModal')">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" name="upload">
                    <i class="fas fa-upload"></i>
                    Update Photo
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Handle file input display
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                const display = this.parentElement.querySelector('.file-input-display span');
                if (this.files.length > 0) {
                    display.textContent = this.files[0].name;
                    this.parentElement.querySelector('.file-input-display').style.borderColor = '#10b981';
                    this.parentElement.querySelector('.file-icon').style.color = '#10b981';
                }
            });
        });

        // Escape key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });

        // Form submission handlers (you can customize these)
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Add your form validation and submission logic here
                console.log('Form submitted:', this.action);
            });
        });
    </script>
</body>
</html>