<template>
    <div>
        <div v-if="items.length">
            <div v-for="(comment, index) in items" :key="comment.id">
                <comment :data="comment" @deleted="remove(index)"></comment>
            </div>
        </div>

        <div v-else>
            <div class="alert alert-warning">No Comments Found In This Thread !</div>
        </div>

        <new-comment :data="data" @created="add"></new-comment>
    </div>
</template>

<script>
    import Comment from './Comment'
    import NewComment from './NewComment'
    export default{

        components:{
            'comment': Comment,
            'new-comment': NewComment
        },

        props: ['data'],

        data(){
            return {
                items: this.data
            }
        },

        methods:{
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