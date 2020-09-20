<template>
    <div>
        <div class="chat-box">
            <div class="messages-box border rounded border-secondary">
                <div
                    :class="['alert', {'alert-success': message.user}, {'alert-warning' : !message.user}]"
                    v-for="message in messages"
                >
                    <b>[{{ message.date }}]: {{ message.user }}</b>
                    <br>
                    {{ message.text }}
                </div>
            </div>
        </div>
        <div class="message-box">
            <form @submit.prevent="submitMessage">
                <input class="form-control border-secondary" placeholder="Put your message here..." type="text"
                       v-model="message">
                <button class="btn btn-primary" type="submit">SEND</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        Echo.private('chat.1')
            .listen('ChatMessageEvent', (e) => {
                this.pushMessage({
                    user: e.socket,
                    text: e.text,
                    date: new Date()
                })
            })
    },

    data() {
        return {
            message: '',
            messages: []
        }
    },

    methods: {
        pushMessage(data) {
            this.messages.push(data);
            document.querySelector('.messages-box').scrollTo(0, 99999999999999);
        },

        submitMessage() {
            if (this.message.length) {
                axios.post('/api/message', {
                        channel_id: 1,
                        text: this.message
                    }
                ).then(() => {
                    this.pushMessage({
                        user: null,
                        text: this.message,
                        date: new Date()
                    });

                    this.message = '';
                })
            }
        }
    }
}
</script>

<style lang="scss">
.chat-box {
    width: 100%;
    height: 700px;
    margin-bottom: 15px;
    display: flex;

    .messages-box {
        width: 100%;
        overflow: auto;
    }
}

.message-box form {
    width: 100%;
    display: flex;

    input {
        width: 100%;
    }
}
</style>
