<?php

namespace App\Http\Controllers;

use App\Exports\DatosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TuImportador;
use Carbon\Carbon;


class GenerarCalculosExcel extends Controller
{
    public function index()
    {
        return view("generarcalculo");
    }
    public function import(Request $request)
    {
        // Importar el archivo Excel y procesarlo
        $datos = Excel::toCollection(new TuImportador, $request->file('archivo'));

        // Inicializar un array para almacenar los datos sumados por fecha
        $sumadosPorFecha = [];

        // Iterar sobre los datos
        foreach ($datos as $fila) {
            foreach ($fila as $row) {
                // Verificar si la fila contiene la clave 'date'
                if (isset($row['date'])) {
                    // Obtener la fecha y el precio de la fila
                    $fecha = Carbon::createFromTimestamp(($row['date'] - 25569) * 86400)->format("d/m/Y");

                    $precio = $row['origin_supplier_price'];

                    // Verificar si la fecha ya está en el array de sumados
                    if (array_key_exists($fecha, $sumadosPorFecha)) {
                        // Sumar el precio al valor existente para esa fecha
                        $sumadosPorFecha[$fecha] += $precio;
                    } else {
                        // Si la fecha no existe en el array, crear una nueva entrada
                        $sumadosPorFecha[$fecha] = $precio;
                    }
                }
            }
        }

        // Ordenar el array por fecha de menor a mayor
        ksort($sumadosPorFecha);
        $nombreArchivo = 'datos_excel.xlsx';

        $datosFormated = [];

        foreach ($sumadosPorFecha as $key => $value) {
            $datosFormated[] = [
                "fecha" => $key,
                "cantidad" => $value,
                "total" => $value . "€",
            ];
        }

        // Generar el archivo Excel utilizando el exportador
        return Excel::download(new DatosExport($datosFormated), $nombreArchivo);
    }
}
