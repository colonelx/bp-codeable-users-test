/**
 * This is the main file for the bp-codeable-users-test plugin.
 */
jQuery(document).ready(function($) {
    var test_data = [
        ['test', 'test', 'test', 'test'],
        ['test', 'test', 'test', 'test'],
        ['test', 'test', 'test', 'test']
    ];

    $('#user-list').DataTable({
        serverSide: true,
        ajax: {
            url: ajax_get_users_url,
            type: 'POST'
        },
        columns: [
            { title: 'Name', name: 'display_name' },
            { title: 'Username', name: 'username' },
            { title: 'Email', name: 'email', orderable: false },
            { title: 'Role', name: 'role', orderable: false },
        ],
        initComplete: function () {
            var role_column = this.api().column(3);
            var select = $('<select><option value="">-Role-</option></select>')
            .appendTo( $(role_column.header()).empty() )
            .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                role_column
                    .search( val ? val : '', true, false )
                    .draw();
            } );
            for (var key in wp_defined_roles) {
                select.append( '<option value="'+key+'">'+wp_defined_roles[key]+'</option>' );
            }
        }
    });
    
});