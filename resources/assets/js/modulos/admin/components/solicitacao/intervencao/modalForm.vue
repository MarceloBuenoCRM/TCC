<template>
    <el-dialog
        :title="edit == true ? $t('message.edit', {msg:  'Intervenção'}) : $t('message.add', {msg:  'Intervenção'})"
        :visible.sync="dialogVisible" :before-close="closeModalForm" append-to-body>
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    Intervenção
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm"
                    @submit.native.prevent="submitForm('form')" id="formUsuarios">
                    <div class="row">
                        <el-form-item label="Aluno" class="col-sm-12 col-md-12" size="mini" prop="cad_nome">
                            <el-input v-model="form.cad_nome" clearable disabled></el-input>
                        </el-form-item>

                        <el-form-item label="Data" class="col-sm-12 col-md-6" size="mini" prop="cad_data">
                            <el-date-picker v-model="form.cad_data" type="datetime" format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd" v-mask="'##/##/#### ##:##:##'" clearable disabled>
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item label="Disciplina" class="col-sm-12 col-md-6" size="mini" prop="cad_disciplina">
                            <el-input v-model="form.cad_disciplina" clearable disabled></el-input>
                        </el-form-item>

                        <el-form-item label="Curso" class="col-sm-12 col-md-6" size="mini" prop="cad_curso">
                            <el-input v-model="form.cad_curso" clearable disabled></el-input>
                        </el-form-item>

                        <el-form-item label="Professor" class="col-sm-12 col-md-6" size="mini" prop="cad_professor">
                            <el-input v-model="form.cad_professor" clearable disabled></el-input>
                        </el-form-item>

                        <el-form-item label="Motivo" class="col-sm-12 col-md-12" size="mini" prop="cad_motivo">
                            <el-input type="textarea" v-model="form.cad_motivo" disabled>
                            </el-input>
                        </el-form-item>

                        <el-form-item label="Aprovado" class="col-sm-12 col-md-12" size="mini" prop="cad_aprovado">
                            <el-radio-group v-model="form.cad_aprovado">
                                <el-radio :label="1">Sim</el-radio>
                                <el-radio :label="0">Não</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </div>
                </el-form>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button type="button" class="btn btn-light btn-sm" @click="closeModalForm()">
                {{$t('message.cancelar')}}
            </button>
            <button native-type="submit" class="btn btn-primary btn-sm" form="formUsuarios">
                <i class="fas fa-save"></i>
                {{$t('message.gravar')}}
            </button>
        </span>
    </el-dialog>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify';
    import modalMixins from '../../../../../components/mixins/modalMixins';

    export default {
        props: {
            edit: Boolean,
        },

        data() {
            return {
                activeCollpase: 'defeito',
                form          : {
                    cad_curso     : '',
                    cad_aluno     : '',
                    cad_disciplina: '',
                    cad_professor : '',
                    cad_motivo    : '',
                    cad_data      : '',
                    cad_aprovado  : ''
                },
                rules: {
                    cad_data: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Data'
                        }),
                        trigger: "change",
                    }],
                    cad_motivo: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Motivo'
                        }),
                        trigger: "change",
                    }],
                    cad_professor: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Professor'
                        }),
                        trigger: "change",
                    }],
                    cad_disciplina: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Disciplina'
                        }),
                        trigger: "change",
                    }],
                    cad_aluno: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Aluno'
                        }),
                        trigger: "change",
                    }],
                    cad_curso: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: 'Curso'
                        }),
                        trigger: "change",
                    }],
                },
                errors: []
            }
        },

        mixins: [modalMixins, notify, funcoes],

        methods: {
            submitForm(form) {
                let self = this;

                self.$refs[form].validate((valid) => {
                    if (!valid) {
                        self.notifyErrorValidation();
                        return false;
                    }

                    self.clearError();

                    axios.put('/sistema/intervencao/' + self.form.id, self.form)
                        .then(function () {
                            self.notifyEdit();
                            self.$emit('loadData');
                            self.closeModal();
                        })
                        .catch(function (error) {
                            self.errors = error.response.data.errors ?? [];
                            self.notifyErrorValidation();
                        })
                })
            },

            carregaDados(id_intervencao) {
                let self = this;

                axios.get('/sistema/intervencao/' + id_intervencao)
                    .then(function (response) {
                        self.form = response.data.data.data[0];
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            closeModalForm() {
                let self = this;

                self.clearError();
                self.closeModal();
            }
        }
    }

</script>
