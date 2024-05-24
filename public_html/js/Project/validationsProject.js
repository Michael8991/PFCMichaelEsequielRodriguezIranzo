//constantes y variables
    //Datos Generales
    const fechaEmisionInput = document.getElementById('fechaEmision');
    const fechaValidezInput = document.getElementById('fechaValidez');
    const proyectoInput = document.getElementById('projectInputName');
    const generalDatasSection = document.getElementById('generalDatasSection')
    



    const seccionListaProyectos = document.getElementById('modalFooterProjects');
    const seccionListaClientes = document.getElementById('modalFooterCustomers');

    const guardarBtn = document.getElementById('btnSubmitBudgetForm');
    let section;
    let messageError;
    let error;

    let generalDataValidated = false;

    function errorAlertMessage(errorMessage, section, error){
        const errorAlert = document.createElement('div');
        errorAlert.classList.add(error, 'p-3', 'my-2', 'alert-danger', 'alert', 'text-center');
        errorAlert.innerText = errorMessage;
        section.appendChild(errorAlert);
    }

    function deleteErrorAlertMessage(valor, error){
        if(valor != '' && document.querySelector(`.${error}`)){
            document.querySelector(`.${error}`).classList.add('element-removed');
            setTimeout(()=>{
                document.querySelector(`.${error}`).remove();
            },490)
        }
    }

    function validateProjectSelected(id){
        if(id === -1){
            errorMessage = 'Debe seleccionar un proyecto si desea guardar';
            error = 'noProjectSelected';
            section = seccionListaProyectos;
            errorAlertMessage(errorMessage, section, error);
        }else{
            error = 'noProjectSelected';
            valor = id;
            deleteErrorAlertMessage(valor, error)
            error ='emptyProjectError';
            deleteErrorAlertMessage(valor, error)
        }
    }

    function validateCustomerSelected(id){
        if(id === -1){
            errorMessage = 'Debe seleccionar un cliente si desea guardar';
            error = 'noCustomerSelected';
            section = seccionListaClientes;
            errorAlertMessage(errorMessage, section, error);
        }else{
            error = 'noCustomerSelected';
            valor = id;
            deleteErrorAlertMessage(valor, error)
        }
    }