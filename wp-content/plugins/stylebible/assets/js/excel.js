var ImportExcel = function () {
    var establishmentTb = null;
    var excelJsonData = [];

    var excelIndex = {
        no: "NO",
        city: "CITY NAME",
        establishment_name: "ESTABLISHMENT NAME",
        price: "PRICE",
        category: "CATEGORY",
        sub_category: "SUB CATEGORY",
        why_we_love_it: "WHY WE LOVE IT",
        author: "AUTHOR - CMS ONLY",
        area: "AREA",
        address: "ADDRESS",
        website_url: "WEBSITE ADDRESS",
        instagram_url: "INSTAGRAM ",
        tiktok: "TIKTOK - CMS ONLY",
        note: "NOTES - CMS ONLY",
        hidden_gem: "HIDDEN GEMS"
    };

    var buildColumns = function() {
        var columns = [];
        for (const key in excelIndex) {
            var column = {
                data: key,
                title: excelIndex[key],
            };
            columns.push( column );
        }
        return columns;
    }

    var handleFileSelect = evt => {
        var files = evt.target.files; // FileList object
        excelJsonData = [];
        parseExcel(files[0]);
    }

    var parseExcel = file => {
        var reader = new FileReader();

        reader.onload = function (e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {type: 'binary'});
            var i = 1;

            workbook.SheetNames.forEach( sheetName => {
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var sheetJsonData = JSON.parse(JSON.stringify(XL_row_object));

                sheetJsonData.forEach( row => {

                    var realRow = {};

                    for (const key in excelIndex) {
                        realRow[key] = ( row[ excelIndex[key] ] ? row[ excelIndex[key] ] : '' );
                    }

                    realRow.no = i;
                    realRow.city = sheetName;

                    excelJsonData.push( realRow );
                    
                    i++;
                });
            });

            establishmentTb.clear().rows.add( excelJsonData ).draw();

        };
        reader.onerror = function (ex) {
            console.log(ex);
        };

        reader.readAsBinaryString(file);
    }

    return {
        init: function() {
            establishmentTb = jQuery("#excel_data").DataTable({
                columns: buildColumns(),
                processing: true,
                searching: false,
                scrollX: true,
                ordering: false,
                autoWidth: false
            });

            jQuery("#excelfile").on('change', handleFileSelect);

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        },
        save: function() {
            if( excelJsonData.length === 0 ) {
                alert("Please select excel file and import data.");
                return;
            }
            jQuery.blockUI({
                css: { 
                    border: 'none', 
                    padding: '5px 15px', 
                    backgroundColor: 'rgba(0,0,0,0.4)',
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    color: '#fff',
                    width: '140px',
                    left: 'calc(50% - 70px)',
                },
                message: 'Saving...'
            });
            jQuery.ajax({
                method: 'POST',
                url: ajaxurl,
                data: {
                    action:     'import_excel',
                    excelJsonData
                },
                success: function(res) {
                    jQuery.unblockUI();
                    var response = JSON.parse( res );
                    if( response.result ) {
                        alert("Saved excel data successfully!");
                        jQuery('.import-excel input').val(null);
                        establishmentTb.clear().draw();
                        excelJsonData = [];
                    }
                }, 
                error: function(err) {
                    console.log(err);
                    jQuery.unblockUI();
                    alert('Error is occuered!');
                }
            });
        }
    }
}();

jQuery(document).ready(function(){
    ImportExcel.init();
});