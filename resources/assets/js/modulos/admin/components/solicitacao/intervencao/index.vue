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
                <li class="breadcrumb-item active">Intervenção</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6 content_index">
                                <h1 class="m-0">Intervenção</h1>
                            </div>
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
                                        <el-form ref="form" :model="form" label-position="top" class="demo-ruleForm"
                                            @submit.native.prevent="submitForm()" id="formIndexIntervencao">
                                            <div class="row">
                                                <el-form-item label="Data" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_data">
                                                    <el-date-picker v-model="form.cad_data" type="datetime"
                                                        format="dd/MM/yyyy" value-format="yyyy-MM-dd"
                                                        v-mask="'##/##/#### ##:##:##'" clearable>
                                                    </el-date-picker>
                                                </el-form-item>

                                                <el-form-item label="Curso" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_curso">
                                                    <el-input v-model="form.cad_curso" clearable></el-input>
                                                </el-form-item>

                                                <el-form-item label="Aluno" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_aluno">
                                                    <el-input v-model="form.cad_aluno" clearable></el-input>
                                                </el-form-item>

                                                <el-form-item label="Professor" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_professor">
                                                    <el-input v-model="form.cad_professor" clearable></el-input>
                                                </el-form-item>
                                            </div>
                                        </el-form>
                                    </div>
                                    <div class="card-footer card_footer_index">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button native-type="submit" class="btn btn-primary btn-sm"
                                                form="formIndexIntervencao">
                                                <i class="fas fa-search"></i>
                                                {{$t('message.buscar')}}
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm" @click="resetForm()">
                                                <i class="fas fa-undo"></i>
                                                {{$t('message.limpar')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <el-table :data="intervencao" style="width: 100%" tooltip-effect="dark" stripe>
                                    <el-table-column prop="id" :label="$t('message.id')" width="120px"
                                        show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_nome" label="Aluno" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_curso" label="Curso" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_data" label="Data" show-overflow-tooltip>
                                        <template slot-scope="scope">
                                            {{formatDate(scope.row.cad_data)}}
                                        </template>
                                    </el-table-column>

                                    <el-table-column prop="cad_aprovado" label="Status" show-overflow-tooltip>
                                        <template slot-scope="scope">
                                            {{scope.row.cad_aprovado}}
                                        </template>
                                    </el-table-column>

                                    <el-table-column prop="cad_professor" label="Professor" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column label="Funções" align="center">
                                        <template slot-scope="scope">
                                            <a href="#" class="edit" @click.prevent="openModal(scope.row.id, true)"
                                                :title="$t('message.editar')">
                                                <i class="fas fa-edit" style="color:#0085fa;"></i>
                                            </a>
                                        </template>
                                    </el-table-column>
                                </el-table>

                                <pagination @navigate="searchForm" @sizeChange="searchForm" :page_size="form.per_page"
                                    :currentPage="currentPage" :next_page="next_page" :prev_page="prev_page">
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
    import modalForm from './modalForm';
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify.js';
    import pagination from '../../../../../components/partials/simplePagination.vue';

    export default {
        components: {
            pagination,
            modalForm
        },

        data() {
            return {
                form: {
                    cad_data     : '',
                    cad_curso    : '',
                    cad_aluno    : '',
                    cad_professor: ''
                },
                url        : '',
                intervencao: [],
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

            delete(id_intervencao) {
                let self = this;

                axios.delete('/sistema/intervencao/' + id_intervencao)
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

                self.resetIntervencao();
                self.form.per_page = page_size;
                self.form.page     = page;
                self.url           = self.mountUrl('/sistema/intervencao?', self.form);

                axios.get(self.url)
                    .then(function (response) {
                        self.currentPage   = response.data.data.current_page;
                        self.form.per_page = parseInt(response.data.data.per_page);
                        self.next_page     = Boolean(response.data.data.next_page_url);
                        self.prev_page     = Boolean(response.data.data.prev_page_url);
                        self.intervencao   = self.mountDataTable(response.data.data.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            resetIntervencao() {
                let self = this;

                self.intervencao = [];
            }
        }
    }

</script>
