<img class="img-fluid" :src="thread.imagePath" alt="">
<div class="top-wrapper ">
    <div class="row d-flex justify-content-between">
        <h2 v-text="thread.title" class="col-lg-8 col-md-12 text-uppercase"></h2>
        <div class="col-lg-4 col-md-12 right-side d-flex justify-content-end">
            <div class="desc">
                <h2 v-text="thread.user.username"></h2>
                <h3 v-text="thread.created_at"></h3>
            </div>
            <div class="user-img">
                <img :src="thread.user.avatarPath" :alt="thread.user.username" width="30" height="30">
            </div>
        </div>
    </div>
</div>

<div class="single-post-content">
    <p v-html="thread.body"></p>
</div>

<div class="form-group" v-if="authorize('updateThread', thread)">
    <button class="btn btn-info" @click="editing=true">Edit</button>
</div>
