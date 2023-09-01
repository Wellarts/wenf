<?php

namespace App\Filament\Resources\ContasReceberResource\Pages;

use App\Filament\Resources\ContasReceberResource;
use App\Livewire\ContasReceberStats;
use App\Livewire\FluxoCaixaStats;
use App\Models\ContasReceber;
use App\Models\FluxoCaixa;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContasRecebers extends ManageRecords
{
    protected static string $resource = ContasReceberResource::class;

    protected static ?string $title = 'Contas a Receber';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Lançar Conta')
            ->after(function ($data, $record) {
              if($record->parcelas > 1)
                {
                    $valor_parcela = ($record->valor_total / $record->parcelas);
                    $vencimentos = Carbon::create($record->data_vencimento);
                    for($cont = 1; $cont < $data['parcelas']; $cont++)
                    {
                                        $dataVencimentos = $vencimentos->addDays(30);
                                        $parcelas = [
                                        'paciente_id' => $data['paciente_id'],
                                        'valor_total' => $data['valor_total'],
                                        'parcelas' => $data['parcelas'],
                                        'formaPgmto' => $data['formaPgmto'],
                                        'ordem_parcela' => $cont+1,
                                        'data_vencimento' => $dataVencimentos,
                                        'valor_recebido' => 0.00,
                                        'status' => 0,
                                        'obs' => $data['obs'],
                                        'valor_parcela' => $valor_parcela,
                                        ];
                            ContasReceber::create($parcelas);
                    }

                }
                else
                {
                   if($data['formaPgmto'] == 1 or $data['formaPgmto'] == 2)
                   {
                    $addFluxoCaixa = [
                        'valor' => ($record->valor_total),
                        'tipo'  => 'CREDITO',
                        'obs'   => 'Recebimento de Conta',
                    ];

                    FluxoCaixa::create($addFluxoCaixa);

                   }

                }


            }
        ),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContasReceberStats::class,
        ];
    }
}
