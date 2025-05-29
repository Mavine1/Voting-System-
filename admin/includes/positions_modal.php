<!-- Add New Position Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2); border: 1px solid #e5e7eb; overflow: hidden;">
            <div class="modal-header" style="background: #1e40af; color: #ffffff; padding: 20px 25px; border-bottom: none; position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 20px; background: rgba(255, 255, 255, 0.15); border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='scale(1)'">
                    <span aria-hidden="true" style="color: #ffffff; font-size: 18px; font-weight: bold; line-height: 1;">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #ffffff; font-weight: 600; font-size: 20px; margin: 0; display: flex; align-items: center;">
                    <i class="fa fa-plus-circle" style="margin-right: 12px; font-size: 24px;"></i>
                    Add New Position
                </h4>
                <p style="color: rgba(255, 255, 255, 0.8); margin: 5px 0 0 36px; font-size: 14px;">Create a new voting position</p>
            </div>
            
            <div class="modal-body" style="padding: 30px 25px; background: #ffffff;">
                <form class="form-horizontal" method="POST" action="positions_add.php" id="addPositionForm">
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="description" class="col-sm-3 control-label" style="color: #1e40af; font-weight: 500; padding-top: 10px; text-align: right;">
                            <i class="fa fa-file-text-o" style="margin-right: 5px;"></i>Description
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" required 
                                   style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #ffffff;" 
                                   placeholder="Enter position description"
                                   onfocus="this.style.borderColor='#1e40af'; this.style.boxShadow='0 0 0 3px rgba(30, 64, 175, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="max_vote" class="col-sm-3 control-label" style="color: #1e40af; font-weight: 500; padding-top: 10px; text-align: right;">
                            <i class="fa fa-sort-numeric-asc" style="margin-right: 5px;"></i>Maximum Vote
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="max_vote" name="max_vote" required min="1"
                                   style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #ffffff;" 
                                   placeholder="Enter maximum votes allowed"
                                   onfocus="this.style.borderColor='#1e40af'; this.style.boxShadow='0 0 0 3px rgba(30, 64, 175, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: #f8fafc; padding: 20px 25px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-curve" data-dismiss="modal" 
                        style="background: #ffffff; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 25px; padding: 10px 20px; font-weight: 500; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db'; this.style.transform='translateY(-1px)'" 
                        onmouseout="this.style.background='#ffffff'; this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)'">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" form="addPositionForm" class="btn btn-curve" name="add"
                        style="background: #1e40af; color: #ffffff; border: none; border-radius: 25px; padding: 10px 25px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);"
                        onmouseover="this.style.background='#1d4ed8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(30, 64, 175, 0.4)'" 
                        onmouseout="this.style.background='#1e40af'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(30, 64, 175, 0.3)'">
                    <i class="fa fa-save"></i> Save Position
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Position Modal -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2); border: 1px solid #e5e7eb; overflow: hidden;">
            <div class="modal-header" style="background: #1e40af; color: #ffffff; padding: 20px 25px; border-bottom: none; position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 20px; background: rgba(255, 255, 255, 0.15); border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='scale(1)'">
                    <span aria-hidden="true" style="color: #ffffff; font-size: 18px; font-weight: bold; line-height: 1;">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #ffffff; font-weight: 600; font-size: 20px; margin: 0; display: flex; align-items: center;">
                    <i class="fa fa-edit" style="margin-right: 12px; font-size: 24px;"></i>
                    Edit Position
                </h4>
                <p style="color: rgba(255, 255, 255, 0.8); margin: 5px 0 0 36px; font-size: 14px;">Modify position details</p>
            </div>
            
            <div class="modal-body" style="padding: 30px 25px; background: #ffffff;">
                <form class="form-horizontal" method="POST" action="positions_edit.php" id="editPositionForm">
                    <input type="hidden" class="id" name="id">
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="edit_description" class="col-sm-3 control-label" style="color: #1e40af; font-weight: 500; padding-top: 10px; text-align: right;">
                            <i class="fa fa-file-text-o" style="margin-right: 5px;"></i>Description
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_description" name="description" required 
                                   style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #ffffff;" 
                                   placeholder="Enter position description"
                                   onfocus="this.style.borderColor='#1e40af'; this.style.boxShadow='0 0 0 3px rgba(30, 64, 175, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="edit_max_vote" class="col-sm-3 control-label" style="color: #1e40af; font-weight: 500; padding-top: 10px; text-align: right;">
                            <i class="fa fa-sort-numeric-asc" style="margin-right: 5px;"></i>Maximum Vote
                        </label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="edit_max_vote" name="max_vote" required min="1"
                                   style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 12px 15px; font-size: 14px; transition: all 0.3s ease; background: #ffffff;" 
                                   placeholder="Enter maximum votes allowed"
                                   onfocus="this.style.borderColor='#1e40af'; this.style.boxShadow='0 0 0 3px rgba(30, 64, 175, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: #f8fafc; padding: 20px 25px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-curve" data-dismiss="modal" 
                        style="background: #ffffff; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 25px; padding: 10px 20px; font-weight: 500; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db'; this.style.transform='translateY(-1px)'" 
                        onmouseout="this.style.background='#ffffff'; this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)'">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" form="editPositionForm" class="btn btn-curve" name="edit"
                        style="background: #1e40af; color: #ffffff; border: none; border-radius: 25px; padding: 10px 25px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);"
                        onmouseover="this.style.background='#1d4ed8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(30, 64, 175, 0.4)'" 
                        onmouseout="this.style.background='#1e40af'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(30, 64, 175, 0.3)'">
                    <i class="fa fa-check"></i> Update Position
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Position Modal -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2); border: 1px solid #fee2e2; overflow: hidden;">
            <div class="modal-header" style="background: #ef4444; color: #ffffff; padding: 20px 25px; border-bottom: none; position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 20px; background: rgba(255, 255, 255, 0.15); border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='scale(1)'">
                    <span aria-hidden="true" style="color: #ffffff; font-size: 18px; font-weight: bold; line-height: 1;">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #ffffff; font-weight: 600; font-size: 20px; margin: 0; display: flex; align-items: center;">
                    <i class="fa fa-exclamation-triangle" style="margin-right: 12px; font-size: 24px;"></i>
                    Confirm Deletion
                </h4>
                <p style="color: rgba(255, 255, 255, 0.9); margin: 5px 0 0 36px; font-size: 14px;">This action cannot be undone</p>
            </div>
            
            <div class="modal-body" style="padding: 30px 25px; background: #ffffff; text-align: center;">
                <form class="form-horizontal" method="POST" action="positions_delete.php" id="deletePositionForm">
                    <input type="hidden" class="id" name="id">
                    
                    <div style="margin-bottom: 25px;">
                        <div style="background: #fef2f2; border: 2px dashed #fecaca; border-radius: 12px; padding: 25px; margin-bottom: 20px;">
                            <i class="fa fa-trash" style="font-size: 48px; color: #ef4444; margin-bottom: 15px;"></i>
                            <p style="color: #374151; font-size: 16px; margin-bottom: 10px; font-weight: 500;">You are about to delete the position:</p>
                            <h3 class="description" style="color: #ef4444; font-weight: 700; font-size: 20px; margin: 0; padding: 10px 0; border-top: 1px solid #fecaca; border-bottom: 1px solid #fecaca;">
                                <!-- Position name will be populated here -->
                            </h3>
                            <p style="color: #6b7280; font-size: 14px; margin-top: 15px; font-style: italic;">All associated data will be permanently removed from the system.</p>
                        </div>
                        
                        <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 0 8px 8px 0;">
                            <p style="color: #92400e; font-size: 14px; margin: 0; display: flex; align-items: center;">
                                <i class="fa fa-warning" style="margin-right: 8px; color: #f59e0b;"></i>
                                <strong>Warning:</strong>&nbsp;This action is irreversible. Please confirm you want to proceed.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: #f8fafc; padding: 20px 25px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-curve" data-dismiss="modal" 
                        style="background: #ffffff; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 25px; padding: 10px 20px; font-weight: 500; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db'; this.style.transform='translateY(-1px)'" 
                        onmouseout="this.style.background='#ffffff'; this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)'">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" form="deletePositionForm" class="btn btn-curve" name="delete"
                        style="background: #ef4444; color: #ffffff; border: none; border-radius: 25px; padding: 10px 25px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);"
                        onmouseover="this.style.background='#dc2626'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.4)'" 
                        onmouseout="this.style.background='#ef4444'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)'">
                    <i class="fa fa-trash"></i> Delete Position
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Enhancements */
.modal-backdrop {
    background-color: rgba(30, 64, 175, 0.4) !important;
}

.modal.fade .modal-dialog {
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    transform: translateY(-50px) scale(0.95);
}

.modal.show .modal-dialog {
    transform: translateY(0) scale(1);
}

/* Form Input Enhancements */
.form-control:focus {
    border-color: #1e40af !important;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1) !important;
}

.form-control::placeholder {
    color: #9ca3af;
    font-style: italic;
}

/* Button Loading States */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    margin: auto;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: button-loading-spinner 1s ease infinite;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

@keyframes button-loading-spinner {
    from { transform: rotate(0turn); }
    to { transform: rotate(1turn); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
        max-width: calc(100% - 20px);
    }
    
    .modal-lg {
        max-width: calc(100% - 20px);
    }
    
    .col-sm-3, .col-sm-9 {
        width: 100%;
        padding: 0 15px;
    }
    
    .control-label {
        text-align: left !important;
        margin-bottom: 8px;
        padding-top: 0 !important;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .modal-footer {
        flex-direction: column;
        gap: 10px;
    }
    
    .modal-footer .btn {
        width: 100%;
        margin: 0;
    }
}

/* Accessibility Improvements */
.btn:focus, .form-control:focus {
    outline: 2px solid #1e40af;
    outline-offset: 2px;
}

/* Animation for modal entrance */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-content {
    animation: modalSlideIn 0.3s ease-out;
}
</style>

<script>
// Enhanced modal functionality
$(document).ready(function() {
    // Add loading states to form submissions
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.addClass('btn-loading');
        submitBtn.prop('disabled', true);
        
        // Reset after 5 seconds in case of issues
        setTimeout(function() {
            submitBtn.removeClass('btn-loading');
            submitBtn.prop('disabled', false);
        }, 5000);
    });
    
    // Enhanced form validation
    $('input[required]').on('blur', function() {
        const input = $(this);
        if (!input.val().trim()) {
            input.css({
                'border-color': '#ef4444',
                'box-shadow': '0 0 0 3px rgba(239, 68, 68, 0.1)'
            });
        } else {
            input.css({
                'border-color': '#10b981',
                'box-shadow': '0 0 0 3px rgba(16, 185, 129, 0.1)'
            });
        }
    });
    
    // Reset form styles when modal is closed
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('input').css({
            'border-color': '#e5e7eb',
            'box-shadow': 'none'
        });
        $(this).find('button[type="submit"]').removeClass('btn-loading').prop('disabled', false);
    });
    
    // Auto-focus first input when modal opens
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('input[type="text"], input[type="number"]').first().focus();
    });
    
    // Keyboard navigation
    $('.modal').on('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            $(this).find('button[type="submit"]').click();
        }
    });
});
</script>