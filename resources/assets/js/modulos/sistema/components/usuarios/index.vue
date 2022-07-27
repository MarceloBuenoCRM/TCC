<template>
    <div class="d-flex flex-column">
        <div class="content-header col-sm-6 breadcrumb_index">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-cog"></i> Sistema</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6 content_index">
                                <h1 class="m-0">Usuários</h1>
                            </div>
                        </div>

                        <div class="row mb-2 button_index">
                            <button type="button" class="btn bg-primary btn-sm" @click="openModal()">
                                <i class="fas fa-plus"></i>
                                Novo
                            </button>

                            <button type="button" class="btn btn-light btn-sm">
                                <i class="fas fa-file-excel"></i>
                                Exportar para Excel
                            </button>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Filtros
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px">
                                        <el-form ref="form" :model="form" label-position="top" class="demo-ruleForm">
                                            <el-form-item label="Nome" class="col-sm col-md-3" size="mini"
                                                prop="cad_nome">
                                                <el-input v-model="form.cad_nome" clearable></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </div>
                                    <div class="card-footer card_footer_index">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-primary btn-sm" @click="submitForm()">
                                                <i class="fas fa-search"></i>
                                                Buscar
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm"
                                            @click="resetForm()">
                                                <i class="fas fa-undo"></i>
                                                Limpar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <el-table :data="usuarios" style="width: 100%" tooltip-effect="dark" stripe>
                                    <el-table-column prop="id" label="Id" width="120px" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_nome" label="Nome" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_email" label="E-mail" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column label="Funções" align="center">
                                        <template slot-scope="scope">
                                            <a href="#" class="edit" @click.prevent="openModal(scope.row.id, true)"
                                                title="Editar">
                                                <i class="fas fa-edit fa-lg" style="color:#0085fa;"></i>
                                            </a>

                                            <a href="#" @click.prevent="confirmDelete(scope.row.id)" title="Excluir">
                                                <i class="fas fa-trash-alt fa-lg" style="color:#f00;"></i>
                                            </a>
                                        </template>
                                    </el-table-column>
                                </el-table>

                                <el-pagination @current-change="navigate" :current-page="currentPage"
                                    layout="total, ->, prev, pager, next, jumper" :total="total">
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <modal-form ref="modalForm" :edit="edit" @loadData="loadData"></modal-form>
    </div>
</template>

<script>
    import modalForm from './modalForm';

    export default {
        components: {
            modalForm
        },

        data() {
            return {
                form: {
                    cad_nome: ''
                },
                usuarios_list: [],
                edit         : false,
                page         : '',
                url          : '',
                total        : null,
                currentPage  : null
            }
        },

        computed: {
            usuarios() {
                return this.$store.state.usuarios;
            },
        },

        mounted() {
            this.loadData();
        },

        methods: {
            openModal(id = '', edit = false) {
                let self = this;

                if (edit == true) {
                    self.$refs.modalForm.carregaDados(id);
                }
                self.edit = edit;
                self.$refs.modalForm.show('');
            },

            confirmDelete(id_usuario) {
                let self = this;

                self.$confirm('Deseja excluir esse registro?', 'Atenção', {
                    confirmButtonText: 'Sim',
                    cancelButtonText : 'Cancelar',
                    type             : 'warning',
                    showClose        : true,
                }).then(() => {
                    self.delete(id_usuario)
                }).catch(() => {
                    self.$notify.info({
                        title  : 'Atenção!',
                        message: 'Exclusão cancelada.'
                    });
                });
            },

            delete(id_usuario) {
                let self = this;

                axios.delete('/sistema/usuario/' + id_usuario)
                    .then(function () {
                        self.loadData();
                        self.$notify({
                            title  : 'Sucesso!',
                            message: 'Registro excluído com sucesso.',
                            type   : 'success'
                        });
                    })
                    .catch(() => {
                        self.$notify.error({
                            title  : 'Atenção!',
                            message: 'Item não pode ser excluído.'
                        });
                    });
            },

            submitForm() {
                let self = this;

                self.page = '';
                self.searchForm();
            },

            loadData() {
                let self = this;

                self.searchForm(self.page);
            },

            navigate(page) {
                let self = this;

                self.page = page;
                self.searchForm(page);
            },

            searchForm(page) {
                let self = this;

                self.resetUsuarios();

                self.url = "/sistema/usuario?"

                Object.keys(self.form).forEach(function (key, i) {
                    if (Object.values(self.form)[i]) {
                        self.url += key + '=' + Object.values(self.form)[i] + '&'
                    }
                })

                if (page != undefined && page != '') {
                    self.url += 'page=' + page
                }

                axios.get(self.url)
                    .then(function (response) {
                        self.currentPage = response.data.data.current_page;
                        self.total       = response.data.data.total;
                        self.setUsuarios(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            setUsuarios(response) {
                let self = this;

                Object.keys(response.data.data.data).forEach((key, i) => self.usuarios_list[key] = Object.values(
                    response.data.data.data)[i]);

                self.$store.commit("LOADING_USUARIOS", self.usuarios_list);
            },

            resetUsuarios() {
                let self = this;

                self.usuarios_list = [];
            },

            resetForm(){
                let self = this;

                self.$refs.form.resetFields();
            }
        }
    }
</script>
