<template>
    <div>
        <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Notification <span id="notifications-count"> {{items.length}}</span>
        </a>

        <div class="dropdown-menu">

            <div v-if="items.length">
                <a
                        class="dropdown-item"
                        :href="item.data.link"
                        v-for="(item, index) in items"
                        :key="index"
                        v-text="index+1 + '- ' + item.data.message"
                        @click="markAsRead(item.id)">
                </a>
            </div>

            <div v-else class="alert alert-primary">
                <a class="dropdown-item">You Don' Have Any Notifications</a>
            </div>

        </div>
    </div>


</template>

<script>
    export default {
        data(){
            return {
                items: []
            }
        },

        created(){
            axios.get("/notifications")
                .then(response => {
                    this.items = response.data;
                });
        },

        methods:{
            markAsRead(id){
                console.log(id);
                axios.delete(`/notifications/${id}`);
            }
        }
    }
</script>

<style scoped>
    #notifications-count{
        background: #f00;
        border-radius: 50%;
        text-align: center;
        color: #fff;
        padding: 5px;
        font-weight: bold;
    }
</style>