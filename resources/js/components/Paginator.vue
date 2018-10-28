<template>
    <nav aria-label="Page navigation" v-if="shouldPaginate">
        <ul class="pagination">
            <li v-if="prevPageUrl">
                <a aria-label="Previous" @click="currentPage--">
                    <span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                    Prev
                </a>
            </li>
            <li v-if="nextPageUrl">
                <a aria-label="Next" @click="currentPage++">
                    Next
                    <span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['data'],

        data(){
          return{
              prevPageUrl: false,
              nextPageUrl: false,
              currentPage: false
          }
        },

        created(){
            this.prevPageUrl = this.data.prev_page_url;
            this.nextPageUrl = this.data.next_page_url;
            this.currentPage = this.data.current_page;
        },

        watch: {
            data(){
                this.prevPageUrl = this.data.prev_page_url;
                this.nextPageUrl = this.data.next_page_url;
                this.currentPage = this.data.current_page;
            },

            currentPage(){
                this.broadcast(this.currentPage).updateUrl();
            }
        },


        computed:{
            shouldPaginate(){
                return !! this.nextPageUrl || this.prevPageUrl;
            }
        },

        methods:{
            broadcast(page){
                this.$emit('updated', page);
                return this;
            },

            updateUrl(){
                history.pushState(null, null, `?page=${this.currentPage}`);
            }
        }
    }
</script>

<style scoped>

    .pagination li a {
        border: 1px;
        margin-left: 0px;
        color: #707070;
        padding: 7px 2px;
        margin: 0px 20px;
        cursor: pointer;
    }
    .pagination li a:hover {
        background-color: transparent;
        color: #4A90E2;
        padding-bottom: 2px;
        border-bottom: 1px solid;
    }
    .pagination li a:focus {
        outline: none;
        background-color: transparent;
        /*color:#707070;*/
    }
    .pagination li:first-child a, .pagination li:last-child a {
        border-radius: 6px;
        margin: 20px;
        padding: 6px 12px;
        font-size: 14px;
        color: #fff;
        background: #0080ff
    }
    .pagination li:first-child a:hover, .pagination li:last-child a:hover {
        text-decoration: none !important;
        color: #fff;
        background-color: #143361;
    }
    .pagination li:first-child a:focus, .pagination li:last-child a:focus {
        outline: none;
    }
</style>