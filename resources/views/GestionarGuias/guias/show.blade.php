<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <title>Obologistic Shipping </title>

    <style>
        @media print {
            .no-print {
                display: none;
            }
            .print-border {
            border: 2px solid black;
        }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-4 rounded-lg shadow-lg max-w-sm mx-auto print-border">
        <button onclick="printLabel()" class="no-print bg-blue-500 text-white px-4 py-2 rounded mb-4">Print</button>

        <div id="label" class="text-sm">
            <div class="mb-2">
                <span class="font-bold">ORIGIN ID MMCA</span>
                <span class="ml-2">{{ $guia->codigo }}</span>
            </div>
            <div>
                <div class="font-bold">{{ $guia->user->name }}</div>
                <div>{{ $guia->almacenSalida->direccion }}</div>
                <div class="font-bold">{{ $guia->almacenSalida->nombre }}</div>
            </div>
        </div>
        <div class="border-t border-gray-300 my-2"></div>
        <div class="text-sm">
            <div class="font-bold">TO</div>
            <div class="mt-1">
            <div class="font-bold">{{ $guia->almacenLlegada->nombre }}</div>
                <div>{{ $guia->almacenLlegada->direccion }}</div>
                <div>{{ $guia->fecha_entrega }}</div>
                <div>{{ $guia->user->direccion }}</div>

            </div>
        </div>
        <div class="border-t border-gray-300 my-2"></div>
        <div class="text-sm mb-2">
            <div>SHIP DATE: {{ $guia->fecha_recepcion }}</div>
            <div class="flex justify-between">
                <div>ACT WT: {{ $guia->peso_total }} KG</div>
            </div>
            <div class="flex justify-between">
                <div>{{ $guia->paquete->dimensiones }} CM</div>
                <div>BILL SENDER</div>
            </div>
        </div>
        <div class="border-t border-gray-300 my-2"></div>
        <div class="text-center text-lg font-bold mb-2">OBOLOGISTIC</div>
        <div class="flex justify-between items-center text-sm mb-2">
            <div class="font-bold">E</div>
            <div class="flex items-center">
                <span class="mr-2">AA</span>
                <span class="font-bold">{{ $guia->servicio->nombre }}</span>
            </div>
        </div>
        <div class="text-sm mb-2">
            <div>RES</div>
            <div>{{ $guia->user->cedula }}</div>
        </div>
        <div class="border-t border-gray-300 my-2"></div>
        <div class="text-center text-xl font-bold">8A MMCA</div>
        <div class="text-sm text-center">{{ $guia->codigo }}</div>
        <div class="border-t border-gray-300 my-2"></div>
        <div class="flex justify-center">
        <img src="https://quickchart.io/qr?text={{ $guia->id }}&dark=000000&light=ffffff&ecLevel=Q&format=svg" alt="QR Code" class="mb-2">
        </div>
        <div class="flex justify-center">
        <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $guia->codigo }}&code=Code128&translate-esc=true" alt="Barcode">
        </div>
    </div>

    <script>
        function printLabel() {
            window.print();
        }
    </script>
</body>
</html>
