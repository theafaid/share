<template>
    <div id="'comment-'+data.id" class="comment-list">
        <div class="single-comment justify-content-between d-flex">
            <div class="user justify-content-between d-flex">
                <div class="thumb">
                <img width="30" height="30" :src="data.user.avatarPath" :alt="data.user.username">
            </div>
                <div class="desc">
                    <h5><a :href="'/profile/'+ data.user.username">{{data.user.username}}</a></h5>
                    <p class="date">{{createdAt(this.data.created_at)}}</p>
                    <p class="comment" v-if="! editing" v-html="body"> </p>
                    <div id="edit-comment-container" v-else>
                        <textarea class="form-control" v-model="body"></textarea><br/>
                        <p class="float-right">
                            <button class="genric-btn primary-border small" @click="update()">Update</button>
                            <button class="genric-btn danger-border small" @click="editing = false">Cancel</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="float-right">

            <div v-if="signedIn">
                <div style="display:inline" v-if="canUpdate">
                    <button class="genric-btn primary-border small" @click.prevent="editing=true" v-if="!editing">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="genric-btn danger-border small" @click.prevent="destroy()">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>

                <like-comment :data="data"></like-comment>
            </div>
        </div>

    </div>
</template>


<script>
    import moment from 'moment';
    import LikeComment from './LikeComment';

    export default {

        components: {
            'like-comment': LikeComment
        },

        props: ['data'],

        data(){
            return {
                editing: false,
                body: this.data.body,
                oldBody: ''
            }
        },

        computed: {
            signedIn(){
                return !! user.id;
            },



            canUpdate(){
               return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods:{

            createdAt($time){
                return moment($time).fromNow();
            },

            update(){
                // old body will work if user has update his comment once
                // and he want to update it again but he write a spam comment
                // so we will rewind the body to be the old body not the main body
                // which came from [this.data.body]
                // this.oldBody = this.body;

                if(this.body == ''){

                    this.$toaster.warning("Comment Cannot Be Empty !");

                }else if(this.body == this.data.body){

                    this.editing = false;

                }else{
                    this.persist();
                }
            },

            persist(){
                axios.patch("/comments/" + this.data.id, {body: this.body})
                    .then(response => {
                        this.editing = false;
                        this.$toaster.success("Your Comment Has Updated");
                    })
                    .catch(error => {
                        this.$toaster.error(error.response.data.errors.body[0]);
                        this.body = this.data.body;
                        this.editing = false;
                    });

            },

            destroy(){
                // $(this.$el).fadeOut(200);
                this.$emit("deleted", this.data.id);
                this.$toaster.success("Your Comment Has Been Deleted");
                axios.delete(`/comments/${this.data.id}`);
            }
        }

    }
</script>

<style>
    #edit-comment-container{
        min-width: 300px;
        max-width: 600px
    }
</style>
