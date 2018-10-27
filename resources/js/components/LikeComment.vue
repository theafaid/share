<template>
    <button class="genric-btn like-btn" :class="classes" @click.prevent="like()">
        <i class="fa fa-thumbs-o-up"></i>
    </button>
</template>

<script>
    export default{
        props: ['data'],

        data(){
            return {
                isLiked: this.data.isLiked
            }
        },

        computed: {
            classes(){
                return [this.isLiked ? 'liked' : ''];
            }
        },

        methods:{
            like(){
                ! this.isLiked ? this.likeComment() : this.unlikeComment();
                this.isLiked = ! this.isLiked;
            },

            likeComment(){
                axios.post(`/comments/${this.data.id}/likes`);
            },

            unlikeComment(){
                axios.delete(`/comments/${this.data.id}/likes`);
            }
        }
    }
</script>

<style>
    .like-btn{
        border-radius: 50%;
        border: 0;
        font-weight: bold;
        text-align: center;
        outline: none;
    }

    .liked{
        background: #399cff;
    }
</style>