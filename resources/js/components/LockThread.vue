<template>
    <button :class="btnClasses" @click="changeLockMode" id="lockThreadBtn">
        {{text}}
        <i :class="iconClasses"></i>
    </button>
</template>

<script>
    export default {
        props: ['data'],

        data(){
            return {
                isLocked: false
            }
        },

        computed: {
            btnClasses(){
                return ['btn', this.isLocked ? 'btn-danger' : 'btn-default'];
            },

            iconClasses(){
                return ['fa', this.isLocked ? 'fa-lock' : 'fa-unlock-alt'];
            },

            text(){
                return this.isLocked ? 'Comments are Disabled' : 'Comments are Enabled';
            }
        },

        methods: {
            changeLockMode(){
                this.isLocked = ! this.isLocked;
                Fire.$emit('changeLockMode');
                axios.post(`${location.pathname}/lock`);
            },
        }
    }
</script>

<style scoped>
#lockThreadBtn{
    width: 100%
}
</style>