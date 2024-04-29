const customerList = document.getElementById("customerDisplayer");

const customerInputID = document.getElementById("customerInputID");
const customerInputName = document.getElementById("customerInputName");
const browserCustomerInput = document.getElementById("browserCustomerInput");



document.getElementById("openCustomersModalBtn").addEventListener("click", searchAllCustomers);

let customers;

browserCustomerInput.addEventListener('input', () => {
    const searchTerm = browserCustomerInput.value;
    fetch(`../../php/BudgetOPs/buscarClienteOP.php?term=${searchTerm}`)
        .then(response => response.json())
        .then(data => {
            customers = data;
            customerList.innerHTML= ``;
            // Construir la tabla de proyectos
            const customersTable = document.createElement('table');
            const customersTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Apellido</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Télefono</th>
                                            <th scope="col">Dirección</th>
                                            </tr>
                                        </thead>`;
            customersTable.innerHTML= customersTableHead;
            customersTable.classList.add('table');

            const customersTableBody = document.createElement('tbody');
            customersTableBody.classList.add('table-group-divider');
            customers.forEach(function(customer) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="customers" value="${customer.CustomerID}" id="customers${customer.CustomerID}">
                                </th>
                                <td>${customer.FirstName}</td>
                                <td>${customer.LastName}</td>
                                <td>${customer.Email}</td>
                                <td>${customer.PhoneNumber}</td>
                                <td>${customer.Address}</td>`;
                customersTableBody.appendChild(tr);
            });
            customersTable.appendChild(customersTableBody);
            customerList.appendChild(customersTable);
        })
        .catch(error => console.error('Error:', error));
});

function searchAllCustomers(){    
    // Obtener la lista de proyectos
    customerList.innerHTML = ``;
    
    // Realizar una solicitud AJAX para obtener los proyectos
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parsear la respuesta JSON
            customers = JSON.parse(xhr.responseText);
            
            // Construir la tabla de proyectos
            const customersTable = document.createElement('table');
            const customersTableHead = `<thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Apellido</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Télefono</th>
                                            <th scope="col">Dirección</th>
                                            </tr>
                                        </thead>`;
            customersTable.innerHTML= customersTableHead;
            customersTable.classList.add('table');

            const customersTableBody = document.createElement('tbody');
            customersTableBody.classList.add('table-group-divider');
            customers.forEach(function(customer) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<th scope="row">
                                    <input class="form-check-input me-1" type="radio" name="customers" value="${customer.CustomerID}" id="customers${customer.CustomerID}">
                                </th>
                                <td>${customer.FirstName}</td>
                                <td>${customer.LastName}</td>
                                <td>${customer.Email}</td>
                                <td>${customer.PhoneNumber}</td>
                                <td>${customer.Address}</td>`;
                customersTableBody.appendChild(tr);
            });
            customersTable.appendChild(customersTableBody);
            customerList.appendChild(customersTable);
        }
    };
    xhr.open("GET", "../../php/BudgetOPs/buscarClienteOP.php", true);
    xhr.send();
};

const confirmCustomerBtn = document.getElementById('confirmCustomerBtn');
let selectedCustomerId = -1;
confirmCustomerBtn.addEventListener('click', () =>{
    
    const checkedInputs = document.querySelectorAll('input[name="customers"]:checked');
    
    if(checkedInputs.length === 0){
        //validaciones
        validateCustomerSelected(selectedCustomerId);
    }else if(checkedInputs.length > 1){
        console.log('Solo puede seleccionar un elemento');
    }else{
        checkedInputs.forEach(option =>{
            selectedCustomerId = option.value;
        })
        closeCustomersModal();
        // Encuentra el proyecto seleccionado por su ID
        const selectedCustomer = customers.find(customer => customer.CustomerID === selectedCustomerId);

        if (selectedCustomer) {
            const selectedCustomerName = selectedCustomer.FirstName +' '+ selectedCustomer.LastName;
            customerInputID.value = selectedCustomerId;
            customerInputName.value = selectedCustomerName;
            validateCustomerSelected(selectedCustomer);
        }
    }
});

