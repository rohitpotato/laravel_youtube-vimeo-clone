<template>
<div class="container">
    <p>{{ comments.length }} Comments</p>

    <div class="video-comment clearfix" v-if="status">
        <textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>

        <div class="pull-right">
            <button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
        </div>
    </div>

    <ul class="media-list">
        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a href="/channel/ comment.channel.data.slug ">
                    <img v-bind:src="comment.channel.data.image" alt=" comment.channel.data.name image" class="media-object" width="50px" height="50px">
                </a>
            </div>
            <div class="media-body">
                <a href="/codetube/public/channel/ comment.channel.data.slug ">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                <p>{{ comment.body }}</p>

                <ul class="list-inline" v-if="status">
                    <li>
                        <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                    </li>
                    <li>
                        <a href="#"  v-show="userId === comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
                    </li>
                </ul>

                <div class="video-comment clear" v-if="replyFormVisible === comment.id">
                    <textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">Reply</button>
                    </div>
                </div>

                <div class="media" v-for="reply in comment.replies.data">
                    <div class="media-left">
                        <a href="/channel/ reply.channel.data.slug ">
                            <img v-bind:src="reply.channel.data.image" alt=" reply.channel.data.name  image" class="media-object" width="50px" height="50px">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="/channel/ reply.channel.data.slug ">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                        <p>{{ reply.body }}</p>

                        <ul class="list-inline" v-if="status">
                            <li>
                                <a href="#" v-if="userId === reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
</template>

<script>
    export default {
        data () {
            return {
                comments: [],
                body: null,
                replyBody: null,
                replyFormVisible: null
            }
        },
        props: {

            videoUid: null,
            status: null,
            userId: null
        },
        methods: {
            toggleReplyForm (commentId) {
                
                console.log(this.userId == this.comments[0].user_id);
            },
            createReply (commentId) {
                axios.post('/codetube/public/videos/' + this.videoUid + '/comments', {
                    body: this.replyBody,
                    reply_id: commentId
                }).then((response) => {
                    this.comments.map((comment, index) => {
                        if (comment.id === commentId) {
                            this.comments[index].replies.data.push(response.data.data);
                            return;
                        }
                    })

                    this.replyBody = null;
                    this.replyFormVisible = null;
                });
            },
            createComment () {
                axios.post('/codetube/public/videos/' + this.videoUid + '/comments', {
                    body: this.body
                }).then((response) => {
                    this.comments.unshift(response.data.data);
                    this.body = null;
                });
            },
            getComments () {
                axios.get('/codetube/public/videos/' + this.videoUid + '/comments').then((response) => {
                    this.comments = response.data.data;
                });
            },
            deleteComment (commentId) {
                if (!confirm('Are you sure you want to delete this comment?')) {
                    return;
                }

                this.deleteById(commentId);
                axios.delete('/codetube/public/videos/' + this.videoUid + '/comments/' + commentId);
            },
            deleteById (commentId) {
                this.comments.map((comment, index) => {
                    if (comment.id === commentId) {
                        this.comments.splice(index, 1);
                        return;
                    }

                    comment.replies.data.map((reply, replyIndex) => {
                        if (reply.id === commentId) {
                            this.comments[index].replies.data.splice(replyIndex, 1);
                            return;
                        }
                    })
                });
            }
        },
        mounted () {
            this.getComments();
        }
    }
</script>
