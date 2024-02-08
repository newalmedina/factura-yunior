<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class TuImportador implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Verifica si la columna 'date' está presente en la fila actual
            if (isset($row['date'])) {
                // Almacena los datos en un array asociativo
                $data[] = [
                    'id' => $row['id'],
                    'date' => $row['date'],
                    'supplier' => $row['Supplier'] ?? null,
                    'type' => $row['Type'] ?? null,
                    'type_t' => $row['Type T'] ?? null,
                    'retailer' => $row['Retailer'] ?? null,
                    'vehicle_type' => $row['Vehicle Type'] ?? null,
                    'origin' => $row['Origin'] ?? null,
                    'supplier_price' => $row['Origin Supplier Price'] ?? null,
                ];
            }
        }

        return collect($data);
    }
}
