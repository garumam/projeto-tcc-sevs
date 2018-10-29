<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissões de usuário

        if (!Permission::where('nome', '=', 'usuario_listar')->count()) {
            Permission::create([
                'nome' => 'usuario_listar',
                'descricao' => 'Listar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_listar')->first();
            $permission->update([
                'nome' => 'usuario_listar',
                'descricao' => 'Listar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_adicionar')->count()) {
            Permission::create([
                'nome' => 'usuario_adicionar',
                'descricao' => 'Adicionar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_adicionar')->first();
            $permission->update([
                'nome' => 'usuario_adicionar',
                'descricao' => 'Adicionar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_atualizar')->count()) {
            Permission::create([
                'nome' => 'usuario_atualizar',
                'descricao' => 'Atualizar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_atualizar')->first();
            $permission->update([
                'nome' => 'usuario_atualizar',
                'descricao' => 'Atualizar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_deletar')->count()) {
            Permission::create([
                'nome' => 'usuario_deletar',
                'descricao' => 'Remover Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_deletar')->first();
            $permission->update([
                'nome' => 'usuario_deletar',
                'descricao' => 'Remover Usuarios'
            ]);
        }

        //Permissões de cliente

        if (!Permission::where('nome', '=', 'cliente_listar')->count()) {
            Permission::create([
                'nome' => 'cliente_listar',
                'descricao' => 'Listar Clientes'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'cliente_listar')->first();
            $permission->update([
                'nome' => 'cliente_listar',
                'descricao' => 'Listar Clientes'
            ]);
        }

        if (!Permission::where('nome', '=', 'cliente_adicionar')->count()) {
            Permission::create([
                'nome' => 'cliente_adicionar',
                'descricao' => 'Adicionar Clientes'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'cliente_adicionar')->first();
            $permission->update([
                'nome' => 'cliente_adicionar',
                'descricao' => 'Adicionar Clientes'
            ]);
        }

        if (!Permission::where('nome', '=', 'cliente_atualizar')->count()) {
            Permission::create([
                'nome' => 'cliente_atualizar',
                'descricao' => 'Atualizar Clientes'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'cliente_atualizar')->first();
            $permission->update([
                'nome' => 'cliente_atualizar',
                'descricao' => 'Atualizar Clientes'
            ]);
        }

        if (!Permission::where('nome', '=', 'cliente_deletar')->count()) {
            Permission::create([
                'nome' => 'cliente_deletar',
                'descricao' => 'Remover Clientes'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'cliente_deletar')->first();
            $permission->update([
                'nome' => 'cliente_deletar',
                'descricao' => 'Remover Clientes'
            ]);
        }

        //Permissões de orçamento

        if (!Permission::where('nome', '=', 'orcamento_listar')->count()) {
            Permission::create([
                'nome' => 'orcamento_listar',
                'descricao' => 'Listar Orçamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'orcamento_listar')->first();
            $permission->update([
                'nome' => 'orcamento_listar',
                'descricao' => 'Listar Orçamentos'
            ]);
        }

        if (!Permission::where('nome', '=', 'orcamento_adicionar')->count()) {
            Permission::create([
                'nome' => 'orcamento_adicionar',
                'descricao' => 'Adicionar Orçamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'orcamento_adicionar')->first();
            $permission->update([
                'nome' => 'orcamento_adicionar',
                'descricao' => 'Adicionar Orçamentos'
            ]);
        }

        if (!Permission::where('nome', '=', 'orcamento_atualizar')->count()) {
            Permission::create([
                'nome' => 'orcamento_atualizar',
                'descricao' => 'Atualizar Orçamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'orcamento_atualizar')->first();
            $permission->update([
                'nome' => 'orcamento_atualizar',
                'descricao' => 'Atualizar Orçamentos'
            ]);
        }

        if (!Permission::where('nome', '=', 'orcamento_deletar')->count()) {
            Permission::create([
                'nome' => 'orcamento_deletar',
                'descricao' => 'Remover Orçamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'orcamento_deletar')->first();
            $permission->update([
                'nome' => 'orcamento_deletar',
                'descricao' => 'Remover Orçamentos'
            ]);
        }

        //Permissões de venda

        if (!Permission::where('nome', '=', 'venda_listar')->count()) {
            Permission::create([
                'nome' => 'venda_listar',
                'descricao' => 'Listar Vendas'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'venda_listar')->first();
            $permission->update([
                'nome' => 'venda_listar',
                'descricao' => 'Listar Vendas'
            ]);
        }

        if (!Permission::where('nome', '=', 'venda_adicionar')->count()) {
            Permission::create([
                'nome' => 'venda_adicionar',
                'descricao' => 'Adicionar Vendas'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'venda_adicionar')->first();
            $permission->update([
                'nome' => 'venda_adicionar',
                'descricao' => 'Adicionar Vendas'
            ]);
        }

        /*if (!Permission::where('nome', '=', 'venda_atualizar')->count()) {
            Permission::create([
                'nome' => 'venda_atualizar',
                'descricao' => 'Atualizar Vendas'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'venda_atualizar')->first();
            $permission->update([
                'nome' => 'venda_atualizar',
                'descricao' => 'Atualizar Vendas'
            ]);
        }

        if (!Permission::where('nome', '=', 'venda_deletar')->count()) {
            Permission::create([
                'nome' => 'venda_deletar',
                'descricao' => 'Remover Vendas'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'venda_deletar')->first();
            $permission->update([
                'nome' => 'venda_deletar',
                'descricao' => 'Remover Vendas'
            ]);
        }*/

        //Permissões de pagamento

        if (!Permission::where('nome', '=', 'pagamento_atualizar')->count()) {
            Permission::create([
                'nome' => 'pagamento_atualizar',
                'descricao' => 'Atualizar Pagamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'pagamento_atualizar')->first();
            $permission->update([
                'nome' => 'pagamento_atualizar',
                'descricao' => 'Atualizar Pagamentos'
            ]);
        }

        //Permissões de ordem de serviço

        if (!Permission::where('nome', '=', 'os_listar')->count()) {
            Permission::create([
                'nome' => 'os_listar',
                'descricao' => 'Listar Ordens de serviço'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'os_listar')->first();
            $permission->update([
                'nome' => 'os_listar',
                'descricao' => 'Listar Ordens de serviço'
            ]);
        }

        if (!Permission::where('nome', '=', 'os_adicionar')->count()) {
            Permission::create([
                'nome' => 'os_adicionar',
                'descricao' => 'Adicionar Ordens de serviço'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'os_adicionar')->first();
            $permission->update([
                'nome' => 'os_adicionar',
                'descricao' => 'Adicionar Ordens de serviço'
            ]);
        }

        if (!Permission::where('nome', '=', 'os_atualizar')->count()) {
            Permission::create([
                'nome' => 'os_atualizar',
                'descricao' => 'Atualizar Ordens de serviço'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'os_atualizar')->first();
            $permission->update([
                'nome' => 'os_atualizar',
                'descricao' => 'Atualizar Ordens de serviço'
            ]);
        }

        if (!Permission::where('nome', '=', 'os_deletar')->count()) {
            Permission::create([
                'nome' => 'os_deletar',
                'descricao' => 'Remover Ordens de serviço'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'os_deletar')->first();
            $permission->update([
                'nome' => 'os_deletar',
                'descricao' => 'Remover Ordens de serviço'
            ]);
        }

        //Permissões de modelos

        if (!Permission::where('nome', '=', 'modelo_listar')->count()) {
            Permission::create([
                'nome' => 'modelo_listar',
                'descricao' => 'Listar Modelos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'modelo_listar')->first();
            $permission->update([
                'nome' => 'modelo_listar',
                'descricao' => 'Listar Modelos'
            ]);
        }

        if (!Permission::where('nome', '=', 'modelo_adicionar')->count()) {
            Permission::create([
                'nome' => 'modelo_adicionar',
                'descricao' => 'Adicionar Modelos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'modelo_adicionar')->first();
            $permission->update([
                'nome' => 'modelo_adicionar',
                'descricao' => 'Adicionar Modelos'
            ]);
        }

        if (!Permission::where('nome', '=', 'modelo_atualizar')->count()) {
            Permission::create([
                'nome' => 'modelo_atualizar',
                'descricao' => 'Atualizar Modelos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'modelo_atualizar')->first();
            $permission->update([
                'nome' => 'modelo_atualizar',
                'descricao' => 'Atualizar Modelos'
            ]);
        }

        if (!Permission::where('nome', '=', 'modelo_deletar')->count()) {
            Permission::create([
                'nome' => 'modelo_deletar',
                'descricao' => 'Remover Modelos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'modelo_deletar')->first();
            $permission->update([
                'nome' => 'modelo_deletar',
                'descricao' => 'Remover Modelos'
            ]);
        }

        //Permissões de estoque

        if (!Permission::where('nome', '=', 'estoque_listar')->count()) {
            Permission::create([
                'nome' => 'estoque_listar',
                'descricao' => 'Listar Estoque'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'estoque_listar')->first();
            $permission->update([
                'nome' => 'estoque_listar',
                'descricao' => 'Listar Estoque'
            ]);
        }

        if (!Permission::where('nome', '=', 'estoque_atualizar')->count()) {
            Permission::create([
                'nome' => 'estoque_atualizar',
                'descricao' => 'Atualizar Estoque'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'estoque_atualizar')->first();
            $permission->update([
                'nome' => 'estoque_atualizar',
                'descricao' => 'Atualizar Estoque'
            ]);
        }

        //Permissões do financeiro

        if (!Permission::where('nome', '=', 'financeiro_listar')->count()) {
            Permission::create([
                'nome' => 'financeiro_listar',
                'descricao' => 'Listar Financeiro'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'financeiro_listar')->first();
            $permission->update([
                'nome' => 'financeiro_listar',
                'descricao' => 'Listar Financeiro'
            ]);
        }

        if (!Permission::where('nome', '=', 'financeiro_adicionar')->count()) {
            Permission::create([
                'nome' => 'financeiro_adicionar',
                'descricao' => 'Adicionar Financeiro'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'financeiro_adicionar')->first();
            $permission->update([
                'nome' => 'financeiro_adicionar',
                'descricao' => 'Adicionar Financeiro'
            ]);
        }

        if (!Permission::where('nome', '=', 'financeiro_deletar')->count()) {
            Permission::create([
                'nome' => 'financeiro_deletar',
                'descricao' => 'Remover Financeiro'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'financeiro_deletar')->first();
            $permission->update([
                'nome' => 'financeiro_deletar',
                'descricao' => 'Remover Financeiro'
            ]);
        }

        //Permissões de funções

        if (!Permission::where('nome', '=', 'funcao_listar')->count()) {
            Permission::create([
                'nome' => 'funcao_listar',
                'descricao' => 'Listar Funções'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'funcao_listar')->first();
            $permission->update([
                'nome' => 'funcao_listar',
                'descricao' => 'Listar Funções'
            ]);
        }

        if (!Permission::where('nome', '=', 'funcao_adicionar')->count()) {
            Permission::create([
                'nome' => 'funcao_adicionar',
                'descricao' => 'Adicionar Funções'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'funcao_adicionar')->first();
            $permission->update([
                'nome' => 'funcao_adicionar',
                'descricao' => 'Adicionar Funções'
            ]);
        }

        if (!Permission::where('nome', '=', 'funcao_atualizar')->count()) {
            Permission::create([
                'nome' => 'funcao_atualizar',
                'descricao' => 'Atualizar Funções'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'funcao_atualizar')->first();
            $permission->update([
                'nome' => 'funcao_atualizar',
                'descricao' => 'Atualizar Funções'
            ]);
        }

        if (!Permission::where('nome', '=', 'funcao_deletar')->count()) {
            Permission::create([
                'nome' => 'funcao_deletar',
                'descricao' => 'Remover Funções'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'funcao_deletar')->first();
            $permission->update([
                'nome' => 'funcao_deletar',
                'descricao' => 'Remover Funções'
            ]);
        }

        //Permissões de fornecedor

        if (!Permission::where('nome', '=', 'fornecedor_listar')->count()) {
            Permission::create([
                'nome' => 'fornecedor_listar',
                'descricao' => 'Listar Fornecedores'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'fornecedor_listar')->first();
            $permission->update([
                'nome' => 'fornecedor_listar',
                'descricao' => 'Listar Fornecedores'
            ]);
        }

        if (!Permission::where('nome', '=', 'fornecedor_adicionar')->count()) {
            Permission::create([
                'nome' => 'fornecedor_adicionar',
                'descricao' => 'Adicionar Fornecedores'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'fornecedor_adicionar')->first();
            $permission->update([
                'nome' => 'fornecedor_adicionar',
                'descricao' => 'Adicionar Fornecedores'
            ]);
        }

        if (!Permission::where('nome', '=', 'fornecedor_atualizar')->count()) {
            Permission::create([
                'nome' => 'fornecedor_atualizar',
                'descricao' => 'Atualizar Fornecedores'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'fornecedor_atualizar')->first();
            $permission->update([
                'nome' => 'fornecedor_atualizar',
                'descricao' => 'Atualizar Fornecedores'
            ]);
        }

        if (!Permission::where('nome', '=', 'fornecedor_deletar')->count()) {
            Permission::create([
                'nome' => 'fornecedor_deletar',
                'descricao' => 'Remover Fornecedores'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'fornecedor_deletar')->first();
            $permission->update([
                'nome' => 'fornecedor_deletar',
                'descricao' => 'Remover Fornecedores'
            ]);
        }

        //Permissões dos dados da empresa

        if (!Permission::where('nome', '=', 'empresa_atualizar')->count()) {
            Permission::create([
                'nome' => 'empresa_atualizar',
                'descricao' => 'Atualizar Dados da Empresa'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'empresa_atualizar')->first();
            $permission->update([
                'nome' => 'empresa_atualizar',
                'descricao' => 'Atualizar Dados da Empresa'
            ]);
        }

        if (!Permission::where('nome', '=', 'empresa_deletar')->count()) {
            Permission::create([
                'nome' => 'empresa_deletar',
                'descricao' => 'Deletar Dados da Empresa'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'empresa_deletar')->first();
            $permission->update([
                'nome' => 'empresa_deletar',
                'descricao' => 'Deletar Dados da Empresa'
            ]);
        }

        //Permissões dos relatórios

        if (!Permission::where('nome', '=', 'orcamento_relatorio')->count()) {
            Permission::create([
                'nome' => 'orcamento_relatorio',
                'descricao' => 'Relatório de Orçamentos'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'orcamento_relatorio')->first();
            $permission->update([
                'nome' => 'orcamento_relatorio',
                'descricao' => 'Relatório de Orçamentos'
            ]);
        }

        if (!Permission::where('nome', '=', 'os_relatorio')->count()) {
            Permission::create([
                'nome' => 'os_relatorio',
                'descricao' => 'Relatório de Ordens de serviço'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'os_relatorio')->first();
            $permission->update([
                'nome' => 'os_relatorio',
                'descricao' => 'Relatório de Ordens de serviço'
            ]);
        }

        if (!Permission::where('nome', '=', 'estoque_relatorio')->count()) {
            Permission::create([
                'nome' => 'estoque_relatorio',
                'descricao' => 'Relatório de Estoque'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'estoque_relatorio')->first();
            $permission->update([
                'nome' => 'estoque_relatorio',
                'descricao' => 'Relatório de Estoque'
            ]);
        }

        if (!Permission::where('nome', '=', 'financeiro_relatorio')->count()) {
            Permission::create([
                'nome' => 'financeiro_relatorio',
                'descricao' => 'Relatório do Financeiro'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'financeiro_relatorio')->first();
            $permission->update([
                'nome' => 'financeiro_relatorio',
                'descricao' => 'Relatório do Financeiro'
            ]);
        }

        if (!Permission::where('nome', '=', 'cliente_relatorio')->count()) {
            Permission::create([
                'nome' => 'cliente_relatorio',
                'descricao' => 'Relatório de Clientes'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'cliente_relatorio')->first();
            $permission->update([
                'nome' => 'cliente_relatorio',
                'descricao' => 'Relatório de Clientes'
            ]);
        }

        if (!Permission::where('nome', '=', 'fornecedor_relatorio')->count()) {
            Permission::create([
                'nome' => 'fornecedor_relatorio',
                'descricao' => 'Relatório de Fornecedores'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'fornecedor_relatorio')->first();
            $permission->update([
                'nome' => 'fornecedor_relatorio',
                'descricao' => 'Relatório de Fornecedores'
            ]);
        }

        if (!Permission::where('nome', '=', 'venda_relatorio')->count()) {
            Permission::create([
                'nome' => 'venda_relatorio',
                'descricao' => 'Relatório de Vendas'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'venda_relatorio')->first();
            $permission->update([
                'nome' => 'venda_relatorio',
                'descricao' => 'Relatório de Vendas'
            ]);
        }

        if (!Permission::where('nome', '=', 'restaurar')->count()) {
            Permission::create([
                'nome' => 'restaurar',
                'descricao' => 'Restaurar itens deletados'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'restaurar')->first();
            $permission->update([
                'nome' => 'restaurar',
                'descricao' => 'Restaurar itens deletados'
            ]);
        }

    }
}
