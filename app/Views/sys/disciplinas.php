<!-- incluir os componentes modais antes do restante do documento -->
<?php echo view('components/disciplina/modal-edit-disciplina'); ?>
<?php echo view('components/disciplina/modal-cad-disciplina'); ?>
<?php echo view('components/disciplina/modal-deletar-disciplina') ?>

<div class="page-header">
    <h3 class="page-title">GERENCIAR DISCIPLINAS</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/sys/home') ?>">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista Disciplinas</li>
        </ol>
    </nav>
</div>

<!-- mostrar ALERT em caso de erro -->
<?php if (session()->has('erros')): ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session('erros') as $erro): ?>
                                <li> <i class="mdi mdi-alert-circle"></i><?= esc($erro) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ações e filtros -->
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ações</h4>
                <div class="row">
                    <div class="col-12 mb-4">
                        <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#modal-cad-disciplina"><i class="fa fa-plus-circle btn-icon-prepend"></i> Incluir Disciplina</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm" id="listagem-disciplina">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Matriz</th>
                                        <th>C.H.</th>
                                        <th>C.H. Dia</th>
                                        <th>Período</th>
                                        <th>Abreviatura</th>
                                        <th>Ambiente</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (!empty($disciplinas)): //verifica se a tabela tem dados 
                                    ?>
                                        <?php foreach ($disciplinas as $disciplina): //loop para percorrer todos os professores retornados do bd 
                                        ?>
                                            <tr>
                                                <td><?php echo esc($disciplina['nome']); ?></td>
                                                <td><?php echo esc($disciplina['nome_matriz']); ?></td>
                                                <td><?php echo esc($disciplina['ch']); ?></td>
                                                <td><?php echo esc($disciplina['max_tempos_diarios']); ?></td>
                                                <td><?php echo ($disciplina['periodo'] == "0") ? "-" : esc($disciplina['periodo']) . "º"; ?></td>
                                                <td><?php echo esc($disciplina['abreviatura']); ?></td>
                                                <td><?php echo esc($disciplina['grupo_de_ambiente']); ?></td>

                                                <!-- essa celula monta os botões de ação que acionam modais -->

                                                <td>
                                                    <div class="d-flex">
                                                        <!-- o elemento <span> é apenas para mostrar o tooltip -->
                                                        <span data-bs-toggle="tooltip" data-placement="top" title="Atualizar dados da disciplina">
                                                            <!-- botão com estilo, ativação do modal, e dados formados para transmitir ao modal -->
                                                            <button
                                                                type="button"
                                                                class="justify-content-center align-items-center d-flex btn btn-inverse-success button-trans-success btn-icon me-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-edit-disciplina"
                                                                data-id="<?php echo esc($disciplina['id']); ?>"
                                                                data-nome="<?php echo esc($disciplina['nome']); ?>"
                                                                data-codigo="<?php echo esc($disciplina['codigo']); ?>"
                                                                data-matriz_id="<?php echo esc($disciplina['matriz_id']); ?>"
                                                                data-ch="<?php echo esc($disciplina['ch']); ?>"
                                                                data-max-tempos-diarios="<?php echo esc($disciplina['max_tempos_diarios']); ?>"
                                                                data-periodo="<?php echo esc($disciplina['periodo']); ?>"
                                                                data-abreviatura="<?php echo esc($disciplina['abreviatura']); ?>"
                                                                data-grupo-ambiente-id="<?php echo esc($disciplina['grupo_de_ambientes_id']); ?>">

                                                                <!-- icone do botão -->
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </span>

                                                        <!-- abaixo são repetidos os códigos acima para replicar os outros 2 botões -->

                                                        <span data-bs-toggle="tooltip" data-placement="top" title="Excluir disciplina">
                                                            <button
                                                                type="button"
                                                                class="justify-content-center align-items-center d-flex btn btn-inverse-danger button-trans-danger btn-icon me-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-deletar-disciplina"
                                                                data-id="<?php echo esc($disciplina['id']); ?>"
                                                                data-nome="<?php echo esc($disciplina['nome']); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- caso não haja curso cadastrado -->
                                        <tr>
                                            <td colspan="4">Nenhum disciplina cadastrada.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 mt-4 d-flex justify-content-end">Legenda</div>
            <div class="col-12 mt-4 d-flex justify-content-end gap-3">
                <p class="card-description text-end"><i class="fa fa-edit text-success me-2"></i>Editar &nbsp; &nbsp; </p>
                <p class="card-description text-end"><i class="fa fa-trash text-danger me-2"></i>Excluir</p>
            </div>
        </div>
    </div>
</div>


<!-- daqui pra baixo é javascript -->
<script>
    //Para carregar a tradução dos itens da DataTable
    const dataTableLangUrl = "<?php echo base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";



    //essa linha abaixo é para detectar que o documento foi completamente carregado e executar o código após isso
    $(document).ready(function() {


        //Verificar se tem disciplina para então "transformar" a tabela em DataTable
        <?php if (!empty($disciplinas)): ?>

            //Cria a DataTable
            $("#listagem-disciplina").DataTable({

                //Define as entradas de quantidade de linhas visíveis na tabela
                aLengthMenu: [
                    [5, 15, 30, -1],
                    [5, 15, 30, "Todos"],
                ],

                //Define as questões de tradução/idioma
                language: {
                    search: "Pesquisar:",
                    url: dataTableLangUrl,
                },

                //Ativa ordenação
                ordering: true,
                //Diz que a coluna 1 (segunda/nome) deve ser o padrão de ordenação ao carregar a tabela
                order: [
                    [1, 'asc']
                ],
                //Desativa a ordenação por ações
                columns: [null, null, null, null, null, null, null, {
                    orderable: false
                }]
            });

            //programação do modal de Edição do curso
            //mais especificamente preenche os campos com os dados atuais
            //que vêm lá do código HTML do botão de editar
            $('#modal-edit-disciplina').on('show.bs.modal', function(event) {
                // Obter o DOM do botão que ativou o modal
                var button = $(event.relatedTarget);

                // Extrair as informações dos atributos data-* 
                var id = button.data('id');
                var nome = button.data('nome');
                var codigo = button.data('codigo');
                var matriz = button.data('matriz_id');
                var ch = button.data('ch');
                var max_tempos_diarios = button.data('max-tempos-diarios');
                var periodo = button.data('periodo');
                var abreviatura = button.data('abreviatura')
                var grupo_ambiente = button.data('grupo-ambiente-id');


                // Formar o modal com os dados preenchidos
                var modal = $(this);
                modal.find('#edit-id').val(id);
                modal.find('#edit-nome').val(nome);
                modal.find('#edit-codigo').val(codigo);
                modal.find('#edit-matriz').val(matriz);
                modal.find('#edit-cargaHoraria').val(ch);
                modal.find('#edit-max_tempos_diarios').val(max_tempos_diarios);
                modal.find('#edit-periodo').val(periodo);
                modal.find('#edit-abreviatura').val(abreviatura);
                modal.find('#edit-grupo_ambiente').val(grupo_ambiente);

            });

            //Mesma abordagem do código acima, para o modal de excluir professor
            $('#modal-deletar-disciplina').on('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget);

                // Extract info from data-* attributes
                var id = button.data('id');
                var nome = button.data('nome');

                var modal = $(this);
                modal.find('#deletar-id').val(id);
                modal.find('#deletar-nome').text(nome);
            });

            //Ativa os tooltips dos botões
            $('[data-bs-toggle="tooltip"]').tooltip();

        <?php endif; ?>

        // Exibe mensagem de sucesso se o flashdata estiver com 'sucesso'
        <?php if (session()->getFlashdata('sucesso')): ?>
            $.toast({
                heading: 'Sucesso',
                text: '<?php echo session()->getFlashdata('sucesso'); ?>',
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-center'
            });
        <?php endif; ?>
    });
</script>