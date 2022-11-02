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
                <li class="breadcrumb-item active">Histórico</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6 content_index">
                                <h1 class="m-0">Histórico</h1>
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
                                            @submit.native.prevent="submitForm()" id="formIndexUsuario">
                                            <div class="row">
                                                <el-form-item label="Professor" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_nome">
                                                    <el-input v-model="form.cad_nome" clearable></el-input>
                                                </el-form-item>
                                                <el-form-item label="Disciplina" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_disciplina">
                                                    <el-input v-model="form.cad_disciplina" clearable></el-input>
                                                </el-form-item>
                                                <el-form-item label="Data" class="col-sm-12 col-md-3" size="mini"
                                                    prop="cad_data_hora_inicio">
                                                    <el-date-picker v-model="form.cad_data_hora_inicio" type="date"
                                                        format="dd/MM/yyyy" value-format="yyyy-MM-dd"
                                                        v-mask="'##/##/####'" clearable>
                                                    </el-date-picker>
                                                </el-form-item>
                                            </div>
                                        </el-form>
                                    </div>
                                    <div class="card-footer card_footer_index">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button native-type="submit" class="btn btn-primary btn-sm"
                                                form="formIndexUsuario">
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

                                <el-table :data="presenca" style="width: 100%" tooltip-effect="dark" stripe>
                                    <el-table-column prop="id" :label="$t('message.id')" width="120px"
                                        show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_nome" label="Professor" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_disciplina" label="Disciplina" show-overflow-tooltip>
                                    </el-table-column>

                                    <el-table-column prop="cad_data_hora_inicio" label="Data Aula"
                                        show-overflow-tooltip>
                                        <template slot-scope="scope">
                                            {{formatDate(scope.row.cad_data_hora_inicio)}}
                                        </template>
                                    </el-table-column>

                                    <el-table-column prop="presenca" label="Presença" show-overflow-tooltip>
                                        <template slot-scope="scope">
                                            <el-tag type="danger" v-if="scope.row.presenca == 0">
                                                FALTA
                                            </el-tag>

                                            <el-tag type="success" v-else>
                                                PRESENÇA
                                            </el-tag>
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
    </div>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify.js';
    import pagination from '../../../../../components/partials/simplePagination.vue';

    export default {
        components: {
            pagination
        },

        data() {
            return {
                form: {
                    cad_nome            : '',
                    cad_disciplina      : '',
                    cad_data_hora_inicio: '',
                    per_page            : 5,
                },
                url: '',
                presenca: [],
                edit: false,
                next_page: false,
                prev_page: false,
                currentPage: null
            }
        },

        mixins: [funcoes, notify],

        mounted() {
            this.submitForm();
        },

        methods: {
            submitForm() {
                let self = this;

                self.searchForm(null, self.form.per_page);
            },

            searchForm(page, page_size) {
                let self = this;

                self.resetPresenca();
                self.form.per_page = page_size;
                self.form.page = page;
                self.url = self.mountUrl('/sistema/presenca?', self.form);

                axios.get(self.url)
                    .then(function (response) {
                        self.currentPage = response.data.data.current_page;
                        self.form.per_page = parseInt(response.data.data.per_page);
                        self.next_page = Boolean(response.data.data.next_page_url);
                        self.prev_page = Boolean(response.data.data.prev_page_url);
                        self.presenca = self.mountDataTable(response.data.data.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            resetPresenca() {
                let self = this;

                self.presenca = [];
            }
        }
    }

</script>
