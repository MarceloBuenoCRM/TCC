<template>
    <div>
        <div class="content-header" style="padding-bottom: 0px">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pacientes</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-clinic-medical"></i> Clínica</a>
                            </li>
                            <li class="breadcrumb-item active">Pacientes</li>
                        </ol>
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
                                    Pesquisar
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px">
                                <el-form ref="form" :model="form" :rules="rules" label-position="top"
                                    class="demo-ruleForm">
                                    <el-form-item label="Nome" class="col-sm col-md-3" size="mini" prop="name">
                                        <el-input v-model="form.name" clearable></el-input>
                                    </el-form-item>
                                </el-form>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn bg-gradient-primary btn-sm float-left"
                                    @click="openModal()"> <i class="fas fa-plus"></i>
                                    Adicionar
                                </button>

                                <button type="button" class="btn bg-gradient-secondary btn-sm float-right"> <i
                                        class="fas fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>

                        <el-table :data="defeitos" style="width: 100%" tooltip-effect="dark" stripe>
                            <el-table-column prop="id_defeito" label="Id" width="120px"
                                show-overflow-tooltip>
                            </el-table-column>

                            <el-table-column prop="dsc_defeito" label="Nome" show-overflow-tooltip
                                width="400px">
                            </el-table-column>

                            <el-table-column label="Funções" align="center">
                                <template slot-scope="scope">
                                    <!-- v-if="can($route.name, 4)" -->
                                    <a href="#" class="edit" @click.prevent="editar(scope.row.id_defeito)"
                                        title="Editar"><i class="fas fa-edit fa-lg"
                                            style="color:#0085fa;"></i></a>

                                    <!-- v-if="can($route.name, 3)" -->
                                    <a href="#" @click.prevent="open(scope.row.id_defeito)"
                                        title="Excluir"><i class="fas fa-trash-alt fa-lg"
                                            style="color:#f00;"></i></a>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </div>
            </div>
        </section>

        <modal-form ref="modalForm"></modal-form>
    </div>
</template>

<script>
    import modalForm from './modalForm';

    export default {
        components:{
            modalForm
        },

        data() {
            return {
                form: {
                    name: ''
                },

                defeitos: [],

                rules: {
                    name: [{
                            required: true,
                            message: 'Please input Activity name',
                            trigger: 'change'
                        },
                        {
                            min: 3,
                            max: 5,
                            message: 'Length should be 3 to 5',
                            trigger: 'change'
                        }
                    ],
                },
            }
        },

        methods: {
            openModal(){
				let self = this;

				self.$refs.modalForm.show('');
            },

            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
        },
    }

</script>
