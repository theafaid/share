<template>
    <div id="'comment-'+data.id" class="comment-list">
        <div class="single-comment justify-content-between d-flex">
            <div class="user justify-content-between d-flex">
                <div class="thumb">
                <img width="30" height="30" :src="data.user.image" :alt="data.user.username">
            </div>
                <div class="desc">
                    <h5><a :href="'/profile/'+ data.user.username">{{data.user.username}}</a></h5>
                    <p class="date">{{data.created_at}}</p>
                    <p class="comment" v-if="! editing">
                        {{body}}
                    </p>
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

        <!--<div class="float-right">-->
            <!--<form style="display: inline;" method="POST" action="{{route('like.store', $comment->id)}}">-->
                <!--@csrf-->
                <!--<button type="submit" class="btn {{$comment->isLiked() ? 'btn-primary' : 'btn-default'}}">-->
                    <!--<i class="fa fa-thumbs-o-up"></i>-->
                    <!--({{$comment->likes_count}})-->
                <!--</button>-->
            <!--</form>-->

            <!--<form style="display: inline;" method="POST" action="{{route('comments.destroy', $comment->id)}}">-->
                <!--@csrf-->
                <!--{{method_field('DELETE')}}-->
                <!--<button type="submit" class="btn btn-danger">-->
                    <!--<i class="fa fa-trash"></i>-->
                <!--</button>-->
            <!--</form>-->
        <!--</div>-->

        <div class="float-right">

            <button class="genric-btn primary-border small" @click.prevent="editing=true" v-if="!editing">
                <i class="fa fa-edit"></i>
            </button>

            <button class="genric-btn danger-border small" @click.prevent="destroy()">
                <i class="fa fa-trash"></i>
            </button>
        </div>

    </div>
</template>


<script>
    export default {
        props: ['data'],
        data(){
            return {
                editing: false,
                body: this.data.body
            }
        },

        methods:{
            update(){
                if(this.body == ''){
                    this.$toaster.warning("Comment Cannot Be Empty !");
                }else if(this.body == this.data.body){
                    this.editing = false;
                }else{
                    this.persist();
                }
            },

            persist(){
                axios.patch("/comments/" + this.data.id, {body: this.body});
                this.editing = false;
                this.$toaster.success("Your Comment Has Updated");
            },

            destroy(){
                $(this.$el).fadeOut(200);
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
