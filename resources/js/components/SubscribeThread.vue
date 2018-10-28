<template>
    <button :class="classes" @click="subscribe">
        {{text}}
        ( {{subscriptions_count}} )
        <i class="fa fa-user-plus"></i>
    </button>
</template>

<script>
    export default {
        props: ['data'],

        data(){
            return {
                isSubscribed: this.data.isSubscribed,
                subscriptions_count: this.data.subscriptions_count
            }
        },

        computed:{
            text(){
                return this.isSubscribed ? 'Subscribed' : 'Subscribe';
            },

            classes(){
                return ['btn', this.isSubscribed ? 'btn-danger' : 'btn-default']
            }
        },

        methods:{
            subscribe(){
                ! this.isSubscribed ? this.post() : this.delete();
                this.isSubscribed = ! this.isSubscribed;
            },

            post(){
                this.subscriptions_count++;
                this.$toaster.success(`Your Subscribed " ${this.data.title} "`)
                axios.post(`${location.pathname}/subscriptions`);
            },

            delete(){
                this.subscriptions_count--;
                this.$toaster.error(`Your Unsubscribed " ${this.data.title} "`)
                axios.delete(`${location.pathname}/subscriptions`);
            }
        }
    }
</script>

<style scoped>

</style>