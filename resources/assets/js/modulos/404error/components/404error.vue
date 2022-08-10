<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$tc('message.error_fallback', 1)}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">{{$t('message.home')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{$tc('message.error_fallback', 1)}}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> {{$tc('message.error_fallback', 2)}}</h2>
                <div class="error-content">
                    <h3>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        {{$t('message.pagina_nao_encontrada')}}
                    </h3>
                    <p v-html="$t('message.pagina_nao_encontrada_link')">
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
