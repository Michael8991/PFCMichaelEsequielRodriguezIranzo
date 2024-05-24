function openProjectsModal() {
    $('#projectsModal').modal('show');
}
function closeProjectsModal() {
    $('#projectsModal').modal('hide');
}
function minimizeProjectsModal() {
    $('#projectsModal').modal('hide');
}


function openCustomersModal() {
    $('#customersModal').modal('show');
}
function closeCustomersModal() {
    $('#customersModal').modal('hide');
}
function minimizeCustomersModal() {
    $('#customersModal').modal('hide');
}

function openAddCustomerModal() {
    minimizeCustomersModal()
    $('#addCustomerModal').modal('show');
}
function closeAddCustomerModal() {
    openCustomersModal();
    searchAllCustomers();
    $('#addCustomerModal').modal('hide');
}


function openSaveModal() {
    $('#confirmSaveModal').modal('show');
}
function closeSaveModal() {
    $('#confirmSaveModal').modal('hide');
}


function openCancelModal() {
    $('#confirmCancelModal').modal('show');
}
function closeCancelModal() {
    $('#confirmCancelModal').modal('hide');
}

