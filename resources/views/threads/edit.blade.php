<div class="col-lg-12">

    <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="form.title">
    </div>

    <div class="form-group">
        {{--<textarea class="form-control" placeholder="Thread Body" v-model="form.body" style="height: 300px"></textarea>--}}
        <wysiwyg name="body" v-model="form.body" :value="form.body"></wysiwyg>
    </div>

    <div class="form-group">
        <button class="btn btn-link" @click="cancel()">Cancel</button>
        <button class="btn btn-primary" @click="update()">Update</button>
    </div>
</div>