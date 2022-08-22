<template>
    <el-dialog :title="edit == true ? $t('message.edit', {msg: $tc('message.usuario', 1)}) : $t('message.add', {msg: $tc('message.usuario', 1)})" :visible.sync="dialogVisible"
        :before-close="closeModalForm" append-to-body>
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    {{$tc('message.usuario', 1)}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm" @submit.native.prevent="submitForm('form')" id="formUsuarios">
                    <div class="row">
                        <el-form-item :label="$tc('message.nome', 2)" class="col-sm-12 col-md-12" size="mini" prop="cad_nome">
                            <el-input v-model="form.cad_nome" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.email')" class="col-sm-12 col-md-4" :class="[{'col-md-12': edit}, {'is-error': hasError('cad_email')}]"
                            size="mini" prop="cad_email">
                            <el-input v-model="form.cad_email" clearable @blur="clearError"></el-input>
                            <div class="el-form-item__error" v-if="hasError('cad_email')">
                                {{errors['cad_email'][0]}}
                            </div>
                        </el-form-item>

                        <el-form-item :label="$tc('message.senha', 1)" class="col-sm-12 col-md-4" size="mini" prop="cad_senha" v-if="!edit">
                            <el-input type="password" v-model="form.cad_senha">
                            </el-input>
                        </el-form-item>

                        <el-form-item :label="$tc('message.senha', 2)" class="col-sm-12 col-md-4" size="mini" prop="cad_confirma_senha" v-if="!edit">
                            <el-input type="password" v-model="form.cad_confirma_senha">
                            </el-input>
                        </el-form-item>

                        <el-form-item class="col-sm-12 col-md-12" :label="$t('message.tipo_usuario')" size="mini" prop="tipo_usuario">
                            <el-radio-group v-model="form.tipo_usuario">
                                <el-radio :label="0">{{$t('message.administrador')}}</el-radio>
                                <el-radio :label="1">{{$t('message.professor')}}</el-radio>
                                <el-radio :label="2">{{$t('message.aluno')}}</el-radio>
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
    import funcoes     from '../../../../../components/mixins/funcoes';
    import notify      from '../../../../../components/mixins/notify';
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
                form          : {
                    cad_nome          : '',
                    cad_email         : '',
                    cad_senha         : '',
                    cad_confirma_senha: '',
                    tipo_usuario      : 0
                },
                rules: {
                    cad_nome: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$tc('message.nome', 2)}),
                        trigger : "change",
                    }],
                    cad_email: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.email')}),
                            trigger : "blur",
                        },
                        {
                            type   : 'email',
                            message: this.$t('message.rules.email_valido'),
                            trigger: "blur",
                        }
                    ],
                    cad_senha: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {msg: this.$tc('message.senha', 1)}),
                            trigger : "change",
                        },
                        {
                            min    : 8,
                            message: this.$t('message.rules.min_caracter', [8]),
                            trigger: "blur",
                        }
                    ],
                    cad_confirma_senha: [{
                            required: true,
                            message : this.$t('message.rules.campo_obrigatorio', {msg: this.$tc('message.senha', 2)}),
                            trigger : "change",
                        },
                        {
                            validator: validatePass,
                            trigger  : 'change'
                        }
                    ],
                    tipo_usuario: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.tipo_usuario')}),
                        trigger : "change",
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
