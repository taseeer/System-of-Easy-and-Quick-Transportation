$(document).ready(function () {
    $('input[name="table_search"]').on('keyup', function () {
        let searchText = $(this).val().toLowerCase();
        $('table tbody tr').each(function () {
            let rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(searchText) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});