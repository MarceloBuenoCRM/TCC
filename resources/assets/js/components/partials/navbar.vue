<template>
    <nav id="navbar" class="main-header navbar navbar-expand">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <li class="nav-item">
                <div class="nav-link">
                    <el-switch v-model="dark_mode"  active-icon-class="far fa-moon" inactive-icon-class="far fa-sun fa-lg" @change="updateDarkMode">
                    </el-switch>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-cog"></i>
                    {{cad_nome}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="/logout" class="dropdown-item text-center">
                        <i class="fas fa-user"></i>
                        Meu Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="dropdown-item text-center">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                dark_mode: Cookie.get("modo_escuro") == 1 ? true : false,
                cad_nome: Cookie.get("cad_nome")
            }
        },

        watch: {
            dark_mode(val) {
                if (val == true) {
                    Cookie.set("modo_escuro", 1)
                } else {
                    Cookie.set("modo_escuro", 0)
                }
            }
        },

        mounted() {
            this.setDarkMode();
        },

        methods: {
            setDarkMode() {
                let self = this;

                self.dark_mode = Cookie.get("modo_escuro") == 1 ? true : false;

                if (self.dark_mode == 1) {
                    $('#body').addClass('dark-mode');
                    $('#navbar').addClass('navbar-dark');
                    $('#navbar').removeClass('navbar-white navbar-light')
                } else {
                    $('#body').removeClass('dark-mode');
                    $('#navbar').removeClass('navbar-dark');
                    $('#navbar').addClass('navbar-white navbar-light')
                }
            },

            updateDarkMode() {
                let self = this;
                let modo_escuro = self.dark_mode ? 1 : 0;

                axios.put('/sistema/usuario/modo_escuro/' + modo_escuro)
                    .then(function () {
                        self.setDarkMode();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
