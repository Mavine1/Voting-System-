<!-- Preview -->
<div class="modal fade" id="preview_modal">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #ffffff; color: #059669; font-size: 15px; font-family: Times;">
            <div class="modal-header" style="border-bottom: 2px solid #059669;">
                <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="background-color: #dc2626; color: #ffffff; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #059669; font-size: 18px; font-family: Times; font-weight: bold;">Vote Preview</h4>
            </div>
            <div class="modal-body">
                <div id="preview_body"></div>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #059669;">
                <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #059669; color: #ffffff; font-size: 12px; font-family: Times; border: none;" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Platform -->
<div class="modal fade" id="platform">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #ffffff; color: #059669;">
            <div class="modal-header" style="border-bottom: 2px solid #059669;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: #dc2626; color: #ffffff; border: none; padding: 8px 12px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #059669; font-weight: bold;">
                    <b><span class="candidate"></span></b>
                </h4>
            </div>
            <div class="modal-body">
                <p id="plat_view" style="color: #059669;"></p>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #059669;">
                <button type="button" class="btn btn-default btn-flat pull-left" style="background-color: #059669; color: #ffffff; border: none;" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Ballot -->
<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #ffffff; color: #059669; font-size: 15px; font-family: Times;">
            <div class="modal-header" style="border-bottom: 2px solid #059669;">
                <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="background-color: #dc2626; color: #ffffff; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color: #059669; font-weight: bold; font-size: 18px;">
                    <b>Your Votes</b>
                </h4>
            </div>
            <div class="modal-body">
                <?php
                    $id = $voter['id'];
                    $sql = "SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id WHERE voters_id = '$id' ORDER BY positions.priority ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        echo "
                            <div class='row votelist' style='margin-bottom: 10px; padding: 8px; border-bottom: 1px solid #059669;'>
                                <span class='col-sm-4'><span class='pull-right' style='color: #059669; font-weight: bold;'><b>".$row['description']." :</b></span></span> 
                                <span class='col-sm-8' style='color: #059669;'>".$row['canfirst']." ".$row['canlast']."</span>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #059669;">
                <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #059669; color: #ffffff; font-size: 12px; font-family: Times; border: none;" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>