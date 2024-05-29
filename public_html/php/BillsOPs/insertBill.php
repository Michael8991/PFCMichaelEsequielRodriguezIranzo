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

    try {

        // Consulta SQL
        $sql = 'SELECT * FROM Bills WHERE CompanyID = :company_id ORDER BY billNumber DESC LIMIT 1';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si se obtuvo un resultado
        if ($result) {
            $currentSequence = $result['billNumber'];
            list($year, $invoiceNumber) = explode('-', $currentSequence);
            $newInvoiceNumber = str_pad((int)$invoiceNumber + 1, 4, '0', STR_PAD_LEFT);
            $billNumber = $year . '-' . $newInvoiceNumber;
        } else {
            $currentYear = date('Y');
            $invoiceNumber = 0;
            $newInvoiceNumber = str_pad((int)$invoiceNumber + 1, 4, '0', STR_PAD_LEFT);
            $billNumber =  $currentYear . '-' . $newInvoiceNumber;
        }
    } catch (PDOException $e) {
        echo 'Error de conexión: ' . $e->getMessage();
    }
    

    //Errores
    $issue_date_error = $exp_date_error = $project_id_error = $materials_error = $paymentPercentaje_error = $total_amount_error = $payment_status_error = $payment_method_error = "";

    //Regex
    $date_regex = "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/";
    $only_number_regex = "/^\d+$/";
    $format_cost_regex ="/^\d{1,3}(,\d{3})*(\.\d{1,2})?$|^\d+(,\d{1,2})?$/";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Variables primer bloque.
        $issue_date = $exp_date = $project_id = $customer_id = $project_name = $customer_name = "";

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
            $sql = "SELECT CompanyID, ProjectName, CustomerID, CustomerName FROM Projects Where ProjectID = :project_id";
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
    }

    if (isset($_POST['paymentStatus']) && !empty($_POST['paymentStatus'])) {
        $paymentStatus = $_POST['paymentStatus'];
    
        if ($paymentStatus === 'Pagada' || $paymentStatus === 'Pendiente') {
            
        } else {
            $payment_status_error = "El estado del pago es incorrecto";
        }
    }
    if (isset($_POST['paymentMethod']) && !empty($_POST['paymentMethod'])) {
        $paymentMethod = $_POST['paymentMethod'];
    
        if ($paymentMethod === 'Tarjeta' || $paymentMethod === 'Efectivo' || $paymentMethod === 'Cheque' || $paymentMethod === 'Transferencia bancaria') {
            
        } else {
            $payment_method_error = "El método del pago es incorrecto";
        }
    }

    if(empty($issue_date_error) && empty($exp_date_error) && empty($project_id_error) && empty($materials_error) && empty($total_amount_error) && empty($payment_method_error) && empty( $payment_status_error)){
        $notes = $_POST["floatingTextarea2"];
        try{
            $sqlInsertionBudget = "INSERT INTO bills (BillDateIssued, BillStatus, BillCreator, BillCreatorName, TotalBillAmount, BillDueDate, ProjectID, CompanyID, ProjectName, CustomerName, CustomerID, BillNotes, BillPaymentMethod, billNumber) 
            VALUES (:BillEmissionDate, :BillStatus, :BillCreatorUserID, :BillCreatorName, :BillTotalAmount, :BillValidityDate, :ProjectID, :CompanyID, :ProjectName, :CustomerName, :CustomerID, :notes, :paymentMethod, :billNumber) ";
            $stmt =  $conn->prepare($sqlInsertionBudget);
            // Vincular parámetros
            $stmt->bindParam(':BillEmissionDate', $issue_date);
            $stmt->bindParam(':BillStatus', $paymentStatus);
            $stmt->bindParam(':BillCreatorUserID', $user_id);
            $stmt->bindParam(':BillCreatorName', $user_name);
            $stmt->bindParam(':BillTotalAmount', $total_amount);
            $stmt->bindParam(':BillValidityDate', $exp_date);
            $stmt->bindParam(':CompanyID', $company_id);
            $stmt->bindParam(':ProjectID', $project_id);
            $stmt->bindParam(':ProjectName', $project_name);
            $stmt->bindParam(':CustomerID', $customer_id);
            $stmt->bindParam(':CustomerName', $customer_name);
            $stmt->bindParam(':notes', $notes);
            $stmt->bindParam(':paymentMethod', $paymentMethod);
            $stmt->bindParam(':billNumber', $billNumber);



            $stmt->execute();

            $bill_id = $conn->lastInsertId();
        }catch(PDOException $e){
            echo 'Error inserción de Presupuesto: ' . $e->getMessage();
        }
        try{
            $sqlInsertionBudgetItems = "INSERT INTO BillItems (BillID, Description, TotalPrice) VALUES (:bill_id, :ItemDescription, :ItemPrice)";

            foreach($elementos as $elemento){
                $ItemID = $elemento['campo1'];
                $ItemPrice = doubleval($elemento['campo2']);
                $ItemDescription = $elemento['campo3'];

                $stmt = $conn->prepare($sqlInsertionBudgetItems);
                $stmt->bindParam(":ItemDescription", $ItemDescription, PDO::PARAM_STR);
                $stmt->bindParam(":ItemPrice", $ItemPrice, PDO::PARAM_STR);
                $stmt->bindParam(":bill_id", $bill_id, PDO::PARAM_INT);
                $stmt->execute();
            }

        }catch(PDOException $e){
            echo 'Error inserción de items: ' . $e->getMessage();
        }

        header("Location: ../views/facturasPage.php");
        exit;
    }else{
        echo 'Hay algun error';
        echo $issue_date_error. ' || ' .$exp_date_error. ' || ' .$project_id_error. ' || ' .$materials_error. ' || ' .$total_amount_error. ' || ' .$payment_method_error. ' || ' .$payment_status_error ;
    }
    
?>