<template>
    <div v-if="items.length">
        <div v-for="(comment, index) in items">
            <comment :data="comment" @deleted="remove(index)"></comment>
        </div>
    </div>

    <div v-else>
        <div class="alert alert-warning">No Comments Found In This Thread !</div>
    </div>
</template>

<script>
    import Comment from './Comment'

    export default{

        components:{
            'comment': Comment
        },

        props: ['data'],

        data(){
            return {
                items: this.data
            }
        },

        methods:{
            remove(index){
                this.data.splice(index, 1);
                this.$emit('decrease');
            }
        }
    }
</script>