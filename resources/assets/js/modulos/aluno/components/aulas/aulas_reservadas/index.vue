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
                    <div v-if="aulas_reservadas.length == 0">
                        <p style="text-align: center">Nenhuma aula reservada</p>
                    </div>
                    <div class="container-fluid" style="display: flex">
                        <div class="col-lg-4 col-sm-4" v-for="item in aulas_reservadas" :key="item.id">
                            <div class="small-box"
                                :class="{'bg-info': aguardando(item), 'bg-success': liberaAula(item), 'bg-danger': !liberaAula(item) && !aguardando(item)}">
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

                                    <div v-if="text">
                                        Tempo Mínimo: {{text}}
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <a href="#" class="small-box-footer" v-if="liberaAula(item)"
                                    @click="verificaLocalizacao(item.cad_tempo_minimo)">
                                    Confirmar Presença
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>

                                <button @click="pause">Pause</button>
                                <button @click="startTimer(duration)">Continuar</button>
                            </div>
                        </div>

                        <div id="map_area">
                            <div id="note">
                                <span id="title">&raquo;Inside the circle?&laquo;</span>
                                <hr />
                                <span class="info">Marker <strong>A</strong>:
                                    <span id="a" class="bool"></span>
                                </span>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <el-dialog :visible.sync="modal" :show-close="false" fullscreen>
            <div v-loading="loading" element-loading-text="Confirmando sua localização...">
                <el-result icon="success" title="Sucesso" subTitle="Localização Válida!" v-if="!loading">
                </el-result>

                <el-result icon="error" title="Atenção" subTitle="Localização Inválida!">
                </el-result>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify.js';

    export default {
        data() {
            return {
                map             : null,
                url             : '',
                cron            : '',
                text            : '',
                aulas_reservadas: [],
                duration        : null,
                modal           : false,
                loading         : false,
                timer           : {
                    minutes: 0,
                    seconds: 0
                }
            }
        },

        mixins: [funcoes, notify],

        mounted() {
            let self = this;

            self.submitForm();
            self.startMap();
        },

        methods: {
            startMap() {
                var contentCenter = '<span class="infowin">Sala de aula 11</span>'
                var contentA      = '<span class="infowin">Marker A (draggable)</span>'

                var latLngCenter  = new google.maps.LatLng(-22.394192, -47.5812358)
                var latLngCMarker = new google.maps.LatLng(-22.394192, -47.5812358)
                var latLngA       = new google.maps.LatLng(37.2, -94.1)

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom          : 20,
                    center        : latLngCenter,
                    mapTypeId     : 'terrain',
                    mapTypeControl: false
                })

                var markerCenter = new google.maps.Marker({
                    position: latLngCMarker,
                    title   : 'Location',
                    map     : map
                })

                var infoCenter = new google.maps.InfoWindow({
                    content: contentCenter
                })

                var markerA = new google.maps.Marker({
                    position : latLngA,
                    title    : 'Location',
                    map      : map,
                    draggable: true
                })

                var infoA = new google.maps.InfoWindow({
                    content: contentA
                })

                var circle = new google.maps.Circle({
                    map      : map,
                    clickable: false,
                    // metres
                    radius       : 2,
                    fillColor    : '#fff',
                    fillOpacity  : .6,
                    strokeColor  : '#313131',
                    strokeOpacity: .4,
                    strokeWeight : .8
                })

                circle.bindTo('center', markerCenter, 'position');

                var bounds = circle.getBounds()
                var noteA  = jQuery('.bool#a')

                noteA.text(bounds.contains(latLngA));

                google.maps.event.addListener(markerCenter, 'click', function () {
                    infoCenter.open(map, markerCenter);
                });

                google.maps.event.addListener(markerA, 'click', function () {
                    infoA.open(map, markerA);
                });
            },

            aguardando(item) {
                let now = moment().format('YYYY-MM-DD HH:mm:ss')

                if (item.cad_data_hora_inicio > now) {
                    return true
                }

                return false
            },

            liberaAula(item) {
                let now = moment().format('YYYY-MM-DD HH:mm:ss')

                if (item.cad_data_hora_inicio <= now && item.cad_data_hora_fim > now) {
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
            },

            verificaLocalizacao(cad_tempo_minimo) {
                this.modal   = true;
                this.loading = true;

                setTimeout(() => {
                    this.loading = false;
                }, 1000);

                setTimeout(() => {
                    this.start(cad_tempo_minimo)
                    this.modal = false;
                }, 5000);
            },

            start(timer) {
                var duration = 60 * timer;  // Converter para segundos
                this.resetCronometro();
                this.startTimer(duration); // iniciando o timer
            },

            pause() {
                clearInterval(this.cron)
            },

            resetCronometro() {
                clearInterval(this.cron)
                this.duration = null
                this.timer    = {
                    minutes: 0,
                    seconds: 0
                }
            },

            startTimer(duration) {
                let self  = this;
                let timer = duration

                self.cron = setInterval(function () {
                    self.timer.minutes = parseInt(timer / 60, 10);
                    self.timer.seconds = parseInt(timer % 60, 10);
                    self.timer.minutes = self.timer.minutes < 10 ? "0" + self.timer.minutes : self.timer
                        .minutes;
                    self.timer.seconds = self.timer.seconds < 10 ? "0" + self.timer.seconds : self.timer
                        .seconds;
                    self.text = self.timer.minutes + ":" + self.timer.seconds;

                    if (--timer < 0) {
                        timer = duration;
                    }

                    self.duration = timer
                }, 1000);
            }
        }
    }

</script>
<style>
    .small-box {
        text-align: left !important;
    }

    .small-box .icon {
        display: block;
    }

    div .el-loading-parent--relative {
        position: static !important;
    }

    #map_area{
        height: 50%;
        width : 30%;
    }

    #map {
        position   : absolute;
        height     : 100%;
        width      : 29%;
        font-family: Arial, sans-serif;
        font-size  : .9em;
        color      : #fff;
    }

    #note {
        text-align: center;
        padding   : .3em;
        background: #009ee0;
    }

    .bool {
        font-style: italic;
        color     : #313131;
    }

    .info {
        display   : inline-block;
        width     : 40%;
        text-align: center;
    }

    .infowin {
        color: #313131;
    }

    #title,
    .bool {
        font-weight: bold;
    }

</style>
