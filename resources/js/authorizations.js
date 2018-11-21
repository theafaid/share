let authorizations = {

    updateComment(comment){
        return comment.user_id === user.id;
    }
};

module.exports = authorizations;