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
                <li class="breadcrumb-item">Aulas</li>
                <li class="breadcrumb-item active">Aulas Reservadas</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div class="container-fluid" style="display: flex">
                        <div class="col-lg-4 col-sm-4" v-for="item in aulas_reservadas" :key="item.id">
                            <!-- small box -->
                            <div class="small-box" :class="{'bg-info': aguardando(item), 'bg-success': liberaAula(item), 'bg-danger': !liberaAula(item) && !aguardando(item)}">
                                <div class="inner">
                                    <h3>{{item.cad_disciplina}}</h3>
                                    <h6 v-if="!liberaAula(item) && aguardando(item)">
                                        <strong>AGUARDANDO</strong>
                                    </h6>
                                    <h6 v-if="!liberaAula(item) && !aguardando(item)">
                                        <strong>ENCERRADO</strong>
                                    </h6>
                                    <span>Início: {{formatDateTime(item.cad_data_hora_inicio)}}</span> <br>
                                    <span>Fim: {{formatDateTime(item.cad_data_hora_fim)}}</span> <br>
                                    <span>Professor: {{item.dsc_professor}}</span> <br>
                                    <span>Sala: {{item.cad_num_sala}}</span> <br>
                                    <span>Bloco: {{item.cad_bloco}}</span>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <a href="#" class="small-box-footer" v-if="liberaAula(item)">
                                    Confirmar Presença
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify.js';

    export default {
        data() {
            return {
                url: '',
                aulas_reservadas: [],
            }
        },

        mixins: [funcoes, notify],

        mounted() {
            this.submitForm();
        },

        methods: {
            aguardando(item){
                let now = moment().format('YYYY-MM-DD HH:mm:ss')
                console.log(item.cad_data_hora_inicio > now)
                if(item.cad_data_hora_inicio > now){
                    return true
                }

                return false
            },

            liberaAula(item){
                let now = moment().format('YYYY-MM-DD HH:mm:ss')

                if(item.cad_data_hora_inicio <= now && item.cad_data_hora_fim > now){
                    return true
                }

                return false
            },

            submitForm() {
                let self = this;

                self.resetAulasReservadas();
                self.url = self.mountUrl('/sistema/aulas_reservadas?', '');

                axios.get(self.url)
                    .then(function (response) {
                        self.aulas_reservadas = response.data.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            resetAulasReservadas() {
                let self = this;

                self.aulas_reservadas = [];
            }
        }
    }

</script>
