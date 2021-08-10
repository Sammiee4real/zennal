/**
 * 
 * Implementations 
 * 
 */

$(document).on('click', '.package_status', function(){
    id = $(this).attr('data-id');
    val = String($(this).attr('data-val'));
    // alert(val);

    ajaxRequest('loan_packages', id, val);

    if(val === '0'){
        $('#status_badge'+id).removeClass('btn-success');
        $('#status_badge'+id).addClass('btn-danger');
        $('#status_badge'+id).text('Hidden');

        $('#package_status'+id).addClass('btn-success');
        $('#package_status'+id).removeClass('btn-danger');
        $('#package_status'+id).text('Show');
        $('#package_status'+id).attr('data-val', '1');
    }
    else if(val === '1'){
        $('#status_badge'+id).removeClass('btn-danger');
        $('#status_badge'+id).addClass('btn-success');
        $('#status_badge'+id).text('Visible');

        $('#package_status'+id).removeClass('btn-success');
        $('#package_status'+id).addClass('btn-danger');
        $('#package_status'+id).text('Hide');
        $('#package_status'+id).attr('data-val', '0');
        
    }
});



load_server_datatable_buttons('users_info_tbl', 'users/info_view');

/**
 * 
 * 
 * FUNCTIONS 
 * 
 * 
 */
function ajaxRequest(page='', id='', val='')
{
    $.ajax({
        url: 'ajax_admin/statuses.php',
        method:'post',
        data: {page:page, id:id, val:val},
        dataType:'json',
        success:function(data)
        {
            data = JSON.parse(data);

            if(data.success){
                $("#success_message").empty();
                $("#success_message").html("Success! Status changed successfully");
                toastbox('success_toast', 1500);
            }else{
                $("#error_message").empty();
                $("#error_message").html("Error! "+data.error);
                toastbox('error_toast', 1500);
            }
        }
    })
}

function load_server_datatable_buttons(tblName='', url=''){
    // alert('request sent');
    $('#'+tblName).DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"server_datatables/"+url+".php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":0,
                "orderable":false,
                "searchable": false,
                "visible": true
            },
        ],
        dom: 'lBfrtip',
        buttons: [
            'csv', 'pdf', 'excel', 'print'
        ]
    });
}


function load_server_datatable(tblName='', url=''){
    $('#'+tblName).DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"server_datatables/"+url+".php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":0,
                "orderable":false,
                "searchable": false,
                "visible": true
            },
        ]
    });
}



