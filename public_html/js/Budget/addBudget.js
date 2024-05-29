
function openProjectsModal() {
    $('#projectsModal').modal('show');
}
function closeProjectsModal() {
    $('#projectsModal').modal('hide');
}
function minimizeProjectsModal() {
    $('#projectsModal').modal('hide');
}

function openAddProjectModal() {
    minimizeProjectsModal()
    $('#addProjectModal').modal('show');
}
function closeAddProjectModal() {
    openProjectsModal();
    seachAllProjects();
    $('#addProjectModal').modal('hide');
}
function minimizeAddProjectModal() {
    $('#addProjectModal').modal('hide');
}

function openCustomersModal() {
    minimizeAddProjectModal();
    $('#customersModal').modal('show');
}
function closeCustomersModal() {
    $('#customersModal').modal('hide');
    openAddProjectModal();

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

function openServicesModal() {
    $('#servicesModal').modal('show');
}
function closeServicesModal() {
    $('#servicesModal').modal('hide');
}
function minimizeServicesModal() {
    $('#servicesModal').modal('hide');
}

function openAddServicesModal() {
    minimizeServicesModal();
    $('#addServicesModal').modal('show');
}
function closeAddServicesModal() {
    openServicesModal();
    $('#addServicesModal').modal('hide');
}
