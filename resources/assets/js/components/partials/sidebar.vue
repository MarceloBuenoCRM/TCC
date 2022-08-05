<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3">
                <div class="d-flex justify-content-center">
                    <img src="/images/logo.png" class="img-circle elevation-2" style="height: 60%; width:60%">
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-header">MENU (Admin)</li>
                    <li class="nav-item" :class="{'menu-open': isModuloMenu($route.name, 'principal')}">
                        <a href="/principal" class="nav-link"
                            :class="{'active': isModuloMenu($route.name, 'principal')}">
                            <i class="fas fa-home"></i>
                            <p>
                                Home
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/" class="nav-link"
                                    :class="{'active': isMenu($route, 'principal.dashboard.index')}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" :class="{'menu-open': isModuloMenu($route.name, 'admin')}">
                        <a href="/admin" class="nav-link" :class="{'active': isModuloMenu($route.name, 'admin')}">
                            <i class="fas fa-edit"></i>
                            <p>
                                Cadastro
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/admin/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'admin.admin.index')}">
                                    <i class="fas fa-user-plus"></i>
                                    <p>
                                        Administrador(a)
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/clinica/consultas/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'clinica.consultas.index')}">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>
                                        Aluno(a)
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/clinica/ficha_anamnese/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'clinica.ficha_anamnese.index')}">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>
                                        Professor(a)
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/clinica/pacientes/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'clinica.pacientes.index')}">
                                    <i class="fas fa-school"></i>
                                    <p>
                                        Sala de Aula
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">MENU (Professor)</li>
                    <li class="nav-item" :class="{'menu-open': isModuloMenu($route.name, 'sistema')}">
                        <a href="/sistema" class="nav-link" :class="{'active': isModuloMenu($route.name, 'sistema')}">
                            <i class="fas fa-edit"></i>
                            <p>
                                Cadastro
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/sistema/usuarios/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'sistema.usuarios.index')}">
                                    <i class="fas fa-spell-check"></i>
                                    <p>
                                        Aula
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" :class="{'menu-open': isModuloMenu($route.name, 'sistema')}">
                        <a href="/sistema" class="nav-link" :class="{'active': isModuloMenu($route.name, 'sistema')}">
                            <i class="fas fa-file-invoice"></i>
                            <p>
                                Relatórios
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/sistema/usuarios/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'sistema.usuarios.index')}">
                                    <i class="fas fa-id-card"></i>
                                    <p>
                                        Presença
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">MENU (Aluno)</li>
                    <li class="nav-item">
                        <a href="/sistema" class="nav-link" :class="{'active': isModuloMenu($route.name, 'sistema')}">
                            <i class="fas fa-id-card"></i>
                            <p>
                                Presença
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
    export default {
        methods: {
            isModuloMenu(route, nome) {
                route = route.split('.')[0];

                return route === nome;
            },

            isMenu(route, nome) {
                return route.name == nome;
            }
        }
    }
</script>
