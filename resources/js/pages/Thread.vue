<script>
    import Comments from '../components/Comments';
    export default{
        components: {
            'comments': Comments
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