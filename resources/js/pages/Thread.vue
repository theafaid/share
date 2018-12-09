<script>
    import Comments from '../components/Comments';
    import SubscribeThread from '../components/SubscribeThread'
    import LockThread from '../components/LockThread'

    export default{
        components: {
            'comments': Comments,
            'subscribe-thread': SubscribeThread,
            'lock-thread': LockThread
        },

        props: ['data'],

        data(){
            return {
                thread: this.data,
            }
        },
    }
</script>

<style>
    [v-cloak]{
        display: none;
    }
</style>