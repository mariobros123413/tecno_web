<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR REPORTES') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Reportes</h1>

        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-600">Estadísticas Generales</h2>
        <p class="text-center text-lg text-gray-700">
            Total de paquetes enviados: <span class="font-medium text-gray-900">{{ $totalPaquetesEnviados }}</span>
        </p>
        <p class="text-center text-lg text-gray-700">
            Monto total enviado: <span class="font-medium text-gray-900">{{ $montoTotalEnviado }}</span>
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 text-center">Paquetes por Mes</h3>
                <canvas id="paquetesPorMesChart" style="width:100%; height:auto;"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 text-center">Paquetes por Año</h3>
                <canvas id="paquetesPorAñoChart" style="width:100%; height:auto;"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 text-center">Paquetes por Almacén</h3>
                <canvas id="paquetesPorAlmacenChart" style="width:100%; height:auto;"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 text-center">Paquetes por Cliente</h3>
                <canvas id="paquetesPorClienteChart" style="width:100%; height:auto;"></canvas>
            </div>
        </div>
        <!-- Tablas ocultas para incluir en el PDF -->
        <div id="tablasParaPdf" style="display: none;">
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Detalles de Guías</h2>
                <table id="guiasTable" class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300">ID</th>
                            <th class="py-2 px-4 border-b border-gray-300">Código</th>
                            <th class="py-2 px-4 border-b border-gray-300">Usuario</th>
                            <th class="py-2 px-4 border-b border-gray-300">Paquete ID</th>
                            <th class="py-2 px-4 border-b border-gray-300">Servicio ID</th>
                            <th class="py-2 px-4 border-b border-gray-300">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guias as $guia)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->id }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->codigo }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->user->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->paquete_id }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->servicio_id }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $guia->precio }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Detalles de Almacenes</h2>
                <table id="almacenesTable" class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300">ID</th>
                            <th class="py-2 px-4 border-b border-gray-300">Nombre</th>
                            <th class="py-2 px-4 border-b border-gray-300">Dirección</th>
                            <th class="py-2 px-4 border-b border-gray-300">Taxes (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($almacenes as $almacen)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $almacen->id }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $almacen->nombre }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $almacen->direccion }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $almacen->tax }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button id="generarPdfBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Generar PDF
            </button>
            <button onclick="printLabel()"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                Imprimir Gráficos
            </button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartOptions = {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 16
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            };
            document.getElementById('generarPdfBtn').addEventListener('click', function () {
                generarPDF();
            });

            function generarPDF() {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const contenido = document.getElementById('tablasParaPdf');
                contenido.style.display = 'block';

                const opciones = {
                    margin: 10,
                    filename: 'reporte.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, logging: true, dpi: 192, letterRendering: true },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
                };
                html2pdf().from(contenido).set(opciones).save();

                setTimeout(() => {
                    contenido.style.display = 'none';
                }, 500);
            }

            // Paquetes por mes
            const paquetesPorMesCtx = document.getElementById('paquetesPorMesChart').getContext('2d');
            const paquetesPorMesData = {
                labels: {!! json_encode($paquetesPorMes->map(function ($mes) {
    return $mes->año . '-' . $mes->mes; })) !!},
                datasets: [{
                    label: 'Paquetes por Mes',
                    data: {!! json_encode($paquetesPorMes->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorMesCtx, {
                type: 'bar',
                data: paquetesPorMesData,
                options: chartOptions
            });

            // Paquetes por año
            const paquetesPorAñoCtx = document.getElementById('paquetesPorAñoChart').getContext('2d');
            const paquetesPorAñoData = {
                labels: {!! json_encode($paquetesPorAño->pluck('año')) !!},
                datasets: [{
                    label: 'Paquetes por Año',
                    data: {!! json_encode($paquetesPorAño->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorAñoCtx, {
                type: 'bar',
                data: paquetesPorAñoData,
                options: chartOptions
            });

            // Paquetes por almacén
            const paquetesPorAlmacenCtx = document.getElementById('paquetesPorAlmacenChart').getContext('2d');
            const paquetesPorAlmacenData = {
                labels: {!! json_encode($paquetesPorAlmacen->pluck('nombre')) !!},
                datasets: [{
                    label: 'Paquetes por Almacén',
                    data: {!! json_encode($paquetesPorAlmacen->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorAlmacenCtx, {
                type: 'bar',
                data: paquetesPorAlmacenData,
                options: chartOptions
            });

            // Paquetes por cliente
            const paquetesPorClienteCtx = document.getElementById('paquetesPorClienteChart').getContext('2d');
            const paquetesPorClienteData = {
                labels: {!! json_encode($paquetesPorCliente->pluck('name')) !!},
                datasets: [{
                    label: 'Paquetes por Cliente',
                    data: {!! json_encode($paquetesPorCliente->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorClienteCtx, {
                type: 'bar',
                data: paquetesPorClienteData,
                options: chartOptions
            });
        });

        function printLabel() {
            window.print();
        }
    </script>

    <footer class="text-center mt-4">
        <p class="text-gray-600 dark:text-gray-300">Número de visitas: {{ $visitas }}</p>
    </footer>
</x-app-layout>