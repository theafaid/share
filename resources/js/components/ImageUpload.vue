<template>
    <input type="file" class='form-control' @change="uploadAvatar" accept="image/*">
</template>

<script>
    export default {
        methods:{
            uploadAvatar(e){
                if(e.target.files.length){
                    // there is selected image
                    let avatar = e.target.files[0];

                    let reader = new FileReader();

                    reader.readAsDataURL(avatar);

                    reader.onload = (e) => {
                        this.$emit('loaded', {
                            src: e.target.result,
                            avatar: avatar
                        });
                    };
                }
            },
        }
    }
</script>

<style scoped>

</style>