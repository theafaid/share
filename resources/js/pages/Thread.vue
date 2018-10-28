<script>
    import Comments from '../components/Comments';
    import SubscribeThread from '../components/SubscribeThread'

    export default{
        components: {
            'comments': Comments,
            'subscribe-thread': SubscribeThread
        },

        props: ['data'],

        data(){
            return {
                thread: this.data
            }
        }
    }
</script>

<style>
    [v-cloak]{
        display: none;
    }
</style>