
// function printDiv() {
//     document.getElementById('btnPrintPDF').style.display = 'none';
//     window.print();
// }

// window.addEventListener('afterprint', function(){
//     let btnPrintPDF = document.getElementById('btnPrintPDF');
//     btnPrintPDF.style.display = 'block';
//     btnPrintPDF.innerHTML = `<i class="fa-solid fa-file-pdf me-2"></i> Imprimir PDF`;
// });

function PrintElem(elem) {
    let mywindow = window.open('', 'PRINT', 'height=400,width=600');
    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    // mywindow.document.write('<link rel="stylesheet" href="../../css/budgetPDF.css" type="text/css" />');
    mywindow.document.write('<style>*{font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:lighter; text-align:left;} .invoce-container{max-width:1440px;margin-right:auto;margin-left:auto}.invoce-logo{height:250px}.table{width:100%;margin-bottom:1rem;color:#212529;border-collapse:collapse}.table th,.table td{padding:0.75rem;vertical-align:top;}.table thead th{vertical-align:bottom;}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table tbody{background-color:#fff !important}.d-flex{display:flex!important}.justify-content-center{justify-content:center!important}.col-6{position:relative;width:100%;padding-right:15px;padding-left:15px;flex:0 0 50%;max-width:50%}.col-12{position:relative;width:100%;padding-right:15px;padding-left:15px;flex:0 0 100%;max-width:100%}.mt-5{margin-top:3rem!important}.mx-auto{margin-right:auto!important;margin-left:auto!important}.w-50{width:50%!important}.w-75{width:75%!important}.fw-bold{font-weight:bold!important}.fw-semibold{font-weight:600!important}.fs-4{font-size:1.5rem!important}.fs-5{font-size:1.25rem!important}.align-middle{vertical-align:middle!important}.rounded-top{border-top-left-radius:0.25rem!important;border-top-right-radius:0.25rem!important}.border-danger { border-color: #dc3545 !important; }</style>');
    mywindow.document.write('</head> <body>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.blur();
    mywindow.focus();

    mywindow.print();
    mywindow.close();

    return true;
}

