<!-- Config Modal -->
<div class="modal fade" id="config">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #ffffff; color: black; font-size: 15px; font-family: Times">
            <div class="modal-header" style="background-color: #1e40af; color: white;">
                <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Configure</b></h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <?php
                        $parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
                        $title = $parse['election_title'];
                    ?>
                    <form class="form-horizontal" method="POST" action="config_save.php?return=<?php echo basename($_SERVER['PHP_SELF']); ?>">
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color: black; font-size: 12px; font-family: Times; border: 1px solid #1e40af;" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
                <button type="submit" class="btn btn-success btn-curve" style="background-color: #1e40af; color: white; font-size: 12px; font-family: Times;" name="save">
                    <i class="fa fa-save"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>