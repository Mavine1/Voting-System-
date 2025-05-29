<!-- Reset Modal -->
<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15); background: white;">
            
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-bottom: none; padding: 25px 30px; position: relative;">
                <div style="display: flex; align-items: center; width: 100%;">
                    <!-- Warning Icon -->
                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px; backdrop-filter: blur(10px);">
                        <i class="fa fa-exclamation-triangle" style="color: white; font-size: 28px;"></i>
                    </div>
                    
                    <!-- Title and Subtitle -->
                    <div style="flex: 1;">
                        <h4 class="modal-title" id="resetModalLabel" style="margin: 0; color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 700;">
                            Critical Action Required
                        </h4>
                        <p style="margin: 5px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                            This action cannot be undone
                        </p>
                    </div>
                </div>
                
                <!-- Close Button -->
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; width: 35px; height: 35px; border-radius: 50%; color: white; font-size: 16px; cursor: pointer; transition: all 0.3s ease; backdrop-filter: blur(10px);">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body" style="padding: 40px 30px; text-align: center;">
                <!-- Alert Icon -->
                <div style="margin-bottom: 25px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fef3c7, #fbbf24); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(251, 191, 36, 0.3);">
                        <i class="fa fa-refresh" style="color: #d97706; font-size: 35px;"></i>
                    </div>
                </div>
                
                <!-- Main Message -->
                <h3 style="color: #1e40af; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 15px;">
                    Reset All Votes
                </h3>
                
                <!-- Description -->
                <div style="background: linear-gradient(135deg, #fef3c7, #fed7aa); padding: 20px; border-radius: 15px; margin-bottom: 25px; border-left: 4px solid #f59e0b;">
                    <p style="color: #92400e; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; margin: 0; line-height: 1.5;">
                        <i class="fa fa-warning" style="margin-right: 8px; color: #d97706;"></i>
                        This will permanently delete all votes and reset the count to zero
                    </p>
                </div>
                
                <!-- Additional Warning -->
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; margin: 0; line-height: 1.4;">
                        <i class="fa fa-info-circle" style="margin-right: 6px; color: #3b82f6;"></i>
                        Make sure you have backed up any important data before proceeding with this action.
                    </p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 25px 30px; background: #f8fafc; display: flex; gap: 15px; justify-content: flex-end;">
                
                <!-- Cancel Button -->
                <button type="button" class="btn btn-cancel" data-dismiss="modal" style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; border: none; border-radius: 25px; padding: 12px 25px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3); min-width: 100px;">
                    <i class="fa fa-times" style="margin-right: 8px;"></i>
                    Cancel
                </button>
                
                <!-- Reset Button -->
                <a href="votes_reset.php" class="btn btn-reset" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; border: none; border-radius: 25px; padding: 12px 25px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4); min-width: 120px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa fa-refresh" style="margin-right: 8px;"></i>
                    Reset Votes
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for Modal -->
<style>
    /* Modal Animation */
    .modal.fade .modal-dialog {
        transform: scale(0.8) translateY(-50px);
        transition: all 0.3s ease-out;
    }
    
    .modal.fade.in .modal-dialog {
        transform: scale(1) translateY(0);
    }
    
    /* Close Button Hover Effect */
    .btn-close-custom:hover {
        background: rgba(255,255,255,0.3) !important;
        transform: rotate(90deg);
    }
    
    /* Cancel Button Hover Effect */
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4) !important;
        background: linear-gradient(135deg, #4b5563, #374151) !important;
    }
    
    /* Reset Button Hover Effect */
    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(220, 38, 38, 0.5) !important;
        background: linear-gradient(135deg, #b91c1c, #991b1b) !important;
    }
    
    /* Modal Backdrop */
    .modal-backdrop {
        background: rgba(30, 64, 175, 0.8);
        backdrop-filter: blur(5px);
    }
    
    /* Responsive Design */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px) !important;
        }
        
        .modal-body {
            padding: 30px 20px !important;
        }
        
        .modal-header {
            padding: 20px !important;
        }
        
        .modal-footer {
            padding: 20px !important;
            flex-direction: column;
        }
        
        .btn-cancel, .btn-reset {
            width: 100%;
            margin: 5px 0;
        }
    }
    
    /* Focus Styles for Accessibility */
    .btn-cancel:focus, .btn-reset:focus, .btn-close-custom:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
    
    /* Animation for Warning Icon */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .modal-body .fa-refresh {
        animation: pulse 2s infinite;
    }
</style>

<!-- JavaScript for Enhanced Interactions -->
<script>
    // Add confirmation dialog for extra safety
    document.addEventListener('DOMContentLoaded', function() {
        const resetButton = document.querySelector('.btn-reset');
        
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Create a secondary confirmation
                if (confirm('Are you absolutely sure you want to reset all votes? This action is irreversible!')) {
                    // Redirect to reset script
                    window.location.href = this.getAttribute('href');
                }
            });
        }
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('reset');
                if (modal && modal.classList.contains('in')) {
                    $(modal).modal('hide');
                }
            }
        });
    });
</script>