<template>
    <div>
        <div v-if="items.length">

            <div v-for="(comment, index) in items" :key="comment.id">
                <comment :data="comment" @deleted="remove(index)"></comment>
            </div>
            <hr>
            <paginator :data="paginatorData" @updated="fetch"></paginator>

        </div>

        <div v-else>
            <div class="alert alert-warning">No Comments Found In This Thread !</div>
        </div>

        <div>
            <div v-if="allowPosting">
                <new-comment @created="add"></new-comment>
            </div>
            <div v-else>
                <div class="alert alert-danger">
                    Thread Creator has disabled comments.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Comment from './Comment'
    import NewComment from './NewComment'
    import Paginator from './Paginator'

    export default{

        components:{
            'comment': Comment,
            'new-comment': NewComment,
            'paginator': Paginator
        },

        props: ['locked'],

        data(){
            return {
                items: [],
                paginatorData: [],
                allowPosting: ! this.locked
            }
        },

        created(){
            this.fetch();
            Fire.$on('changeLockMode', () => {
                this.allowPosting = ! this.allowPosting;
            });
        },

        methods:{
            fetch(page){
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page){
                // page = page ? page : 1 ;
                if(!page){
                    let query = location.search.match(/page=(\d)/);
                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/comments?page=${page}`;
            },

            refresh(response){
                this.items = response.data.data;
                this.paginatorData = response.data;
            },

            remove(index){
                this.items.splice(index, 1);
                this.$emit('decrease');
            },

            add(data){
                 this.items.push(data);
                 this.$emit('increase');

            }
        }
    }
</script>