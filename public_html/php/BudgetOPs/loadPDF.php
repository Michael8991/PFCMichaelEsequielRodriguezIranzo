<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../login.php");
    exit;
}

require '../conexion.php'; 
$user = $_SESSION['user'];

// Validar y sanitizar la entrada
$budget_id = $_POST['id'];

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
        exit;
    }

    if ($budget_company_id != $company_id) {
        echo 'Error no coincide con es id';
        exit;
    }
} else {
    echo 'Error no hay budget id';
    exit;
}

try {
    $consultaCompleta = "SELECT * FROM Budgets 
                JOIN Projects ON Budgets.ProjectID = Projects.ProjectID 
                JOIN customers ON Projects.CustomerID = customers.CustomerID 
                JOIN users ON Budgets.BudgetCreatorUserID = users.ID 
                WHERE Budgets.BudgetID = :budget_id";
    $stmt = $conn->prepare($consultaCompleta);
    $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    echo 'Error en la seleccion de datos del presupuesto'.$e->getMessage();
    exit;
}

// Obtener los resultados como un array asociativo
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($resultados)) {
    echo 'No se encontraron datos para el presupuesto';
    exit;
}

$datos_presupuesto = [];
foreach($resultados as $resultado){
    $datos_presupuesto = [
        'companyName' => $resultado['CompanyName'],
        'companyNIF' => $resultado['CompanyNIF'],
        'companyPostalCode' => $resultado['CompanyPostalCode'],
        'companyCity' => $resultado['CompanyCity'],
        'companyCountry' => $resultado['CompanyCountry'],
        'totalAmount' => $resultado['BudgetTotalAmount'],
        'projectName' => $resultado['ProjectName'], 
        'projectID' => $resultado['ProjectID'], 
        'customerName' => $resultado['FirstName'] . ' ' . $resultado['LastName'],
        'issue_date' => $resultado['BudgetEmissionDate'],
        'exp_date' => $resultado['BudgetValidityDate'],
        'materials_not_included' => $resultado['materialsNotIncluded'],
        'estadoPresupuesto' => $resultado['BudgetStatus'],
        'paymentAtTheEnd' => $resultado['paymentAtTheEnd'],
        'paymentInProcess' => $resultado['paymentInProcess'], 	
        'paymentUponAccepting' => $resultado['paymentUponAccepting'],
        'IVA' => $resultado['IVA'],
        'buildingPermit' => $resultado['buildingPermit'],
        'creator_user' => $resultado['user']
    ];
}

try {
    $consultaItems = "SELECT * FROM budgetitems WHERE BudgetID = :budget_id";
    $stmt = $conn->prepare($consultaItems);
    $stmt->bindParam(":budget_id", $budget_id, PDO::PARAM_INT);
    $stmt->execute();
    $resultadosItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta de items: '.$e->getMessage();
    exit;
}

// Include the main TCPDF library (search for installation path).
require_once('../../TCPDF-main/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu nombre');
$pdf->SetTitle('Presupuesto');
$pdf->SetSubject('Detalles del Presupuesto');
$pdf->SetKeywords('Presupuesto, PDF');

// set default header data
$pdf->SetHeaderData('', 0, 'Presupuesto', "Número de presupuesto: " . $budget_id);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
$pdf->AddPage();

// Set some content to print
$html = <<<EOD
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
<style>
   *{font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:lighter; text-align:left;}
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
    </style>
</head>
<body>
    <div class="invoce-container mt-5">
        <div class="container">
            <div class="row d-flex">
                <table class="table-flex">
                    <tr>
                        <th>
                            <div class="col-6 d-flex justify-content-center"><img class="invoce-logo" src="../../imagenes/Logos/LogoSimple.png" alt=""></div>
                        </th>
                        <th>
                            <div class="col-6 d-flex justify-content-center">
                                <table class="table dates-table w-50">
                                    <tr class="border-danger align-middle text-center">
                                        <th colspan="2" class="align-middle fw-bold fs-4">Presupuesto {$datos_presupuesto['companyName}']}</th>
                                    </tr>
                                    <tr class="border-danger align-middle">
                                        <th class="align-middle">Fecha de creación:</th>
                                        <th class="align-middle">{$datos_presupuesto['issue_date']}</th>
                                    </tr>
                                    <tr class="border-danger align-middle">
                                        <th class="align-middle">Fecha de validez:</th>
                                        <th class="align-middle">{$datos_presupuesto['exp_date']}</th>
                                    </tr>
                                </table>
                            </div>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="row mt-5">
                <div class="col-6 d-flex justify-content-center">
                    <table class="table companies-table w-50 border-danger">
                        <thead>
                            <tr class="align-middle">
                                <th class="fw-bold fs-4" style="font-weight: bold; font-size: 24px;">Empresa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <th>NIF: {$datos_presupuesto['companyNIF']}</th>
                            </tr>
                            <tr class="align-middle">
                                <th>{$datos_presupuesto['companyAddress']}</th>
                            </tr>
                            <tr class="align-middle">
                                <th>{$datos_presupuesto['companyPostalCode']} {$datos_presupuesto['companyCity']}</th>
                            </tr>
                            <tr class="align-middle">
                                <th>{$datos_presupuesto['companyCity']}, {$datos_presupuesto['companyCountry']}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <table class="table companies-table">
                        <thead>
                            <tr>
                                <th style="font-weight: bold; font-size: 24px;">Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Nombre: {$datos_presupuesto['FirstName']} {$datos_presupuesto['LastName']} </th>
                            </tr>
                            <tr>
                                <th>{$datos_presupuesto['customerAddress']}</th>
                            </tr>
EOD;

if ($customerPostalCode) {
    $html .= <<<EOD
                            <tr>
                                <th>{$customerPostalCode} {$customerCity}</th>
                            </tr>
                            EOD;
}

if ($customerCity && $customerCountry) {
    $html .= <<<EOD
                            <tr>
                                <th>{$customerCity}, {$customerCountry}</th>
                            </tr>
                            EOD;
}

$html .= <<<EOD
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <table class="items-table mx-auto table w-75 rounded-top">
                        <thead>
                            <tr class="align-middle">
                                <th class="fw-bold fs-4" colspan="2" style="font-weight: bold; font-size: 24px;">Concepto</th>
                                <th class="fw-bold fs-4 text-end" style="font-weight: bold; font-size: 24px; text-align: right;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
EOD;

foreach ($resultadosItems as $item) {
    $itemDescription = $item['Description'];
    $totalPrice = $item['TotalPrice'];
    $html .= <<<EOD
                            <tr>
                                <td colspan="2">{$itemDescription}</td>
                                <td style="text-align: right;">{$totalPrice} €</td>
                            </tr>
                            EOD;
}

$html .= <<<EOD
                            <tr class="align-middle total-amount">
                                <td class="fw-semibold fs-5" colspan="2">Precio Total:</td>
                                <td style="text-align: right;">{$totalAmount} €</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5 w-75 mx-auto">
                <div class="col-12">
                    <p style="font-weight: bold;">Materiales NO incluidos:</p>
                    <p>{$materials_not_included}</p>
                </div>
            </div>
            <div class="row mt-2 d-flex w-75 mx-auto mb-2">
                <div class="col-6">
                    <p style="font-weight: bold;">Términos de pago</p>
                    <p>Al aceptar el presupuesto: {$paymentUponAccepting} %</p>
                    <p>En el proceso: {$paymentInProcess} %</p>
                    <p>Al finalizar el proyecto: {$paymentAtTheEnd} %</p>
                </div>
                <div class="col-6">
                    <p style="font-weight: bold;">IVA</p>
                    <p>El IVA <strong><?php echo $IVA == 0 ? 'NO' : 'SÍ'; ?></strong> está incluido</p>                    <p style="font-weight: bold;">Permisos de obra</p>
                    <p>Los permisos de obra <strong><?php echo $buildingPermit == 0 ? 'SÍ' : 'NO'; ?></strong> están incluidos</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('presupuesto.pdf', 'I');
?>
