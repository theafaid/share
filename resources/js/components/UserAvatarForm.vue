<template>
    <div>
        <div class="input-group stylish-input-group text-center">
            <img :src="avatar" width="150" height="150" style="margin: auto">
        </div><hr>
        <ImageUpload @loaded="loaded"></ImageUpload>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload'

    export default {
        props: ['data'],

        components: {
            'ImageUpload': ImageUpload
        },

        data(){
            return {
                avatar: this.data
            }
        },

        methods: {
            loaded(data){
                this.avatar = data.src;
                this.persist(data.avatar);
            },

            persist(avatar){
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post("/api/users/avatar", data)
                    .then(response => {
                        this.$toaster.success("Your Profile Picture Has Beed Updated Successfully");
                    })
                    .catch(error => {
                        this.$toaster.error(error.response.data.errors.avatar[1]);
                    });
            }
        }
    }
</script>

<style scoped>

</style>