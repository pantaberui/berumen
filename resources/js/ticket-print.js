window.imprimirTicket = function() {
    const ticket  = document.getElementById('ticket').innerHTML;
    const ventana = window.open('', '_blank', 'width=320,height=600');
    ventana.document.write(`<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page {
            size: 80mm auto;
            margin: 2mm 3mm;
        }
        body {
            font-family: monospace;
            font-size: 10px;
            width: 74mm;
            margin: 0 auto;
            padding: 0;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 2mm;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .flex        { display: flex; }
        .justify-between { justify-content: space-between; }
        .font-bold   { font-weight: bold; }
        .font-medium { font-weight: 500; }
        .text-lg     { font-size: 13px; }
        .text-base   { font-size: 12px; }
        .text-sm     { font-size: 10px; }
        .text-xs     { font-size: 9px; }
        .text-gray-500 { color: #555; }
        .text-gray-600 { color: #444; }
        .text-gray-400 { color: #777; }
        .text-red-600  { color: #c00; }
        .text-green-700{ color: #060; }
        .border-t      { border-top: 1px solid #ccc; }
        .border-dashed { border-top-style: dashed; }
        .pt-4  { padding-top: 3mm; }
        .pt-2  { padding-top: 1.5mm; }
        .mt-4  { margin-top: 3mm; }
        .mt-2  { margin-top: 1.5mm; }
        .mt-1  { margin-top: 1mm; }
        .mb-4  { margin-bottom: 3mm; }
        .mb-3  { margin-bottom: 2mm; }
        .mb-2  { margin-bottom: 1.5mm; }
        .mb-1  { margin-bottom: 1mm; }
        .space-y-2 > * + * { margin-top: 1.5mm; }
        .space-y-1 > * + * { margin-top: 1mm; }
        .italic      { font-style: italic; }
        .capitalize  { text-transform: capitalize; }
        .max-w-xs    { max-width: 45mm; }
        .tracking-widest { letter-spacing: 2mm; }
        .font-mono   { font-family: monospace; }
        table        { width: 100%; border-collapse: collapse; }
        td, th       { padding: 0.5mm 1mm; font-size: 9px; }
        .py-1        { padding-top: 0.5mm; padding-bottom: 0.5mm; }
        .pb-2        { padding-bottom: 1.5mm; }
        .text-right  { text-align: right; }
        .bg-gray-100 { background: #f5f5f5; }
        .rounded-lg  { border-radius: 2mm; }
        .py-4        { padding-top: 3mm; padding-bottom: 3mm; }
        .px-6        { padding-left: 4mm; padding-right: 4mm; }
        .inline-block{ display: inline-block; }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.close(), 500);">
    ${ticket}
</body>
</html>`);
    ventana.document.close();
};