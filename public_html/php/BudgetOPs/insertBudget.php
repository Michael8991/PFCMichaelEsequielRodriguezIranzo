<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }
    require '../conexion.php';
    //accedemos al id del usuario para hacer las validaciones correspondientes.

    $user_name =  $_SESSION['user'];
    try{
        $sql = "SELECT CompanyID, ID FROM Users Where user = :userName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userName", $user_name, PDO::PARAM_STR);
        $stmt->execute();
    }catch(PDOException $e){
        echo 'error'. $e->getMessage();
    }
    
    if($stmt){
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $company_id = $row[0]['CompanyID'];
        $user_id = $row[0]['ID'];
    }else{
        echo "error de usuario";
    }

    //Errores
    $issue_date_error = $exp_date_error = $project_id_error = $materials_error = $paymentPercentaje_error = $total_amount_error = "";

    //Regex
    $date_regex = "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/";
    $only_number_regex = "/^\d+$/";
    $format_cost_regex ="/^\d{1,3}(,\d{3})*(\.\d{1,2})?$|^\d+(,\d{1,2})?$/";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Variables primer bloque.
        $issue_date = $exp_date = $project_id = $customer_id =  "";

        //Validaciones datos vacíos y formato de fecha.
        if(empty(trim($_POST["fechaEmisionInput"])) && !preg_match($date_regex, $_POST['fechaEmisionInput'])){
            $issue_date_error = "La fecha de emisión no es válida: ".$_POST["fechaEmisionInput"]; 
            echo $issue_date_error;
        }else{
            $issue_date = $_POST["fechaEmisionInput"];
        }

        if(empty(trim($_POST["fechaValidezInput"])) && !preg_match($date_regex, $_POST['fechaValidezInput'])){
            $exp_date_error = "La fecha de expiración no es válida: ".$_POST["fechaValidezInput"];  
            echo $exp_date_error;
        }else{
            $exp_date = $_POST["fechaValidezInput"];
        }
        
        if(empty(trim($_POST["projectInputID"]))){
            $project_id_error = "El proyecto no es válido: ".$_POST["projectInputID"];
            echo $project_id_error;
        }else{
            $project_id = $_POST["projectInputID"];
        }

        //Validación de que el proyecto pertenece al usuario.
        try{
            $sql = "SELECT CompanyID, CustomerID, CustomerName, ProjectName FROM Projects Where ProjectID = :project_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":project_id", $project_id, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $company_id_check = $row[0]['CompanyID'];
        }catch(PDOException $e){
            echo 'error'. $e->getMessage();
        }

        if($company_id_check !== $company_id){
            $project_id_error = "El proyecto no existe. Compañía del usuario" . $company_id; 
            echo $project_id_error;
        }else{
            $project_name = $row[0]['ProjectName'];
            $customer_name = $row[0]['CustomerName'];
            $customer_id = $row[0]['CustomerID'];
        }
        
        //Validación tabla de materiales y servicios.
        $elementos = $_POST['materials'];
        foreach($elementos as $elemento){
            $description = $elemento['campo3'];
            $cost = $elemento['campo2'];

            if(empty($description) || empty($cost)){
                $materials_error = "Los servicios o materiales no tienen un formato correto." .$cost;
            }
        }
        if($materials_error !== ""){
            echo $materials_error;
        }
        if(doubleval($_POST['totalAmountBudget']) === 0.0 ){
            $total_amount_error = "Error en el total del presupuesto, revise los datos.";
            echo $total_amount_error;
        }else{
            $total_amount = doubleval($_POST['totalAmountBudget']);
        }

        $paymentUponAccepting =  doubleval($_POST["paymentUponAccepting"]); 
        $paymentInProcess = doubleval($_POST["paymentInProcess"]);
        $paymentAtTheEnd = doubleval($_POST["paymentAtTheEnd"]);

        $totalPaymentPercentaje = $paymentAtTheEnd + $paymentInProcess + $paymentUponAccepting;

        //Validación de términos del presupuesto.
        if($totalPaymentPercentaje != 100){
            $paymentPercentaje_error = "Los porcentajes de pagos no son válidos: " .$totalPaymentPercentaje;
            echo $paymentPercentaje_error;
        }
    }

    if(empty($issue_date_error) && empty($exp_date_error) && empty($project_id_error) && empty($materials_error) && empty($paymentPercentaje_error) && empty($total_amount_error)){
        $budget_status = "Pendiente";
        if(empty($_POST["TAXincluded"]) || $_POST['TAXincluded'] === 'No'){
            $iva = 0;
        }else{
            $iva = 1;
        }

        if(empty($_POST["BuildingPermits"]) || $_POST['BuildingPermits'] === 'Si'){
            $building_permit = 1;
        }else{
            $building_permit = 0;
        }
        $materials_not_included = $_POST["floatingTextarea2"];
        try{
            $sqlInsertionBudget = "INSERT INTO Budgets (BudgetEmissionDate, BudgetStatus, BudgetCreatorUserID, BudgetTotalAmount, BudgetValidityDate, ProjectID, ProjectName, CustomerID, CustomerName, CompanyID, paymentAtTheEnd, paymentInProcess, paymentUponAccepting, materialsNotIncluded, IVA, buildingPermit) 
            VALUES (:BudgetEmissionDate, :BudgetStatus, :BudgetCreatorUserID, :BudgetTotalAmount, :BudgetValidityDate, :ProjectID, :ProjectName, :CustomerID, :CustomerName,  :CompanyID, :paymentAtTheEnd, :paymentInProcess, :paymentUponAccepting, :materialsNotIncluded, :IVA, :buildingPermit) ";
            $stmt =  $conn->prepare($sqlInsertionBudget);
            // Vincular parámetros
            $stmt->bindParam(':BudgetEmissionDate', $issue_date);
            $stmt->bindParam(':BudgetStatus', $budget_status);
            $stmt->bindParam(':BudgetCreatorUserID', $user_id);
            $stmt->bindParam(':BudgetTotalAmount', $total_amount);
            $stmt->bindParam(':BudgetValidityDate', $exp_date);
            $stmt->bindParam(':ProjectID', $project_id);
            $stmt->bindParam(':ProjectName', $project_name);
            $stmt->bindParam(':CompanyID', $company_id);
            $stmt->bindParam(':CustomerID', $customer_id);
            $stmt->bindParam(':CustomerName', $customer_name);
            $stmt->bindParam(':paymentAtTheEnd', $paymentAtTheEnd);
            $stmt->bindParam(':paymentInProcess', $paymentInProcess);
            $stmt->bindParam(':paymentUponAccepting', $paymentUponAccepting);
            $stmt->bindParam(':materialsNotIncluded', $materials_not_included);
            $stmt->bindParam(':IVA', $iva);
            $stmt->bindParam(':buildingPermit', $building_permit);

            $stmt->execute();

            $budget_id = $conn->lastInsertId();

        }catch(PDOException $e){
            echo 'Error inserción de Presupuesto: ' . $e->getMessage();
        }


        try{
            $sqlInsertionBudgetItems = "INSERT INTO budgetitems (BudgetID, Description, TotalPrice) VALUES (:budget_id :ItemDescription, :ItemPrice)";

            foreach($elementos as $elemento){
                $ItemID = $elemento['campo1'];
                $ItemPrice = doubleval($elemento['campo2']);
                $ItemDescription = $elemento['campo3'];

                $stmt = $conn->prepare($sqlInsertionBudgetItems);
                $stmt->bindParam(":ItemDescription", $ItemDescription, PDO::PARAM_STR);
                $stmt->bindParam(":ItemPrice", $ItemPrice, PDO::PARAM_STR);
                $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);
                $stmt->execute();
            }

        }catch(PDOException $e){
            echo 'Error inserción de items: ' . $e->getMessage();
        }

        header("Location: ../views/presupuestosPage.php");
        exit;
    }
    
?>