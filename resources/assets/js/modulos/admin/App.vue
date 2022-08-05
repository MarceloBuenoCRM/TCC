<template>
    <div class="wrapper">
        <preloader></preloader>

        <navbar_partial></navbar_partial>

        <sidebar_partial></sidebar_partial>

        <div class="content-wrapper">
            <router-view></router-view>
        </div>

        <footer_partial></footer_partial>
    </div>
</template>

<script>
    import preloader from '../../components/partials/preloader.vue';
    import navbar_partial from '../../components/partials/navbar.vue';
    import sidebar_partial from '../../components/partials/sidebar.vue';
    import footer_partial from '../../components/partials/footer.vue';

    export default {
        components: {
            preloader,
            navbar_partial,
            sidebar_partial,
            footer_partial
        }
    }
</script>
