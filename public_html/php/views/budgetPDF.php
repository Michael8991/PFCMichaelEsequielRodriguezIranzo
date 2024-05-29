<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("location: login.php");
        exit;
    }

    require '../conexion.php'; 
    $user = $_SESSION['user'];

    // Validar y sanitizar la entrada
    $budget_id = $_GET['id'];

    if ($budget_id === false) {
        echo "ID de presupuesto no válido.";
        exit;
    }

    try {
        $sql = "SELECT CompanyID, ID FROM Users WHERE user = :userName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userName", $user, PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $company_id = $user_data['CompanyID'];
            $user_id = $user_data['ID'];
        } else {
            echo "Error: Usuario no encontrado";
            exit;
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit;
    }

    if ($budget_id) {
        try {
            $sql = "SELECT CompanyID FROM Budgets WHERE BudgetID = :budget_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }

        if ($resultados) {
            $budget_company_id = $resultados[0]['CompanyID'];
        } else {
            echo 'Error no hay presupuesto con es id';
            // header("Location: ../views/projectsPage.php");
            exit;
        }

        if ($budget_company_id != $company_id) {
            echo 'Error no coincide con es id';
            // header("Location: ../views/projectsPage.php");
            exit;
        }
    } else {
        echo 'Error no hay budget id';
        // header("Location: ../views/projectsPage.php");
        exit;
    }
    try{
        $consultaCompleta = "SELECT * FROM Budgets 
                    JOIN Projects ON Budgets.ProjectID = Projects.ProjectID 
                    JOIN customers ON Projects.CustomerID = customers.CustomerID 
                    JOIN users ON Budgets.BudgetCreatorUserID = users.ID 
                    JOIN Company ON Budgets.CompanyID = Company.CompanyID
                    -- JOIN budgetitems ON Budgets.BudgetID = budgetitems.BudgetID
                    WHERE Budgets.BudgetID = :budget_id";


        $stmt = $conn->prepare($consultaCompleta);
        $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);

        $stmt->execute();
    }catch(PDOException $e){
        echo 'Error en la seleccion de datos del presupuesto'.$e->getMessage();
    }
    // Obtener los resultados como un array asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultados as $resultado){
        $companyName = $resultado['CompanyName'];
        $companyNIF = $resultado['CompanyNIF'];
        $companyPostalCode = $resultado['CompanyPostalCode'];
        $companyCity = $resultado['CompanyCity'];
        $companyCountry = $resultado['CompanyCountry'];
        $companyAddress = $resultado['CompanyAddress'];
        $projectName = $resultado['ProjectName']; 
        $projectID = $resultado['ProjectID']; 
        $customerName = $resultado['FirstName']; 
        $customerSurname = $resultado['LastName']; 
        $customerAddress = $resultado['Address']; 

        $customer_complete_name = $customerName . ' ' . $customerSurname;

        $issue_date = $resultado['BudgetEmissionDate'];
        $exp_date = $resultado['BudgetValidityDate'];

        $materials_not_included = $resultado['materialsNotIncluded'];

        $estadoPresupuesto = $resultado['BudgetStatus'];

        $paymentAtTheEnd = $resultado['paymentAtTheEnd'];
        $paymentInProcess = $resultado['paymentInProcess']; 	
        $paymentUponAccepting = $resultado['paymentUponAccepting'];
        
        $IVA = $resultado['IVA'];
        $buildingPermit = $resultado['buildingPermit'];

        $creator_user = $resultado['user'];
        $totalAmount = $resultado['BudgetTotalAmount'];
    }
    try{
        $consultaItems = "SELECT * FROM budgetitems WHERE BudgetID = :budget_id";
        //Preparamos la consulta 2
        $stmt = $conn->prepare($consultaItems);
        $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultadosItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
   }catch(PDOException $e){
       echo 'Error en la consulta de items: '.$e->getMessage();
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador PDF</title>
    <link rel="shortcut icon" href="../../imagenes/Logos/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../../css/budgetPDF.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JavaScript y dependencias Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>
    <!-- /*<style>
    /* *{font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:lighter; text-align:left;}
    .invoce-container{max-width:1440px;margin-right:auto;margin-left:auto}
    .invoce-logo{height:250px}
    .table{width:100%;margin-bottom:1rem;color:#212529;border-collapse:collapse}
    .table th,.table td{padding:0.75rem;vertical-align:top;}
    .table thead th{vertical-align:bottom;}
    .table tbody+tbody{border-top:2px solid #dee2e6}
    .table .table{background-color:#fff}
    .table tbody{background-color:#fff !important}
    .d-flex{display:flex!important}
    .justify-content-center{justify-content:center!important}
    .col-6{position:relative;width:100%;padding-right:15px;padding-left:15px;flex:0 0 50%;max-width:50%}
    .col-12{position:relative;width:100%;padding-right:15px;padding-left:15px;flex:0 0 100%;max-width:100%}
    .mt-5{margin-top:3rem!important}
    .mx-auto{margin-right:auto!important;margin-left:auto!important}
    .w-50{width:50%!important}
    .w-75{width:75%!important}
    .fw-bold{font-weight:bold!important}
    .fw-semibold{font-weight:600!important}
    .fs-4{font-size:1.5rem!important}
    .fs-5{font-size:1.25rem!important}
    .align-middle{vertical-align:middle!important}
    .rounded-top{border-top-left-radius:0.25rem!important;border-top-right-radius:0.25rem!important}
    .border-danger { border-color: #dc3545 !important; }
    </style>  -->
</head>
<body>
<button id="btnPrintPDF" onclick="PrintElem('divToPrint')" class="m-2 btn btn-success"><i class="fa-solid fa-file-pdf me-2"></i> Imprimir PDF</button>  
    <div id="divToPrint" class="invoce-container mt-5">
        <div class="container">
            <div class="row d-flex">
                <div class="col-6 d-flex justify-content-center"><img class="invoce-logo" src="../../imagenes/Logos/LogoSimple.png" alt=""></div>
                <div class="col-6 d-flex justify-content-center">
                    <table class="table dates-table w-50">
                        <tr class="border-danger align-middle text-center">
                            <th colspan="2" class="align-middle fw-bold fs-4">Presupuesto <?php echo $companyName?></th>
                        </tr>
                        <tr class="border-danger align-middle">
                            <th class="align-middle">Fecha de creación:</th>
                            <th class="align-middle"><?php echo $issue_date ?></th>
                        </tr>
                        <tr class="border-danger align-middle">
                            <th class="align-middle">Fecha de validez:</th>
                            <th class="align-middle"><?php echo $exp_date ?></th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-5 d-flex">
                <div class="col-6 d-flex justify-content-center">
                    <table class="table companies-table w-50 border-danger">
                        <thead>
                            <tr class="align-middle">
                                <th  class="fw-bold fs-4">Empresa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <th class="align-middle">NIF: <?php echo $companyNIF ?></th>
                            </tr>
                            <tr class="align-middle">
                                <th  class="align-middle"><?php echo $companyAddress ?></th>
                            </tr>
                            <tr class="align-middle">
                                <th  class="align-middle"><?php echo $companyPostalCode. ' ' .$companyCity ?></th>
                            </tr>
                            <tr class="align-middle">
                                <th  class="align-middle"><?php echo $companyCity. ', ' .$companyCountry ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <table class="table companies-table w-50 border-danger">
                        <thead>
                            <tr class="align-middle">
                                <th  class="fw-bold fs-4">Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <th class="align-middle">Nombre: <?php echo $customer_complete_name ?></th>
                            </tr>
                            <tr class="align-middle">
                                <th  class="align-middle"><?php echo $customerAddress ?></th>
                            </tr>
                            <?php 
                                if($customerPostalCode){
                                    echo "<tr class='align-middle'>
                                            <th  class='align-maliddle'> $companyPostalCode. ' ' .$companyCity </th>
                                        </tr>";
                                }
                            ?>
                            <?php 
                                if($customerCity && $customerCountry){
                                    echo "<tr class='align-middle'>
                                            <th  class='align-maliddle'> $companyCity. ', ' .$companyCountry ?></th>
                                        </tr>";
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5 d-flex">
                <div class="col-12">
                    <table class="items-table mx-auto table w-75 rounded-top">
                        <thead class="">
                            <tr class="align-middle">
                                <th class="fw-bold fs-4" colspan="2">Concepto</th>
                                <th class="fw-bold fs-4 text-end">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($resultadosItems as $item){
                                    $itemDescription = $item['Description'];
                                    $totalPrice = $item['TotalPrice'];
                                   echo "<tr class='align-middle'>
                                        <th colspan='2'>$itemDescription</th>
                                        <th class='text-end'>$totalPrice €</th>
                                    </tr>";
                                }
                            ?>
                            <tr class="align-middle total-amount">
                                <th class="fw-semibold fs-5" colspan="2">Precio Total:</th>
                                <th class="text-end fw-semibold fs-5"><?php echo $totalAmount ?> €</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5 w-75 mx-auto">
                <div class="col-12">
                    <p class="fw-bold">Materiales NO incluidos:</p>
                    <p><?php echo $materials_not_included ?></p>
                </div>
            </div>
            <div class="row mt-2 d-flex w-75 mx-auto mb-2">
                <div class="col-6">
                    <p class="fw-bold">Términos de pago</p>
                    <p>Al aceptar el presupuesto: <?php echo $paymentUponAccepting ?> %</p>
                    <p>En el proceso: <?php echo $paymentInProcess ?> %</p>
                    <p>Al finalizar el proyecto: <?php echo $paymentAtTheEnd ?> %</p>
                </div>
                <div class="col-6">
                    <p class="fw-bold">IVA</p>
                    <?php 
                        if($IVA == 0){
                            echo "<p class=''> El IVA <b>NO</b> está incluido</p>";
                        }else{
                            echo "<p class=''> El IVA <b>SÍ</b> está incluido</p>";
                        }
                    ?>
                    <p class="fw-bold">Permisos de obra</p>
                    <?php 
                    if($buildingPermit == 0){
                        echo "<p class=''> Los permisos de obra <b>SÍ</b> están incluido</p>";
                    }else{
                        echo "<p class=''> Los permisos de obra <b>NO</b> están incluido</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/Budget/printBudget.js"></script>
</body>
</html>