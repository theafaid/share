let Authorizations = {

    updateComment(comment){
        return user.id == comment.user_id;
    },

    updateThread(thread){
        return user.id == thread.user_id;
    }

};

module.exports = Authorizations;