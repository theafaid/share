<template>
    <div>
        <div class="input-group stylish-input-group text-center">
            <img :src="avatar" width="150" height="150" style="margin: auto"><br>
        </div><hr>
        <input type="file" class='form-control' @change="uploadAvatar" accept="image/*">
    </div>
</template>

<script>
    export default {
        props: ['data'],

        data(){
            return {
                avatar: this.data
            }
        },

        methods: {
            uploadAvatar(e){
                if(e.target.files.length){
                    // there is selected image
                    let avatar = e.target.files[0];

                    let reader = new FileReader();

                    reader.readAsDataURL(avatar);

                    reader.onload = (e) => {

                        this.avatar = e.target.result;
                        this.$toaster.success("Your Profile Picture Has Beed Updated Successfully");
                    };
                    // persist to the server
                    this.persist(avatar);

                }
            },

            persist(avatar){

                let data = new FormData();

                data.append('avatar', avatar);

                axios.post("/api/users/avatar", data);
            }
        }
    }
</script>

<style scoped>

</style>