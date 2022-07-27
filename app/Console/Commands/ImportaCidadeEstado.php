<?php

namespace App\Console\Commands;

use App\Models\Cidade;
use App\Models\Estado;
use App\Services\RegistroIbgeService;
use Illuminate\Console\Command;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class ImportaCidadeEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suporte:importa-cidade-estado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa todos os estados e cidades da API do IBGE';

    protected $ibgeService;

    public function __construct(RegistroIbgeService $ibgeRestIntegrationService)
    {
        $this->ibgeService = $ibgeRestIntegrationService;
        parent::__construct();
    }

    public function handle()
    {
        try {
            $this->importStates();
            $this->importCities();
        } catch (ServiceUnavailableHttpException | \Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    private function importStates()
    {
        $states = $this->ibgeService->getStates();
        $this->output->progressStart(count($states));
        $totalCreated = $totalUpdated = 0;
       
        foreach ($states as $value) {
            $this->output->progressAdvance();

            $stateData = [
                'id_ibge' => $value['id'],
                'cad_nome' => $value['nome'],
                'cad_sigla' => $value['sigla'],
            ];

            if (isset($value['regiao']) && !empty($value['regiao'])) {
                $stateData['id_ibge_regiao'] = $value['regiao']['id'];
                $stateData['cad_regiao_sigla'] = $value['regiao']['sigla'];
                $stateData['cad_regiao'] = $value['regiao']['nome'];
            }

            if (!$state = Estado::where('id_ibge', $value['id'])->first()) {
                Estado::create($stateData);
                $totalCreated++;
                continue;
            }

            $state->update($stateData);
            $totalUpdated++;
        }
        $this->output->progressFinish();
        $this->generateTableLog('Estados', $totalCreated, $totalUpdated);
    }

    private function importCities()
    {
        $tableBody = [];
        $states = Estado::all();
        foreach ($states as $state) {
            $this->info("Importando as cidades do estado: {$state->cad_nome}");
            $this->newLine();

            $totalCreated = $totalUpdated = 0;
            $cities = $this->ibgeService->getCitiesByState($state->id_ibge);
            $this->output->progressStart(count($cities));
           
            foreach ($cities as $value) {
                $this->output->progressAdvance();

                $dataCity = [
                    'id_ibge' => $value['id'],
                    'cad_nome' => $value['nome'],
                    'id_estado' => $state->id_estado,
                ];
                
                if (!$city = Cidade::where('id_ibge', $value['id'])->first()) {
                    Cidade::create($dataCity);
                    $totalCreated++;
                    continue;
                }
                
                $city->update($dataCity);
                $totalUpdated++;
            }

            $this->output->progressFinish();

            $tableBody[] = [
                'state' => $state->cad_nome,
                'created' => $totalCreated,
                'updated' => $totalUpdated,
            ];

            $this->info("Todas as cidades do estado {$state->cad_nome} foram importadas com sucesso");
            $this->newLine();
        }

        $tableHeader = ['Estado', 'Total de Cidades Cadastradas', 'Total de Cidades Atualizadas'];
        $this->table($tableHeader, $tableBody);
    }

    private function generateTableLog(string $table, int $totalCreated, int $totalUpdated)
    {
        $header = ['Tabela', 'Total de Cadastros', 'Total de Atualizações'];
        $body = [['name' => $table, 'created' => $totalCreated, 'updated' => $totalUpdated]];
        $this->table($header, $body);
    }
}

