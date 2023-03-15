<?php
function excel(){
?>
<div class="main" style="padding: 15px;">
    <div class="form-group import-excel" style="width: 30%">
        <input type="file" class="filestyle" id="excelfile" accept=".xls,.xlsx">
    </div>
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-left">
                <strong>All Establishments in Excel</strong>
            </h2>
        </div>
        <div class="col-md-4">
            <button class="btn btn-md btn-primary pull-right" style="margin-top: 20px;" onclick="ImportExcel.save();">Save to database</button>
        </div>
    </div>
    <table id="excel_data" class="table table-striped table-bordered table-hover">
    </table>
</div>
<?php
}
?>