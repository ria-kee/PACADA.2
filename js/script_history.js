// Retrieve the encrypted employee ID from the query parameter
var urlParams = new URLSearchParams(window.location.search);
var encryptedEmpID = urlParams.get('employee');
var decodedEncryptedEmpID = decodeURIComponent(encryptedEmpID);
var empName = urlParams.get('Name');

// Set the employee name in the <b> element
$('#employee-name').text(empName);

// Decrypt the employee ID using the secret key
var secretKey = 'd0$tP@c@da';
var decryptedEmpID = CryptoJS.AES.decrypt(decodedEncryptedEmpID, secretKey).toString(CryptoJS.enc.Utf8);



var leavesTable = $('#leavesTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_history_leaves.php',
        type: 'post',
        data: {
            employeeID: decryptedEmpID
        }
    },
    columnDefs: [{
        targets: [4]
    }]
});
    $(document).ready(function() {

        $('.searchField').on('keyup', function() {
            leavesTable.search(this.value).draw();
        });
    });
    $('.dataTables_filter').hide();



var timeoffsTable = $('#timeoffsTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_history_timeoff.php',
        type: 'post',
        data: {
            employeeID: decryptedEmpID
        }
    },
    columnDefs: [{
        targets: [3]
    }]
});
$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        timeoffsTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();



