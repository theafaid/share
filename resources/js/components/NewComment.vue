<template>
    <!-- Start commentform Area -->
    <section class="commentform-area  pb-120 pt-80 mb-100">
        <div class="container">
            <h5 class="text-uppercas pb-50">Leave a Comment</h5>
            <div class="row flex-row d-flex" v-if="signedIn">
                <div class="col-lg-12">
                    <textarea v-model="body" class="form-control" placeholder="Your Comment ....."></textarea>
                    <button :disabled="isDisabled" class="primary-btn mt-20" @click.prevent="post">Post Comment</button>
                </div>
            </div>
            <div class="alert alert-danger" v-else>
                Please <a href="/login">Login</a> To Add Your Comment !.
            </div>
        </div>
    </section>
    <!-- End commentform Area -->
</template>

<script>
    export default{

        data(){
            return {
                body: "",
                isDisabled: false
            }
        },

        computed: {
            signedIn(){
                return !! user.id;
            }
        },

        methods:{

            post(){
                return this.body == '' ? this.avoidPost() : this.persist();
            },

            avoidPost(){
                this.$toaster.warning("Write a comment before post !");
                return;
            },

            persist(){
                axios.post(`${location.pathname}/comments`, {body: this.body})
                    .then(response => {
                        this.body = '';
                        this.$toaster.success("Your Comment Has Bee Published");
                        this.$emit('created', response.data);
                    }).catch(error => {
                        this.$toaster.error(error.response.data.errors.body[0]);
                        this.body = '';
                    });
            }
        }
    }
</script>

<style>
    .commentform-area .form-control{
        color: #000;
        border-radius: 20px;
        color: #000;
        border: 1px solid #aed5ff;
    }
</style>