<template>
    <div class="d-flex flex-column">
        <div class="content-header col-sm-6 breadcrumb_index">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        {{$t('message.sistema')}}
                    </a>
                </li>
                <li class="breadcrumb-item">{{$t('message.cadastro')}}</li>
                <li class="breadcrumb-item active">{{$tc('message.usuario', 2)}}</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6 content_index">
                                <h1 class="m-0">{{$tc('message.usuario', 2)}}</h1>
                            </div>
                        </div>

                        <div class="row mb-2 button_index">
                            <button type="button" class="btn btn-primary btn-sm" @click="openModal()">
                                <i class="fas fa-plus"></i>
                                {{$t('message.novo')}}
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
                                            {{$t('message.filtro')}}
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px">
                                        <el-form ref="form" :model="form" label-position="top" class="demo-ruleForm" @submit.native.prevent="submitForm()" id="formIndexUsuario">
                                            <el-form-item :label="$tc('message.nome', 1)" class="col-sm-12 col-md-3" size="mini" prop="cad_nome">
                                                <el-input v-model="form.cad_nome" clearable></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </div>
                                    <div class="card-footer card_footer_index">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button native-type="submit" class="btn btn-primary btn-sm" form="formIndexUsuario">
                                                <i class="fas fa-search"></i>
                                                {{$t('message.buscar')}}
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm"
                                            @click="resetForm()">
                                                <i class="fas fa-undo"></i>
                                                {{$t('message.limpar')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <el-table :data="usuarios" style="width: 100%" tooltip-effect="dark" stripe>
                                    <el-table-column prop="id" :label="$t('message.id')" width="120px" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_nome" :label="$tc('message.nome', 2)" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_email" :label="$t('message.email')" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column label="Funções" align="center">
                                        <template slot-scope="scope">
                                            <a href="#" class="edit" @click.prevent="openModal(scope.row.id, true)" :title="$t('message.editar')">
                                                <i class="fas fa-edit" style="color:#0085fa;"></i>
                                            </a>

                                            <a href="#" @click.prevent="confirmDelete(scope.row.id)" :title="$t('message.excluir')">
                                                <i class="fas fa-trash-alt" style="color:#f00;"></i>
                                            </a>
                                        </template>
                                    </el-table-column>
                                </el-table>

                                <pagination @navigate="searchForm" @sizeChange="searchForm" :page_size="form.per_page" :currentPage="currentPage" :next_page="next_page" :prev_page="prev_page">
                                </pagination>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <modal-form ref="modalForm" :edit="edit" @loadData="submitForm"></modal-form>
    </div>
</template>

<script>
    import modalForm  from './modalForm';
    import funcoes    from '../../../../../components/mixins/funcoes';
    import notify     from '../../../../../components/mixins/notify.js';
    import pagination from '../../../../../components/partials/simplePagination.vue';

    export default {
        components: {
            pagination,
            modalForm
        },

        data() {
            return {
                form: {
                    cad_nome: '',
                    per_page: 5,
                },
                url        : '',
                usuarios   : [],
                edit       : false,
                next_page  : false,
                prev_page  : false,
                currentPage: null
            }
        },

        mixins: [funcoes, notify],

        mounted() {
            this.submitForm();
        },

        methods: {
            openModal(id = '', edit = false) {
                let self = this;

                if (edit == true) {
                    self.$refs.modalForm.carregaDados(id);
                }
                self.edit = edit;
                self.$refs.modalForm.show();
            },

            delete(id_usuario) {
                let self = this;

                axios.delete('/sistema/usuario/' + id_usuario)
                    .then(function () {
                        self.submitForm();
                        self.notifyDelete();
                    })
                    .catch((error) => {
                        self.notifyError(error.response.data.message);
                    });
            },

            submitForm() {
                let self = this;

                self.searchForm(null, self.form.per_page);
            },

            searchForm(page, page_size) {
                let self = this;

                self.resetUsuarios();
                self.form.per_page = page_size;
                self.form.page     = page;
                self.url           = self.mountUrl('/sistema/usuario?', self.form);

                axios.get(self.url)
                    .then(function (response) {
                        self.currentPage   = response.data.data.current_page;
                        self.form.per_page = parseInt(response.data.data.per_page);
                        self.next_page     = Boolean(response.data.data.next_page_url);
                        self.prev_page     = Boolean(response.data.data.prev_page_url);
                        self.usuarios      = self.mountDataTable(response.data.data.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            resetUsuarios() {
                let self = this;

                self.usuarios = [];
            }
        }
    }
</script>
