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
                editing: false,
                form:{
                    title: this.data.title,
                    body: this.data.body
                }
            }
        },

        methods:{
            cancel(){
                this.editing = false;
                this.resetForm();
            },

            update(){
                axios.patch(location.pathname, this.form)
                    .then(() => {
                        this.editing = false;
                        this.$toaster.success('Thread has updated successfully');
                        this.thread.title = this.form.title;
                        this.thread.body  = this.form.body;
                        this.resetForm();
                    }).catch(() => {
                        this.editing = false;
                        this.$toaster.error('Please complete all fields !');
                        this.resetForm();
                    });
            },

            resetForm(){
                this.form.title = this.thread.title;
                this.form.body  = this.thread.body;
            }
        }
    }
</script>

<style>
    [v-cloak]{
        display: none;
    }
</style>