<template>
    <el-pagination @current-change="navigate" @size-change="sizeChange" :current-page="currentPage"
        :page-sizes="['5', '10', '20', '50', '100']" :page-size="page_size" layout="->, sizes, slot"
        background small>
        <template v-slot>
            <button :disabled="!prev_page" type="button" class="btn-prev" @click="navigate('prev')">
                <i class="el-icon el-icon-arrow-left"></i>
            </button>

            <button :disabled="!next_page" type="button" class="btn-next" @click="navigate('next')">
                <i class="el-icon el-icon-arrow-right"></i>
            </button>
        </template>
    </el-pagination>
</template>

<script>
    export default {
        props:{
            currentPage: Number,
            page_size  : String,
            next_page  : Boolean,
            prev_page  : Boolean
        },

        methods: {
            navigate(acao) {
                let self = this;

                let page = acao == 'next' ? self.currentPage + 1 : self.currentPage -1

                self.$emit('navigate', page, self.page_size)
            },

            sizeChange(page_size) {
                let self = this;

                self.$emit('sizeChange', null, page_size)
            }
        },
    }
</script>
