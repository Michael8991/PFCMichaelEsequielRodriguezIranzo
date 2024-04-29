const serviceList = document.getElementById("serviceDisplayer");

// const serviceInputID = document.getElementById("customerInputID");
const browserServiceInput = document.getElementById("browserServiceInput");



document.getElementById("openServicesModalBtn").addEventListener("click", seachAllServices);

let services;

browserServiceInput.addEventListener('input', () => {
    const searchTerm = browserServiceInput.value;
    fetch(`../../php/BudgetOPs/buscarServicioOP.php?term=${searchTerm}`)
        .then(response => response.json())
        .then(data => {
            services = data;
            serviceList.innerHTML= ``;
            // Construir la tabla de servicios
            const servicesTable = document.createElement('table');
            const servicesTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Precio unidad</th>
                                            <th scope="col">Formato unidad</th>
                                            </tr>
                                        </thead>`;
            servicesTable.innerHTML= servicesTableHead;
            servicesTable.classList.add('table');

            const servicesTableBody = document.createElement('tbody');
            servicesTableBody.classList.add('table-group-divider');
            services.forEach(function(service) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="services" value="${service.ServiceID}" id="services${service.ServiceID}">
                                </th>
                                <td>${service.ServiceName}</td>
                                <td>${service.ServiceDescription}</td>
                                <td>${service.unitPrice}€</td>
                                <td>${service.unitFormat}</td>`;
                servicesTableBody.appendChild(tr);
            });
            servicesTable.appendChild(servicesTableBody);
            servicesList.appendChild(servicesTable);
        })
        .catch(error => console.error('Error:', error));
});

function seachAllServices(){    
    // Obtener la lista de proyectos
    serviceList.innerHTML = ``;
    
    // Realizar una solicitud AJAX para obtener los proyectos
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parsear la respuesta JSON
            services = JSON.parse(xhr.responseText);
            
            // Construir la tabla de servicios
            const servicesTable = document.createElement('table');
            const servicesTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Precio unidad</th>
                                            <th scope="col">Formato unidad</th>
                                            </tr>
                                        </thead>`;
            servicesTable.innerHTML= servicesTableHead;
            servicesTable.classList.add('table');

            const servicesTableBody = document.createElement('tbody');
            servicesTableBody.classList.add('table-group-divider');
            services.forEach(function(service) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="services" value="${service.ServiceID}" id="services${service.ServiceID}">
                                </th>
                                <td>${service.ServiceName}</td>
                                <td>${service.ServiceDescription}</td>
                                <td>${service.UnitPrice}€</td>
                                <td>${service.UnitFormat}</td>`;
                servicesTableBody.appendChild(tr);
            });
            servicesTable.appendChild(servicesTableBody);
            serviceList.appendChild(servicesTable);
        }
    };
    xhr.open("GET", "../../php/BudgetOPs/buscarServicioOP.php", true);
    xhr.send();
};

const confirmServiceBtn = document.getElementById('confirmServiceBtn');
let selectedServiceId = -1;
confirmServiceBtn.addEventListener('click', async () =>{
    
    const checkedInputs = document.querySelectorAll('input[name="services"]:checked');
    
    if(checkedInputs.length === 0){
        //validaciones
        // validateServicesSelected(selectedServiceId);
    }else if(checkedInputs.length > 1){
        console.log('Solo puede seleccionar un elemento');
    }else{
        addRowBudgetService();
        const serviceInputName = document.getElementById(`rowBudget-${rowCounter - 1}`);
        const serviceInputID = document.getElementById(`rowBudget-${rowCounter - 1}-Id`);
        checkedInputs.forEach(option =>{
            selectedServiceId = option.value;
        })
        closeServicesModal();
        
        // Encuentra el proyecto seleccionado por su ID
        const selectedService = services.find(service => service.ServiceID === selectedServiceId);

        if (selectedService) {
            serviceInputID.value = selectedServiceId;
            serviceInputName.value = selectedService.ServiceName;
            // validateServicesSelected(selectedService);
        }
    }
});

