<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR REPORTES') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Reportes</h1>

        <h2 class="text-xl font-semibold mb-2 text-center">Estadísticas Generales</h2>
        <p class="text-center">Total de paquetes enviados: <span class="font-medium">{{ $totalPaquetesEnviados }}</span></p>
        <p class="text-center">Monto total enviado: <span class="font-medium">{{ $montoTotalEnviado }}</span></p>
        <p class="text-center">Tiempo promedio de envío: <span class="font-medium">{{ $tiempoPromedioEnvio }} segundos</span></p>

        <div class="flex justify-center">
            <canvas id="paquetesPorDiaChart" style="width:100%; max-width:750px; height:auto;"></canvas>
        </div>
        <div class="flex justify-center mt-4">
            <canvas id="paquetesPorMesChart" style="width:100%; max-width:750px; height:auto;"></canvas>
        </div>
        <div class="flex justify-center mt-4">
            <canvas id="paquetesPorAñoChart" style="width:100%; max-width:750px; height:auto;"></canvas>
        </div>
        <div class="flex justify-center mt-4">
            <canvas id="paquetesPorAlmacenChart" style="width:100%; max-width:750px; height:auto;"></canvas>
        </div>
        <div class="flex justify-center mt-4">
            <canvas id="paquetesPorClienteChart" style="width:100%; max-width:750px; height:auto;"></canvas>
        </div>

        <div class="flex justify-end mt-4">
            <button id="generarPdfBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Generar PDF
            </button>
            <button onclick="printLabel()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                Imprimir
            </button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('generarPdfBtn').addEventListener('click', function () {
                generarPDF();
            });

            function generarPDF() {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const contenido = document.querySelector('body');
                const opciones = {
                    filename: 'reporte.pdf',
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().from(contenido).set(opciones).save();
            }

            // Paquetes por día
            const paquetesPorDiaCtx = document.getElementById('paquetesPorDiaChart').getContext('2d');
            const paquetesPorDiaData = {
                labels: {!! json_encode($paquetesPorDia->pluck('fecha')) !!},
                datasets: [{
                    label: 'Paquetes por Día',
                    data: {!! json_encode($paquetesPorDia->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorDiaCtx, {
                type: 'bar',
                data: paquetesPorDiaData,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

            // Paquetes por mes
            const paquetesPorMesCtx = document.getElementById('paquetesPorMesChart').getContext('2d');
            const paquetesPorMesData = {
                labels: {!! json_encode($paquetesPorMes->map(function($mes) { return $mes->año . '-' . $mes->mes; })) !!},
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
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
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
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

            // Paquetes por almacén
            const paquetesPorAlmacenCtx = document.getElementById('paquetesPorAlmacenChart').getContext('2d');
            const paquetesPorAlmacenData = {
                labels: {!! json_encode($paquetesPorAlmacen->keys()) !!},
                datasets: [{
                    label: 'Paquetes por Almacén',
                    data: {!! json_encode($paquetesPorAlmacen->values()) !!},
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorAlmacenCtx, {
                type: 'bar',
                data: paquetesPorAlmacenData,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

            // Paquetes por cliente
            const paquetesPorClienteCtx = document.getElementById('paquetesPorClienteChart').getContext('2d');
            const paquetesPorClienteData = {
                labels: {!! json_encode($paquetesPorCliente->pluck('user_id')) !!},
                datasets: [{
                    label: 'Paquetes por Cliente',
                    data: {!! json_encode($paquetesPorCliente->pluck('cantidad')) !!},
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(paquetesPorClienteCtx, {
                type: 'bar',
                data: paquetesPorClienteData,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        });

        function printLabel() {
            window.print();
        }
    </script>
</x-app-layout>
