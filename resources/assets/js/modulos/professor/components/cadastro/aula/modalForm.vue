<template>
    <el-dialog
        :title="edit == true ? $t('message.edit', {msg: $t('message.aula')}) : $t('message.add', {msg: $t('message.aula')})"
        :visible.sync="dialogVisible" :before-close="closeModalForm" append-to-body>
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    {{$t('message.aula')}}
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
                        <el-form-item :label="$t('message.disciplina')" class="col-sm-12 col-md-6" size="mini"
                            prop="cad_disciplina">
                            <el-input v-model="form.cad_disciplina" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.curso')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_curso">
                            <el-input v-model="form.cad_curso" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.periodo')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_periodo">
                            <el-input v-model="form.cad_periodo" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.data_hora_inicio')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_data_hora_inicio">
                            <el-date-picker v-model="form.cad_data_hora_inicio" type="datetime" format="dd/MM/yyyy HH:mm:ss"
                                value-format="yyyy-MM-dd HH:mm:ss" v-mask="'##/##/#### ##:##:##'" clearable>
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item :label="$t('message.data_hora_fim')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_data_hora_fim">
                            <el-date-picker v-model="form.cad_data_hora_fim" type="datetime" format="dd/MM/yyyy HH:mm:ss"
                                value-format="yyyy-MM-dd HH:mm:ss" v-mask="'##/##/#### ##:##:##'" clearable>
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item :label="$t('message.num_sala')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_num_sala">
                            <el-input v-model="form.cad_num_sala" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.bloco')" class="col-sm-12 col-md-3" size="mini"
                            prop="cad_bloco">
                            <el-input v-model="form.cad_bloco" clearable></el-input>
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
            var validatePass = (rule, value, callback) => {
                if (value !== this.form.cad_senha) {
                    callback(new Error('As senhas não conferem.'));
                } else {
                    callback();
                }
            };

            return {
                activeCollpase: 'defeito',
                form          : {
                    cad_data_hora_inicio: moment().format('YYYY-MM-DD 19:10:00'),
                    cad_nome            : '',
                    cad_email           : '',
                    cad_senha           : '',
                    cad_confirma_senha  : '',
                    tipo_usuario        : 0
                },
                rules: {
                    cad_nome: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$tc('message.nome', 2)
                        }),
                        trigger: "change",
                    }],
                    cad_email: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {
                                msg: this.$t('message.email')
                            }),
                            trigger: "blur",
                        },
                        {
                            type   : 'email',
                            message: this.$t('message.rules.email_valido'),
                            trigger: "blur",
                        }
                    ],
                    cad_senha: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {
                                msg: this.$tc('message.senha', 1)
                            }),
                            trigger: "change",
                        },
                        {
                            min    : 8,
                            message: this.$t('message.rules.min_caracter', [8]),
                            trigger: "blur",
                        }
                    ],
                    cad_confirma_senha: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {
                                msg: this.$tc('message.senha', 2)
                            }),
                            trigger: "change",
                        },
                        {
                            validator: validatePass,
                            trigger  : 'change'
                        }
                    ],
                    tipo_usuario: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.tipo_usuario')
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

                    if (self.edit == true) {
                        axios.put('/sistema/usuario/' + self.form.id, self.form)
                            .then(function () {
                                self.notifyEdit();
                                self.$emit('loadData');
                                self.closeModal();
                            })
                            .catch(function (error) {
                                self.errors = error.response.data.errors ?? [];
                                self.notifyErrorValidation();
                            })
                    } else {
                        axios.post('/sistema/usuario', self.form)
                            .then(function () {
                                self.notifyAdd();
                                self.$emit('loadData');
                                self.closeModal();
                            })
                            .catch(function (error) {
                                self.errors = error.response.data.errors ?? [];
                                self.notifyErrorValidation();
                            })
                    }
                })
            },

            carregaDados(id_usuario) {
                let self = this;

                axios.get('/sistema/usuario/' + id_usuario)
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
