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
guardarBtn.addEventListener('click', async (event)=>{
    event.preventDefault();
    
    


    // validateData(fechaEmisionInput.value, 'La fecha de emisión no es válida', 'emptyEmissionDateError',generalDatasSection);
    // validateData(fechaValidezInput.value, 'La fecha de validez no es válida', 'emptyValidateDateError',generalDatasSection);
    // validateData(proyectoInput.value, 'Rellene el campo del proyecto', 'emptyProjectError',generalDatasSection);
    
    // checkAlerts()
    
});

    // function checkAlerts(){
    //     const counterErrorAlertMessage = document.querySelectorAll('.alert');

    //     if(counterErrorAlertMessage.length >= 1){
    //         console.log('no se puede avanzar');
    //     }else{
    //         console.log('enviamos el presupuesto');
    //     }
    // }
    


    let generalDataValidated = false;
  

    //funciones
    function validateData(value, errorMessage, error, section){
        if(!value){
            if(!document.querySelector(`.${error}`)){
                errorAlertMessage(errorMessage, section, error);
            }
        }else if(document.querySelector(`.${error}`)){
            deleteErrorAlertMessage(value, error)
        }
    }
    function validateGeneralData(value, errorMessage, error){
        if(!value){
            if(!document.querySelector(`.${error}`)){
                errorAlertMessage(errorMessage, section, error);
            }
        }else if(document.querySelector(`.${error}`)){
            deleteErrorAlertMessage(value, error)
        }
    }

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