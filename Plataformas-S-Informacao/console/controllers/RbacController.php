<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Limpa permissões e papéis anteriores
        $auth->removeAll();

        // ==========================================
        // 1. CRIAÇÃO DAS PERMISSÕES
        // ==========================================

        // Catálogo & Obras
        $verCatalogo = $auth->createPermission('verCatalogo');
        $verCatalogo->description = 'Consultar catálogo de museus e monumentos';
        $auth->add($verCatalogo);

        $pesquisarCatalogo = $auth->createPermission('pesquisarCatalogo');
        $pesquisarCatalogo->description = 'Pesquisar museus por nome ou filtros';
        $auth->add($pesquisarCatalogo);

        $verObras = $auth->createPermission('verObras');
        $verObras->description = 'Visualizar obras em destaque e os seus detalhes';
        $auth->add($verObras);

        // Bilhética
        $comprarBilhetes = $auth->createPermission('comprarBilhetes');
        $comprarBilhetes->description = 'Comprar e reservar bilhetes online';
        $auth->add($comprarBilhetes);

        $verBilhetes = $auth->createPermission('verBilhetes');
        $verBilhetes->description = 'Consultar histórico de bilhetes comprados';
        $auth->add($verBilhetes);

        // Loja de Lembranças
        $verLembrancas = $auth->createPermission('verLembrancas');
        $verLembrancas->description = 'Consultar produtos da loja de lembranças';
        $auth->add($verLembrancas);

        $encomendarLembrancas = $auth->createPermission('encomendarLembrancas');
        $encomendarLembrancas->description = 'Efetuar encomenda de lembranças';
        $auth->add($encomendarLembrancas);

        // Fidelização & App Móvel
        $verRecompensas = $auth->createPermission('verRecompensas');
        $verRecompensas->description = 'Consultar pontos, descontos e recompensas';
        $auth->add($verRecompensas);

        $digitalizarObras = $auth->createPermission('digitalizarObras');
        $digitalizarObras->description = 'Reconhecer obras ou monumentos com a câmara';
        $auth->add($digitalizarObras);

        $verMapa = $auth->createPermission('verMapa');
        $verMapa->description = 'Aceder ao mapa interativo na app móvel';
        $auth->add($verMapa);

        // Operação do Colaborador
        $verTurnosProprios = $auth->createPermission('verTurnosProprios');
        $verTurnosProprios->description = 'Consultar a sua escala de trabalho e horários';
        $auth->add($verTurnosProprios);

        $criarVerificacaoDiaria = $auth->createPermission('criarVerificacaoDiaria');
        $criarVerificacaoDiaria->description = 'Submeter checklist de verificação de fim de turno';
        $auth->add($criarVerificacaoDiaria);

        // Gestão do Museu (Gestor)
        $gerirTurnos = $auth->createPermission('gerirTurnos');
        $gerirTurnos->description = 'Criar e atribuir turnos aos colaboradores';
        $auth->add($gerirTurnos);

        $gerirLotacao = $auth->createPermission('gerirLotacao');
        $gerirLotacao->description = 'Configurar lotação e vagas de bilhetes por hora';
        $auth->add($gerirLotacao);

        $gerirPrecosBilhetes = $auth->createPermission('gerirPrecosBilhetes');
        $gerirPrecosBilhetes->description = 'Definir tipos de bilhetes e preços';
        $auth->add($gerirPrecosBilhetes);

        $gerirLembrancas = $auth->createPermission('gerirLembrancas');
        $gerirLembrancas->description = 'Gerir produtos e stock da loja de lembranças';
        $auth->add($gerirLembrancas);

        $verVerificacoesDiarias = $auth->createPermission('verVerificacoesDiarias');
        $verVerificacoesDiarias->description = 'Acompanhar verificações diárias dos colaboradores';
        $auth->add($verVerificacoesDiarias);

        // Administração Geral (Sys Admin)
        $gerirMuseus = $auth->createPermission('gerirMuseus');
        $gerirMuseus->description = 'Criar, editar e gerir museus e monumentos no catálogo';
        $auth->add($gerirMuseus);

        $gerirGestores = $auth->createPermission('gerirGestores');
        $gerirGestores->description = 'Criar e gerir contas de gestores de museu';
        $auth->add($gerirGestores);


        // ==========================================
        // 2. CRIAÇÃO DOS ROLES E ASSOCIAÇÃO
        // ==========================================

        // Visitante (Não autenticado / Público)
        $visitante = $auth->createRole('visitante');
        $auth->add($visitante);
        $auth->addChild($visitante, $verCatalogo);
        $auth->addChild($visitante, $pesquisarCatalogo);
        $auth->addChild($visitante, $verObras);
        $auth->addChild($visitante, $verLembrancas);
        $auth->addChild($visitante, $encomendarLembrancas);

        // Visitante Registado (Web & App)
        $visitanteRegistado = $auth->createRole('visitante_registado');
        $auth->add($visitanteRegistado);
        $auth->addChild($visitanteRegistado, $visitante); // Herda permissões de visitante
        $auth->addChild($visitanteRegistado, $comprarBilhetes);
        $auth->addChild($visitanteRegistado, $verBilhetes);
        $auth->addChild($visitanteRegistado, $verRecompensas);
        $auth->addChild($visitanteRegistado, $digitalizarObras);
        $auth->addChild($visitanteRegistado, $verMapa);

        // Colaborador (Back-Office)
        $colaborador = $auth->createRole('colaborador');
        $auth->add($colaborador);
        $auth->addChild($colaborador, $verCatalogo);
        $auth->addChild($colaborador, $pesquisarCatalogo);
        $auth->addChild($colaborador, $verObras);
        $auth->addChild($colaborador, $verLembrancas);
        $auth->addChild($colaborador, $verTurnosProprios);
        $auth->addChild($colaborador, $criarVerificacaoDiaria);

        // Gestor de Museu (Back-Office)
        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);
        $auth->addChild($gestor, $colaborador); // Herda acesso de colaborador
        $auth->addChild($gestor, $gerirTurnos);
        $auth->addChild($gestor, $gerirLotacao);
        $auth->addChild($gestor, $gerirPrecosBilhetes);
        $auth->addChild($gestor, $gerirLembrancas);
        $auth->addChild($gestor, $verVerificacoesDiarias);

        // Administrador da Plataforma (Sys Admin)
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $verCatalogo);
        $auth->addChild($admin, $pesquisarCatalogo);
        $auth->addChild($admin, $verObras);
        $auth->addChild($admin, $verLembrancas);
        $auth->addChild($admin, $gerirMuseus);
        $auth->addChild($admin, $gerirGestores);

        $this->stdout("RBAC inicializado com sucesso!\n");

        return ExitCode::OK;
    }
}