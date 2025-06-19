<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MonitorPLC extends Command
{
    protected $signature = 'monitor:plc';
    protected $description = 'Monitorea el PLC cada 1.5 segundos y hace inserciones si hay cambios';

    private $lastData = null;

    public function handle()
    {


        $this->info("Monitoreo iniciado...");

        while (true) {
            try {
                $response = Http::get('http://192.168.0.1/awp/Pruebas/tiempos.htm');


                $html = $response->body();
                file_put_contents(storage_path('app/plc_response.html'), $html);
                $data = $this->parseData($html);
                $this->info('Datos extraídos: ' . json_encode($data));

                // Guardar para debug
                file_put_contents(storage_path('app/plc_parsed_data.json'), json_encode($data));

                // Verificar que datos mínimos estén presentes
                if ($this->isValidData($data) && $this->hasChanged($data)) {
                    $this->lastData = $data;

                    $data['created_at'] = now()->toISOString();
                    $data['cicle_time'] = 3; // Ajusta si necesitas calcularlo dinámicamente

                    $res = Http::post('http://127.0.0.1:8000/api/insertions', $data);

                    $this->info("Insertado: " . json_encode($res->json()));
                } else {
                    $this->info("No hay cambios o datos inválidos");
                }
            } catch (\Exception $e) {
                $this->error("Error: " . $e->getMessage());
            }

            usleep(1500000); // 1.5 segundos
        }
    }

    private function parseData($html)
{
    $dom = new \DOMDocument();

    @$dom->loadHTML($html);

    // En lugar de buscar div#tiempos, buscamos todos los h1 directamente
    $h1s = $dom->getElementsByTagName('h1');

    $data = [];

    foreach ($h1s as $h1) {
        $text = trim($h1->textContent);
        if (preg_match('/(\w+)\s*:\s*([\d.]+)/', $text, $matches)) {
            $key = $matches[1];
            $value = $matches[2];
            $data[$key] = $value;
        }
    }

    return [
        'machine_number' => isset($data['NumberMachine']) ? (int)$data['NumberMachine'] : null,
        'recipe_number' => isset($data['NumberRecipe']) ? (int)$data['NumberRecipe'] : null,
        'profile_length' => isset($data['ProfileLenght']) ? (float)$data['ProfileLenght'] : null,
        'distance_between_holes' => isset($data['DistanceBtwnHoles']) ? (float)$data['DistanceBtwnHoles'] : null,
        'length_before_reset' => isset($data['LenghtBeforeReset']) ? (float)$data['LenghtBeforeReset'] : null,
        'good_piece' => (isset($data['HolesNOHoles']) && (int)$data['HolesNOHoles'] === 1),
    ];
}



    private function hasChanged($newData)
    {
        return json_encode($newData) !== json_encode($this->lastData);
    }

    private function isValidData($data)
{
    return
        !is_null($data['machine_number']) &&
        !is_null($data['recipe_number']) &&
        !is_null($data['profile_length']) &&
        !is_null($data['distance_between_holes']) &&
        !is_null($data['length_before_reset']);
}

}
