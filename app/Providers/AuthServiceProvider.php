<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\AgendarAtendimento;
use App\Models\Amamentacao;
use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\DiagnosticoIntervencao;
use App\Models\FluxoCaixa;
use App\Models\OrientacaoPaciente;
use App\Models\Paciente;
use App\Models\Perinatal;
use App\Models\PlanejamentoGinecologico;
use App\Models\PlanejamentoImplementacao;
use App\Models\PlanejamentoReprodutivo;
use App\Models\Receituario;
use App\Models\User;
use App\Policies\AgendamentoPolicy;
use App\Policies\AmamentacaoPolicy;
use App\Policies\ContaPagarPolicy;
use App\Policies\DiagnosticoIntervencaoPolicy;
use App\Policies\FluxoCaixaPolicy;
use App\Policies\OrientacaoPacientePolicy;
use App\Policies\PacientePolicy;
use App\Policies\PerinatalPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PlanejamentoGinecologicoPolicy;
use App\Policies\PlanejamentoImplementacaoPolicy;
use App\Policies\PlanejamentoReprodutivoPolicy;
use App\Policies\ReceituarioPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        AgendarAtendimento::class => AgendamentoPolicy::class,
        Amamentacao::class => AmamentacaoPolicy::class,
        ContasPagar::class => ContaPagarPolicy::class,
        ContasReceber::class => ContaPagarPolicy::class,
        DiagnosticoIntervencao::class => DiagnosticoIntervencaoPolicy::class,
        FluxoCaixa::class => FluxoCaixaPolicy::class,
        OrientacaoPaciente::class => OrientacaoPacientePolicy::class,
        Paciente::class => PacientePolicy::class,
        Perinatal::class => PerinatalPolicy::class,
        PlanejamentoGinecologico::class => PlanejamentoGinecologicoPolicy::class,
        PlanejamentoImplementacao::class => PlanejamentoImplementacaoPolicy::class,
        PlanejamentoReprodutivo::class => PlanejamentoReprodutivoPolicy::class,
        Receituario::class => ReceituarioPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
